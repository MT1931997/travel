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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('total_purchase_price')->nullable();
            $table->double('total_selling_price')->nullable();
            $table->text('price_note')->nullable(); // price Description
            $table->enum('status', ['pending', 'completed','cancelled'])->default('pending');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
            $table->timestamps();
        });
    }

    // $table->dateTime('from_date')->nullable();
    // $table->dateTime('to_date')->nullable();
    // $table->unsignedBigInteger('from_country')->nullable();
    // $table->foreign('from_country')->references('id')->on('countries')->onDelete('cascade');
    // $table->unsignedBigInteger('to_country')->nullable();
    // $table->foreign('to_country')->references('id')->on('countries')->onDelete('cascade');
    // $table->string('from_city')->nullable();
    // $table->string('to_city')->nullable();

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
