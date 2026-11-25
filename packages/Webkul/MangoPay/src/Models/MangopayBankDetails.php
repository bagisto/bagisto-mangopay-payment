<?php

namespace Webkul\MangoPay\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\MangoPay\Contracts\MangopayBankDetails as MangopayBankDetailsContract;

class MangopayBankDetails extends Model implements MangopayBankDetailsContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mangopay_bank_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        'bank_id',
    ];
}
