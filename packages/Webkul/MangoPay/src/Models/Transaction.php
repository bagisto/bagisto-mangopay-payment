<?php

namespace Webkul\MangoPay\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\MangoPay\Contracts\Transaction as TransactionContract;

class Transaction extends Model implements TransactionContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mangopay_transaction_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'amount',
        'message',
        'status',
        'seller_id',
        'admin_id',
    ];
}
