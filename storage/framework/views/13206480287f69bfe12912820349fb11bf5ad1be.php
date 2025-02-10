<?php $__env->startSection('title', __('messages.employees')); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo e(__('messages.employees')); ?></h3>
        <a href="<?php echo e(route('admin.employee.create')); ?>" class="btn btn-sm btn-success"><?php echo e(__('messages.New Employee')); ?></a>
    </div>
    <div class="card-body">
        <?php if($data->count()): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo e(__('messages.ID')); ?></th>
                            <th><?php echo e(__('messages.Name')); ?></th>
                            <th><?php echo e(__('messages.username')); ?></th>
                            <th><?php echo e(__('messages.Activate')); ?></th>
                            <th><?php echo e(__('messages.Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($employee->id); ?></td>
                                <td><?php echo e($employee->name); ?></td>
                                <td><?php echo e($employee->username ?? __('messages.Not Available')); ?></td>
                                <td>
                                    <span class="badge <?php echo e($employee->activate == 1 ? 'badge-success' : 'badge-danger'); ?>">
                                        <?php echo e($employee->activate == 1 ? __('messages.Yes') : __('messages.No')); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('admin.employee.edit', $employee->id)); ?>" class="btn btn-primary btn-sm"><?php echo e(__('messages.Edit')); ?></a>
                                    <form action="<?php echo e(route('admin.employee.destroy', $employee->id)); ?>" method="POST" style="display:inline-block;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo e(__('messages.Are you sure?')); ?>')"><?php echo e(__('messages.Delete')); ?></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <?php echo e($data->links()); ?>

            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                <?php echo e(__('messages.No employees found')); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/admin/employee/index.blade.php ENDPATH**/ ?>