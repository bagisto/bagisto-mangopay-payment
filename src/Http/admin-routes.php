<?php

Route::group(['middleware' => ['admin', 'mangopay']], function () {

    // Wallet Routes
    Route::get('/admin/mangopay/wallets', 'Webkul\MangoPay\Http\Controllers\Admin\WalletController@index')->defaults('_config', [
        'view' => 'mangopay::admin.wallet.index',
    ])->name('admin.mangopay.wallet');

    Route::get('/admin/mangopay/wallets/create', 'Webkul\MangoPay\Http\Controllers\Admin\WalletController@create')->defaults('_config', [
        'redirect' => 'admin.mangopay.wallet',
    ])->name('admin.mangopay.create-wallet');

    // BAnk Routes
    Route::get('/admin/mangopay/save-bank-details', 'Webkul\MangoPay\Http\Controllers\Admin\BankDetailsController@index')->defaults('_config', [
        'view' => 'mangopay::admin.bank.index',
    ])->name('admin.mangopay.save-bank-details');

    Route::post('/admin/mangopay/save-bank-details/store', 'Webkul\MangoPay\Http\Controllers\Admin\BankDetailsController@store')->defaults('_config', [
        'redirect' => 'admin.mangopay.save-bank-details',
    ])->name('admin.mangopay.save-bank-details.store');

    // Transaction Routes
    Route::get('/admin/mangopay/transaction', 'Webkul\MangoPay\Http\Controllers\Admin\TransactionController@index')->defaults('_config', [
        'view' => 'mangopay::admin.transaction.index',
    ])->name('admin.mangopay.transaction');

    Route::get('/admin/mangopay/transfer-amount', 'Webkul\MangoPay\Http\Controllers\Admin\AmountController@index')->defaults('_config', [
        'view' => 'mangopay::admin.amount.index',
    ])->name('admin.mangopay.amount');

    Route::post('/admin/mangopay/release-amount', 'Webkul\MangoPay\Http\Controllers\Admin\TransactionController@releaseAmount')->defaults('_config', [
        'redirect' => 'admin.mangopay.transaction',
    ])->name('admin.mangopay.release-amount');

    // Refund Routes
    Route::get('/admin/mangopay/refund/create/{orderId}', 'Webkul\MangoPay\Http\Controllers\Admin\RefundController@create')->defaults('_config', [
        'view' => 'mangopay::admin.refunds.create',
    ])->name('admin.mangopay.refund.create');

    Route::post('/admin/mangopay/refund/store/{orderId}', 'Webkul\MangoPay\Http\Controllers\Admin\RefundController@store')->defaults('_config', [
        'redirect' => 'admin.sales.orders.view',
    ])->name('admin.mangopay.refund.store');
});