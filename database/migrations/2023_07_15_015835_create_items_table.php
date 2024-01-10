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
            $table->uuid('uuid');
            $table->string('code')->nullable();
            $table->integer('transaction_type_id')->constrained();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->double('amount')->unsigned()->default(0);
            $table->double('nuc')->unsigned()->default(0);
            $table->double('rs_points')->unsigned()->default(0);
            $table->double('pv_points')->unsigned()->default(0);
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
        Schema::dropIfExists('items');
    }
};
