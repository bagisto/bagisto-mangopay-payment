<?php

return [
    [
        'key' => 'marketplace.mangopay',
        'name' => 'mangopay::app.admin.mangopay.module-name',
        'route' => 'admin.mangopay.wallet',
        'sort' => 2,
        'icon-class' => 'mangopay-icon',
    ], [
        'key' => 'marketplace.mangopay.wallet',
        'name' => 'mangopay::app.admin.wallet.module-name',
        'route' => 'admin.mangopay.wallet',
        'sort' => 6
    ] , [
        'key' => 'marketplace.mangopay.bankdetails',
        'name' => 'mangopay::app.admin.bank-details.module-name',
        'route' => 'admin.mangopay.save-bank-details',
        'sort' => 6
    ] , [
        'key' => 'marketplace.mangopay.transaction',
        'name' => 'mangopay::app.admin.transaction.module-name',
        'route' => 'admin.mangopay.transaction',
        'sort' => 6
    ] , [
        'key' => 'marketplace.mangopay.amount',
        'name' => 'mangopay::app.admin.amount.module-name',
        'route' => 'admin.mangopay.amount',
        'sort' => 6
    ]
  ];