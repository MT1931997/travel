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
        Schema::create('cheque_data', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->double('amount');
            $table->date('date_collection')->nullable();
            $table->tinyInteger('cheque_collection_type')->default(1); // (1.co,مجير2)
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->text('note')->nullable();


            $table->unsignedBigInteger('costCenter_id')->nullable();
            $table->unsignedBigInteger('journalEntryCheque_id')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('costCenter_id')->references('id')->on('cost_centers')->onDelete('cascade');
            $table->foreign('journalEntryCheque_id')->references('id')->on('journal_entry_cheques')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('cheque_data')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cheque_data');
    }
};
