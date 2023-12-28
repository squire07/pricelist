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
            $table->longText('distributor')->nullable();
            $table->longText('so')->nullable();
            $table->longText('si')->nullable();
            $table->longText('comment')->nullable(); // cashiers comment
            $table->longText('payment')->nullable();
            $table->string('nuc_points')->nullable();

            $table->string('distributor_response_status')->nullable();
            $table->string('distributor_response_body')->nullable();
            
            $table->string('so_response_status')->nullable();
            $table->longText('so_response_body')->nullable();
            
            $table->string('si_response_status')->nullable();
            $table->longText('si_response_body')->nullable();

            $table->string('comment_status')->nullable();
            $table->longText('comment_body')->nullable();
            
            $table->string('payment_response_status')->nullable();
            $table->longText('payment_response_body')->nullable();
            
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
