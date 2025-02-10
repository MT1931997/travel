<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmployeeAttendance extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

    protected $fillable = [
        'in_date_time',
        'out_date_time',
        'leave_start_time',
        'leave_back_time',
        'date_attendance',
        'note',
        'employee_id',
    ];


    public function children()
    {
        return $this->hasMany(EmployeeAttendance::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(EmployeeAttendance::class, 'parent_id');
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
