@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">👥 HR Management Dashboard</h2>
    <div class="row">
        @php
            $hrRoutes = [
                ['name' => 'Shifts', 'route' => 'shifts.index', 'icon' => 'fa-solid fa-clock'],
                ['name' => 'Holidays', 'route' => 'holidays.index', 'icon' => 'fa-solid fa-calendar-day'],
                ['name' => 'Rewards', 'route' => 'rewards.index', 'icon' => 'fa-solid fa-trophy'],
                ['name' => 'Deductions', 'route' => 'deductions.index', 'icon' => 'fa-solid fa-minus-circle'],
                ['name' => 'Salary Cutoffs', 'route' => 'salaryCutoffs.index', 'icon' => 'fa-solid fa-money-bill-wave'],
                ['name' => 'Allowance on Salaries', 'route' => 'allowanceOnSalarys.index', 'icon' => 'fa-solid fa-hand-holding-usd'],
                ['name' => 'Petty Cash', 'route' => 'pettyCashes.index', 'icon' => 'fa-solid fa-wallet'],
                ['name' => 'Permit Types', 'route' => 'permitTypes.index', 'icon' => 'fa-solid fa-id-card'],
                ['name' => 'Employee Loan Payments', 'route' => 'employeeLoanPayments.index', 'icon' => 'fa-solid fa-university'],
                ['name' => 'HRM Settings', 'route' => 'hrmSettings.index', 'icon' => 'fa-solid fa-cogs'],
                ['name' => 'Add Shift to Employees', 'route' => 'addShiftToEmployees.index', 'icon' => 'fa-solid fa-users-cog'],
                ['name' => 'Employee Attendances', 'route' => 'employeeAttendances.index', 'icon' => 'fa-solid fa-user-check'],
                ['name' => 'Employee Permits', 'route' => 'employeePermits.index', 'icon' => 'fa-solid fa-passport'],
                ['name' => 'Employee Rewards', 'route' => 'employeeRewards.index', 'icon' => 'fa-solid fa-medal'],
                ['name' => 'Employee Deductions', 'route' => 'employeeDeductions.index', 'icon' => 'fa-solid fa-file-invoice-dollar'],
                ['name' => 'Employee Cutoffs', 'route' => 'employeeCutoffs.index', 'icon' => 'fa-solid fa-cut'],
                ['name' => 'Employee Allowance on Salaries', 'route' => 'employeeAllowanceOnSalaries.index', 'icon' => 'fa-solid fa-money-check-alt'],
                ['name' => 'Employee Petty Cash', 'route' => 'employeePettyCashes.index', 'icon' => 'fa-solid fa-coins'],
                ['name' => 'Shift Holidays', 'route' => 'shiftHolidays.index', 'icon' => 'fa-solid fa-plane'],
                ['name' => 'Employee Loans', 'route' => 'employeeLoans.index', 'icon' => 'fa-solid fa-handshake'],
                ['name' => 'Employee Clearances', 'route' => 'employeeClearances.index', 'icon' => 'fa-solid fa-user-shield'],
                ['name' => 'Employees', 'route' => 'employees.index', 'icon' => 'fa-solid fa-user'],
            ];
        @endphp

        @foreach($hrRoutes as $route)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 bg-light">
                    <div class="card-body text-center">
                        <div class="icon-container mb-3">
                            <i class="{{ $route['icon'] }} fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title fw-bold">{{ $route['name'] }}</h5>
                        <a href="{{ route($route['route']) }}" class="btn btn-outline-primary mt-2">
                            <i class="fa-solid fa-arrow-right"></i> Open
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .icon-container {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #f6fbff, #4c80b8);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        transition: 0.3s ease-in-out;
    }
    .card:hover .icon-container {
        transform: scale(1.1);
    }
    .card {
        transition: 0.3s;
        border-radius: 15px;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
