<?php

namespace App\Models;

use App\Traits\HasApprovals;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Employee extends Model
{
    use HasFactory,HasApprovals,LogsActivity;

    protected $fillable = [
        'name',
        'foreign_name',
        'number',
        'password','name_of_job','phone','number_of_identity','email','address','basic_salary','social_salary','start_date_according_to_social_salary','date_of_birth',
        'percent_of_employee_from_social_salary','percent_of_company_from_social_salary','percent_of_monthly_advance_from_salary','date_of_start','date_of_end',
        'number_in_social','education','number_of_hourly_work_in_day','last_permit_calc_date','annual_permit','ill_permit','status','marital_status',
        'country_of_nationality','salary_calculation_method','photo','note','branch_id','employee_group_id','role_id','user_id','admin_id'
    ];


    public function children()
    {
        return $this->hasMany(Employee::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Employee::class, 'parent_id');
    }

    public function employeeGroup()
    {
        return $this->belongsTo(EmployeeGroup::class, 'employee_group_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
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
