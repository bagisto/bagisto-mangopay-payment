<?php

namespace Webkul\MangoPay\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\MangoPay\Contracts\MangopayKyc as MangopayKycContract;

class MangopayKyc extends Model implements MangopayKycContract
{
    protected $fillable = [
        'type',
        'file',
        'seller_id',
        'status'
    ];

    protected $table="mangopay_kyc";
}