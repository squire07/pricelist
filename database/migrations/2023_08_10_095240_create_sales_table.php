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
            $table->foreignId('transaction_type_id');
            $table->foreignId('branch_id');
            $table->integer('company_id')->default(1);
            $table->string('so_no', 25);
            $table->string('si_no', 25)->nullable();
            $table->string('si_assignment_id', 25)->nullable();
            $table->string('oid', 12)->nullable(); // for future use
            $table->bigInteger('bcid');
            $table->string('distributor_name');
            $table->double('shipping_fee')->default(0);
            $table->double('total_amount')->default(0);
            $table->double('vatable_sales')->default(0);
            $table->double('vat_amount')->default(0);
            $table->double('grandtotal_amount')->default(0);
            $table->double('total_nuc')->default(0);
            $table->foreignId('status_id');
            $table->bigInteger('payment_id')->nullable();
            $table->string('group_name', 100)->nullable();
            $table->text('so_remarks')->nullable();
            $table->text('si_remarks')->nullable();
            $table->tinyInteger('new_signup')->default(0);
            $table->string('signee_name')->nullable();
            $table->integer('origin_id')->nullable(); 
            $table->integer('version')->default(0)->unsigned();
            $table->tinyInteger('deleted')->default(false);
            $table->text('cashiers_remarks')->nullable();
            $table->timestamps();
            
            // for future use: created_at = drafted_at; full details at history
            $table->datetime('submitted_at')->nullable();
            $table->datetime('invoiced_at')->nullable();
            $table->datetime('validated_at')->nullable();
            $table->datetime('released_at')->nullable(); // same as posted_at
            $table->datetime('cancelled_at')->nullable();

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
