<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mangopay_wallets', function (Blueprint $table) {
            $table->increments('id');

            $table->string('wallet_id')->nullable();
            $table->string('mangopay_id')->nullable();

            $table->integer('cart_id')->unsigned()->nullable()->unique();
            $table->foreign('cart_id')->references('id')->on('cart')->nullOnDelete();

            $table->integer('seller_id')->unsigned()->nullable()->unique();
            $table->foreign('seller_id')->references('id')->on('marketplace_sellers')->cascadeOnDelete();

            $table->integer('admin_id')->unsigned()->nullable()->unique();
            $table->foreign('admin_id')->references('id')->on('admins')->cascadeOnDelete();

            $table->integer('customer_id')->unsigned()->nullable()->unique();
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mangopay_wallets');
    }
};
