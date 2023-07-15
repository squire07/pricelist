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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('item_id');
            $table->string('item', 50)->nullable();
            $table->string('description', 255)->nullable();
            $table->integer('srp')->nullable();
            $table->integer('distributor_srp')->nullable();
            $table->integer('upc_srp')->nullable();
            $table->integer('nuc')->nullable();
            $table->integer('rs_points')->nullable();
            $table->tinyInteger('delete')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
