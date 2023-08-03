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
        Schema::table('sales_order_types', function (Blueprint $table) {
            $table->integer('income_account_id')->after('sales_order_type')->nullable();
            $table->integer('expense_account_id')->after('income_account')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_order_types', function (Blueprint $table) {
            $table->dropColumn('income_account_id');
            $table->dropColumn('expense_account_id');
        });
    }
};
