<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HrmSetting extends Model
{
    use HasFactory,HasApprovals,LogsActivity;
    protected $fillable = [
        'income_tax_limit_married',
        'income_tax_limit_single',
        'employee_clearances_header',
        'employee_clearances_footer',
        'calc_salary_with_allowance',
        'salary_debit_account_id',
        'income_tax_account_id',
        'branch_id',
    ];


    public function children()
    {
        return $this->hasMany(HrmSetting::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(HrmSetting::class, 'parent_id');
    }
    public function salary_debit_account()
    {
        return $this->belongsTo(Account::class, 'salary_debit_account_id');
    }
    public function income_tax_account()
    {
        return $this->belongsTo(Account::class, 'income_tax_account_id');
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
