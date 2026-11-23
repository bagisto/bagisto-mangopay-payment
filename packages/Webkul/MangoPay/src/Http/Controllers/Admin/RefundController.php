<?php

namespace Webkul\MangoPay\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\MangoPay\Helpers\MangopayHelper;
use Webkul\MangoPay\Repositories\EscrowedAmountRepository;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\RefundRepository;

class RefundController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected RefundRepository $refundRepository,
        protected MangopayHelper $mangopayHelper,
        protected EscrowedAmountRepository $escrowedAmountRepository,
        protected MangopayWalletRepository $mangopayWalletRepository
    ) {}

    /**
     * Show the form for creating a new refund.
     */
    public function create(int $orderId): View
    {
        $order = $this->orderRepository->findOrFail($orderId);

        return view('mangopay::admin.refunds.create', compact('order'));
    }

    /**
     * Refund the order through MangoPay, then record the refund; one refund per order at a time.
     */
    public function store(Request $request, int $orderId): RedirectResponse
    {
        $order = $this->orderRepository->findOrFail($orderId);

        if (! $order->canRefund()) {
            session()->flash('error', trans('admin::app.sales.refunds.create.creation-error'));

            return redirect()->back();
        }

        $request->validate([
            'refund.items' => ['array'],
            'refund.items.*' => ['required', 'numeric', 'min:0'],
            'refund.shipping' => ['sometimes', 'numeric', 'min:0', 'max:'.($order->base_shipping_invoiced - $order->base_shipping_refunded)],
            'refund.adjustment_refund' => ['sometimes', 'numeric', 'min:0'],
            'refund.adjustment_fee' => ['sometimes', 'numeric', 'min:0'],
        ]);

        $lock = Cache::lock('mangopay-refund-'.$orderId, 120);

        if (! $lock->get()) {
            session()->flash('error', trans('mangopay::app.admin.response.request-in-progress'));

            return redirect()->back();
        }

        try {
            return $this->refund($request->all(), $order);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            return redirect()->back();
        } finally {
            $lock->release();
        }
    }

    /**
     * Send the refund's grand total back to the buyer's card, then create the Bagisto refund.
     */
    protected function refund(array $data, $order): RedirectResponse
    {
        $data['refund']['shipping'] = $data['refund']['shipping'] ?? 0;
        $data['refund']['adjustment_refund'] = $data['refund']['adjustment_refund'] ?? 0;
        $data['refund']['adjustment_fee'] = $data['refund']['adjustment_fee'] ?? 0;

        if (array_diff(array_keys($data['refund']['items'] ?? []), $order->items->pluck('id')->all())) {
            session()->flash('error', trans('admin::app.sales.refunds.create.invalid-qty'));

            return redirect()->back();
        }

        $totals = $this->refundRepository->getOrderItemsRefundSummary($data['refund'], $order->id);

        $refundAmount = round((float) $totals['grand_total']['price'], 2);

        $maxRefundAmount = round((float) $order->base_grand_total_invoiced - (float) $order->base_grand_total_refunded, 2);

        if ($refundAmount <= 0) {
            session()->flash('error', trans('admin::app.sales.refunds.create.invalid-refund-amount-error'));

            return redirect()->back();
        }

        if ($refundAmount > $maxRefundAmount) {
            session()->flash('error', trans('admin::app.sales.refunds.create.refund-limit-error', [
                'amount' => core()->formatBasePrice($maxRefundAmount),
            ]));

            return redirect()->back();
        }

        $escrow = $this->escrowedAmountRepository->findOneByField('order_id', $order->id);

        if (! $escrow) {
            session()->flash('error', trans('mangopay::app.admin.response.escrow-not-found'));

            return redirect()->back();
        }

        if ($escrow->status) {
            session()->flash('error', trans('mangopay::app.admin.response.already-released'));

            return redirect()->back();
        }

        $wallet = $this->mangopayWalletRepository->findOneByField('wallet_id', $escrow->wallet_id);

        if (! $wallet) {
            session()->flash('error', trans('mangopay::app.admin.response.buyer-wallet-not-found'));

            return redirect()->back();
        }

        $refund = $this->mangopayHelper->makeRefund(
            $wallet->mangopay_id,
            $refundAmount,
            0,
            $escrow->payin_id
        );

        if (($refund->Status ?? null) === 'FAILED') {
            session()->flash('error', (string) ($refund->ResultMessage ?? trans('mangopay::app.admin.transaction.failed')));

            return redirect()->back();
        }

        $this->refundRepository->create(array_merge($data, [
            'order_id' => $order->id,
        ]));

        session()->flash('success', trans('admin::app.sales.refunds.create.create-success'));

        return redirect()->route('admin.sales.orders.view', $order->id);
    }
}
