<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JournalEntryAccount extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

    protected $fillable = [
        'name',
        'foreign_name',
        'number',
    ];


    public function children()
    {
        return $this->hasMany(JournalEntryAccount::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(JournalEntryAccount::class, 'parent_id');
    }

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntry::class);
    }


    public function account()
    {
        return $this->belongsTo(Account::class);
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
