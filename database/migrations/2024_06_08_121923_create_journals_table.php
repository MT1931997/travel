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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('name');
            $table->string('foreign_name')->nullable();
            $table->integer('next_number')->nullable();
            $table->string('code')->nullable();
            $table->text('header')->nullable();
            $table->text('footer')->nullable();

            $table->tinyInteger('cost_center_status')->default(1); // 1 yes // 2 no
            $table->tinyInteger('check_status')->default(1); // 1 yes // 2 no
            $table->tinyInteger('journal_types')->nullable(); //[مبيعات ، مشتريات ، كاش ، بنك]
            $table->tinyInteger('numbering_type'); //(تسلسلي،شهري،سنوي)
            $table->tinyInteger('type'); //[قيد ، قيد اقفال ، سند قبض ، سند صرف، قيد افتتاحي ، فاتورة مبيعات ، فاتورة مردود مبيعات ، فاتورة مشتريات ، فاتورة مردور مشتريات ، ]
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('journals')->onDelete('cascade');
        });

        DB::table('journals')->insert([
            [
                'number' => 1,
                'name' => "قيد",
                'foreign_name' => "JournalEntry",
                'branch_id' => 1,
                'journal_types' => 1,
                'numbering_type' => 1,
                'type' => 1,
                'next_number' => null,
                'code' => null,
                'header' => null,
                'footer' => null,
                'cost_center_status' => 1,
                'check_status' => 1,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 2,
                'name' => "قبض",
                'foreign_name' => "Reciept",
                'branch_id' => 1,
                'journal_types' => 1,
                'numbering_type' => 1,
                'type' => 3,
                'header' => '<div class="row">
                    <div class="col-5 center">
                        <div class="bold" style="font-size:30px">اسم الشركة</div>
                    </div>
                    <div class="col-2 center">
                        <img width="180px" height="100px" src="https://softya.com/demo/public/storage/logo.png" />
                    </div>
                    <div class="col-5 center">
                        <div class="bold" style="font-size:30px">Company name</div>
                    </div>
                </div>',
                'next_number' => null,
                'code' => null,
                'footer' => null,
                'cost_center_status' => 1,
                'check_status' => 1,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 3,
                'name' => "ًصرف",
                'foreign_name' => "Payment",
                'branch_id' => 1,
                'journal_types' => 1,
                'numbering_type' => 1,
                'type' => 4,
                'header' => '<div class="row">
                    <div class="col-5 center">
                        <div class="bold" style="font-size:30px">اسم الشركة</div>
                    </div>
                    <div class="col-2 center">
                        <img width="180px" height="100px" src="https://softya.com/demo/public/storage/logo.png" />
                    </div>
                    <div class="col-5 center">
                        <div class="bold" style="font-size:30px">Company name</div>
                    </div>
                </div>',
                'next_number' => null,
                'code' => null,
                'footer' => null,
                'cost_center_status' => 1,
                'check_status' => 1,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
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
        Schema::dropIfExists('journals');
    }
};
