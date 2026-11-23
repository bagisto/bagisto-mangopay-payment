<?php

return [
    [
        'key' => 'mangopay',
        'name' => 'mangopay::app.admin.mangopay.module-name',
        'route' => 'mangopay.shop.bankdetails',
        'icon' => 'mp-transaction-icon',
        'sort' => 9,
    ], [
        'key' => 'mangopay.bankdetails',
        'name' => 'mangopay::app.admin.bank-details.module-name',
        'route' => 'mangopay.shop.bankdetails',
        'icon' => '',
        'sort' => 9,
    ], [
        'key' => 'mangopay.kyc',
        'name' => 'mangopay::app.admin.kyc.module-name',
        'route' => 'mangopay.shop.kyc',
        'icon' => '',
        'sort' => 10,
    ], [
        'key' => 'mangopay.amount',
        'name' => 'mangopay::app.admin.transaction.module-name',
        'route' => 'mangopay.shop.transactions',
        'icon' => '',
        'sort' => 11,
    ],
];
