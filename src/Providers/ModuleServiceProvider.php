<?php

namespace Webkul\MangoPay\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Webkul\MangoPay\Models\MangopayBankDetails::class,
        \Webkul\MangoPay\Models\MangopayKyc::class,
        \Webkul\MangoPay\Models\MangopayWallet::class,
        \Webkul\MangoPay\Models\EscrowedAmount::class,
        \Webkul\MangoPay\Models\Transaction::class
    ];
}