@if (
    isset($order)
    && $order->canRefund()
    && optional($order->payment)->method === 'mangopay_standard'
    && bouncer()->hasPermission('sales.refunds.create')
    && bouncer()->hasPermission('marketplace.mangopay.refund')
)
    <a
        href="{{ route('admin.mangopay.refund.create', $order->id) }}"
        class="transparent-button px-1 py-1.5 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
    >
        <span class="icon-cancel text-2xl"></span>

        @lang('mangopay::app.admin.system.mangopay-refund')
    </a>
@endif
