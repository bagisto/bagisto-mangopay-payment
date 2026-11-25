<?php

use Webkul\Checkout\Models\Cart;
use Webkul\MangoPay\Models\EscrowedAmount;
use Webkul\MangoPay\Tests\Doubles\FakeMangoPayApi;
use Webkul\Sales\Models\Order;

beforeEach(function () {
    $this->configureMangoPay();

    $this->fakeMangoPay();

    $customer = $this->loginAsCustomer();

    $cartId = $this->prepareCartForCheckout($this->createSimpleProduct(), [], 'free_free', 'mangopay_standard');

    $this->cart = Cart::query()->findOrFail($cartId);

    $this->createMangoPayWallet([
        'customer_id' => $customer->id,
        'cart_id' => $cartId,
    ], 'wallet-4004', 'user-1001');

    $this->paidCents = (int) round($this->cart->base_grand_total * 100);

    $this->cartTag = 'cart:'.$cartId;

    auth()->guard('customer')->logout();
});

/**
 * Send a MangoPay hook notification for the given event and PayIn.
 */
function mangoPayHook($test, string $eventType, string $payInId = 'payin-5005')
{
    return $test->get(route('mangopay.webhook', [
        'EventType' => $eventType,
        'RessourceId' => $payInId,
        'Date' => time(),
    ]));
}

// ====================================================================
// Succeeded PayIns
// ====================================================================

it('places the order of a cart whose payin mangopay reports as succeeded', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('SUCCEEDED', 'wallet-4004', $this->paidCents, null, $this->cartTag);

    mangoPayHook($this, 'PAYIN_NORMAL_SUCCEEDED')->assertOk();

    $order = Order::query()->where('cart_id', $this->cart->id)->firstOrFail();

    expect($order->status)->toBe('processing')
        ->and($order->invoices()->count())->toBe(1)
        ->and(EscrowedAmount::query()->where('payin_id', 'payin-5005')->value('order_id'))->toBe($order->id)
        ->and((bool) $this->cart->fresh()->is_active)->toBeFalse();
});

it('places the order only once when mangopay reports the payin twice', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('SUCCEEDED', 'wallet-4004', $this->paidCents, null, $this->cartTag);

    mangoPayHook($this, 'PAYIN_NORMAL_SUCCEEDED')->assertOk();

    mangoPayHook($this, 'PAYIN_NORMAL_SUCCEEDED')->assertOk();

    expect(Order::query()->where('cart_id', $this->cart->id)->count())->toBe(1)
        ->and(EscrowedAmount::query()->where('payin_id', 'payin-5005')->count())->toBe(1)
        ->and(FakeMangoPayApi::called('PayIns', 'CreateRefund'))->toBeFalse();
});

it('reads what the payin paid from the api, not from the notification', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('FAILED', 'wallet-4004', $this->paidCents, null, $this->cartTag);

    mangoPayHook($this, 'PAYIN_NORMAL_SUCCEEDED')->assertOk();

    expect(Order::query()->where('cart_id', $this->cart->id)->exists())->toBeFalse()
        ->and(FakeMangoPayApi::called('PayIns', 'CreateRefund'))->toBeFalse();
});

it('places nothing for a payin credited to another wallet', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('SUCCEEDED', 'wallet-other', $this->paidCents, null, $this->cartTag);

    mangoPayHook($this, 'PAYIN_NORMAL_SUCCEEDED')->assertOk();

    expect(Order::query()->where('cart_id', $this->cart->id)->exists())->toBeFalse()
        ->and(FakeMangoPayApi::called('PayIns', 'CreateRefund'))->toBeFalse();
});

it('places nothing for a payin that names no cart', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('SUCCEEDED', 'wallet-4004', $this->paidCents);

    mangoPayHook($this, 'PAYIN_NORMAL_SUCCEEDED')->assertOk();

    expect(Order::query()->where('cart_id', $this->cart->id)->exists())->toBeFalse();
});

it('refunds a succeeded payin that does not cover the cart', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('SUCCEEDED', 'wallet-4004', $this->paidCents - 1, null, $this->cartTag);

    mangoPayHook($this, 'PAYIN_NORMAL_SUCCEEDED')->assertOk();

    $refund = FakeMangoPayApi::callsTo('PayIns', 'CreateRefund');

    expect(Order::query()->where('cart_id', $this->cart->id)->exists())->toBeFalse()
        ->and($refund)->toHaveCount(1)
        ->and($refund[0]['argument'])->toBe('payin-5005')
        ->and($refund[0]['arguments'][1]->DebitedFunds->Amount)->toBe($this->paidCents - 1);
});

// ====================================================================
// Other Notifications
// ====================================================================

it('acknowledges a failed payin without placing an order', function () {
    mangoPayHook($this, 'PAYIN_NORMAL_FAILED')->assertOk();

    expect(Order::query()->where('cart_id', $this->cart->id)->exists())->toBeFalse()
        ->and(FakeMangoPayApi::called('PayIns', 'Get'))->toBeFalse();
});

it('acknowledges an event it does not handle without calling mangopay', function () {
    mangoPayHook($this, 'KYC_SUCCEEDED')->assertOk();

    expect(FakeMangoPayApi::$calls)->toBe([]);
});

it('needs no csrf token, being a get', function () {
    expect(app('router')->getRoutes()->getByName('mangopay.webhook')->methods())->toBe(['GET', 'HEAD']);
});
