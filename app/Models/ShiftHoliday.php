<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShiftHoliday extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

    protected $fillable = [
        'date_shift_holiday',
        'from_date',
        'to_date',
        'shift_id',
        'holiday_id',
    ];


    public function children()
    {
        return $this->hasMany(ShiftHoliday::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(ShiftHoliday::class, 'parent_id');
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
    public function holiday()
    {
        return $this->belongsTo(Holiday::class, 'holiday_id');
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
