<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PayReceive extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

    protected $fillable = [
        'type',
        'number',
        'date_pay_receive',
        'amount',
        'note',
        'in_date_currency_rate',
        'currency_id',
        'journal_id',
        'branch_id',
        'account_id',
        'user_id',
    ];


    public function children()
    {
        return $this->hasMany(PayReceive::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(PayReceive::class, 'parent_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
