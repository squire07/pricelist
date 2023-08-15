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
        Schema::table('sales', function (Blueprint $table) {
            $table->tinyInteger('payment_method')->after('deleted')->default(false);
            $table->string('group_name', 100)->after('payment_method')->nullable();
            $table->string('company', 100)->after('group_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('payment_method');
            $table->dropColumn('group_name');
            $table->dropColumn('company');
        });
    }
};
