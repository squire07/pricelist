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
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_id')->constrained();
            $table->string('item_code', 12)->nullable();
            $table->string('item_name')->nullable();
            $table->double('item_price')->nullable();
            $table->double('item_nuc')->nullable();
            $table->integer('quantity')->default(0)->nullable();
            $table->double('amount')->default(0)->nullable();
            $table->double('nuc')->default(0)->nullable();
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
        Schema::dropIfExists('sales_details');
    }
};
