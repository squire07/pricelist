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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name')->nullable();
            $table->string('upc')->nullable();
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->string('brand_id')->nullable();
            $table->string('category_id')->nullable();
            $table->float('size')->nullable();
            $table->float('size_in_kg')->nullable();
            $table->string('uom')->nullable();
            $table->string('uom_abbrv')->nullable();
            $table->string('pack_size')->nullable();
            $table->integer('packs_per_case')->nullable();
            $table->double('orig_srp')->unsigned()->default(0);
            $table->double('spec_srp')->unsigned()->default(0);
            $table->string('remarks')->nullable();
            $table->string('images')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('products');
    }
};
