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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company_no')->nullable();
            $table->text('address')->nullable();
            $table->string('whats_no')->nullable();
            $table->text('link_google')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
        DB::table('settings')->insert(
            [
                'name' => "Enjoy Jordan Tours & Travel",
                'address' => "Amman - Wasfi Al Tall St - Building #96, 1st Floor Office #9&10",
                'company_no' => "+962 6 5534544",
                'whats_no' => "+962 6 5534544",
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
