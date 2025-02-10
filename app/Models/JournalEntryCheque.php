<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JournalEntryCheque extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

    protected $fillable = [
        'date_journal_entry_cheque',
        'journal_entry_type',
        'number',
        'cheque_collection_type',
        'branch_id',
        'currency_id',
        'checkPortfolio_id',
        'user_id',
        'cash_check_account_id',
    ];


    public function children()
    {
        return $this->hasMany(JournalEntryCheque::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(JournalEntryCheque::class, 'parent_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    public function checkPortfolio()
    {
        return $this->belongsTo(CheckPortfolio::class, 'checkPortfolio_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cash_check_account()
    {
        return $this->belongsTo(Account::class, 'cash_check_account_id');
    }

    public function cheques()
    {
        return $this->hasMany(ChequeData::class,'journalEntryCheque_id');
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
