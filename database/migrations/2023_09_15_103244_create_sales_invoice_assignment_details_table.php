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
        Schema::create('sales_invoice_assignment_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('sales_invoice_assignment_id');
            $table->string('series_number', 12);
            $table->tinyInteger('prefixed')->default(false);
            $table->string('prefix_value', 3)->nullable();
            $table->tinyInteger('used')->default(false);
            $table->string('so_no')->nullable();
            $table->string('si_no')->nullable();
            $table->tinyInteger('deleted')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by',55)->nullable();
            $table->string('updated_by',55)->nullable();
            $table->string('deleted_by',55)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_assignment_details');
    }
};
