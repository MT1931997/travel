<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AddShiftToEmployee extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

    protected $fillable = [
        'from_date',
        'to_date',
        'employee_id',
        'shift_id',
    ];


    public function children()
    {
        return $this->hasMany(AddShiftToEmployee::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(AddShiftToEmployee::class, 'parent_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
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
