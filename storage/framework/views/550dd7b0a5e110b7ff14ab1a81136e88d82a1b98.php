<?php $__env->startSection('title'); ?>
<?php echo e(__('messages.Home')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader'); ?>
<?php echo e(__('messages.Home')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheaderlink'); ?>
<a href="<?php echo e(route('admin.dashboard')); ?>"> <?php echo e(__('messages.Home')); ?> </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheaderactive'); ?>
<?php echo e(__('messages.Show')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<?php
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

?>



<div class="dashboard">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('home-client')): ?>
    <div class="card">
        <h2><?php echo e(__('messages.users')); ?></h2>
        <p><?php echo e($users->count()); ?></p>
    </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('home-pendingBooking')): ?>
    <div class="card">
        <h2><?php echo e(__('messages.Pending Bookings')); ?></h2>
        <p><?php echo e($pendingBookings->sum('booking_users_count')); ?></p>
    </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('home-completedBooking')): ?>
    <div class="card">
        <h2><?php echo e(__('messages.Completed Bookings')); ?></h2>
        <p><?php echo e($completedBookings->sum('booking_users_count')); ?></p>
    </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('home-bookingThisMonth')): ?>
    <div class="card">
        <h2><?php echo e(__('messages.Bookings This Month')); ?></h2>
        <p><?php echo e($bookingsThisMonth->sum('booking_users_count')); ?></p>
    </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('home-bookingLastMonth')): ?>
    <div class="card">
        <h2><?php echo e(__('messages.Bookings Last Month')); ?></h2>
        <p><?php echo e($bookingsLastMonth->sum('booking_users_count')); ?></p>
    </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('home-totalSelling')): ?>
    <div class="card">
        <h2><?php echo e(__('messages.Total Selling Bookings')); ?></h2>
        <p><?php echo e($totalSellings); ?></p>
    </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('home-totalRevenue')): ?>
    <div class="card">
        <h2><?php echo e(__('messages.Total Revenue Bookings')); ?></h2>
        <p><?php echo e($totalRevenue); ?></p>
    </div>
    <?php endif; ?>
</div>

<div class="dashboard">
   <a href="<?php echo e(route('employee.task','pending')); ?>">
    <div class="card" style="background-color:yellow;">
        <h2><?php echo e(__('messages.Pending Tasks')); ?></h2>
        <p><?php echo e($pendingTasks); ?></p>
    </div>
    </a>
    <a href="<?php echo e(route('employee.task','in_progress')); ?>">
    <div class="card">
        <h2><?php echo e(__('messages.In Progress Tasks')); ?></h2>
        <p><?php echo e($onTheWayTasks); ?></p>
    </div>
    </a>
    <a href="<?php echo e(route('employee.task','completed')); ?>">
    <div class="card">
        <h2><?php echo e(__('messages.Completed Tasks')); ?></h2>
        <p><?php echo e($completedTasks); ?></p>
    </div>
    </a>
</div>

<div class="dashboard">

   <?php $__currentLoopData = $bookingsCountByAdmin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adminData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card">
            <h2><?php echo e(__('messages.Number of bookings for')); ?> : <?php echo e($adminData->name); ?></h2>
            <p><?php echo e($adminData->bookings?->sum('booking_users_count')); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>