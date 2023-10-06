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
        Schema::create('payment_lists', function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid');
                $table->string('name');
                $table->string('code', 12);
                $table->string('branch_id', 12)->nullable();
                $table->tinyInteger('company_id');
                $table->tinyInteger('status_id')->default(6);
                $table->string('remarks', 255)->nullable();
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
