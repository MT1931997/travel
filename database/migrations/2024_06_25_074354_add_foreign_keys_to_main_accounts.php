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
        Schema::table('main_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->after('name'); // Assuming 'name' is the last column in the initial migration
            $table->foreign('branch_id')->references('id')->on('branches');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->after('name'); // Assuming 'name' is the last column in the initial migration
            $table->foreign('branch_id')->references('id')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('main_accounts', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};
