<?php

use Illuminate\Support\Facades\Route;
use Webkul\MangoPay\Http\Controllers\Admin\AmountController;
use Webkul\MangoPay\Http\Controllers\Admin\BankDetailsController;
use Webkul\MangoPay\Http\Controllers\Admin\RefundController;
use Webkul\MangoPay\Http\Controllers\Admin\TransactionController;
use Webkul\MangoPay\Http\Controllers\Admin\WalletController;

Route::group([
    'middleware' => ['web', 'admin', 'mangopay'],
    'prefix' => config('app.admin_url').'/mangopay',
], function () {
    /**
     * Wallet routes.
     */
    Route::controller(WalletController::class)->prefix('wallets')->group(function () {
        Route::get('', 'index')->name('admin.mangopay.wallet');

        Route::post('create', 'create')->name('admin.mangopay.create_wallet');
    });

    /**
     * Bank details routes.
     */
    Route::controller(BankDetailsController::class)->prefix('save-bank-details')->group(function () {
        Route::get('', 'index')->name('admin.mangopay.save_bank_details');

        Route::post('store', 'store')->name('admin.mangopay.save_bank_details.store');
    });

    /**
     * Transaction routes.
     */
    Route::controller(TransactionController::class)->group(function () {
        Route::get('transaction', 'index')->name('admin.mangopay.transaction');

        Route::post('release-amount/{id}', 'releaseAmount')->name('admin.mangopay.release_amount')->whereNumber('id');
    });

    /**
     * Transfer amount (escrow) routes.
     */
    Route::controller(AmountController::class)->prefix('transfer-amount')->group(function () {
        Route::get('', 'index')->name('admin.mangopay.amount');
    });

    /**
     * Refund routes.
     */
    Route::controller(RefundController::class)->prefix('refund')->group(function () {
        Route::get('create/{orderId}', 'create')->name('admin.mangopay.refund.create')->whereNumber('orderId');

        Route::post('store/{orderId}', 'store')->name('admin.mangopay.refund.store')->whereNumber('orderId');
    });
});
