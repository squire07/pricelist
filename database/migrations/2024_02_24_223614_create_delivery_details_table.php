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
        Schema::create('delivery_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id');
            $table->string('item_code', 125)->nullable();
            $table->string('item_name')->nullable();
            $table->double('item_price')->nullable();
            $table->string('pack_size', 255)->nullable();
            $table->string('size_in_kg', 255)->nullable();
            $table->double('item_discount')->nullable();
            $table->integer('quantity')->unsigned()->default(0)->nullable();
            $table->double('amount')->default(0)->nullable();
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
        Schema::dropIfExists('delivery_details');
    }
};
