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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('delivery_id');
            $table->text('payment_type'); // cash, gcash, cc
            $table->integer('payment_count'); // cash, gcash, cc
            $table->double('total_amount'); // 100, 50, 25
            $table->double('amount_paid')->default(0); // 100, 50, 25
            $table->double('balance')->default(0); // 100, 50, 25
            $table->double('total_amount_paid')->default(0); // 100, 50, 25
            $table->text('details')->nullable(); 
            $table->text('payment_references')->nullable(); // Array: format -> 0 => 0.00   where first zero '0' is the id of payment method followed by amount.
            $table->string('change'); // create, update, view, cancel
            $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('payment_logs');
    }
};
