<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1 class="text-center mb-4"><?php echo e(__('messages.Show')); ?> </h1>
    <div class="card">
        <div class="card-body">
            <?php $__currentLoopData = $columns_view; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $column_view): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($columns_table_name[$index] !== 'password'): ?>
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <strong><?php echo e($column_view); ?>:</strong>
                    </div>
                    <div class="col-sm-8">
                        <?php echo e($data->{$columns_table_name[$index]}); ?>

                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\travel\resources\views/crud/show.blade.php ENDPATH**/ ?>