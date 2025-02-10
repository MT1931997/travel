<?php $__env->startSection('title'); ?>
    <?php echo e(__('messages.companies')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> <?php echo e(__('messages.companies')); ?> </h3>
        
            <a href="<?php echo e(route('companies.create')); ?>" class="btn btn-sm btn-success"> <?php echo e(__('messages.New')); ?> <?php echo e(__('messages.companies')); ?></a>
        </div>
        <div class="card-body">
            <form method="get" action="<?php echo e(route('companies.index')); ?>" enctype="multipart/form-data">
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
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('company-table')): ?>
                    <?php if(@isset($data) && !@empty($data) && count($data) > 0): ?>
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <th><?php echo e(__('messages.Name')); ?></th>
                                <th><?php echo e(__('messages.Company Number')); ?></th>
                                <th><?php echo e(__('messages.Whats Number')); ?></th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($info->name); ?></td>
                                        <td><?php echo e($info->company_no); ?></td>
                                        <td><?php echo e($info->whats_no); ?></td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('company-edit')): ?>
                                                <a href="<?php echo e(route('companies.edit', $info->id)); ?>" class="btn btn-sm btn-primary">
                                                    <?php echo e(__('messages.Edit')); ?>

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



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\travel\resources\views/admin/companies/index.blade.php ENDPATH**/ ?>