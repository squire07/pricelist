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
        Schema::create('transaction_listings', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('invoice_number', 50)->nullable();
            $table->integer('bcid')->nullable();
            $table->string('account_title', 50)->nullable();
            $table->float('debit')->nullable();
            $table->float('credit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_listings');
    }
};
