<?php

use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Webkul\MangoPay\Models\EscrowedAmount;
use Webkul\MangoPay\Tests\Doubles\FakeMangoPayApi;
use Webkul\Sales\Repositories\RefundRepository;

beforeEach(function () {
    $this->configureMangoPay();

    $this->fakeMangoPay();

    $this->loginAsAdmin();

    $this->order = $this->createOrder(['payment_method' => 'mangopay_standard']);

    $this->invoiceOrder($this->order);

    $this->order->refresh();

    $this->createMangoPayWallet(['customer_id' => $this->order->customer_id], 'wallet-buyer', 'user-buyer');

    $this->escrow = EscrowedAmount::query()->create([
        'order_id' => $this->order->id,
        'wallet_id' => 'wallet-buyer',
        'escrowed_amount' => $this->order->base_grand_total,
        'payin_id' => 'payin-5005',
        'transaction_id' => 'payin-5005',
        'status' => 0,
    ]);

    $this->item = $this->order->items->first();
});

/**
 * The refund form payload for the order's first item.
 */
function refundPayload($item, array $refund = []): array
{
    return [
        'refund' => array_merge([
            'items' => [$item->id => 1],
            'shipping' => 0,
            'adjustment_refund' => 0,
            'adjustment_fee' => 0,
        ], $refund),
    ];
}

// ====================================================================
// Refund Amount
// ====================================================================

it('refunds the refund grand total to the original payin, counting the adjustments once', function () {
    $payload = refundPayload($this->item, ['adjustment_fee' => 5]);

    $grandTotal = app(RefundRepository::class)->getOrderItemsRefundSummary($payload['refund'], $this->order->id)['grand_total']['price'];

    $this->post(route('admin.mangopay.refund.store', $this->order->id), $payload)
        ->assertRedirect(route('admin.sales.orders.view', $this->order->id));

    $call = FakeMangoPayApi::callsTo('PayIns', 'CreateRefund')[0];

    expect($call['arguments'][0])->toBe('payin-5005')
        ->and($call['arguments'][1]->AuthorId)->toBe('user-buyer')
        ->and($call['arguments'][1]->DebitedFunds->Amount)->toBe((int) round($grandTotal * 100))
        ->and($grandTotal)->toEqualWithDelta((float) $this->item->base_price + (float) $this->item->base_tax_amount - (float) $this->item->base_discount_amount - 5, 0.001)
        ->and($this->order->refunds()->count())->toBe(1);
});

it('records no refund when mangopay refuses it', function () {
    FakeMangoPayApi::$responses['PayIns.CreateRefund'] = (object) [
        'Id' => 'refund-6006',
        'Status' => 'FAILED',
        'ResultMessage' => 'Refund refused',
    ];

    $this->post(route('admin.mangopay.refund.store', $this->order->id), refundPayload($this->item))
        ->assertSessionHas('error', 'Refund refused');

    expect($this->order->refunds()->count())->toBe(0);
});

// ====================================================================
// Refused Refunds
// ====================================================================

it('refuses a refund once the escrow was released to the sellers', function () {
    $this->escrow->update(['status' => 1]);

    $this->post(route('admin.mangopay.refund.store', $this->order->id), refundPayload($this->item))
        ->assertSessionHas('error', trans('mangopay::app.admin.response.already-released'));

    expect(FakeMangoPayApi::called('PayIns', 'CreateRefund'))->toBeFalse()
        ->and($this->order->refunds()->count())->toBe(0);
});

it('refuses an item of another order', function () {
    $other = $this->createOrder()->items->first();

    $this->post(route('admin.mangopay.refund.store', $this->order->id), [
        'refund' => [
            'items' => [$other->id => 1],
            'shipping' => 0,
        ],
    ])->assertSessionHas('error');

    expect(FakeMangoPayApi::called('PayIns', 'CreateRefund'))->toBeFalse();
});

it('refuses more shipping than was invoiced', function () {
    $this->post(route('admin.mangopay.refund.store', $this->order->id), refundPayload($this->item, [
        'shipping' => (float) $this->order->base_shipping_invoiced + 1,
    ]))->assertSessionHasErrors('refund.shipping');

    expect(FakeMangoPayApi::called('PayIns', 'CreateRefund'))->toBeFalse();
});

it('refuses a refund for an order paid without mangopay', function () {
    $this->escrow->delete();

    $this->post(route('admin.mangopay.refund.store', $this->order->id), refundPayload($this->item))
        ->assertSessionHas('error', trans('mangopay::app.admin.response.escrow-not-found'));

    expect(FakeMangoPayApi::called('PayIns', 'CreateRefund'))->toBeFalse();
});

it('refuses a second refund while one for the order runs', function () {
    $lock = Cache::lock('mangopay-refund-'.$this->order->id, 120);

    $lock->get();

    $this->post(route('admin.mangopay.refund.store', $this->order->id), refundPayload($this->item))
        ->assertSessionHas('error', trans('mangopay::app.admin.response.request-in-progress'));

    $lock->release();

    expect(FakeMangoPayApi::called('PayIns', 'CreateRefund'))->toBeFalse();
});

// ====================================================================
// Refund Routes
// ====================================================================

it('does not match the refund form route for a non-numeric order id', function () {
    $this->withoutExceptionHandling();

    expect(fn () => $this->get(config('app.admin_url').'/mangopay/refund/create/abc'))
        ->toThrow(HttpException::class);
});

it('does not match the refund store route for a non-numeric order id', function () {
    $this->withoutExceptionHandling();

    expect(fn () => $this->post(config('app.admin_url').'/mangopay/refund/store/abc'))
        ->toThrow(HttpException::class);
});
