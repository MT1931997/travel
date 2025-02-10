<?php $__env->startSection('content'); ?>
<div class="row  mb-3">
    <div class="col-md-3">
        <form action="<?php echo e(route($routeName . '.index')); ?>" method="GET" class="form-inline">
            <input type="text" name="search" class="form-control mr-2" placeholder="<?php echo e(__('messages.Search')); ?>">
        </form>
    </div>
</div>
<div class="container">
    <div class="row justify-content-end mb-3">
        <div class="col-md-6">
            <?php if($routeName == 'note_vouchers'): ?>
            <a class="btn btn-sm btn-primary" href="<?php echo e(route('note_vouchers.create', ['id' => 1])); ?>"><?php echo e(__('messages.Create')); ?></a>
            <?php elseif($routeName == 'invoices'): ?>
            <a class="btn btn-sm btn-primary" href="<?php echo e(route('invoices.create', ['id' => 1])); ?>"><?php echo e(__('messages.Create')); ?></a>
            <?php else: ?>
            <a href="<?php echo e(route($routeName . '.create')); ?>" class="btn btn-sm btn-primary"><?php echo e(__('messages.Create')); ?></a>
            <?php endif; ?>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($index_var)): ?>
                        <?php if(@isset($data) && !@empty($data) && count($data) > 0): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <?php $__currentLoopData = $columnsIndex; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($column !== 'id'): ?>
                                    <th><?php echo e(__('messages.' . $column)); ?></th>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e(__('messages.Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php $__currentLoopData = $columnsIndex; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($column !== 'id'): ?>
                                    <td><?php echo e($item->$column); ?></td>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?php echo e(route($routeName . '.show', $item->id)); ?>" class="btn btn-sm btn-primary"><?php echo e(__('messages.Show')); ?></a>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($edit_var)): ?>
                                            <a href="<?php echo e(route($routeName . '.edit', $item->id)); ?>" class="btn btn-sm btn-warning"><?php echo e(__('messages.Edit')); ?></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($delete_var)): ?>
                                            <form action="<?php echo e(route($routeName . '.destroy', $item->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger"><?php echo e(__('messages.Delete')); ?></button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            <?php echo e($data->links()); ?>

                        </div>
                        <?php else: ?>
                        <div class="alert alert-danger">
                            <?php echo e(__('messages.No_data')); ?> </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\travel\resources\views/crud/index.blade.php ENDPATH**/ ?>