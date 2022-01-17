<?php

return [

    [
        'key'    => 'mangopay',
        'name'   => 'mangopay::app.admin.system.module-name',
        'sort'   => 2,   
    ],
    [
        'key'    => 'mangopay.general',
        'name'   => 'mangopay::app.admin.system.general',
        'sort'   => 1,
    ],
    [
        'key'    => 'mangopay.general.general',
        'name'   => 'mangopay::app.admin.system.general',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'active',
                'title'         => 'mangopay::app.admin.system.status',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true
            ]
        ]
    ],

    [
        'key'    => 'sales.paymentmethods.mangopay_standard',
        'name'   => 'mangopay::app.admin.system.module-name',
        'sort'   => 4,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'mangopay::app.admin.system.title',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => false,
                'locale_based'  => true,
            ],  [
                'name'          => 'clientid',
                'title'         => 'mangopay::app.admin.system.client-id',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => false,
                'locale_based'  => true,
            ],  [
                'name'          => 'passphrase',
                'title'         => 'mangopay::app.admin.system.passphrase',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'active',
                'title'         => 'mangopay::app.admin.system.status',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true
            ], [
                'name'          => 'sandbox',
                'title'         => 'mangopay::app.admin.system.sandbox',
                'type'          => 'boolean',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'    => 'sort',
                'title'   => 'mangopay::app.admin.system.sort_order',
                'type'    => 'select',
                'options' => [
                    [
                        'title' => '1',
                        'value' => 1,
                    ], [
                        'title' => '2',
                        'value' => 2,
                    ], [
                        'title' => '3',
                        'value' => 3,
                    ], [
                        'title' => '4',
                        'value' => 4,
                    ], [
                        'title' => '5',
                        'value' => 5,
                    ],
                ],
            ]
        ]
    ]
];