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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('name');
            $table->string('foreign_name')->nullable();
            $table->string('symbol')->nullable();
            $table->integer('currency_rate')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('currencies')->onDelete('cascade');
        });
        DB::table('currencies')->insert([
            [
            'number' => 1,
            'name' => "دينار",
            'symbol' => "JD",
            'currency_rate' => 1,

            ],
            [
                'number' => 2,
                'name' => "دولار",
                'symbol' => "$",
                'currency_rate' => 0.71,

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
        Schema::dropIfExists('currencies');
    }
};
