<?php

namespace Webkul\MangoPay\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Webkul\MangoPay\Models\EscrowedAmount;
use Webkul\MangoPay\Models\MangopayBankDetails;
use Webkul\MangoPay\Models\MangopayKyc;
use Webkul\MangoPay\Models\MangopayWallet;
use Webkul\MangoPay\Models\Transaction;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    /**
     * The models registered with Concord.
     *
     * @var array
     */
    protected $models = [
        MangopayBankDetails::class,
        MangopayKyc::class,
        MangopayWallet::class,
        EscrowedAmount::class,
        Transaction::class,
    ];
}
