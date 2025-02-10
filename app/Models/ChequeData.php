<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ChequeData extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

    protected $fillable = [
        'journalEntryCheque_id',
        'number',
        'amount',
        'date_collection',
        'cheque_collection_type',
        'bank_name',
        'bank_branch',
        'costCenter_id',
        'note'
    ];


    public function children()
    {
        return $this->hasMany(ChequeData::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(ChequeData::class, 'parent_id');
    }
    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'costCenter_id');
    }

    public function journalEntryCheque()
    {
        return $this->belongsTo(JournalEntryCheque::class,'journalEntryCheque_id');
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
