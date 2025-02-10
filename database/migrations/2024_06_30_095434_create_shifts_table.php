<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('name');
            $table->string('foreign_name')->nullable();
            $table->double('forgiving_check_in')->nullable();
            $table->double('forgiving_check_out')->nullable();
            $table->double('Start_count_overtime_after')->nullable();
            $table->double('overtime_percentage')->nullable();
            $table->double('late_percentage')->nullable();
            $table->double('holiday_percentage')->nullable();
            $table->double('missed_percentage')->nullable();
            $table->double('working_hours_in_day')->nullable();
            $table->integer('days_in_month')->nullable();

            $table->time('saturday_start')->nullable();
            $table->time('saturday_end')->nullable();
            $table->time('sunday_start')->nullable();
            $table->time('sunday_end')->nullable();
            $table->time('monday_start')->nullable();
            $table->time('monday_end')->nullable();
            $table->time('tuesday_start')->nullable();
            $table->time('tuesday_end')->nullable();
            $table->time('wednesday_start')->nullable();
            $table->time('wednesday_end')->nullable();
            $table->time('thursday_start')->nullable();
            $table->time('thursday_end')->nullable();
            $table->time('friday_start')->nullable();
            $table->time('friday_end')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('shifts')->onDelete('cascade');
        });

        DB::table('shifts')->insert([
            'number' => 1,
            'name' => "وردية 1",
            'foreign_name' => "1 وردية",
            'forgiving_check_in'=>1,
            'forgiving_check_out'=>1,
            'Start_count_overtime_after'=>1,
            'overtime_percentage'=>1,
            'late_percentage'=>1,
            'holiday_percentage'=>1,
            'missed_percentage'=>1,
            'working_hours_in_day'=>8,
            'days_in_month'=>30,
            'saturday_start'=> Carbon::createFromTime(9, 0, 0), // Example time: 09:00:00
            'saturday_end'=> Carbon::createFromTime(16, 0, 0), // Example time: 09:00:00
            'sunday_start'=> Carbon::createFromTime(9, 0, 0), // Example time: 09:00:00
            'sunday_end'=> Carbon::createFromTime(16, 0, 0), // Example time: 09:00:00
            'monday_start'=> Carbon::createFromTime(9, 0, 0), // Example time: 09:00:00
            'monday_end'=> Carbon::createFromTime(16, 0, 0), // Example time: 09:00:00
            'tuesday_start'=> Carbon::createFromTime(9, 0, 0), // Example time: 09:00:00
            'tuesday_end'=> Carbon::createFromTime(16, 0, 0), // Example time: 09:00:00
            'wednesday_start'=> Carbon::createFromTime(9, 0, 0), // Example time: 09:00:00
            'wednesday_end'=> Carbon::createFromTime(16, 0, 0), // Example time: 09:00:00
            'thursday_start'=> Carbon::createFromTime(9, 0, 0), // Example time: 09:00:00
            'thursday_end'=> Carbon::createFromTime(16, 0, 0), // Example time: 09:00:00
            'friday_start'=> Carbon::createFromTime(9, 0, 0), // Example time: 09:00:00
            'friday_end'=> Carbon::createFromTime(16, 0, 0), // Example time: 09:00:00
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts');
    }
};
