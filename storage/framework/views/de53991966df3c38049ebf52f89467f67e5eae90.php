<?php if($results->isEmpty()): ?>
    <div class="search-item not-found">Not found</div>
<?php else: ?>
    <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="search-item" data-value="<?php echo e($result->id); ?>"><?php echo e($result->name); ?></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/inputs/search_results.blade.php ENDPATH**/ ?>