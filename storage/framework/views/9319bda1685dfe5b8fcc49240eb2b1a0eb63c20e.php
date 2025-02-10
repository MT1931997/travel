<select name="<?php echo e($name); ?>" class="form-control" <?php if($required == 'required'): ?> required <?php endif; ?>>
    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($value); ?>"><?php echo e($option); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/inputs/options.blade.php ENDPATH**/ ?>