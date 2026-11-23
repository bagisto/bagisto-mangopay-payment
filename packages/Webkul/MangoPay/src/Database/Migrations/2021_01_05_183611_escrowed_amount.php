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
        Schema::create('mangopay_escrowed_amount', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payin_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('wallet_id')->nullable();
            $table->string('escrowed_amount')->nullable();
            $table->string('status')->default(0);

            $table->unsignedInteger('order_id')->nullable();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mangopay_escrowed_amount');
    }
};
