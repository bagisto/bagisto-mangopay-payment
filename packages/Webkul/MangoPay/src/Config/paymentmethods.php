<?php

use Webkul\MangoPay\Payment\Standard;

return [
    'mangopay_standard' => [
        'code' => 'mangopay_standard',
        'title' => 'MangoPay',
        'description' => 'MangoPay',
        'class' => Standard::class,
        'sandbox' => true,
        'active' => true,
        'sort' => 3,
    ],
];
