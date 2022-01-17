<?php

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency','mangopay']], function () {

    // Auth Routes
    Route::group(['middleware' => ['customer']], function () {

        Route::prefix('marketplace/account')->group(function () {
             
            // Mango Pay Bank Details             
            Route::get('/mangopay/bankdetails', 'Webkul\MangoPay\Http\Controllers\Shop\MangoPayController@bankdetails')->defaults('_config', [
                'view' => 'mangopay::shop.customers.account.mangopay.bankdetails.index',
            ])->name('mangopay.shop.bankdetails');

            Route::post('/mangopay/bankdetails/store', 'Webkul\MangoPay\Http\Controllers\Shop\MangoPayController@storeBankdetails')->defaults('_config', [
                'redirect' => 'mangopay.shop.bankdetails'
            ])->name('mangopay.shop.bankdetails.store');

            // Mango Pay Kyc
            Route::get('/mangopay/kyc', 'Webkul\MangoPay\Http\Controllers\Shop\MangoPayController@kyc')->defaults('_config', [
                'view' => 'mangopay::shop.customers.account.mangopay.kyc.index',
            ])->name('mangopay.shop.kyc');

            Route::get('/mangopay/kyc/create', 'Webkul\MangoPay\Http\Controllers\Shop\MangoPayController@createKyc')->defaults('_config', [
                'view' => 'mangopay::shop.customers.account.mangopay.kyc.create',
            ])->name('mangopay.shop.kyc.create');

            Route::post('/mangopay/kyc/store', 'Webkul\MangoPay\Http\Controllers\Shop\MangoPayController@storeKyc')->defaults('_config', [
                'redirect' => 'mangopay.shop.kyc',
            ])->name('mangopay.shop.kyc.store');

            // Mango Pay Transactions
            Route::get('/mangopay/transactions', 'Webkul\MangoPay\Http\Controllers\Shop\MangoPayController@transactions')->defaults('_config', [
                'view' => 'mangopay::shop.customers.account.mangopay.transactions.index',
            ])->name('mangopay.shop.transactions');
        }); 
    });

    // Payment Routes
    Route::prefix('mangopay/standard')->group(function () {
        Route::get('/redirect', 'Webkul\MangoPay\Http\Controllers\Shop\MangoPayStandardController@redirect')->name('mangopay.standard.redirect');

        Route::get('/success', 'Webkul\MangoPay\Http\Controllers\Shop\MangoPayStandardController@success')->name('mangopay.standard.success');

        Route::get('/cancel', 'Webkul\MangoPay\Http\Controllers\Shop\MangoPayStandardController@cancel')->name('mangopay.standard.cancel');
   
        Route::get('/mangopay', 'Webkul\MangoPay\Http\Controllers\Shop\MangoPayStandardController@redirectMangoPay')->name('mangopay.standard.redirect-mangopay');
    });

});