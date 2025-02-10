<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InvoiceType extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

    protected $fillable = [
        'name',
        'foreign_name',
        'number',
        'next_number',
        'code',
        'cost_center_status',
        'transfer_type',
        'journal_types',
        'numbering_type',
        'tax_status',
        'default_payment_method',
        'sales_account_id',
        'non_tax_account_id',
        'zero_tax_account_id',
        'transport_account_id',
        'defualt_partner_id',
        'branch_id',

    ];


    public function children()
    {
        return $this->hasMany(InvoiceType::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(InvoiceType::class, 'parent_id');
    }

    public function saleAccount()
    {
        return $this->belongsTo(Account::class, 'sales_account_id');
    }
    public function nonTaxAccount()
    {
        return $this->belongsTo(Account::class, 'non_tax_account_id');
    }
    public function zeroTaxAccount()
    {
        return $this->belongsTo(Account::class, 'zero_tax_account_id');
    }
    public function transportAccount()
    {
        return $this->belongsTo(Account::class, 'transport_account_id');
    }
    public function partner()
    {
        return $this->belongsTo(Employee::class, 'defualt_partner_id');
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
