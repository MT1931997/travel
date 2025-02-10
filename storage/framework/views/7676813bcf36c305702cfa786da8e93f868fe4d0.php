<?php $__env->startSection('title'); ?>
    <?php echo e(__('messages.Subscriptions for')); ?> <?php echo e($client->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo e(__('messages.Subscriptions for')); ?> <?php echo e($client->name); ?></h3>
    </div>
    <div class="card-body">
        <!-- Display existing subscriptions -->
        <h4><?php echo e(__('messages.Existing Subscriptions')); ?></h4>
        <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="form-group">
                <label><?php echo e(__('messages.from_date')); ?></label>
                <input type="date" class="form-control" value="<?php echo e($subscription->from_date); ?>" readonly>
            </div>

            <div class="form-group">
                <label><?php echo e(__('messages.to_date')); ?></label>
                <input type="date" class="form-control" value="<?php echo e($subscription->to_date); ?>" readonly>
            </div>

            <div class="form-group">
                <label><?php echo e(__('messages.price_of_subscription')); ?></label>
                <input type="text" class="form-control" value="<?php echo e($subscription->price_of_subscription); ?>" readonly>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <!-- Add new subscription if the last one is expired -->
        <?php if(!$latestSubscription || $latestSubscription->to_date < now()): ?>
            <h4><?php echo e(__('messages.Add New Subscription')); ?></h4>
            <form action="<?php echo e(route('clients.storeSubscription', $client->id)); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label><?php echo e(__('messages.from_date')); ?></label>
                    <input type="date" name="from_date" class="form-control" value="<?php echo e(old('from_date')); ?>">
                    <?php $__errorArgs = ['from_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label><?php echo e(__('messages.to_date')); ?></label>
                    <input type="date" name="to_date" class="form-control" value="<?php echo e(old('to_date')); ?>">
                    <?php $__errorArgs = ['to_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label><?php echo e(__('messages.price_of_subscription')); ?></label>
                    <input type="text" name="price_of_subscription" class="form-control" value="<?php echo e(old('price_of_subscription')); ?>">
                    <?php $__errorArgs = ['price_of_subscription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary"><?php echo e(__('messages.Add Subscription')); ?></button>
                </div>
            </form>
        <?php else: ?>
            <p><?php echo e(__('messages.Current subscription is still active.')); ?></p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\travel\resources\views/superAdmin/clients/subscriptions.blade.php ENDPATH**/ ?>