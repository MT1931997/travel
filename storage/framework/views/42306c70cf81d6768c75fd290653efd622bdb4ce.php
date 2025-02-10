<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route($routeName . '.update', $data->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <?php if(($is_there_radio_tree && $existing_classes !== null) || ($is_there_radio_tree_self && $existing_classes !== null)): ?>
                                <?php if($existing_classes->isNotEmpty()): ?>
                                    <div class="radio-list-tree">
                                        <?php $__currentLoopData = $existing_classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="parent">
                                                <span class="toggle-icon">▶</span> <!-- Icon for toggling visibility -->
                                                <input type="radio" name="selected_class_id"
                                                       value="<?php echo e($class->id); ?>" <?php echo e($data->selected_class_id == $class->id ? 'checked' : ''); ?>>
                                                       <?php echo e($class->name); ?>

                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <p>No existing classes found. Please create a new one.</p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>Radio tree functionality is disabled or not applicable.</p>
                            <?php endif; ?>

                            <?php
                                $optionsIndex = 0;
                            ?>

                            <?php $__currentLoopData = $columns_view; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $column_view): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="<?php echo e($columns_table_name[$index]); ?>"><?php echo e($column_view); ?>:</label>
                                        <?php if($inputTypes[$index] == 'text'): ?>
                                            <input type="text" name="<?php echo e($columns_table_name[$index]); ?>" class="form-control"
                                                   value="<?php echo e(old($columns_table_name[$index], $data->{$columns_table_name[$index]})); ?>"
                                                   <?php if($required[$index] == 'required'): ?> required <?php endif; ?>>
                                        <?php elseif($inputTypes[$index] == 'text_area'): ?>
                                            <textarea name="<?php echo e($columns_table_name[$index]); ?>" class="form-control"
                                                      <?php if($required[$index] == 'required'): ?> required <?php endif; ?>><?php echo e(old($columns_table_name[$index], $data->{$columns_table_name[$index]})); ?></textarea>
                                        <?php elseif($inputTypes[$index] == 'date'): ?>
                                            <input type="date" name="<?php echo e($columns_table_name[$index]); ?>" class="form-control"
                                                   value="<?php echo e(old($columns_table_name[$index], $data->{$columns_table_name[$index]})); ?>"
                                                   <?php if($required[$index] == 'required'): ?> required <?php endif; ?>>
                                        <?php elseif($inputTypes[$index] == 'date_time'): ?>
                                            <input type="datetime-local" name="<?php echo e($columns_table_name[$index]); ?>" class="form-control"
                                                   value="<?php echo e(old($columns_table_name[$index], $data->{$columns_table_name[$index]})); ?>"
                                                   <?php if($required[$index] == 'required'): ?> required <?php endif; ?>>
                                        <?php elseif($inputTypes[$index] == 'photo'): ?>
                                            <input type="file" name="<?php echo e($columns_table_name[$index]); ?>" class="form-control"
                                                   <?php if($required[$index] == 'required'): ?> required <?php endif; ?>>
                                            <?php if($data->{$columns_table_name[$index]}): ?>
                                                <br>
                                                <img src="<?php echo e(asset('storage/' . $data->{$columns_table_name[$index]})); ?>" alt="Current Image" width="100">
                                            <?php endif; ?>
                                        <?php elseif($inputTypes[$index] == 'options'): ?>
                                            <?php echo $__env->make('inputs.options', [
                                                'name' => $columns_table_name[$index],
                                                'options' => $options[$optionsIndex] ?? [],
                                                'selected' => old($columns_table_name[$index], $data->{$columns_table_name[$index]}),
                                                'required' => $required[$index],
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php
                                                $optionsIndex++;
                                            ?>
                                        <?php elseif($inputTypes[$index] == 'search_select'): ?>
                                            <?php echo $__env->make('inputs.search_select', [
                                                'name' => $columns_table_name[$index],
                                                'selected' => old($columns_table_name[$index], $data->{$columns_table_name[$index]}),
                                                'required' => $required[$index],
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php elseif($inputTypes[$index] == 'select_another_table_multiple'): ?>
                                            <?php echo $__env->make('inputs.select_another_model_multiple', [
                                                'name' => $columns_table_name[$index],
                                                'optionsFromTable' => $optionsFromTable,
                                                'selected' => old($columns_table_name[$index], $data->{$columns_table_name[$index]}),
                                                'required' => $required[$index],
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php elseif($inputTypes[$index] == 'select_another_table'): ?>
                                            <?php echo $__env->make('inputs.select_another_model', [
                                                'name' => $columns_table_name[$index],
                                                'optionsFromTable' => $optionsFromTable,
                                                'selected' => old($columns_table_name[$index], $data->{$columns_table_name[$index]}),
                                                'required' => $required[$index],
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php elseif($inputTypes[$index] == 'select_another_table_two'): ?>
                                            <?php echo $__env->make('inputs.select_another_model_two', [
                                                'name' => $columns_table_name[$index],
                                                'optionsFromTable2' => $optionsFromTable2,
                                                'selected' => old($columns_table_name[$index], $data->{$columns_table_name[$index]}),
                                                'required' => $required[$index],
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><?php echo e(__('messages.Update')); ?></button>
                            <a href="<?php echo e(route($routeName . '.index')); ?>" class="btn btn-danger"><?php echo e(__('messages.Cancel')); ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/crud/edit.blade.php ENDPATH**/ ?>