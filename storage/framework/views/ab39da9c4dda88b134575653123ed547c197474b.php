<?php $__env->startSection('title', __('messages.Booking Report')); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo e(__('messages.Booking Report')); ?></h3>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.bookings')); ?>">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo e(__('messages.Start Date')); ?></label>
                        <input type="date" name="start_date" class="form-control" value="<?php echo e(request('start_date')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo e(__('messages.End Date')); ?></label>
                        <input type="date" name="end_date" class="form-control" value="<?php echo e(request('end_date')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo e(__('messages.Employee')); ?></label>
                        <select name="employee" class="form-control">
                            <option value=""><?php echo e(__('messages.All Employees')); ?></option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>" <?php echo e(request('employee') == $employee->id ? 'selected' : ''); ?>>
                                    <?php echo e($employee->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo e(__('messages.Generate Report')); ?></button>
        </form>
        <hr>
        <?php if($bookings->isNotEmpty()): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo e(__('messages.Booking ID')); ?></th>
                            <th><?php echo e(__('messages.Title')); ?></th>
                            <th><?php echo e(__('messages.Employee')); ?></th>
                            <th><?php echo e(__('messages.Start Date')); ?></th>
                            <th><?php echo e(__('messages.Due Date')); ?></th>
                            <th><?php echo e(__('messages.Status')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($booking->id); ?></td>
                                <td><?php echo e($booking->title); ?></td>
                                <td><?php echo e($booking->employee?->name); ?></td>
                                <td><?php echo e($booking->start_date); ?></td>
                                <td><?php echo e($booking->due_date); ?></td>
                                <td><?php echo e(ucfirst($booking->status)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning"><?php echo e(__('messages.No records found')); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/reports/booking.blade.php ENDPATH**/ ?>