<?php

return [
    [
        'key' => 'sales.payment_methods.mangopay_standard',
        'name' => 'mangopay::app.admin.mangopay.configuration.module-name',
        'info' => 'mangopay::app.admin.mangopay.configuration.info',
        'sort' => 4,

        'fields' => [
            [
                'name' => 'active',
                'title' => 'mangopay::app.admin.mangopay.configuration.status',
                'type' => 'boolean',
                'validation' => 'required',
                'channel_based' => false,
                'locale_based' => true,
            ], [
                'name' => 'title',
                'title' => 'mangopay::app.admin.mangopay.configuration.title',
                'type' => 'text',
                'depends' => 'active:1',
                'validation' => 'required_if:active,1',
                'channel_based' => false,
                'locale_based' => true,
            ], [
                'name' => 'description',
                'title' => 'mangopay::app.admin.mangopay.configuration.description',
                'type' => 'textarea',
                'depends' => 'active:1',
                'channel_based' => true,
                'locale_based' => true,
            ], [
                'name' => 'image',
                'title' => 'mangopay::app.admin.mangopay.configuration.logo',
                'type' => 'image',
                'info' => 'mangopay::app.admin.mangopay.configuration.logo-information',
                'depends' => 'active:1',
                'channel_based' => true,
                'locale_based' => false,
                'validation' => 'mimes:bmp,jpeg,jpg,png,webp',
            ], [
                'name' => 'clientid',
                'title' => 'mangopay::app.admin.mangopay.configuration.client-id',
                'type' => 'text',
                'depends' => 'active:1',
                'validation' => 'required_if:active,1',
                'channel_based' => false,
                'locale_based' => true,
            ], [
                'name' => 'passphrase',
                'title' => 'mangopay::app.admin.mangopay.configuration.passphrase',
                'type' => 'text',
                'depends' => 'active:1',
                'validation' => 'required_if:active,1',
                'channel_based' => false,
                'locale_based' => true,
            ], [
                'name' => 'sandbox',
                'title' => 'mangopay::app.admin.mangopay.configuration.sandbox',
                'type' => 'boolean',
                'info' => 'mangopay::app.admin.mangopay.configuration.production-mode-info',
                'depends' => 'active:1',
                'channel_based' => false,
                'locale_based' => true,
            ], [
                'name' => 'sort',
                'title' => 'mangopay::app.admin.mangopay.configuration.sort-order',
                'type' => 'number',
                'depends' => 'active:1',
            ],
        ],
    ],
];
