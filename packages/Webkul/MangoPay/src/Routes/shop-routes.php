<?php

use Illuminate\Support\Facades\Route;
use Webkul\MangoPay\Http\Controllers\Shop\MangoPayController;
use Webkul\MangoPay\Http\Controllers\Shop\MangoPayStandardController;
use Webkul\MangoPay\Http\Controllers\Shop\MangoPayWebhookController;

/**
 * Seller payout onboarding routes, gated on the marketplace rather than the payment method.
 */
Route::group([
    'middleware' => ['web', 'marketplace', 'theme', 'seller', 'seller.locale'],
    'prefix' => 'seller/mangopay',
], function () {
    Route::controller(MangoPayController::class)->group(function () {
        /**
         * MangoPay bank details routes.
         */
        Route::get('bankdetails', 'bankdetails')->name('mangopay.shop.bankdetails');

        Route::post('bankdetails/store', 'storeBankdetails')->name('mangopay.shop.bankdetails.store');

        /**
         * MangoPay KYC routes.
         */
        Route::get('kyc', 'kyc')->name('mangopay.shop.kyc');

        Route::get('kyc/create', 'createKyc')->name('mangopay.shop.kyc.create');

        Route::post('kyc/store', 'storeKyc')->name('mangopay.shop.kyc.store');

        /**
         * MangoPay transaction routes.
         */
        Route::get('transactions', 'transactions')->name('mangopay.shop.transactions');
    });
});

/**
 * MangoPay payment routes (buyer checkout — gated on the payment method).
 */
Route::group(['middleware' => ['web', 'shop', 'mangopay']], function () {
    Route::controller(MangoPayStandardController::class)->prefix('mangopay/standard')->group(function () {
        Route::get('redirect', 'redirect')->name('mangopay.standard.redirect');

        Route::get('success', 'success')->name('mangopay.standard.success');

        Route::get('cancel', 'cancel')->name('mangopay.standard.cancel');

        Route::get('mangopay', 'redirectMangoPay')->name('mangopay.standard.redirect_mangopay');
    });
});

/**
 * MangoPay hook notifications (a GET naming the PayIn, public by design; the PayIn is read back from the API).
 */
Route::get('mangopay/webhook', [MangoPayWebhookController::class, 'handle'])
    ->middleware(['web', 'mangopay'])
    ->name('mangopay.webhook');
