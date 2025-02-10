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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('name');
            $table->string('foreign_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('address')->nullable();
            $table->string('tax_number')->nullable();
            $table->integer('numbers_after_coma');

            $table->tinyInteger('tax_status'); //[ضريبي،معفي،صفري،تصدير،غير مسجل]
            $table->tinyInteger('inventory_type'); //[جرد دوري،جرد مستمر]
            $table->tinyInteger('is_e_invoice'); //1 active// 2 disactive
            $table->tinyInteger('can_sell_in_minus'); //1 active// 2 disactive

            $table->text('report_header')->nullable();
            $table->text('report_footer')->nullable();
            $table->text('reciept_header')->nullable();
            $table->text('reciept_footer')->nullable();

            $table->string('photo')->nullable();
            // accounts
            $table->unsignedBigInteger('main_acoount_expenses_id')->nullable();
            $table->unsignedBigInteger('main_acoount_income_id')->nullable();
            $table->unsignedBigInteger('main_acoount_purchase_id')->nullable();
            $table->unsignedBigInteger('main_acoount_employee_id')->nullable();
            $table->unsignedBigInteger('main_acoount_customer_id')->nullable();
            $table->unsignedBigInteger('main_acoount_suplier_id')->nullable();
            //
            $table->unsignedBigInteger('sales_tax_account_id')->nullable();
            $table->unsignedBigInteger('discount_allowed_account_id')->nullable();
            $table->unsignedBigInteger('discount_received_account_id')->nullable();
            $table->unsignedBigInteger('salary_expenses_account_id')->nullable();
            $table->unsignedBigInteger('salary_debit_account_id')->nullable();
            $table->unsignedBigInteger('invoCost_of_goods_sold_account_id')->nullable();
            $table->unsignedBigInteger('goods_beginning_of_period_account_id')->nullable();
            $table->unsignedBigInteger('debits_account_id')->nullable();
            $table->unsignedBigInteger('credits_account_id')->nullable();
            $table->unsignedBigInteger('social_security_secretariats_account_id')->nullable();
            $table->unsignedBigInteger('company_contribution_social_account_id')->nullable();
            $table->unsignedBigInteger('receipt_account_id')->nullable();

            // end accounts
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('branches')->onDelete('cascade');
         // accounts
         $table->foreign('main_acoount_expenses_id')->references('id')->on('main_accounts')->onDelete('cascade');
         $table->foreign('main_acoount_income_id')->references('id')->on('main_accounts')->onDelete('cascade');
         $table->foreign('main_acoount_purchase_id')->references('id')->on('main_accounts')->onDelete('cascade');
         $table->foreign('main_acoount_employee_id')->references('id')->on('main_accounts')->onDelete('cascade');
         $table->foreign('main_acoount_customer_id')->references('id')->on('main_accounts')->onDelete('cascade');
         $table->foreign('main_acoount_suplier_id')->references('id')->on('main_accounts')->onDelete('cascade');
         //
         $table->foreign('sales_tax_account_id')->references('id')->on('accounts')->onDelete('cascade');
         $table->foreign('discount_allowed_account_id')->references('id')->on('accounts')->onDelete('cascade');
         $table->foreign('discount_received_account_id')->references('id')->on('accounts')->onDelete('cascade');
         $table->foreign('salary_expenses_account_id')->references('id')->on('accounts')->onDelete('cascade');
         $table->foreign('salary_debit_account_id')->references('id')->on('accounts')->onDelete('cascade');
         $table->foreign('invoCost_of_goods_sold_account_id')->references('id')->on('accounts')->onDelete('cascade');
         $table->foreign('goods_beginning_of_period_account_id')->references('id')->on('accounts')->onDelete('cascade');
         $table->foreign('debits_account_id')->references('id')->on('accounts')->onDelete('cascade');
         $table->foreign('credits_account_id')->references('id')->on('accounts')->onDelete('cascade');
         $table->foreign('social_security_secretariats_account_id')->references('id')->on('accounts')->onDelete('cascade');
         $table->foreign('company_contribution_social_account_id')->references('id')->on('accounts')->onDelete('cascade');
         $table->foreign('receipt_account_id')->references('id')->on('accounts')->onDelete('cascade');
         //end accounts

        });

        DB::table('branches')->insert([
            'number' => 1,
            'name' => "Kenda",
            'tax_number'=>"12345",
            'email' => "admin@demo.com",
            'numbers_after_coma' => 3,
            'tax_status' => 1,
            'inventory_type' => 1,
            'is_e_invoice' => 2,
            'can_sell_in_minus' => 1,

            'main_acoount_expenses_id' => 6,
            'main_acoount_income_id' => 4,
            'main_acoount_employee_id' => 22,
            'main_acoount_customer_id' => 21,
            'main_acoount_suplier_id' => 27,
            ////
            'sales_tax_account_id' => 8,
            'discount_allowed_account_id' => 57,
            'discount_received_account_id' => 40,
            'salary_expenses_account_id' => 46,
            'salary_debit_account_id' => 1,
            'invoCost_of_goods_sold_account_id' => 42,
            'debits_account_id' => 4,
            'credits_account_id' => 24,
            'social_security_secretariats_account_id' => 10,
            'company_contribution_social_account_id' => 48,
            'receipt_account_id' => 5,

            'report_header' => '<div class="row">
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
        'reciept_header' =>'<div class="row">
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
        'reciept_footer' =>'<br />
        <br />
        <div class="end-footer">
            <div class="row">

                <div class="col-6"><h3> المستلم:  ________________</h3></div>
                <div class="col-6"><h3> المحاسب :  ________________</h3></div>
            </div>
            <br />
            <div class="bg" style="height: 40px; background-color:#1c85a7"></div>
        </div>',
        'currency_id' =>1,

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
