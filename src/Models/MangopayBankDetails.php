<?php

namespace Webkul\MangoPay\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\MangoPay\Contracts\MangopayBankDetails as MangopayBankDetailsContract;

class MangopayBankDetails extends Model implements MangopayBankDetailsContract
{
    protected $fillable = [
        'type',
        'iban',
        'bic',
        'account_number',
        'sortcode',
        'aba',
        'bank_name',
        'institution_number',
        'branch_code',
        'owner_name',
        'owner_address',
        'owner_city',
        'owner_region',
        'owner_postal_code',
        'country',
        'seller_id',
        'admin_id',
        'bank_id'
    ];
}

