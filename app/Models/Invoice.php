<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Invoice extends Model
{
    use HasFactory,HasApprovals,LogsActivity;


    protected $fillable = [
        'date_invoice',
        'note',
        'number',
        'collected',
        'in_date_currency_rate',
        'payment_type',
        'tax_status',

        'branch_id',
        'user_id',
        'invoice_type_id',
        'currency_id',
        'cost_center_id',
        'account_id',
        'warehouse_id',
    ];


    public function children()
    {
        return $this->hasMany(Invoice::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Invoice::class, 'parent_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    public function invoice_type()
    {
        return $this->belongsTo(InvoiceType::class, 'invoice_type_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    public function cost_center()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }


    public function invoiceProducts()
    {
        return $this->belongsToMany(Product::class, 'invoice_products', 'invoice_id', 'product_id')->withPivot('quantity','selling_price_without_tax','selling_price_with_tax','tax','discount_fixed','discount_percentage','note','unit_id' ,'created_by','updated_by','created_at', 'updated_at')
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
