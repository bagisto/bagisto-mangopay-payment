<?php

return [
    [
        'key' => 'marketplace.mangopay',
        'name' => 'mangopay::app.admin.mangopay.module-name',
        'route' => 'admin.mangopay.wallet',
        'sort' => 11,
        'icon' => '',
    ], [
        'key' => 'marketplace.mangopay.wallet',
        'name' => 'mangopay::app.admin.wallet.module-name',
        'route' => 'admin.mangopay.wallet',
        'icon' => '',
        'sort' => 1,
    ], [
        'key' => 'marketplace.mangopay.bankdetails',
        'name' => 'mangopay::app.admin.bank-details.module-name',
        'route' => 'admin.mangopay.save_bank_details',
        'icon' => '',
        'sort' => 2,
    ], [
        'key' => 'marketplace.mangopay.transaction',
        'name' => 'mangopay::app.admin.transaction.module-name',
        'route' => 'admin.mangopay.transaction',
        'icon' => '',
        'sort' => 3,
    ], [
        'key' => 'marketplace.mangopay.amount',
        'name' => 'mangopay::app.admin.amount.module-name',
        'route' => 'admin.mangopay.amount',
        'icon' => '',
        'sort' => 4,
    ],
];
