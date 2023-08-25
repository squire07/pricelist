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
        Schema::table('payment_lists', function (Blueprint $table) {
            $table->tinyInteger('company_id')->after('code');
            $table->tinyInteger('status_id')->after('company_id')->default('6');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_lists', function (Blueprint $table) {
            $table->dropColumn('company_id');
            $table->dropColumn('codstatus_id');
        });
    }
};
