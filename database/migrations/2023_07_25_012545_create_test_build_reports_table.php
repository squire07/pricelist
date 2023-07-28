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
        Schema::create('test_build_reports', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('invoice_number', 50)->nullable();
            $table->integer('bcid')->nullable();
            $table->string('name', 50)->nullable();
            $table->float('NUC')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_build_reports');
    }
};
