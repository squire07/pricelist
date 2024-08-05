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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('dr_no', 25)->nullable();
            $table->tinyInteger('delivery_status')->nullable();
            $table->tinyInteger('payment_status')->nullable();
            $table->bigInteger('payment_id')->nullable();
            $table->string('delivery_date')->nullable();
            $table->integer('payment_terms')->nullable();
            $table->string('due_date')->nullable();
            $table->string('delivered_date')->nullable();
            $table->string('srp_type')->nullable();
            $table->text('store_name')->nullable();
            $table->text('address')->nullable();
            $table->string('customer_category')->nullable();
            $table->string('area_group')->nullable();
            $table->double('total_quantity')->default(0)->nullable();
            $table->string('add_discount', 255)->nullable();
            $table->string('add_discount_value', 255)->nullable();
            $table->double('total_amount')->default(0)->nullable();
            $table->double('vatable_sales')->default(0)->nullable();
            $table->double('vat_amount')->default(0)->nullable();
            $table->double('grandtotal_amount')->default(0)->nullable();
            $table->tinyInteger('deleted')->default(false);
            $table->string('delivered_by', 255)->nullable();
            $table->string('agents', 255)->nullable();
            $table->text('delivery_remarks')->nullable();
            $table->text('payment_remarks')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('version')->default(0)->unsigned();
            $table->timestamps();
            // $table->datetime('invoiced_at')->nullable();
            $table->datetime('paid_at')->nullable(); // same as posted_at
            $table->datetime('cancelled_at')->nullable();
            $table->datetime('submitted_at')->nullable();

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
        Schema::dropIfExists('deliveries');
    }
};
