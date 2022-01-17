<?php

namespace Webkul\MangoPay\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Product\Models\ProductProxy;
use Webkul\MangoPay\Contracts\Transaction as TransactionContract;

class Transaction extends Model implements TransactionContract
{
    protected $fillable = [
       'transaction_id',
       'amount',
       'message',
       'status',
       'seller_id',
       'admin_id'
    ];

    protected $table= "mangopay_transaction_details";
}