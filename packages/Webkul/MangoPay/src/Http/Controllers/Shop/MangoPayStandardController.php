<?php

namespace Webkul\MangoPay\Http\Controllers\Shop;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Webkul\Checkout\Facades\Cart;
use Webkul\MangoPay\Helpers\OrderPlacement;
use Webkul\MangoPay\Helpers\PaymentProcessHelper;
use Webkul\Shop\Http\Controllers\Controller;

class MangoPayStandardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected PaymentProcessHelper $paymentProcessHelper,
        protected OrderPlacement $orderPlacement
    ) {}

    /**
     * Display the redirect page, or send the customer back to the cart when the credentials are missing.
     */
    public function redirect(): View|RedirectResponse
    {
        if (! $this->hasValidCredentials()) {
            session()->flash('warning', trans('mangopay::app.shop.standard.unavailable'));

            return redirect()->route('shop.checkout.cart.index');
        }

        return view('mangopay::shop.checkout.mangopay-redirect');
    }

    /**
     * Cancel MangoPay payment.
     */
    public function cancel(): RedirectResponse
    {
        session()->flash('error', trans('mangopay::app.shop.standard.canceled'));

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Place the order once MangoPay confirms the PayIn this session started; a bare return is
     * refused, and a charge that cannot become an order is refunded.
     */
    public function success(): RedirectResponse
    {
        $cart = Cart::getCart();

        if (! $cart) {
            session()->flash('error', trans('mangopay::app.shop.standard.cart-not-found'));

            return redirect()->route('shop.checkout.cart.index');
        }

        $payInId = (string) session()->get('payin_id');

        if (
            $payInId === ''
            || (string) request()->query('transactionId') !== $payInId
        ) {
            session()->flash('error', trans('mangopay::app.shop.standard.payment-not-confirmed'));

            return redirect()->route('shop.checkout.cart.index');
        }

        if (! $this->orderPlacement->buyerWallet($cart)) {
            session()->flash('error', trans('mangopay::app.shop.standard.wallet-not-found'));

            return redirect()->route('shop.checkout.cart.index');
        }

        $result = $this->orderPlacement->place($cart, $payInId);

        if ($result['status'] === OrderPlacement::PLACED) {
            session()->forget('payin_id');

            session()->flash('order_id', $result['order']->id);

            return redirect()->route('shop.checkout.onepage.success');
        }

        session()->flash('error', trans($result['status'] === OrderPlacement::REFUNDED
            ? 'mangopay::app.shop.standard.payment-refunded'
            : 'mangopay::app.shop.standard.payment-not-confirmed'));

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Redirect the customer to MangoPay; a gateway failure is logged and the customer warned instead.
     */
    public function redirectMangoPay()
    {
        if (! $this->hasValidCredentials()) {
            session()->flash('warning', trans('mangopay::app.shop.standard.unavailable'));

            return redirect()->route('shop.checkout.cart.index');
        }

        try {
            return $this->paymentProcessHelper->authorize();
        } catch (\Exception $e) {
            Log::error('MangoPay payment failed: '.$e->getMessage());

            session()->flash('warning', trans('mangopay::app.shop.standard.unavailable'));

            return redirect()->route('shop.checkout.cart.index');
        }
    }

    /**
     * Determine whether the MangoPay API credentials are configured.
     */
    protected function hasValidCredentials(): bool
    {
        $clientId = core()->getConfigData('sales.payment_methods.mangopay_standard.clientid');
        $passphrase = core()->getConfigData('sales.payment_methods.mangopay_standard.passphrase');

        return ! empty($clientId) && ! empty($passphrase);
    }
}
