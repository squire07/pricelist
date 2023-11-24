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
        Schema::create('nucs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('bcid');
            $table->double('total_nuc')->default(0);
            $table->string('state', 15)->nullable();
            $table->tinyInteger('status')->default(0); // 0 - uncredited; 1 - credited;
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
        Schema::dropIfExists('nucs');
    }
};
