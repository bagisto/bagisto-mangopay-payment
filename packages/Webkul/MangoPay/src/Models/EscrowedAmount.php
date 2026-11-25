<?php

namespace Webkul\MangoPay\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\MangoPay\Contracts\EscrowedAmount as EscrowedAmountContract;

class EscrowedAmount extends Model implements EscrowedAmountContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mangopay_escrowed_amount';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'wallet_id',
        'escrowed_amount',
        'payin_id',
        'transaction_id',
        'status',
    ];
}
