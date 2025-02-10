<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php
    $setting = App\Models\Setting::first();
    ?>

    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light"><?php echo e($setting->name); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3  d-flex">

            <a href="<?php echo e(route('admin.login.edit',auth()->user()->id)); ?>" class="nav-link">
                <p><?php echo e(auth()->user()->name); ?></p>
            </a>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?php echo e(route('employees.fingerprint')); ?>" class="nav-link">
                        <i class="fas fa-fingerprint nav-icon"></i>
                        <p> <?php echo e(__('messages.fingerprint')); ?> </p>
                    </a>
                </li>

                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?php echo e(route('accounting.dashboard')); ?>" class="nav-link">
                        <i class="fas fa-home nav-icon"></i>
                        <p> <?php echo e(__('messages.Accounting')); ?> </p>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?php echo e(route('hr.dashboard')); ?>" class="nav-link">
                        <i class="fas fa-home nav-icon"></i>
                        <p> <?php echo e(__('messages.Hr')); ?> </p>
                    </a>
                </li>

                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link">
                        <i class="fas fa-home nav-icon"></i>
                        <p> <?php echo e(__('messages.Home')); ?> </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-file nav-icon"></i>
                        <p>
                            <?php echo e(__('messages.Settings')); ?>

                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if(
                        $user->can('country-table') ||
                        $user->can('country-add') ||
                        $user->can('country-edit') ||
                        $user->can('country-delete')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('countries.index')); ?>" class="nav-link">
                                <i class="fas fa-globe nav-icon"></i>
                                <p> <?php echo e(__('messages.countries')); ?> </p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <!-- Hotels -->
                        <?php if(
                        $user->can('hotel-table') ||
                        $user->can('hotel-add') ||
                        $user->can('hotel-edit') ||
                        $user->can('hotel-delete')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('hotels.index')); ?>" class="nav-link">
                                <i class="fas fa-hotel nav-icon"></i>
                                <p> <?php echo e(__('messages.hotels')); ?> </p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <!-- Airplanes -->
                        <?php if(
                        $user->can('airplane-table') ||
                        $user->can('airplane-add') ||
                        $user->can('airplane-edit') ||
                        $user->can('airplane-delete')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('airplanes.index')); ?>" class="nav-link">
                                <i class="fas fa-plane nav-icon"></i>
                                <p> <?php echo e(__('messages.airplanes')); ?> </p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <!-- companies -->
                        <?php if(
                        $user->can('company-table') ||
                        $user->can('company-add') ||
                        $user->can('company-edit') ||
                        $user->can('company-delete')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('companies.index')); ?>" class="nav-link">
                                <i class="fas fa-plane nav-icon"></i>
                                <p> <?php echo e(__('messages.companies')); ?> </p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <!-- Settings -->
                        <li class="nav-item">
                            <a href="<?php echo e(route('settings.index')); ?>" class="nav-link">
                                <i class="fas fa-cog nav-icon"></i>
                                <p><?php echo e(__('messages.Configrations')); ?> </p>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Bookings -->
                <?php if(
                $user->can('booking-table') ||
                $user->can('booking-add') ||
                $user->can('booking-edit') ||
                $user->can('booking-delete')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('bookings.index')); ?>" class="nav-link">
                        <i class="fas fa-book nav-icon"></i>
                        <p> <?php echo e(__('messages.bookings')); ?> </p>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Users -->
                <?php if(
                $user->can('customer-table') ||
                $user->can('customer-add') ||
                $user->can('customer-edit') ||
                $user->can('customer-delete')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('users.index')); ?>" class="nav-link">
                        <i class="fas fa-users nav-icon"></i>
                        <p> <?php echo e(__('messages.users')); ?> </p>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Tasks -->
                <?php if(
                $user->can('task-table') ||
                $user->can('task-add') ||
                $user->can('task-edit') ||
                $user->can('task-delete')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('tasks.index')); ?>" class="nav-link">
                        <i class="fas fa-tasks nav-icon"></i>
                        <p> <?php echo e(__('messages.tasks')); ?> </p>
                    </a>
                </li>
                <?php endif; ?>

                <!-- My Files -->
                <li class="nav-item">
                    <a href="<?php echo e(isset($setting) && $setting->link_google ? $setting->link_google : '#'); ?>" target="_blank" class="nav-link">
                        <i class="fas fa-file-alt nav-icon"></i>
                        <p><?php echo e(__('messages.My Files')); ?></p>
                    </a>
                </li>

                <!-- Reports -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-chart-bar nav-icon"></i>
                        <p>
                            <?php echo e(__('messages.Reports')); ?>

                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('reports.bookings')); ?>" class="nav-link">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p> <?php echo e(__('messages.Booking Report')); ?> </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('reports.users')); ?>" class="nav-link">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p> <?php echo e(__('messages.Users Report')); ?> </p>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Roles -->
                <?php if($user->can('role-table') || $user->can('role-add') || $user->can('role-edit') || $user->can('role-delete')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.role.index')); ?>" class="nav-link">
                        <i class="fas fa-user-shield nav-icon"></i>
                        <span><?php echo e(__('messages.Roles')); ?> </span>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Employees -->
                <?php if(
                $user->can('employee-table') ||
                $user->can('employee-add') ||
                $user->can('employee-edit') ||
                $user->can('employee-delete')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.employee.index')); ?>" class="nav-link">
                        <i class="fas fa-user-tie nav-icon"></i>
                        <span> <?php echo e(__('messages.Employee')); ?> </span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/admin/includes/sidebar.blade.php ENDPATH**/ ?>