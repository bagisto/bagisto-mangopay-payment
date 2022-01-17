<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EscrowedAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mangopay_escrowed_amount', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payin_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('wallet_id')->nullable();
            $table->string('escrowed_amount')->nullable();
            $table->string('status')->default(0);
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mangopay_escrowed_amount');
    }
}
