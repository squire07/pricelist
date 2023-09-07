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
        Schema::table('histories', function (Blueprint $table) {
            $table->foreignId('transaction_type_id')->after('record_id');
            $table->foreignId('status_id')->after('transaction_type_id');
            $table->string('so_no', 25)->after('status_id');
            $table->string('si_no', 25)->after('so_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
