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
        Schema::create('account_settings', function (Blueprint $table) {
            $table->id();
            $table->double('value_discount_on_working_contract')->nullable();
            $table->double('extra_amount_on_all_invoices')->nullable();

            $table->tinyInteger('in_account_statment_payment_type_available')->default(1);
            $table->tinyInteger('show_invoice_remain_account_statment')->default(1);
            $table->tinyInteger('show_payment_terms_account_statment')->default(1);
            $table->tinyInteger('invoice_terms')->default(1);
            $table->tinyInteger('active_discount_in_invoice')->default(1);
            $table->tinyInteger('installment_invoices')->default(1);
            $table->tinyInteger('active_price_with_tax')->default(1);
            $table->tinyInteger('has_extra_amount_on_invoice')->default(1);
            $table->tinyInteger('in_account_statment_currency_rate')->default(1);


            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('account_settings')->onDelete('cascade');
        });
        DB::table('account_settings')->insert([
            [
                'show_payment_terms_account_statment' => 2,
                'invoice_terms' => 2,
                'installment_invoices' => 2,
                'branch_id' => 1,
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
        Schema::dropIfExists('account_settings');
    }
};
