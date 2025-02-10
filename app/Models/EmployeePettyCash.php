<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmployeePettyCash extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

    protected $fillable = [
        'amount',
        'date_petty_cash',
        'note',
        'petty_cash_id',
        'employee_id',
    ];


    public function children()
    {
        return $this->hasMany(EmployeePettyCash::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(EmployeePettyCash::class, 'parent_id');
    }
    public function petty_cash()
    {
        return $this->belongsTo(PettyCash::class, 'petty_cash_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
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
