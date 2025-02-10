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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('name');
            $table->string('foreign_name')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('start_calculation_date')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('price_without_tax')->nullable();
            $table->double('annual_consumption_ratio')->nullable();
            $table->double('total_depreciation_hours')->nullable();
            $table->double('currency_rate')->nullable();
            $table->date('date_of_relase')->nullable();
            $table->double('tax_value')->nullable();
            $table->double('stamps')->nullable();
            $table->double('accumolated')->nullable();

            $table->tinyInteger('asset_minimum')->nullable(); // 1 one // 2 zero

            $table->text('note')->nullable();



            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('asset_account_id')->nullable();
            $table->unsignedBigInteger('accumulated_depreciation_account_id')->nullable();
            $table->unsignedBigInteger('expensed_depreciation_account_id')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('asset_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('accumulated_depreciation_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('expensed_depreciation_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
};
