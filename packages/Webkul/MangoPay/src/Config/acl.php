<?php

return [
    [
        'key' => 'marketplace.mangopay',
        'name' => 'mangopay::app.admin.mangopay.module-name',
        'route' => 'admin.mangopay.wallet',
        'sort' => 11,
    ], [
        'key' => 'marketplace.mangopay.wallet',
        'name' => 'mangopay::app.admin.wallet.module-name',

        'route' => [
            'admin.mangopay.wallet',
            'admin.mangopay.create_wallet',
        ],

        'sort' => 1,
    ], [
        'key' => 'marketplace.mangopay.bankdetails',
        'name' => 'mangopay::app.admin.bank-details.module-name',

        'route' => [
            'admin.mangopay.save_bank_details',
            'admin.mangopay.save_bank_details.store',
        ],

        'sort' => 2,
    ], [
        'key' => 'marketplace.mangopay.transaction',
        'name' => 'mangopay::app.admin.transaction.module-name',
        'route' => 'admin.mangopay.transaction',
        'sort' => 3,
    ], [
        'key' => 'marketplace.mangopay.amount',
        'name' => 'mangopay::app.admin.amount.module-name',

        'route' => [
            'admin.mangopay.amount',
            'admin.mangopay.release_amount',
        ],

        'sort' => 4,
    ], [
        'key' => 'marketplace.mangopay.refund',
        'name' => 'mangopay::app.admin.system.mangopay-refund',

        'route' => [
            'admin.mangopay.refund.create',
            'admin.mangopay.refund.store',
        ],

        'sort' => 5,
    ],
];
