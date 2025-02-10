<?php $__env->startSection('css'); ?>
    <style>
        .permission-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            padding: 15px;
            border-radius: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }

        .permission-card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 200px;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .permission-card h5 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .form-check {
            margin-bottom: 8px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title"><?php echo e(__('messages.Create Role')); ?></h4>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.role.store')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="my-3">
                                <input type="text"
                                    class="form-control <?php if($errors->has('name')): ?> is-invalid <?php endif; ?>" id="name"
                                    placeholder="<?php echo e(__('messages.Role Name')); ?>" value="<?php echo e(old('name')); ?>" name="name">
                                <?php $__errorArgs = ['name'];
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

                            <h1 class="mt-4" style="font-size: 20px;"><?php echo e(__('messages.Permission')); ?></h1>

                            <div class="permission-container">
                                <?php $__currentLoopData = $data->groupBy(function ($item) {
                                    return explode('-', $item->name)[0]; // Group by module
                                }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $actions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="permission-card">
                                        <h5><?php echo e(__(ucfirst($module))); ?></h5>
                                        <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                name="permissions[]" 
                                                value="<?php echo e($permission->id); ?>" 
                                                id="permission_<?php echo e($permission->id); ?>" 
                                                <?php echo e(in_array($permission->id, old('permissions', [])) ? 'checked' : ''); ?>>                                         
                                                <label class="form-check-label" for="permission_<?php echo e($permission->id); ?>">
                                                    <?php echo e(__(explode('-', $permission->name)[1])); ?>

                                                </label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit"
                                    class="btn btn-success waves-effect waves-light"><?php echo e(__('messages.Submit')); ?></button>
                                <a href="<?php echo e(route('admin.role.index')); ?>"
                                    class="btn btn-danger waves-effect waves-light ml-2"><?php echo e(__('messages.Cancel')); ?></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.admin", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/admin/roles/create.blade.php ENDPATH**/ ?>