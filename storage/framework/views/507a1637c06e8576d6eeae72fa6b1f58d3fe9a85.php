<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo e(__('messages.endSubscriptions')); ?></h3>
    </div>
    <div class="card-body">
        <!-- Display subscriptions in a table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?php echo e(__('messages.Name')); ?></th>
                    <th><?php echo e(__('messages.from_date')); ?></th>
                    <th><?php echo e(__('messages.to_date')); ?></th>
                    <th><?php echo e(__('messages.price_of_subscription')); ?></th>
                    <th><?php echo e(__('messages.whatsapp')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $subsucriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($subscription->client->name); ?></td>
                    <td><?php echo e($subscription->from_date); ?></td>
                    <td><?php echo e($subscription->to_date); ?></td>
                    <td><?php echo e($subscription->price_of_subscription); ?></td>
                    <td>
                        <a href="https://wa.me/<?php echo e(ltrim($subscription->client->phone, '0')); ?>" target="_blank">
                            <i class="fab fa-whatsapp"></i> <?php echo e($subscription->client->phone); ?>

                        </a>
                    </td>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\travel\resources\views/superAdmin/clients/endSubscriptions.blade.php ENDPATH**/ ?>