<?php

return [
    [
        'key' => 'mangopay',
        'name' => 'mangopay::app.admin.mangopay.module-name',
        'route' => 'mangopay.shop.bankdetails',
        'sort' => 14,
    ], [
        'key' => 'mangopay.bankdetails',
        'name' => 'mangopay::app.admin.bank-details.module-name',

        'route' => [
            'mangopay.shop.bankdetails',
            'mangopay.shop.bankdetails.store',
        ],

        'sort' => 9,
    ], [
        'key' => 'mangopay.kyc',
        'name' => 'mangopay::app.admin.kyc.module-name',

        'route' => [
            'mangopay.shop.kyc',
            'mangopay.shop.kyc.create',
            'mangopay.shop.kyc.store',
        ],

        'sort' => 10,
    ], [
        'key' => 'mangopay.amount',
        'name' => 'mangopay::app.admin.transaction.module-name',
        'route' => 'mangopay.shop.transactions',
        'sort' => 11,
    ],
];
