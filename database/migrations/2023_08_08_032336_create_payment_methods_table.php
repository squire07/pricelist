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
        Schema::create('payment_methods', function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid');
                $table->string('name');
                $table->string('description')->nullable();
                $table->string('code', 12);
                $table->tinyInteger('company_id');
                $table->string('branch_id', 55)->nullable();
                $table->tinyInteger('is_cash')->default(0); // payment reference number is not required if cash is true (1)
                $table->tinyInteger('is_debit_to')->default(0);
                $table->tinyInteger('status_id')->default(6);
                $table->text('remarks')->nullable();
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
        Schema::dropIfExists('payment_lists');
    }
};
