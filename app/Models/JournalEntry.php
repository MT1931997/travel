<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JournalEntry extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

    protected $fillable = [
        'date_journal',
        'in_date_currency_rate',
        'number',
        'photo',
        'note',
        'currency_id',
        'branch_id',
        'journal_id',
    ];


    public function children()
    {
        return $this->hasMany(JournalEntry::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(JournalEntry::class, 'parent_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }

    public function journalAccounts()
    {
        return $this->belongsToMany(Account::class, 'journal_entry_accounts', 'journal_entry_id', 'account_id')
            ->withPivot('depit', 'credit', 'note', 'created_by', 'updated_by', 'created_at', 'updated_at')
            ->withTimestamps();
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
