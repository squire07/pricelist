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
        Schema::create('sales_order_types', function (Blueprint $table) {
            $table->id();
            $table->string('sales_type_id', 100)->nullable();
            $table->string('sales_company', 100)->nullable();
            $table->string('sales_order_type', 100)->nullable();
            $table->string('income_account', 100)->nullable();
            $table->string('expense_account', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_types');
    }
};
