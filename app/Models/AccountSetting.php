<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AccountSetting extends Model
{
    use HasFactory,HasApprovals,LogsActivity;


    protected $fillable = [
        'value_discount_on_working_contract',
        'extra_amount_on_all_invoices',
        'in_account_statment_payment_type_available',
        'show_invoice_remain_account_statment',
        'show_payment_terms_account_statment',
        'invoice_terms',
        'active_discount_in_invoice',
        'installment_invoices',
        'active_price_with_tax',
        'has_extra_amount_on_invoice',
        'in_account_statment_currency_rate',
        'branch_id',
    ];


    public function children()
    {
        return $this->hasMany(AccountSetting::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(AccountSetting::class, 'parent_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
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
