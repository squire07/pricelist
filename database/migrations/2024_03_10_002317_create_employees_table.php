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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('code')->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('middle_name', 255)->nullable();
            $table->text('full_name')->nullable();
            $table->string('gender', 255)->nullable();
            $table->string('civil_status', 255)->nullable();
            $table->string('birthdate', 255)->nullable();
            $table->string('age', 255)->nullable();
            $table->string('height', 255)->nullable();
            $table->string('weight', 255)->nullable();
            $table->string('religion', 255)->nullable();
            $table->string('nationality', 255)->nullable();
            $table->integer('company_id')->default(1)->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('role_id')->nullable();
            $table->integer('agent_category')->nullable();
            $table->string('images', 255)->nullable();
            $table->string('tin', 255)->nullable();
            $table->string('phic', 255)->nullable();
            $table->string('sss', 255)->nullable();
            $table->text('hdmf')->nullable();
            $table->string('national_id', 255)->nullable();
            $table->string('umid', 255)->nullable();
            $table->string('passport', 255)->nullable();
            $table->string('drivers_license', 255)->nullable();
            $table->text('house_number')->nullable();
            $table->text('street')->nullable();
            $table->text('barangay')->nullable();
            $table->text('city')->nullable();
            $table->text('province')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('contact_details')->nullable();
            $table->string('emergency_contact_name', 255)->nullable();
            $table->string('emergency_contact_number', 255)->nullable();
            $table->string('employee_type', 255)->nullable();
            $table->string('date_hired', 255)->nullable();
            $table->string('date_separated', 255)->nullable();
            $table->string('pay_frequency', 255)->nullable();
            $table->double('basic_pay')->nullable();
            $table->double('rate_per_day')->nullable();
            $table->double('rate_per_hour')->nullable();
            $table->double('ot_rate_per_hour')->nullable();
            $table->string('remarks', 255)->nullable();
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('employees');
    }
};
