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
        Schema::create('main_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('name');
            $table->string('foreign_name')->nullable();
            $table->tinyInteger('multiple_branch')->default(1); // 1 yes // 2 no
            $table->tinyInteger('account_type')->default(1); // 1 profit and loss // 2 balance sheet
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('main_accounts')->onDelete('cascade');
        });

        DB::table('main_accounts')->insert([
            [
                'number' => 1,
                'name' => "الموجودات",
                'foreign_name' => "Assets",
               
                'parent_id' => null,
            ],
            [
                'number' => 2,
                'name' => "المطلوبات",
                'foreign_name' => "Liabilities",

                'parent_id' => null,
            ],
            [
                'number' => 3,
                'name' => "حقوق الملكية وراس المال",
                'foreign_name' => "Equity And Capital",

                'parent_id' => null,
            ],
            [
                'number' => 4,
                'name' => "ايرادات",
                'foreign_name' => "Revenue",

                'parent_id' => null,
            ],
            [
                'number' => 5,
                'name' =>"مشتريات",
                'foreign_name' => "Purchases",

                'parent_id' => null,
            ],
            [
                'number' => 6,
                'name' =>"المصاريف الادارية والعمومية والاستهلاك",
                'foreign_name' => "General Admin And Depreciation Expenses",

                'parent_id' => null,
            ],
            // sub Assets
            [
                'number' => 11,
                'name' =>"الموجودات المتداولة",
                'foreign_name' => "Current Assets",

                'parent_id' => 1,
            ],
            [
                'number' => 12,
                'name' =>"الموجودات الثابتة",
                'foreign_name' => "Fixed Assets",

                'parent_id' => 1,
            ],

            // sub Liabilities
            [
                'number' => 21,
                'name' =>"المطلوبات المتداولة",
                'foreign_name' => "Current liabilities",

                'parent_id' => 2,
            ],

            // sub Equity And Capital
            [
                'number' => 31,
                'name' =>"رأس المال",
                'foreign_name' => "Capital",

                'parent_id' => 3,
            ],

            [
                'number' => 32,
                'name' =>"احتياطات",
                'foreign_name' => "Reserves",

                'parent_id' => 3,
            ],
            [
                'number' => 33,
                'name' =>"أرباح",
                'foreign_name' => "Profit",

                'parent_id' => 3,
            ],
            [
                'number' => 34,
                'name' =>"جاري الشركاء",
                'foreign_name' => "Partners Current Account",

                'parent_id' => 3,
            ],


            // sub Revenue
            [
                'number' => 41,
                'name' =>"إجمالي الإيرادات",
                'foreign_name' => "Total Revenue",

                'parent_id' => 4,
            ],
            [
                'number' => 42,
                'name' =>"تكلفة البضاعة المباعة",
                'foreign_name' => "تكلفة البضاعة المباعة",

                'parent_id' => 4,
            ],

            // sub Purchases
            [
                'number' => 51,
                'name' =>"إجمالي المشتريات",
                'foreign_name' => "Total Purchases",

                'parent_id' => 5,
            ],

            // sub General Admin And Depreciation Expenses
            [
                'number' => 61,
                'name' =>"مصاريف إدارية وعمومية",
                'foreign_name' => "Administrative and General Expenses ",

                'parent_id' => 6,
            ],

            [
                'number' => 62,
                'name' =>"مصاريف استهلاك",
                'foreign_name' => "Depreciation Expenses",

                'parent_id' => 6,
            ],

               // sub Current Assets
            [
                'number' => 111,
                'name' =>"الصناديق",
                'foreign_name' => "Cash",

                'parent_id' => 7,
            ],
            [
                'number' => 112,
                'name' =>"البنوك",
                'foreign_name' => "Bank",

                'parent_id' => 7,
            ],
            [
                'number' => 113,
                'name' =>"الذمم المدينة",
                'foreign_name' => "Depts",

                'parent_id' => 7,
            ],
            [
                'number' => 114,
                'name' =>"ذمم الموظفين",
                'foreign_name' => "Employee Depts",

                'parent_id' => 7,
            ],
            [
                'number' => 115,
                'name' =>"بضاعة اخر المدة",
                'foreign_name' => "Ending Inventory",

                'parent_id' => 7,
            ],
            [
                'number' => 116,
                'name' =>"أرصدة مدينة أخرى",
                'foreign_name' => "Other Depts",

                'parent_id' => 7,
            ],

                // sub Fixed Assets
            [
                'number' => 121,
                'name' =>"الأصول الثابتة",
                'foreign_name' => "Fixed Assets",

                'parent_id' => 8,
            ],
            [
                'number' => 122,
                'name' =>"مجمع الاستهلاك",
                'foreign_name' => "Acquisition Cost",

                'parent_id' => 8,
            ],

            // sub Current liabilities
            [
                'number' => 211,
                'name' =>"ذمم دائنة",
                'foreign_name' => "Accounts Receivable",

                'parent_id' => 9,
            ],
            [
                'number' => 221,
                'name' =>"أرصدة دائنة أخرى",
                'foreign_name' => "Other Credit Accounts",

                'parent_id' => 9,
            ],
            [
                'number' => 231,
                'name' =>"شيكات أجلة الدفع",
                'foreign_name' => "Postdated Cheques",

                'parent_id' => 9,
            ],

             // sub Capital
            [
                'number' => 311,
                'name' =>"راس المال المسجل",
                'foreign_name' => "Capital",

                'parent_id' => 10,
            ],


             // sub Reserves
            [
                'number' => 321,
                'name' =>"احتياطات",
                'foreign_name' => "Reserves",

                'parent_id' => 11,
            ],

            // sub Profit
            [
                'number' => 331,
                'name' =>"ارباح مدورة",
                'foreign_name' => "Retained Earnings",

                'parent_id' => 12,
            ],

            // sub Partner
            [
                'number' => 341,
                'name' =>"جاري الشريك",
                'foreign_name' => "Partners Current Accounts",

                'parent_id' => 13,
            ],

            // sub Total Revenue
            [
                'number' => 411,
                'name' =>"ايرادات المبيعات",
                'foreign_name' => "Sales Revenue",

                'parent_id' => 14,
            ],
            [
                'number' => 412,
                'name' =>"ايرادات الخدمات",
                'foreign_name' => "Services Revenue",

                'parent_id' => 14,
            ],
            [
                'number' => 413,
                'name' =>"ايرادات أخرى",
                'foreign_name' => "Other Revenue",

                'parent_id' => 14,
            ],

            // sub "تكلفة البضاعة المباعة"
            [
                'number' => 421,
                'name' =>"تكاليف البضاعة المباعة",
                'foreign_name' => "تكاليف البضاعة المباعة",

                'parent_id' => 15,
            ],

             // sub Total Purchases
            [
                'number' => 511,
                'name' =>"صافي المشتريات المحلية",
                'foreign_name' => "Net Local Purchases",

                'parent_id' => 16,
            ],
            [
                'number' => 512,
                'name' =>"اجمالي المستوردات",
                'foreign_name' => "Gross Import",

                'parent_id' => 16,
            ],

            // sub Administrative and General Expenses
            [
                'number' => 611,
                'name' =>"مصاريف إدارية وعمومية",
                'foreign_name' => "Administrative and General Expenses ",

                'parent_id' => 17,
            ],

            // sub Depreciation Expenses
            [
                'number' => 621,
                'name' =>"مصاريف استهلاك",
                'foreign_name' => "Depreciation Expenses",

                'parent_id' => 18,
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
        Schema::dropIfExists('main_accounts');
    }
};
