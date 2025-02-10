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
        Schema::create('invoice_types', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('name');
            $table->string('foreign_name')->nullable();
            $table->integer('next_number')->nullable();
            $table->integer('code')->nullable();
            $table->text('header')->nullable();
            $table->text('footer')->nullable();



            $table->tinyInteger('cost_center_status')->default(1); // 1 yes // 2 no
            $table->tinyInteger('transfer_type'); // 1 in // 2 out
            $table->tinyInteger('journal_types'); //[مبيعات ، مشتريات ، كاش ، بنك]
            $table->tinyInteger('numbering_type'); //(تسلسلي،شهري،سنوي)
            $table->tinyInteger('tax_status'); //[ضريبي،معفي،صفري،تصدير،غير مسجل]
            $table->tinyInteger('default_payment_method'); //1 cash // 2 depit

            $table->unsignedBigInteger('sales_account_id');
            $table->unsignedBigInteger('non_tax_account_id')->nullable();
            $table->unsignedBigInteger('zero_tax_account_id')->nullable();
            $table->unsignedBigInteger('transport_account_id')->nullable();
            $table->unsignedBigInteger('defualt_partner_id')->nullable();

            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('invoice_types')->onDelete('cascade');

            $table->foreign('sales_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('non_tax_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('zero_tax_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('transport_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('defualt_partner_id')->references('id')->on('employees')->onDelete('cascade');
        });

        DB::table('invoice_types')->insert([
            [
                'number' => 1,
                'name' => "فاتورة بيع",
                'foreign_name' => "Sell Invoice",
                'transfer_type' => 2,
                'journal_types' => 1,
                'numbering_type' => 1,
                'tax_status' => 1,
                'default_payment_method' => 1,
                'sales_account_id' => 36,
                'branch_id' => 1,
                'header' => '  <div class="row">
                    <div class="col-5 center">
                        <div class="bold" style="font-size:30px">اسم الشركة</div>
                    </div>
                    <div class="col-2 center">
                        <img width="180px" height="100px" src="https://softya.com/demo/public/storage/logo.png" />
                    </div>
                    <div class="col-5 center">
                        <div class="bold" style="font-size:30px">Company name</div>
                    </div>
                </div>
            ',

                'footer' => ' <div class="end-footer">
                    <div class="bold center">
                        تعتبر جميع المواد المدونة في الفاتورة قد سلمت للعميل وفي حالة جيدة وصالحة
                        وأن المشتري قد استلمها بعد المعاينة والقبول
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-6"><h1>اسم المستلم:  ________________</h1></div>
                            <div class="col-6"><h1>توقيع المستلم :  ________________</h1></div>
                        </div>
                        <br />
                        <h3 style="text-align: center;"><strong>Jordan.Amman&nbsp;/ Mob mobile/Tel telephone/P.O.Box.number&ndash; number/Email. Email@email.com</strong></h3>
                        <div class="bg" style="height: 40px; background-color:#62875B"></div>
                    </div>
                </div>

            ',
            ],
            [
                'number' => 2,
                'name' => "فاتورة مردود بيع",
                'foreign_name' => "Refund Invoice",
                'transfer_type' => 1,
                'journal_types' => 1,
                'numbering_type' => 1,
                'tax_status' => 1,
                'default_payment_method' => 1,
                'sales_account_id' => 37,
                'branch_id' => 1,
                'header' => '  <div class="row">
                    <div class="col-5 center">
                        <div class="bold" style="font-size:30px">اسم الشركة</div>
                    </div>
                    <div class="col-2 center">
                        <img width="180px" height="100px" src="https://softya.com/demo/public/storage/logo.png" />
                    </div>
                    <div class="col-5 center">
                        <div class="bold" style="font-size:30px">Company name</div>
                    </div>
                </div>
            ',

                'footer' => ' <div class="end-footer">
                    <div class="bold center">
                        تعتبر جميع المواد المدونة في الفاتورة قد سلمت للعميل وفي حالة جيدة وصالحة
                        وأن المشتري قد استلمها بعد المعاينة والقبول
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-6"><h1>اسم المستلم:  ________________</h1></div>
                            <div class="col-6"><h1>توقيع المستلم :  ________________</h1></div>
                        </div>
                        <br />
                        <h3 style="text-align: center;"><strong>Jordan.Amman&nbsp;/ Mob mobile/Tel telephone/P.O.Box.number&ndash; number/Email. Email@email.com</strong></h3>
                        <div class="bg" style="height: 40px; background-color:#62875B"></div>
                    </div>
                </div>
            ',
            ],
            [
                'number' => 3,
                'name' => "فاتورة مشتريات",
                'foreign_name' => "Purchase Invoice",
                'transfer_type' => 1,
                'journal_types' => 2,
                'numbering_type' => 1,
                'tax_status' => 1,
                'default_payment_method' => 1,
                'sales_account_id' => 43,
                'branch_id' => 1,
                'header' => '  <div class="row">
                    <div class="col-5 center">
                        <div class="bold" style="font-size:30px">اسم الشركة</div>
                    </div>
                    <div class="col-2 center">
                        <img width="180px" height="100px" src="https://softya.com/demo/public/storage/logo.png" />
                    </div>
                    <div class="col-5 center">
                        <div class="bold" style="font-size:30px">Company name</div>
                    </div>
                </div>
            ',

                'footer' => ' <div class="end-footer">
                    <div class="bold center">
                        تعتبر جميع المواد المدونة في الفاتورة قد سلمت للعميل وفي حالة جيدة وصالحة
                        وأن المشتري قد استلمها بعد المعاينة والقبول
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-6"><h1>اسم المستلم:  ________________</h1></div>
                            <div class="col-6"><h1>توقيع المستلم :  ________________</h1></div>
                        </div>
                        <br />
                        <h3 style="text-align: center;"><strong>Jordan.Amman&nbsp;/ Mob mobile/Tel telephone/P.O.Box.number&ndash; number/Email. Email@email.com</strong></h3>
                        <div class="bg" style="height: 40px; background-color:#62875B"></div>
                    </div>
                </div>
            ',
            ],

            [
                'number' => 4,
                'name' => "فاتورة مردود مشتريات",
                'foreign_name' => "Refund Purchase Invoice",
                'transfer_type' => 2,
                'journal_types' => 2,
                'numbering_type' => 1,
                'tax_status' => 1,
                'default_payment_method' => 1,
                'sales_account_id' => 44,
                'branch_id' => 1,
                'header' => '  <div class="row">
                    <div class="col-5 center">
                        <div class="bold" style="font-size:30px">اسم الشركة</div>
                    </div>
                    <div class="col-2 center">
                        <img width="180px" height="100px" src="https://softya.com/demo/public/storage/logo.png" />
                    </div>
                    <div class="col-5 center">
                        <div class="bold" style="font-size:30px">Company name</div>
                    </div>
                </div>
            ',

                'footer' => ' <div class="end-footer">
                    <div class="bold center">
                        تعتبر جميع المواد المدونة في الفاتورة قد سلمت للعميل وفي حالة جيدة وصالحة
                        وأن المشتري قد استلمها بعد المعاينة والقبول
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-6"><h1>اسم المستلم:  ________________</h1></div>
                            <div class="col-6"><h1>توقيع المستلم :  ________________</h1></div>
                        </div>
                        <br />
                        <h3 style="text-align: center;"><strong>Jordan.Amman&nbsp;/ Mob mobile/Tel telephone/P.O.Box.number&ndash; number/Email. Email@email.com</strong></h3>
                        <div class="bg" style="height: 40px; background-color:#62875B"></div>
                    </div>
                </div>
            ',
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
        Schema::dropIfExists('invoice_types');
    }
};
