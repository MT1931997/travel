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
        Schema::create('hrm_settings', function (Blueprint $table) {
            $table->id();
            $table->double('income_tax_limit_married');
            $table->double('income_tax_limit_single');

            $table->text('employee_clearances_header')->nullable();
            $table->text('employee_clearances_footer')->nullable();

            $table->tinyInteger('calc_salary_with_allowance')->default(1); // 1 active //2 no


            $table->unsignedBigInteger('salary_debit_account_id')->nullable();
            $table->unsignedBigInteger('income_tax_account_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('income_tax_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('salary_debit_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('hrm_settings')->onDelete('cascade');
        });
        DB::table('hrm_settings')->insert([
            'income_tax_limit_married' => 18000,
            'income_tax_limit_single' => 9000,
            'salary_debit_account_id' => 46,
            'branch_id' => 1,

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_settings');
    }
};
