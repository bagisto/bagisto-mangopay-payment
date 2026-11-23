<?php

namespace Webkul\MangoPay\Helpers;

use Illuminate\Support\Facades\Cache;
use Webkul\MangoPay\Repositories\EscrowedAmountRepository;
use Webkul\MangoPay\Repositories\MangopayTransferAmountRepository;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;
use Webkul\Marketplace\Repositories\OrderRepository;
use Webkul\Marketplace\Repositories\SellerRepository;
use Webkul\Marketplace\Repositories\TransactionRepository;
use Webkul\Sales\Repositories\OrderRepository as BaseOrderRepository;

class ReleaseAmount
{
    /**
     * Payout method recorded on the Marketplace seller transactions this release creates.
     */
    const PAYOUT_METHOD = 'MangoPay';

    /**
     * Create a new helper instance.
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected EscrowedAmountRepository $escrowedAmountRepository,
        protected MangopayWalletRepository $mangopayWalletRepository,
        protected SellerRepository $sellerRepository,
        protected TransactionRepository $transactionRepository,
        protected BaseOrderRepository $baseOrderRepository,
        protected MangopayHelper $mangopayHelper,
        protected MangopayTransferAmountRepository $mangopayTransferAmountRepository
    ) {}

    /**
     * Release an escrowed order: each seller gets their unpaid payout, the admin wallet the rest.
     */
    public function execute(array $data): void
    {
        $lock = Cache::lock('mangopay-escrow-'.$data['id'], 120);

        if (! $lock->get()) {
            throw new \Exception(trans('mangopay::app.admin.response.request-in-progress'));
        }

        try {
            $this->release((int) $data['id'], (string) ($data['message'] ?? ''));
        } finally {
            $lock->release();
        }
    }

    /**
     * Plan every transfer before moving money, then pay the sellers first and the admin last.
     */
    protected function release(int $id, string $message): void
    {
        $escrow = $this->escrowedAmountRepository->find($id);

        if (! $escrow) {
            throw new \Exception(trans('mangopay::app.admin.response.escrow-not-found'));
        }

        if ($escrow->status) {
            throw new \Exception(trans('mangopay::app.admin.response.already-released'));
        }

        $order = $this->baseOrderRepository->find($escrow->order_id);

        if (! $order) {
            throw new \Exception(trans('mangopay::app.admin.response.escrow-not-found'));
        }

        $buyerWallet = $this->mangopayWalletRepository->findOneByField('wallet_id', $escrow->wallet_id);

        if (! $buyerWallet) {
            throw new \Exception(trans('mangopay::app.admin.response.buyer-wallet-not-found'));
        }

        $adminWallet = $this->mangopayWalletRepository->adminWallet();

        if (! $adminWallet) {
            throw new \Exception(trans('mangopay::app.admin.response.admin-wallet-not-found'));
        }

        $sellerOrders = $this->orderRepository->findWhere(['order_id' => $order->id]);

        $payouts = $this->sellerPayouts($sellerOrders);

        $adminCents = $this->toCents((float) $escrow->escrowed_amount - (float) $order->base_grand_total_refunded)
            - $this->toCents($this->releasedToSellers($sellerOrders))
            - array_sum(array_column($payouts, 'cents'));

        if ($adminCents < 0) {
            throw new \Exception(trans('mangopay::app.admin.response.insufficient-escrow'));
        }

        foreach ($payouts as $payout) {
            $this->paySeller($payout['seller_order'], $payout['cents'] / 100, $buyerWallet, $message);
        }

        if ($adminCents > 0) {
            $transfer = $this->transfer($buyerWallet, $adminWallet, 'Transfer to admin from buyer', $adminCents / 100);

            $this->recordTransfer($transfer, $adminCents / 100, $message);

            $this->assertSucceeded($transfer);
        }

        $this->escrowedAmountRepository->update(['status' => 1], $escrow->id);
    }

    /**
     * Get the unpaid, refund-adjusted payout of every approved seller in whole cents, rounded down.
     */
    protected function sellerPayouts($sellerOrders): array
    {
        $payouts = [];

        foreach ($sellerOrders as $sellerOrder) {
            if (! $sellerOrder->seller?->is_approved) {
                continue;
            }

            $cents = (int) floor(100 * (
                (float) $sellerOrder->base_seller_total_invoiced
                - $this->sellerRefunded($sellerOrder)
                - (float) $sellerOrder->transactions()->sum('base_total')
            ) + 0.000001);

            if ($cents > 0) {
                $payouts[] = [
                    'seller_order' => $sellerOrder,
                    'cents' => $cents,
                ];
            }
        }

        return $payouts;
    }

    /**
     * Get the seller's share of what was refunded: net items after commission plus their tax.
     */
    protected function sellerRefunded($sellerOrder): float
    {
        $netRefunded = (float) $sellerOrder->base_sub_total_refunded - (float) $sellerOrder->base_discount_refunded;

        return $netRefunded * (1 - (float) $sellerOrder->commission_percentage / 100)
            + (float) $sellerOrder->base_tax_amount_refunded;
    }

    /**
     * Get what earlier releases of this order already moved from the buyer wallet to the sellers.
     */
    protected function releasedToSellers($sellerOrders): float
    {
        $released = 0;

        foreach ($sellerOrders as $sellerOrder) {
            $released += (float) $sellerOrder->transactions()
                ->where('method', self::PAYOUT_METHOD)
                ->sum('base_total');
        }

        return $released;
    }

    /**
     * Transfer a seller's payout to their wallet and record it as a Marketplace payout.
     */
    protected function paySeller($sellerOrder, float $amount, $buyerWallet, string $message): void
    {
        $sellerWallet = $this->sellerWallet($sellerOrder->marketplace_seller_id);

        $transfer = $this->transfer($buyerWallet, $sellerWallet, 'Transaction to seller from buyer', $amount);

        $this->recordTransfer($transfer, $amount, $message, $sellerOrder->marketplace_seller_id);

        $this->assertSucceeded($transfer);

        $transaction = $this->transactionRepository->paySeller([
            'order_id' => $sellerOrder->order_id,
            'marketplace_seller_id' => $sellerOrder->marketplace_seller_id,
            'amount' => $amount,
            'type' => self::PAYOUT_METHOD,
            'method' => self::PAYOUT_METHOD,
            'comment' => $message !== '' ? $message : 'MangoPay transfer '.$transfer->Id,
        ]);

        if (! $transaction) {
            throw new \Exception(trans('mangopay::app.admin.response.insufficient-escrow'));
        }
    }

    /**
     * Get the seller's MangoPay wallet, registering the seller with MangoPay when they have none.
     */
    protected function sellerWallet(int $sellerId)
    {
        $wallet = $this->mangopayWalletRepository->findOneByField('seller_id', $sellerId);

        if ($wallet) {
            return $wallet;
        }

        $seller = $this->sellerRepository->find($sellerId);

        $name = explode(' ', trim((string) $seller->name), 2);

        return $this->mangopayHelper->createLegal([
            'fname' => $name[0] ?? $seller->name,
            'lname' => $name[1] ?? ($name[0] ?? ''),
            'email' => $seller->email,
            'usertype' => 'Seller',
            'dob' => null,
            'description' => 'Seller Create Wallet',
            'seller_id' => $seller->id,
        ]);
    }

    /**
     * Move an amount from the buyer wallet to another MangoPay wallet.
     */
    protected function transfer($buyerWallet, $creditedWallet, string $tag, float $amount)
    {
        return $this->mangopayHelper->createTransfer(
            $buyerWallet->mangopay_id,
            $buyerWallet->wallet_id,
            $creditedWallet->mangopay_id,
            $creditedWallet->wallet_id,
            $tag,
            $amount,
            0
        );
    }

    /**
     * Stop the release when MangoPay refused a transfer, so nothing is marked as paid.
     */
    protected function assertSucceeded($transfer): void
    {
        if (($transfer->Status ?? null) === 'FAILED') {
            throw new \Exception((string) ($transfer->ResultMessage ?? trans('mangopay::app.admin.transaction.failed')));
        }
    }

    /**
     * Record a transfer against the seller, or the admin when no seller is given.
     */
    protected function recordTransfer($transfer, float $amount, string $message, ?int $sellerId = null): void
    {
        $payload = [
            'transaction_id' => $transfer->Id,
            'amount' => $amount,
            'message' => $message,
            'status' => $transfer->Status ?? 'SUCCEEDED',
        ];

        if ($sellerId) {
            $payload['seller_id'] = $sellerId;
        } else {
            $payload['admin_id'] = auth()->guard('admin')->id();
        }

        $this->mangopayTransferAmountRepository->create($payload);
    }

    /**
     * Convert an amount to whole cents, the unit MangoPay moves.
     */
    protected function toCents(float $amount): int
    {
        return (int) round($amount * 100);
    }
}
