<select name="<?php echo e($name); ?>"  <?php if($required): ?> required  class="form-control" <?php endif; ?>>
    <?php $__currentLoopData = $optionsFromTable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($label['id']); ?>"><?php echo e($label['name']); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<?php /**PATH C:\xampp\htdocs\travel\resources\views/inputs/select_another_model.blade.php ENDPATH**/ ?>