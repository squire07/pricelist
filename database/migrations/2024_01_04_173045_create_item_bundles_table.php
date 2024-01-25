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
        Schema::create('item_bundles', function (Blueprint $table) {
            $table->id();
            // $table->uuid('uuid'); // do not use uuid to prevent multiple same entry
            $table->string('bundle_name');
            $table->string('bundle_description');
            $table->string('item_code');
            $table->string('item_description');
            $table->double('quantity')->unsigned();
            $table->string('uom');
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
        Schema::dropIfExists('item_bundles');
    }
};
