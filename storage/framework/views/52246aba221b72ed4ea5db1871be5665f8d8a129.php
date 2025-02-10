<footer class="main-footer">
  <?php
        $setting = App\Models\Setting::first();
    ?>
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023 <a href=""><?php echo e($setting->name); ?></a>.</strong> All rights reserved.
  </footer>
<?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/admin/includes/footer.blade.php ENDPATH**/ ?>