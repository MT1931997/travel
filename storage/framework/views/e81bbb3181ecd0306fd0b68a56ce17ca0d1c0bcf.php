<?php if(Session::has('success')): ?>
<div class="alert alert-success" role="alert">
    <?php echo e(Session::get('success')); ?>

  </div>
  <?php endif; ?>

  <?php /**PATH C:\xampp\htdocs\travel\resources\views/superAdmin/includes/alerts/success.blade.php ENDPATH**/ ?>