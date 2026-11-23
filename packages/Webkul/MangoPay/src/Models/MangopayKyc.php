<?php

namespace Webkul\MangoPay\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\MangoPay\Contracts\MangopayKyc as MangopayKycContract;

class MangopayKyc extends Model implements MangopayKycContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mangopay_kyc';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'file',
        'seller_id',
        'status',
        'mangopay_file_id',
    ];
}
