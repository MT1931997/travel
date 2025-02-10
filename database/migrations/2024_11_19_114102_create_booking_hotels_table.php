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
        Schema::create('booking_hotels', function (Blueprint $table) {
            $table->id();

            $table->dateTime('from_date')->nullable();
            $table->dateTime('to_date')->nullable();
            $table->smallInteger('days')->nullable();
            $table->enum('hotel_stars',[1,2,3,4,5])->nullable();
            $table->enum('room_type',['single','trible','double','four','five'])->nullable();
            $table->integer('selling_price')->nullable();
            $table->smallInteger('room_no')->nullable();
            $table->string('reserve_no')->nullable();
            $table->tinyInteger('is_suite')->nullable();
            $table->tinyInteger('if_breackfast')->nullable();
            $table->tinyInteger('if_lanuch')->nullable();
            $table->tinyInteger('if_dinner')->nullable();
            $table->tinyInteger('private_pathroom')->nullable();
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');

            $table->text('note')->nullable();
            
            $table->string('service_type')->default('hotel');
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_hotels');
    }
};
