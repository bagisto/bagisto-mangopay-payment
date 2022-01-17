<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MangopayWallet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('mangopay_wallets', function (Blueprint $table) {
            $table->increments('id');

            $table->string('wallet_id')->nullable();
            $table->string('mangopay_id')->nullable();  
            
            $table->integer('cart_id')->unsigned()->nullable()->unique();
            $table->foreign('cart_id')->references('id')->on('cart')->onDelete('cascade');
                       
            $table->integer('seller_id')->unsigned()->nullable()->unique();
            $table->foreign('seller_id')->references('id')->on('marketplace_sellers')->onDelete('cascade');
            
            $table->integer('admin_id')->unsigned()->nullable()->unique();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            
            $table->integer('customer_id')->unsigned()->nullable()->unique();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('mangopay_wallets');
    }
}
