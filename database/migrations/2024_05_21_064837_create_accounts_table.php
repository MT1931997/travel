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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('name');
            $table->string('foreign_name')->nullable();
            $table->string('balance_limit')->nullable();

            $table->tinyInteger('is_cost_center_required')->nullable(); // 1 yes // 2 no
            $table->tinyInteger('is_account_bank')->nullable(); // 1 yes // 2 no
            $table->tinyInteger('is_account_tax')->nullable(); // 1 yes // 2 no
            $table->tinyInteger('multiple_branch')->default(1); // 1 yes // 2 no


            $table->unsignedBigInteger('main_account_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('main_account_id')->references('id')->on('main_accounts')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('accounts')->onDelete('cascade');
        });

        DB::table('accounts')->insert([
            [
                'number' => 111001,
                'name' => "الصندوق",
                'foreign_name' => "Cash",
                'main_account_id' => 19,

            ],

            [
                'number' => 111002,
                'name' => "صندوق الشيكات",
                'foreign_name' => "صندوق الشيكات",
                'main_account_id' => 19,

            ],
            [
                'number' => 112001,
                'name' => " بنك 1",
                'foreign_name' => "Bank",
                'main_account_id' => 20,

            ],

            [
                'number' => 113001,
                'name' => "ذمم مدينة",
                'foreign_name' => "Debits",
                'main_account_id' => 21,

            ],

            [
                'number' => 113002,
                'name' => "اوراق قبض",
                'foreign_name' => "Recepit Paper",
                'main_account_id' => 21,

            ],

            [
                'number' => 115001,
                'name' => "بضاعة اخر المدة",
                'foreign_name' => "Recepit Paper",
                'main_account_id' => 23,

            ],

            [
                'number' => 115001,
                'name' => "بضاعة اخر المدة",
                'foreign_name' => "",
                'main_account_id' => 23,

            ],

            [
                'number' => 116001,
                'name' => "امانات ضريبة مبيعات",
                'foreign_name' => "",
                'main_account_id' => 24,

            ],

            [
                'number' => 116002,
                'name' => "شيكات برسم التحصيل",
                'foreign_name' => "",
                'main_account_id' => 24,

            ],

            [
                'number' => 116003,
                'name' => "امانات الضمان الاجتماعي",
                'foreign_name' => "",
                'main_account_id' => 24,

            ],

            [
                'number' => 116004,
                'name' => "مصاريف مدفوعة مقدما",
                'foreign_name' => "",
                'main_account_id' => 24,

            ],

            [
                'number' => 116005,
                'name' => "امانات ضريبة الدخل",
                'foreign_name' => "",
                'main_account_id' => 24,

            ],

            [
                'number' => 121001,
                'name' => "اجهزة حاسوب",
                'foreign_name' => "",
                'main_account_id' => 25,

            ],

            [
                'number' => 121002,
                'name' => "مباني",
                'foreign_name' => "",
                'main_account_id' => 25,

            ],

            [
                'number' => 121003,
                'name' => "الاثاث و المفروشات وديكورات",
                'foreign_name' => "",
                'main_account_id' => 25,

            ],

            [
                'number' => 121004,
                'name' => "الاجهزة و المعدات",
                'foreign_name' => "",
                'main_account_id' => 25,

            ],

            [
                'number' => 121005,
                'name' => "سيارات",
                'foreign_name' => "",
                'main_account_id' => 25,

            ],

            [
                'number' => 121006,
                'name' => "اراضي",
                'foreign_name' => "",
                'main_account_id' => 25,

            ],

            [
                'number' => 122001,
                'name' => "مجمع استهلاك اجهزة حاسوب	",
                'foreign_name' => "",
                'main_account_id' => 26,

            ],

            [
                'number' => 122002,
                'name' => "مجمع استهلاك مباني",
                'foreign_name' => "",
                'main_account_id' => 26,

            ],

            [
                'number' => 122003,
                'name' => "مجمع استهلاك اثاث ومفروشات",
                'foreign_name' => "",
                'main_account_id' => 26,

            ],

            [
                'number' => 122004,
                'name' => "مجمع استهلاك الاجهزة و المعدات",
                'foreign_name' => "",
                'main_account_id' => 26,

            ],
            [
                'number' => 122005,
                'name' => "مجمع استهلاك سيارات",
                'foreign_name' => "",
                'main_account_id' => 26,

            ],
            [
                'number' => 211001,
                'name' => "ذمم دائنة",
                'foreign_name' => "",
                'main_account_id' => 27,

            ],
            [
                'number' => 221001,
                'name' => "مصاريف مستحقة وغير مدفوعة",
                'foreign_name' => "",
                'main_account_id' => 28,

            ],
            [
                'number' => 221002,
                'name' => "الرواتب المستحقة وغير مدفوعة",
                'foreign_name' => "",
                'main_account_id' => 28,

            ],
            [
                'number' => 221003,
                'name' => "امانة تأمين صحي",
                'foreign_name' => "",
                'main_account_id' => 28,

            ],

            [
                'number' =>231001 ,
                'name' => "شيكات اجلة الدفع	",
                'foreign_name' => "",
                'main_account_id' => 29,

            ],

            [
                'number' =>311001 ,
                'name' => "رأس المال المدفوع",
                'foreign_name' => "",
                'main_account_id' => 30,

            ],

            [
                'number' =>311002 ,
                'name' => "رأس المال غير المدفوع",
                'foreign_name' => "",
                'main_account_id' => 30,

            ],

            [
                'number' =>321001 ,
                'name' => "احتياطي اختياري",
                'foreign_name' => "",
                'main_account_id' => 31,

            ],

            [
                'number' =>321002 ,
                'name' => "احتياطي اجباري",
                'foreign_name' => "",
                'main_account_id' => 31,

            ],


            [
                'number' =>331001 ,
                'name' => "ارباح السنة الحالية",
                'foreign_name' => "",
                'main_account_id' => 32,

            ],

            [
                'number' =>331002 ,
                'name' => "ارباح السنوات السابقة",
                'foreign_name' => "",
                'main_account_id' => 32,

            ],

            [
                'number' =>341001 ,
                'name' => "جاري الشريك",
                'foreign_name' => "",
                'main_account_id' => 33,

            ],

            [
                'number' =>411001 ,
                'name' => "مبيعات محلية",
                'foreign_name' => "",
                'main_account_id' => 34,

            ],

            [
                'number' =>411002 ,
                'name' => "مردود مبيعات	",
                'foreign_name' => "",
                'main_account_id' => 34,

            ],

            [
                'number' =>411003 ,
                'name' => "مبيعات تصدير	",
                'foreign_name' => "",
                'main_account_id' => 34,

            ],

            [
                'number' =>412001,
                'name' => "ايرادات الخدمات",
                'foreign_name' => "",
                'main_account_id' => 35,

            ],

            [
                'number' =>413001,
                'name' => "خصم مكتسب",
                'foreign_name' => "",
                'main_account_id' => 36,

            ],

            [
                'number' =>413002,
                'name' => "ايرادات بيع اصول",
                'foreign_name' => "",
                'main_account_id' => 36,

            ],

            [
                'number' =>421001,
                'name' => "تكلفة البضاعة المباعة",
                'foreign_name' => "",
                'main_account_id' => 37,

            ],

            [
                'number' =>511001,
                'name' => "مشتريات",
                'foreign_name' => "",
                'main_account_id' => 38,

            ],

            [
                'number' =>511002,
                'name' => "مردود مشتريات",
                'foreign_name' => "",
                'main_account_id' => 38,

            ],


            [
                'number' =>512001,
                'name' => "مستوردات",
                'foreign_name' => "",
                'main_account_id' => 39,

            ],

            [
                'number' =>611001,
                'name' => "مصروف رواتب وأجور",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],

            [
                'number' =>611002,
                'name' => "مصروف عمل اضافي",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611003,
                'name' => "مصروف مساهمة الشركة في الضمان الاجتماعي",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611004,
                'name' => "مصروف ايجارات",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611005,
                'name' => "مصروف بريد وهاتف وأنترنت	",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611006,
                'name' => "مصروف كهرباء ومياه",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],

            [
                'number' =>611007,
                'name' => "مصروف قرطاسية ومطبوعات",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611008,
                'name' => "مصروف ضيافة",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611009,
                'name' => "مصروف صيانة عامة	",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611010,
                'name' => "مصروف نثرية ومتفرقة	",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611011,
                'name' => "مصروف رسوم ورخص حكومية",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611012,
                'name' => "مصروف خصم مسموح به",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611013,
                'name' => "مصروف اتعاب تدقيق",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611014,
                'name' => "مصروف اتعاب مهنية",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611015,
                'name' => "مصروف نضافة ومواد تنضيف",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],
            [
                'number' =>611016,
                'name' => "مصروف تبرعات وأكراميات",
                'foreign_name' => "",
                'main_account_id' => 40,

            ],

            [
                'number' =>621001,
                'name' => "مصروف استهلاك اجهزة حاسوب",
                'foreign_name' => "",
                'main_account_id' => 41,

            ],
            [
                'number' =>621002,
                'name' => "مصروف استهلاك مباني	",
                'foreign_name' => "",
                'main_account_id' => 41,

            ],
            [
                'number' =>621003,
                'name' => "مصروف استهلاك اثاث وديكور ومفروشات",
                'foreign_name' => "",
                'main_account_id' => 41,

            ],
            [
                'number' =>621004,
                'name' => "مصروف استهلاك الاجهزة والمعدات",
                'foreign_name' => "",
                'main_account_id' => 41,

            ],
            [
                'number' =>621005,
                'name' => "مصروف استهلاك سيارات	",
                'foreign_name' => "",
                'main_account_id' => 41,

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
        Schema::dropIfExists('accounts');
    }
};
