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
        Schema::create('booking_tickets', function (Blueprint $table) {
            $table->id();
            $table->dateTime('from_date')->nullable();
            $table->dateTime('to_date')->nullable();
            $table->double('purchase_price')->nullable();
            $table->double('selling_price')->nullable();
            
            $table->string('degree')->nullable();
            $table->string('flight_no')->nullable();
            $table->unsignedBigInteger('from_country')->nullable();
            $table->foreign('from_country')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('to_country')->nullable();
            $table->foreign('to_country')->references('id')->on('countries')->onDelete('cascade');
            $table->string('from_city')->nullable();
            $table->string('to_city')->nullable();
            $table->unsignedBigInteger('airplane_id')->nullable();
            $table->foreign('airplane_id')->references('id')->on('airplanes')->onDelete('cascade');
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');

            $table->enum('ticket_type',['oneway','round'])->default('oneway');
            $table->dateTime('return_from_date')->nullable();
            $table->dateTime('return_to_date')->nullable();
            $table->string('return_flight_no')->nullable();

            $table->enum('is_transit', ['1', '0'])->default('0');
            $table->enum('is_transit_step', ['1', '0'])->default('0');
            $table->enum('transit_step_type', ['going', 'return'])->default('going');
            $table->dateTime('transit_from_date')->nullable();
            $table->dateTime('transit_to_date')->nullable();
            $table->unsignedBigInteger('transit_country_id')->nullable();
            $table->foreign('transit_country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->string('transit_city')->nullable();
            $table->string('transit_airport')->nullable();

            $table->text('note')->nullable();
            $table->string('service_type')->default('ticket');
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->foreign('ticket_id')->references('id')->on('booking_tickets')->onDelete('cascade');
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
        Schema::dropIfExists('booking_tickets');
    }
};
