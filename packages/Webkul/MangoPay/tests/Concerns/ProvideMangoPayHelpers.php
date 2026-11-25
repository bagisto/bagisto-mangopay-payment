<?php

namespace Webkul\MangoPay\Tests\Concerns;

use Illuminate\Support\Facades\Cache;
use Webkul\Checkout\Models\Cart;
use Webkul\Customer\Models\Customer;
use Webkul\MangoPay\Helpers\MangopayHelper;
use Webkul\MangoPay\Models\EscrowedAmount;
use Webkul\MangoPay\Models\MangopayWallet;
use Webkul\MangoPay\Tests\Doubles\FakeMangoPayApi;
use Webkul\MangoPay\Tests\Doubles\TestableMangopayHelper;
use Webkul\Marketplace\Models\Order as SellerOrder;
use Webkul\Marketplace\Models\Seller;
use Webkul\Sales\Models\Order;

trait ProvideMangoPayHelpers
{
    /**
     * Payment settings applied to every test that needs a working MangoPay method.
     */
    public function configureMangoPay(array $overrides = []): void
    {
        $config = array_merge([
            'active' => '1',
            'title' => 'MangoPay',
            'description' => 'Pay securely with MangoPay',
            'sandbox' => '1',
            'clientid' => 'test-client-id',
            'passphrase' => 'test-passphrase',
            'sort' => '1',
        ], $overrides);

        foreach ($config as $field => $value) {
            if ($value === null) {
                continue;
            }

            $this->setConfig('sales.payment_methods.mangopay_standard.'.$field, $value);
        }
    }

    /**
     * Save settings through core's helper, then drop the cached repository reads that outlive a test.
     */
    public function setConfig(array|string $settings, mixed $value = null): void
    {
        parent::setConfig($settings, $value);

        Cache::flush();
    }

    /**
     * An active cart owned by a customer, which the customer-side flows read.
     */
    public function createCartForCustomer(): Cart
    {
        $customer = Customer::factory()->create();

        auth()->guard('customer')->login($customer);

        $cart = Cart::factory()->create([
            'customer_id' => $customer->id,
            'customer_email' => $customer->email,
            'customer_first_name' => $customer->first_name,
            'customer_last_name' => $customer->last_name,
            'is_guest' => 0,
            'is_active' => 1,
        ]);

        \Webkul\Checkout\Facades\Cart::setCart($cart = $cart->fresh());

        return $cart;
    }

    /**
     * The real helper with the SDK swapped for the recorder.
     */
    public function mangopay(): MangopayHelper
    {
        FakeMangoPayApi::reset();

        return app(TestableMangopayHelper::class);
    }

    /**
     * Make every class the container builds use the recorder instead of the MangoPay API.
     */
    public function fakeMangoPay(): void
    {
        FakeMangoPayApi::reset();

        $this->app->instance(MangopayHelper::class, app(TestableMangopayHelper::class));
    }

    /**
     * A MangoPay wallet row for a customer, a guest cart, a seller or an admin.
     */
    public function createMangoPayWallet(array $owner, string $walletId, string $userId): MangopayWallet
    {
        return MangopayWallet::query()->create(array_merge($owner, [
            'wallet_id' => $walletId,
            'mangopay_id' => $userId,
        ]));
    }

    /**
     * A PayIn as MangoPay returns it, for the success check to read.
     */
    public function payIn(string $status, string $walletId, int $cents, ?string $currency = null, ?string $tag = null): object
    {
        $payIn = new \stdClass;

        $payIn->Id = 'payin-5005';
        $payIn->Tag = $tag;
        $payIn->Status = $status;
        $payIn->CreditedWalletId = $walletId;
        $payIn->DebitedFunds = new \stdClass;
        $payIn->DebitedFunds->Amount = $cents;
        $payIn->DebitedFunds->Currency = $currency ?? core()->getBaseCurrencyCode();

        return $payIn;
    }

    /**
     * An order shared by the admin and the given sellers, escrowed in the buyer's wallet.
     *
     * Each seller entry is the Marketplace seller order columns, plus `seller` for the Seller model.
     */
    public function createSharedEscrow(float $grandTotal, array $sellers, array $orderAttributes = []): EscrowedAmount
    {
        $order = $this->createOrder(array_merge([
            'grand_total' => $grandTotal,
            'base_grand_total' => $grandTotal,
            'grand_total_invoiced' => $grandTotal,
            'base_grand_total_invoiced' => $grandTotal,
            'payment_method' => 'mangopay_standard',
        ], $orderAttributes));

        foreach ($sellers as $sellerOrder) {
            $seller = $sellerOrder['seller'] ?? Seller::factory()->create();

            unset($sellerOrder['seller']);

            SellerOrder::query()->create(array_merge([
                'status' => 'processing',
                'commission_percentage' => 10,
            ], $sellerOrder, [
                'marketplace_seller_id' => $seller->id,
                'order_id' => $order->id,
            ]));
        }

        $this->createMangoPayWallet(['customer_id' => $order->customer_id], 'wallet-buyer', 'user-buyer');

        return EscrowedAmount::query()->create([
            'order_id' => $order->id,
            'wallet_id' => 'wallet-buyer',
            'escrowed_amount' => $grandTotal,
            'payin_id' => 'payin-5005',
            'transaction_id' => 'payin-5005',
            'status' => 0,
        ]);
    }
}
