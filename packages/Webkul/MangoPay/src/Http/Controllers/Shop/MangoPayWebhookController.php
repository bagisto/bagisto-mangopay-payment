<?php

namespace Webkul\MangoPay\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\MangoPay\Helpers\MangopayHelper;
use Webkul\MangoPay\Helpers\OrderPlacement;
use Webkul\MangoPay\Helpers\PaymentProcessHelper;
use Webkul\Shop\Http\Controllers\Controller;

class MangoPayWebhookController extends Controller
{
    /**
     * Hook event sent when a card PayIn succeeded.
     */
    const PAYIN_SUCCEEDED = 'PAYIN_NORMAL_SUCCEEDED';

    /**
     * Hook event sent when a card PayIn failed.
     */
    const PAYIN_FAILED = 'PAYIN_NORMAL_FAILED';

    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected MangopayHelper $mangopayHelper,
        protected PaymentProcessHelper $paymentProcessHelper,
        protected OrderPlacement $orderPlacement,
        protected CartRepository $cartRepository
    ) {}

    /**
     * Handle a MangoPay hook notification. The query only names the PayIn: what it paid is always
     * read back from the MangoPay API, and the order is placed with the return page's checks.
     */
    public function handle(Request $request): Response
    {
        $eventType = (string) $request->query('EventType');

        $payInId = (string) $request->query('RessourceId');

        if (
            $payInId === ''
            || ! in_array($eventType, [self::PAYIN_SUCCEEDED, self::PAYIN_FAILED])
        ) {
            return response('', 200);
        }

        if ($eventType === self::PAYIN_FAILED) {
            Log::info('MangoPay hook: PayIn '.$payInId.' failed; no order is placed.');

            return response('', 200);
        }

        $cart = $this->payInCart($payInId);

        if (! $cart) {
            return response('', 200);
        }

        $result = $this->orderPlacement->place($cart, $payInId);

        Log::info('MangoPay hook: PayIn '.$payInId.' of cart '.$cart->id.' '.$result['status'].'.');

        return response('', $result['status'] === OrderPlacement::BUSY ? 409 : 200);
    }

    /**
     * Find the cart a PayIn pays for, through the tag MangoPay returns for it.
     */
    protected function payInCart(string $payInId)
    {
        try {
            $payIn = $this->mangopayHelper->getPayIn($payInId);
        } catch (\Throwable $e) {
            Log::error('MangoPay hook: PayIn '.$payInId.' could not be read: '.$e->getMessage());

            return null;
        }

        $cartId = $this->paymentProcessHelper->cartIdFromTag($payIn->Tag ?? null);

        return $cartId ? $this->cartRepository->find($cartId) : null;
    }
}
