<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('name');
            $table->string('foreign_name')->nullable();
            $table->string('password');
            $table->string('name_of_job')->nullable();
            $table->string('phone')->nullable();
            $table->string('number_of_identity')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('basic_salary')->nullable();
            $table->string('social_salary')->nullable();
            $table->date('start_date_according_to_social_salary')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->double('percent_of_employee_from_social_salary')->nullable();
            $table->double('percent_of_company_from_social_salary')->nullable();
            $table->double('percent_of_monthly_advance_from_salary')->nullable();
            $table->date('date_of_start')->nullable();
            $table->date('date_of_end')->nullable();
            $table->string('number_in_social')->nullable();
            $table->string('education')->nullable();
            $table->integer('number_of_hourly_work_in_day')->nullable();
            $table->date('last_permit_calc_date')->nullable();
            $table->integer('annual_permit')->nullable();
            $table->integer('ill_permit')->nullable();

            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('marital_status')->nullable();
            $table->tinyInteger('country_of_nationality')->nullable();
            $table->tinyInteger('salary_calculation_method')->nullable();

            $table->string('photo')->nullable();

            $table->text('note')->nullable();


            $table->unsignedBigInteger('employee_group_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('employee_group_id')->references('id')->on('employee_groups')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
