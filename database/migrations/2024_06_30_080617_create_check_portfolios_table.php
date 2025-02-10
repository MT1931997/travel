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
        Schema::create('check_portfolios', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('name');
            $table->string('foreign_name')->nullable();
            $table->text('note')->nullable();

            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->unsignedBigInteger('Cheques_payment_accuont_id')->nullable();
            $table->unsignedBigInteger('Cheques_under_collection_account_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('bank_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('Cheques_payment_accuont_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('Cheques_under_collection_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('check_portfolios')->onDelete('cascade');
        });

        DB::table('check_portfolios')->insert([
            [
            'number' => 1,
            'name' => "خزينة الشركة",
            'bank_account_id' => 3,
            'Cheques_payment_accuont_id' => 28,
            'Cheques_under_collection_account_id' => 9,
            'branch_id' => 1,

            ],
            [

            'number' => 1,
            'name' => "خزينة البنك",
            'bank_account_id' => 3,
            'Cheques_payment_accuont_id' => 28,
            'Cheques_under_collection_account_id' => 9,
            'branch_id' => 1,

            ],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_portfolios');
    }
};
