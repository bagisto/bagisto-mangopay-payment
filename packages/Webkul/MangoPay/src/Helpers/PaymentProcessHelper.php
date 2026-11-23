<?php

namespace Webkul\MangoPay\Helpers;

use Webkul\Checkout\Facades\Cart;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;

class PaymentProcessHelper
{
    /**
     * Legacy MangoPay method code.
     */
    const METHOD_CODE = 'mpmangopay';

    /**
     * Customer id used for guests.
     */
    const GUEST_ID = 0;

    /**
     * Prefix of the PayIn tag naming the cart the PayIn pays for.
     */
    const CART_TAG_PREFIX = 'cart:';

    /**
     * Legacy MangoPay method code.
     *
     * @var string
     */
    protected $_code = self::METHOD_CODE;

    /**
     * Create a new helper instance.
     */
    public function __construct(
        protected MangopayWalletRepository $mangopayWalletRepository,
        protected MangopayHelper $mangopayHelper
    ) {}

    /**
     * Get the URL MangoPay returns the customer to.
     */
    public function getOrderPlaceRedirectUrl(): string
    {
        return route('mangopay.standard.success');
    }

    /**
     * Authorizes payment and redirects to MangoPay.
     */
    public function authorize()
    {
        $cart = Cart::getCart();

        if (! $cart) {
            throw new \Exception('Cart not found. Please try placing the order again.');
        }

        $cardType = 'CB_VISA_MASTERCARD';
        $customerId = $cart->customer_id;

        $mpUserColl = $customerId == ''
            ? $this->mangopayWalletRepository->where('cart_id', $cart->id)->first()
            : $this->mangopayWalletRepository->where('customer_id', $customerId)->first();

        if (! empty($mpUserColl)) {
            $mangopayId = $mpUserColl->mangopay_id;
            $walletId = $mpUserColl->wallet_id;
        } else {
            $wholeData = $this->getCustomerDataByOrder();
            $result = $this->mangopayHelper->createNatural($wholeData);

            $mpData = explode('split', $result);
            $mangopayId = $mpData[1] ?? null;
            $walletId = $mpData[2] ?? null;

            if (
                ! $mangopayId
                || ! $walletId
            ) {
                throw new \Exception('Failed to retrieve Mangopay user details. Please try again.');
            }
        }

        $result = $this->mangopayHelper->makeCardpayment(
            $cardType,
            $mangopayId,
            $walletId,
            $cart->base_grand_total,
            0,
            self::CART_TAG_PREFIX.$cart->id
        );

        session()->put('payin_id', $result->Id);

        if (empty($result->ExecutionDetails->RedirectURL)) {
            throw new \Exception('MangoPay did not return a redirect URL.');
        }

        return redirect()->to($result->ExecutionDetails->RedirectURL);
    }

    /**
     * Get the id of the cart a PayIn's tag names, or null when the tag names none.
     */
    public function cartIdFromTag(?string $tag): ?int
    {
        if (
            ! $tag
            || ! str_starts_with($tag, self::CART_TAG_PREFIX)
        ) {
            return null;
        }

        $cartId = substr($tag, strlen(self::CART_TAG_PREFIX));

        return ctype_digit($cartId) ? (int) $cartId : null;
    }

    /**
     * Build the MangoPay natural-user data from the current cart.
     */
    public function getCustomerDataByOrder(): array
    {
        $cart = Cart::getCart();

        if (! $cart) {
            throw new \Exception('Cart not found. Unable to retrieve customer data.');
        }

        return [
            'fname' => $cart->customer_first_name,
            'lname' => $cart->customer_last_name,
            'country_id' => 'IN',
            'email' => $cart->customer_email,
            'usertype' => 'Customer',
            'description' => 'Customer Create Wallet',
        ];
    }
}
