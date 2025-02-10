@extends('layouts.admin')
@section('title')
{{ __('messages.Home') }}
@endsection

@section('css')
<style>
.dashboard {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    padding: 20px;
    background-color: #e9f7f6;
    border-radius: 10px;
}

.card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
}

.card h2 {
    font-size: 18px;
    color: #555;
    margin-bottom: 10px;
}

.card p {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

/* Mobile adjustments */
@media (max-width: 768px) {
    .dashboard {
        grid-template-columns: 1fr; /* Single column layout */
        gap: 15px;
        padding: 15px;
    }

    .card h2 {
        font-size: 16px; /* Smaller font for mobile */
    }

    .card p {
        font-size: 20px;
    }
}
</style>

@endsection

@section('contentheader')
{{ __('messages.Home') }}
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.dashboard') }}"> {{ __('messages.Home') }} </a>
@endsection

@section('contentheaderactive')
{{ __('messages.Show') }}
@endsection

@section('content')


@php
use Carbon\Carbon;


$admin = auth()->user();
// Fetch all models
$users = App\Models\User::get();
$pendingBookings = App\Models\Booking::withCount('booking_users')->where('status','pending')->get();


$completedBookings = App\Models\Booking::withCount('booking_users')->where('status','completed')->get();

// Calculate total sellings
$totalSellings = App\Models\Booking::sum('total_selling_price');

// Calculate total revenue
$totalRevenue = App\Models\Booking::sum(DB::raw('total_selling_price - total_purchase_price'));

// Current month and last month
$currentMonth = Carbon::now()->month;
$currentYear = Carbon::now()->year;
$lastMonth = Carbon::now()->subMonth()->month;
$lastMonthYear = Carbon::now()->subMonth()->year;

// Bookings counts for this month and last month
$bookingsThisMonth = App\Models\Booking::withCount('booking_users')->whereMonth('created_at', $currentMonth)
                                   ->whereYear('created_at', $currentYear)->get();

$bookingsLastMonth = App\Models\Booking::withCount('booking_users')->whereMonth('created_at', $lastMonth)
                                   ->whereYear('created_at', $lastMonthYear)->get();

// Orders by status
$pendingTasks = App\Models\Task::where('status', 'pending')->where('admin_id', $admin->id)->count();
$onTheWayTasks = App\Models\Task::where('status', 'in_progress')->where('admin_id', $admin->id)->count();
$completedTasks = App\Models\Task::where('status', 'completed')->where('admin_id', $admin->id)->count();



$bookingsCountByAdmin = App\Models\Admin::select('admins.id', 'admins.name', DB::raw('COUNT(bookings.id) as bookings_count'))
    ->leftJoin('bookings', 'bookings.created_by', '=', 'admins.id')
    ->groupBy('admins.id', 'admins.name')
    ->get();
$bookingsCountByAdmin = App\Models\Admin::with(['bookings' => function($query) {
        $query->withCount('booking_users');
    }])->get();

@endphp

{{-- <div class="dashboard">
    @can('home-notification')
    <a href="{{ route('notifications.index') }}">
        <div class="card">
            <h2>{{ __('messages.notifications') }}</h2>
            <p>{{ $notifications->count() }}</p>
        </div>
    </a>
    @endcan
</div> --}}

<div class="dashboard">
    @can('home-client')
    <div class="card">
        <h2>{{ __('messages.users') }}</h2>
        <p>{{ $users->count() }}</p>
    </div>
    @endcan

    @can('home-pendingBooking')
    <div class="card">
        <h2>{{ __('messages.Pending Bookings') }}</h2>
        <p>{{ $pendingBookings->sum('booking_users_count') }}</p>
    </div>
    @endcan

    @can('home-completedBooking')
    <div class="card">
        <h2>{{ __('messages.Completed Bookings') }}</h2>
        <p>{{ $completedBookings->sum('booking_users_count') }}</p>
    </div>
    @endcan

    @can('home-bookingThisMonth')
    <div class="card">
        <h2>{{ __('messages.Bookings This Month') }}</h2>
        <p>{{ $bookingsThisMonth->sum('booking_users_count') }}</p>
    </div>
    @endcan

    @can('home-bookingLastMonth')
    <div class="card">
        <h2>{{ __('messages.Bookings Last Month') }}</h2>
        <p>{{ $bookingsLastMonth->sum('booking_users_count') }}</p>
    </div>
    @endcan

    @can('home-totalSelling')
    <div class="card">
        <h2>{{ __('messages.Total Selling Bookings') }}</h2>
        <p>{{ $totalSellings }}</p>
    </div>
    @endcan

    @can('home-totalRevenue')
    <div class="card">
        <h2>{{ __('messages.Total Revenue Bookings') }}</h2>
        <p>{{ $totalRevenue }}</p>
    </div>
    @endcan
</div>

<div class="dashboard">
   <a href="{{route('employee.task','pending')}}">
    <div class="card" style="background-color:yellow;">
        <h2>{{ __('messages.Pending Tasks') }}</h2>
        <p>{{ $pendingTasks }}</p>
    </div>
    </a>
    <a href="{{route('employee.task','in_progress')}}">
    <div class="card">
        <h2>{{ __('messages.In Progress Tasks') }}</h2>
        <p>{{ $onTheWayTasks }}</p>
    </div>
    </a>
    <a href="{{route('employee.task','completed')}}">
    <div class="card">
        <h2>{{ __('messages.Completed Tasks') }}</h2>
        <p>{{ $completedTasks }}</p>
    </div>
    </a>
</div>

<div class="dashboard">

   @foreach ($bookingsCountByAdmin as $adminData)
        <div class="card">
            <h2>{{ __('messages.Number of bookings for') }} : {{ $adminData->name }}</h2>
            <p>{{ $adminData->bookings?->sum('booking_users_count') }}</p>
        </div>
    @endforeach
    
</div>
@endsection
