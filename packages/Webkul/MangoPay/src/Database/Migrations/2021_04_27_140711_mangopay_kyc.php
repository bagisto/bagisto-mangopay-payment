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
        Schema::create('mangopay_kyc', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mangopay_file_id');
            $table->string('type')->nullable();
            $table->string('file')->nullable();
            $table->string('status')->nullable();
            $table->integer('seller_id')->unsigned()->nullable();
            $table->foreign('seller_id')->references('id')->on('marketplace_sellers')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mangopay_kyc');
    }
};
