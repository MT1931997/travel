<?php $__env->startSection('title'); ?>
    <?php echo e(__('messages.users')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> <?php echo e(__('messages.users')); ?> </h3>

            <a href="<?php echo e(route('users.create')); ?>" class="btn btn-sm btn-success"> <?php echo e(__('messages.New')); ?> <?php echo e(__('messages.users')); ?></a>
        </div>
        <div class="card-body">
            <form method="get" action="<?php echo e(route('users.index')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row my-3">
                    <div class="col-md-3">
                        <input autofocus type="text" placeholder="<?php echo e(__('messages.Search')); ?>" name="search" class="form-control" value="<?php echo e(request('search')); ?>">
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-success "> <?php echo e(__('messages.Search')); ?> </button>
                    </div>
                </div>
            </form>

            <div class="clearfix"></div>

            <div id="ajax_responce_serarchDiv" class="col-md-12">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-table')): ?>
                    <?php if(@isset($data) && !@empty($data) && count($data) > 0): ?>
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <th><?php echo e(__('messages.Name')); ?></th>
                                <th><?php echo e(__('messages.Phone')); ?></th>
                                <th><?php echo e(__('messages.Photo of passport')); ?></th>
                                <th><?php echo e(__('messages.Address')); ?></th>
                                <th><?php echo e(__('messages.Companies')); ?></th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($info->name); ?></td>
                                        <td><?php echo e($info->phone); ?></td>
                                        <td>
                                            <?php if($info->photo_of_passport): ?>

                                                <div class="image">
                                                   <img class="custom_img" src="<?php echo e(asset('assets/admin/uploads').'/'.$info->photo_of_passport); ?>"  >

                                                </div>
                                              <?php else: ?>
                                                No Photo
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($info->address); ?></td>
                                        <td>
                                            <?php if($info->companies->isNotEmpty()): ?>
                                                <?php $__currentLoopData = $info->companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($company->name); ?><?php echo e(!$loop->last ? ', ' : ''); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <?php echo e(__('No Companies Assigned')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-edit')): ?>
                                                <a href="<?php echo e(route('users.edit', $info->id)); ?>" class="btn btn-sm btn-primary">
                                                    <?php echo e(__('messages.Edit')); ?>

                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-edit')): ?>
                                                <a href="<?php echo e(route('users.show', $info->id)); ?>" class="btn btn-sm btn-secondary">
                                                    <?php echo e(__('messages.Show')); ?>

                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <br>
                        <?php echo e($data->appends(['search' => $searchQuery])->links()); ?>

                    <?php else: ?>
                        <div class="alert alert-danger">
                            <?php echo e(__('messages.No_data')); ?>

                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/admin/js/users.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\travel\resources\views/admin/users/index.blade.php ENDPATH**/ ?>