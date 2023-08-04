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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('transaction_type_id')->constrained();
            $table->foreignId('branch_id')->constrained();
            $table->string('so_no', 25);
            $table->string('si_no', 25)->nullable();
            $table->integer('bcid');
            $table->string('distributor_name');
            $table->double('total_amount')->default(0)->nullable();
            $table->double('total_nuc')->default(0)->nullable();
            $table->foreignId('status_id')->constrained();
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
        Schema::dropIfExists('sales');
    }
};
