<?php

use Webkul\Checkout\Models\Cart;
use Webkul\MangoPay\Helpers\PaymentProcessHelper;
use Webkul\MangoPay\Models\EscrowedAmount;
use Webkul\MangoPay\Tests\Doubles\FakeMangoPayApi;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\OrderRepository;

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
});

// ====================================================================
// Refused Returns
// ====================================================================

it('refuses a return when this session never started a payment', function () {
    $this->get(route('mangopay.standard.success', ['transactionId' => 'payin-5005']))
        ->assertRedirect(route('shop.checkout.cart.index'))
        ->assertSessionHas('error', trans('mangopay::app.shop.standard.payment-not-confirmed'));

    expect(Order::query()->where('cart_id', $this->cart->id)->exists())->toBeFalse()
        ->and(FakeMangoPayApi::called('PayIns', 'Get'))->toBeFalse();
});

it('refuses a return for another payin than the one this session started', function () {
    $this->withSession(['payin_id' => 'payin-5005'])
        ->get(route('mangopay.standard.success', ['transactionId' => 'payin-other']))
        ->assertRedirect(route('shop.checkout.cart.index'));

    expect(Order::query()->where('cart_id', $this->cart->id)->exists())->toBeFalse();
});

it('refuses a payin that mangopay did not mark as succeeded', function (string $status) {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn($status, 'wallet-4004', $this->paidCents);

    $this->withSession(['payin_id' => 'payin-5005'])
        ->get(route('mangopay.standard.success', ['transactionId' => 'payin-5005']))
        ->assertRedirect(route('shop.checkout.cart.index'))
        ->assertSessionHas('error', trans('mangopay::app.shop.standard.payment-not-confirmed'));

    expect(Order::query()->where('cart_id', $this->cart->id)->exists())->toBeFalse()
        ->and(EscrowedAmount::query()->where('payin_id', 'payin-5005')->exists())->toBeFalse();
})->with(['FAILED', 'CREATED']);

it('refunds a payin for less than the cart total instead of placing the order', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('SUCCEEDED', 'wallet-4004', $this->paidCents - 1);

    $this->withSession(['payin_id' => 'payin-5005'])
        ->get(route('mangopay.standard.success', ['transactionId' => 'payin-5005']))
        ->assertRedirect(route('shop.checkout.cart.index'))
        ->assertSessionHas('error', trans('mangopay::app.shop.standard.payment-refunded'));

    $refund = FakeMangoPayApi::callsTo('PayIns', 'CreateRefund');

    expect(Order::query()->where('cart_id', $this->cart->id)->exists())->toBeFalse()
        ->and($refund)->toHaveCount(1)
        ->and($refund[0]['argument'])->toBe('payin-5005')
        ->and($refund[0]['arguments'][1]->DebitedFunds->Amount)->toBe($this->paidCents - 1);
});

it('refuses a payin credited to another wallet', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('SUCCEEDED', 'wallet-other', $this->paidCents);

    $this->withSession(['payin_id' => 'payin-5005'])
        ->get(route('mangopay.standard.success', ['transactionId' => 'payin-5005']))
        ->assertRedirect(route('shop.checkout.cart.index'));

    expect(Order::query()->where('cart_id', $this->cart->id)->exists())->toBeFalse()
        ->and(FakeMangoPayApi::called('PayIns', 'CreateRefund'))->toBeFalse();
});

it('refuses a payin in another currency than the base currency', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('SUCCEEDED', 'wallet-4004', $this->paidCents, 'XXX');

    $this->withSession(['payin_id' => 'payin-5005'])
        ->get(route('mangopay.standard.success', ['transactionId' => 'payin-5005']))
        ->assertRedirect(route('shop.checkout.cart.index'));

    expect(Order::query()->where('cart_id', $this->cart->id)->exists())->toBeFalse();
});

it('treats a gateway error while checking the payin as not paid', function () {
    FakeMangoPayApi::$throw = new Exception('MangoPay responded 500');

    $this->withSession(['payin_id' => 'payin-5005'])
        ->get(route('mangopay.standard.success', ['transactionId' => 'payin-5005']))
        ->assertRedirect(route('shop.checkout.cart.index'));

    expect(Order::query()->where('cart_id', $this->cart->id)->exists())->toBeFalse();
});

// ====================================================================
// Confirmed Payment
// ====================================================================

it('places, invoices and escrows the order once mangopay confirms the payin', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('SUCCEEDED', 'wallet-4004', $this->paidCents);

    $this->withSession(['payin_id' => 'payin-5005'])
        ->get(route('mangopay.standard.success', ['transactionId' => 'payin-5005']))
        ->assertRedirect(route('shop.checkout.onepage.success'));

    $order = Order::query()->where('cart_id', $this->cart->id)->firstOrFail();

    expect($order->status)->toBe('processing')
        ->and($order->invoices()->count())->toBe(1);

    $escrow = EscrowedAmount::query()->where('order_id', $order->id)->firstOrFail();

    expect($escrow->payin_id)->toBe('payin-5005')
        ->and($escrow->wallet_id)->toBe('wallet-4004')
        ->and((float) $escrow->escrowed_amount)->toBe((float) $order->base_grand_total);
});

it('places the order only once when the same payin returns again', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('SUCCEEDED', 'wallet-4004', $this->paidCents);

    $this->withSession(['payin_id' => 'payin-5005'])
        ->get(route('mangopay.standard.success', ['transactionId' => 'payin-5005']));

    $this->withSession(['payin_id' => 'payin-5005'])
        ->get(route('mangopay.standard.success', ['transactionId' => 'payin-5005']));

    expect(EscrowedAmount::query()->where('payin_id', 'payin-5005')->count())->toBe(1)
        ->and(Order::query()->where('cart_id', $this->cart->id)->count())->toBe(1);
});

it('charges the cart base total in the base currency', function () {
    app(PaymentProcessHelper::class)->authorize();

    $sent = FakeMangoPayApi::firstArgument('PayIns', 'Create');

    expect($sent->DebitedFunds->Amount)->toBe($this->paidCents)
        ->and($sent->DebitedFunds->Currency)->toBe(core()->getBaseCurrencyCode())
        ->and(session('payin_id'))->toBe('payin-5005');
});

it('refunds the payin when the paid order cannot be created', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('SUCCEEDED', 'wallet-4004', $this->paidCents);

    $this->mock(OrderRepository::class)
        ->shouldReceive('create')
        ->andThrow(new Exception('Not enough stock'));

    $this->withSession(['payin_id' => 'payin-5005'])
        ->get(route('mangopay.standard.success', ['transactionId' => 'payin-5005']))
        ->assertRedirect(route('shop.checkout.cart.index'))
        ->assertSessionHas('error', trans('mangopay::app.shop.standard.payment-refunded'));

    $refund = FakeMangoPayApi::callsTo('PayIns', 'CreateRefund');

    expect(EscrowedAmount::query()->where('payin_id', 'payin-5005')->exists())->toBeFalse()
        ->and($refund)->toHaveCount(1)
        ->and($refund[0]['arguments'][1]->DebitedFunds->Amount)->toBe($this->paidCents);
});

it('tags the payin with the cart it pays for, so the mangopay hook can find it', function () {
    app(PaymentProcessHelper::class)->authorize();

    expect(FakeMangoPayApi::firstArgument('PayIns', 'Create')->Tag)->toBe('cart:'.$this->cart->id);
});

it('ignores the mangopay hook for a payin the return page already turned into an order', function () {
    FakeMangoPayApi::$responses['PayIns.Get'] = $this->payIn('SUCCEEDED', 'wallet-4004', $this->paidCents, null, 'cart:'.$this->cart->id);

    $this->withSession(['payin_id' => 'payin-5005'])
        ->get(route('mangopay.standard.success', ['transactionId' => 'payin-5005']))
        ->assertRedirect(route('shop.checkout.onepage.success'));

    $this->get(route('mangopay.webhook', [
        'EventType' => 'PAYIN_NORMAL_SUCCEEDED',
        'RessourceId' => 'payin-5005',
    ]))
        ->assertOk();

    expect(Order::query()->where('cart_id', $this->cart->id)->count())->toBe(1)
        ->and(FakeMangoPayApi::called('PayIns', 'CreateRefund'))->toBeFalse();
});
