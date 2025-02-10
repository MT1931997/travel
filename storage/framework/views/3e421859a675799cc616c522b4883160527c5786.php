<?php $__env->startSection('title', __('messages.create_employee')); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo e(__('messages.create_employee')); ?></h3>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('admin.employee.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="name"><?php echo e(__('messages.Name')); ?></label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone"><?php echo e(__('messages.username')); ?></label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo e(old('username')); ?>">
            </div>

            <div class="form-group">
                <label for="password"><?php echo e(__('messages.Password')); ?></label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>



            <div class="form-group">
                <label for="activate"><?php echo e(__('messages.Activate')); ?></label>
                <select name="activate" id="activate" class="form-control">
                    <option value="1" <?php echo e(old('activate') == 1 ? 'selected' : ''); ?>><?php echo e(__('messages.Yes')); ?></option>
                    <option value="2" <?php echo e(old('activate') == 2 ? 'selected' : ''); ?>><?php echo e(__('messages.No')); ?></option>
                </select>
            </div>


            <div class="my-3">
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <br>
                     <input <?php echo e(in_array( $role->id,old('roles')? old('roles'): []) ? 'checked':''); ?> class="ml-5" type="checkbox" name="roles[]" id="role_<?php echo e($role->id); ?>" value="<?php echo e($role->id); ?>">
                     <label for="role_<?php echo e($role->id); ?>"> <?php echo e($role->name); ?>. </label>
                     <br>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             </div>
             <div class="row" id="permissions">
                 <?php $__errorArgs = ['perms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                     <span class="text-danger"><?php echo e($message); ?></span>
                 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                 <span class="emsg text-danger"></span>
             </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><?php echo e(__('messages.Submit')); ?></button>
                <a href="<?php echo e(route('admin.employee.index')); ?>" class="btn btn-secondary"><?php echo e(__('messages.Cancel')); ?></a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/admin/employee/create.blade.php ENDPATH**/ ?>