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
        Schema::create('mangopay_bank_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('bank_id')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();
            $table->string('account_number')->nullable();
            $table->string('sortcode')->nullable();
            $table->string('aba')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('institution_number')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_address')->nullable();
            $table->string('owner_city')->nullable();
            $table->string('owner_region')->nullable();
            $table->string('owner_postal_code')->nullable();
            $table->string('country')->nullable();

            $table->integer('seller_id')->unsigned()->nullable();
            $table->foreign('seller_id')->references('id')->on('marketplace_sellers')->cascadeOnDelete();

            $table->integer('admin_id')->unsigned()->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mangopay_bank_details');
    }
};
