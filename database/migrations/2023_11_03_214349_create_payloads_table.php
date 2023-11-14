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
        Schema::create('payloads', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('bcid')->nullable();
            $table->string('distributor')->nullable();
            $table->longText('so')->nullable();
            $table->longText('si')->nullable();
            $table->string('nuc_points')->nullable();
            $table->string('distributor_response')->nullable();
            $table->longText('so_response')->nullable();
            $table->longText('si_response')->nullable();
            $table->text('nuc_points_response')->nullable();
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
        Schema::dropIfExists('payloads');
    }
};
