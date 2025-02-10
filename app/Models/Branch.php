<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Branch extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

    protected $fillable = [
        'name',
        'foreign_name',
        'number',
        'email',
        'phone',
        'fax',
        'address',
        'tax_number',
        'numbers_after_coma',
        'tax_status',
        'inventory_type',
        'is_e_invoice',
        'can_sell_in_minus',
        'report_header',
        'report_footer',
        'reciept_header',
        'reciept_footer',
        'photo',
        'currency_id',

        'main_acoount_expenses_id',
        'main_acoount_income_id',
        'main_acoount_purchase_id',
        'main_acoount_employee_id',
        'main_acoount_customer_id',
        'main_acoount_suplier_id',

        'sales_tax_account_id',
        'discount_allowed_account_id',
        'discount_received_account_id',
        'salary_expenses_account_id',
        'salary_debit_account_id',
        'invoCost_of_goods_sold_account_id',
        'goods_beginning_of_period_account_id',
        'debits_account_id',
        'credits_account_id',
        'social_security_secretariats_account_id',
        'company_contribution_social_account_id',
        'receipt_account_id',

    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    public function main_acoount_expenses()
    {
        return $this->belongsTo(MainAccount::class, 'main_acoount_expenses_id');
    }
    public function main_acoount_income()
    {
        return $this->belongsTo(MainAccount::class, 'main_acoount_income_id');
    }
    public function main_acoount_purchase()
    {
        return $this->belongsTo(MainAccount::class, 'main_acoount_purchase_id');
    }
    public function main_acoount_employee()
    {
        return $this->belongsTo(MainAccount::class, 'main_acoount_employee_id');
    }
    public function main_acoount_customer()
    {
        return $this->belongsTo(MainAccount::class, 'main_acoount_customer_id');
    }
    public function main_acoount_suplier()
    {
        return $this->belongsTo(MainAccount::class, 'main_acoount_suplier_id');
    }



    public function sales_tax_account()
    {
        return $this->belongsTo(Account::class, 'sales_tax_account_id');
    }
    public function discount_allowed_account()
    {
        return $this->belongsTo(Account::class, 'discount_allowed_account_id');
    }
    public function discount_received_account()
    {
        return $this->belongsTo(Account::class, 'discount_received_account_id');
    }
    public function salary_expenses_account()
    {
        return $this->belongsTo(Account::class, 'salary_expenses_account_id');
    }
    public function salary_debit_account()
    {
        return $this->belongsTo(Account::class, 'salary_debit_account_id');
    }
    public function invoCost_of_goods_sold_account()
    {
        return $this->belongsTo(Account::class, 'invoCost_of_goods_sold_account_id');
    }
    public function goods_beginning_of_period_account()
    {
        return $this->belongsTo(Account::class, 'goods_beginning_of_period_account_id');
    }
    public function debits_account()
    {
        return $this->belongsTo(Account::class, 'debits_account_id');
    }
    public function credits_account()
    {
        return $this->belongsTo(Account::class, 'credits_account_id');
    }
    public function social_security_secretariats_account()
    {
        return $this->belongsTo(Account::class, 'social_security_secretariats_account_id');
    }
    public function company_contribution_social_account()
    {
        return $this->belongsTo(Account::class, 'company_contribution_social_account_id');
    }
    public function receipt_account()
    {
        return $this->belongsTo(Account::class, 'receipt_account_id');
    }


    public function children()
    {
        return $this->hasMany(Clas::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Clas::class, 'parent_id');
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('number', 'LIKE', "%{$search}%");
        }

        return $query;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $userId = Auth::id();
            $model->created_by = $userId;
            $model->updated_by = $userId;
        });

        static::updating(function ($model) {
            $userId = Auth::id();
            $model->updated_by = $userId;
        });
    }
}
