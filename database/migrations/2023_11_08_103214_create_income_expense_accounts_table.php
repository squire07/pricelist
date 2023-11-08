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
        Schema::create('income_expense_accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('transaction_type_id'); // refactor this 
            $table->integer('company_id')->nullable(); // do not link
            $table->string('currency', 5)->nullable();
            $table->string('income_account')->nullable();
            $table->string('expense_account')->nullable();
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
        Schema::dropIfExists('transaction_type_accounts');
    }
};
