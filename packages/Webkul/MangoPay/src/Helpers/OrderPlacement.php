<?php

namespace Webkul\MangoPay\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Webkul\Checkout\Facades\Cart;
use Webkul\MangoPay\Repositories\EscrowedAmountRepository;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Transformers\OrderResource;

class OrderPlacement
{
    /**
     * The PayIn became the cart's paid order.
     */
    const PLACED = 'placed';

    /**
     * The PayIn already placed an order.
     */
    const USED = 'used';

    /**
     * MangoPay did not confirm the PayIn for this cart; nothing was charged that the store keeps.
     */
    const REFUSED = 'refused';

    /**
     * The card was charged but no order could be placed, so the PayIn was refunded.
     */
    const REFUNDED = 'refunded';

    /**
     * Another request is placing the order of this PayIn.
     */
    const BUSY = 'busy';

    /**
     * Create a new helper instance.
     */
    public function __construct(
        protected MangopayHelper $mangopayHelper,
        protected OrderRepository $orderRepository,
        protected InvoiceRepository $invoiceRepository,
        protected EscrowedAmountRepository $escrowedAmountRepository,
        protected MangopayWalletRepository $mangopayWalletRepository
    ) {}

    /**
     * Place the order a confirmed PayIn paid for, once, from the return page or the MangoPay hook.
     *
     * @return array{status: string, order?: mixed}
     */
    public function place($cart, string $payInId): array
    {
        $lock = Cache::lock('mangopay-payin-'.$payInId, 60);

        if (! $lock->get()) {
            return ['status' => self::BUSY];
        }

        try {
            return $this->placeOnce($cart, $payInId);
        } finally {
            $lock->release();
        }
    }

    /**
     * Find the MangoPay wallet the buyer of this cart pays from.
     */
    public function buyerWallet($cart)
    {
        return $cart->customer_id
            ? $this->mangopayWalletRepository->findOneByField('customer_id', $cart->customer_id)
            : $this->mangopayWalletRepository->findOneByField('cart_id', $cart->id);
    }

    /**
     * Verify the PayIn with MangoPay and turn it into the cart's order, refunding a charge that
     * cannot become an order.
     *
     * @return array{status: string, order?: mixed}
     */
    protected function placeOnce($cart, string $payInId): array
    {
        if ($this->escrowedAmountRepository->findOneByField('payin_id', $payInId)) {
            return ['status' => self::USED];
        }

        $wallet = $this->buyerWallet($cart);

        $payIn = $wallet ? $this->fetchPayIn($payInId) : null;

        if (
            ! $payIn
            || ($payIn->Status ?? null) !== 'SUCCEEDED'
            || (string) ($payIn->CreditedWalletId ?? '') !== (string) $wallet->wallet_id
        ) {
            Log::warning('MangoPay PayIn '.$payInId.' was not accepted for cart '.$cart->id.': status '.($payIn->Status ?? 'unknown').'.');

            return ['status' => self::REFUSED];
        }

        if (
            ! $cart->is_active
            || ! $this->coversCart($payIn, $cart)
        ) {
            return $this->refund($payIn, $wallet, 'the PayIn does not match the active cart '.$cart->id);
        }

        Cart::setCart($cart);

        try {
            $order = $this->orderRepository->create(
                (new OrderResource($cart))->jsonSerialize()
            );
        } catch (\Throwable $e) {
            report($e);

            return $this->refund($payIn, $wallet, 'the order of cart '.$cart->id.' could not be created');
        }

        $this->escrowedAmountRepository->create([
            'order_id' => $order->id,
            'wallet_id' => $wallet->wallet_id,
            'escrowed_amount' => $order->base_grand_total,
            'payin_id' => $payInId,
            'transaction_id' => $payInId,
        ]);

        $this->processOrder($order);

        Cart::deActivateCart();

        return [
            'status' => self::PLACED,
            'order' => $order,
        ];
    }

    /**
     * Fetch the PayIn from MangoPay; a gateway error counts as unconfirmed.
     */
    protected function fetchPayIn(string $payInId)
    {
        try {
            return $this->mangopayHelper->getPayIn($payInId);
        } catch (\Throwable $e) {
            Log::error('MangoPay PayIn check failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Whether the PayIn charged exactly the cart's base grand total in the base currency.
     */
    protected function coversCart($payIn, $cart): bool
    {
        return (int) ($payIn->DebitedFunds->Amount ?? -1) === (int) round($cart->base_grand_total * 100)
            && ($payIn->DebitedFunds->Currency ?? null) === core()->getBaseCurrencyCode();
    }

    /**
     * Give a succeeded PayIn back to the buyer's card, so no money is kept without an order.
     *
     * @return array{status: string}
     */
    protected function refund($payIn, $wallet, string $reason): array
    {
        Log::warning('MangoPay PayIn '.$payIn->Id.' is refunded because '.$reason.'.');

        try {
            $this->mangopayHelper->makeRefund(
                $wallet->mangopay_id,
                ((int) $payIn->DebitedFunds->Amount) / 100,
                0,
                (string) $payIn->Id
            );
        } catch (\Throwable $e) {
            Log::error('MangoPay PayIn '.$payIn->Id.' could not be refunded: '.$e->getMessage());
        }

        return ['status' => self::REFUNDED];
    }

    /**
     * Mark the order as processing and invoice it in full, the payment being captured; an invoice
     * failure is reported without undoing the paid order.
     */
    protected function processOrder($order): void
    {
        $this->orderRepository->update(['status' => 'processing'], $order->id);

        if (! $order->canInvoice()) {
            return;
        }

        try {
            $this->invoiceRepository->create($this->prepareInvoiceData($order));
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * Prepare invoice data.
     */
    protected function prepareInvoiceData($order): array
    {
        $invoiceData = [
            'order_id' => $order->id,
        ];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }
}
