<?php

namespace Webkul\MangoPay\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Product\Models\ProductProxy;
use Webkul\MangoPay\Contracts\EscrowedAmount as EscrowedAmountContract;

class EscrowedAmount extends Model implements EscrowedAmountContract
{
    protected $fillable = [
        'order_id',
        'wallet_id',
        'escrowed_amount',
        'payin_id',
        'transaction_id',
    ];

    protected $table = "mangopay_escrowed_amount";
}