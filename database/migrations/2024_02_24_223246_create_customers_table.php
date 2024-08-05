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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name', 150)->nullable();
            $table->string('proprietor', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('area_id')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('contact_number')->nullable();
            $table->string('vat_type', 50)->nullable();
            $table->string('tin', 50)->nullable();
            $table->integer('srp_type_id')->nullable();
            $table->string('remarks', 255)->nullable();
            $table->tinyInteger('status')->default(true);
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
        Schema::dropIfExists('customers');
    }
};
