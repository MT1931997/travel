<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CheckPortfolio extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

        protected $fillable = [
        'name',
        'foreign_name',
        'number',
        'note',
        'bank_account_id',
        'Cheques_payment_accuont_id',
        'Cheques_under_collection_account_id',
        'branch_id',
    ];


    public function children()
    {
        return $this->hasMany(CheckPortfolio::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(CheckPortfolio::class, 'parent_id');
    }
    public function bank_account()
    {
        return $this->belongsTo(Account::class, 'bank_account_id');
    }
    public function Cheques_payment_accuont()
    {
        return $this->belongsTo(Account::class, 'Cheques_payment_accuont_id');
    }
    public function Cheques_under_collection_account()
    {
        return $this->belongsTo(Account::class, 'Cheques_under_collection_account_id');
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
