<?php $__env->startSection('title'); ?>
<?php echo e(__('messages.clients')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title card_title_center"> <?php echo e(__('messages.clients')); ?> </h3>
        <input type="hidden" id="token_search" value="<?php echo e(csrf_token()); ?>">
        <a href="<?php echo e(route('clients.create')); ?>" class="btn btn-sm btn-success"><?php echo e(__('messages.New')); ?> <?php echo e(__('messages.clients')); ?></a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4"></div>
        </div>
        <div class="clearfix"></div>
        <div id="ajax_responce_serarchDiv" class="col-md-12">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('order-table')): ?>
            <?php if(isset($data) && !$data->isEmpty()): ?>
            <table id="example2" class="table table-bordered table-hover">
                <thead class="custom_thead">
                    <th><?php echo e(__('messages.Name')); ?></th>
                    <th><?php echo e(__('messages.Phone')); ?></th>
                    <th>Subdomain</th>
                    <th><?php echo e(__('messages.Action')); ?></th>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($info->name); ?></td>
                        <td><?php echo e($info->phone); ?></td>
                        <td><?php echo e($info->subdomain); ?></td>
                        <td>
                             <?php if(auth()->user()->is_super == 1): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client-edit')): ?>
                            <a href="<?php echo e(route('clients.edit', $info->id)); ?>" class="btn btn-sm btn-primary"><?php echo e(__('messages.Edit')); ?></a>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client-delete')): ?>
                            <form action="<?php echo e(route('clients.destroy', $info->id)); ?>" method="POST" style="display: inline-block;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger"><?php echo e(__('messages.Delete')); ?></button>
                            </form>
                            <?php endif; ?>
                            <!-- New Subscription Button -->
                            <a href="<?php echo e(route('clients.subscriptions', $info->id)); ?>" class="btn btn-sm btn-info"><?php echo e(__('messages.Subscription')); ?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <br>
            <?php echo e($data->links()); ?>

            <?php else: ?>
            <div class="alert alert-danger"><?php echo e(__('messages.No_data')); ?></div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('assets/admin/js/clientss.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\travel\resources\views/superAdmin/clients/index.blade.php ENDPATH**/ ?>