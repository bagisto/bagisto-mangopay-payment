<?php

namespace Webkul\MangoPay\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\MangoPay\Contracts\MangopayWallet as MangopayWalletContract;

class MangopayWallet extends Model implements MangopayWalletContract
{
    protected $fillable = [
        'admin_id',
        'mangopay_id',
        'wallet_id',
        'seller_id',
        'customer_id',
        'cart_id'
    ];
}