<?php $__env->startSection('title'); ?>
    <?php echo e(__('messages.bookings')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> <?php echo e(__('messages.bookings')); ?> </h3>

            <a href="<?php echo e(route('bookings.createOrEdit')); ?>" class="btn btn-sm btn-success"> <?php echo e(__('messages.New')); ?>

                <?php echo e(__('messages.booking')); ?></a>
        </div>
        <div class="card-body">


            <div class="clearfix"></div>

            <div id="ajax_responce_serarchDiv" class="col-md-12">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking-table')): ?>
                    <?php if(@isset($bookings) && !@empty($bookings) && count($bookings) > 0): ?>
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <th><?php echo e(__('messages.User')); ?></th>
                                <th><?php echo e(__('messages.Travellers No')); ?></th>
                                <th><?php echo e(__('messages.Create at')); ?></th>
                                <th><?php echo e(__('messages.Country')); ?></th>
                                <!-- <th><?php echo e(__('messages.Date_of_Travel')); ?></th>
                                <th><?php echo e(__('messages.Date_of_Come')); ?></th> -->
                                <th><?php echo e(__('messages.Purchase_Price')); ?></th>
                                <th><?php echo e(__('messages.Selling_Price')); ?></th>
                                <th><?php echo e(__('messages.Status')); ?></th>
                                <th><?php echo e(__('messages.Actions')); ?></th>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($booking->user->name ?? __('messages.Unknown')); ?></td>
                                        <td><?php echo e($booking->booking_users?->count()); ?></td>
                                        <td><?php echo e($booking->created_at); ?></td>
                                        <td><?php echo e($booking->get_service_country() ??  __('messages.Unknown')); ?></td>
                                        <!-- <td><?php echo e($booking->date_of_travel); ?></td>
                                        <td><?php echo e($booking->date_of_come); ?></td> -->
                                        <td><?php echo e($booking->total_purchase_price); ?></td>
                                        <td><?php echo e($booking->total_selling_price); ?></td>
                                        <td>
                                            <select class="form-control status-select" data-id="<?php echo e($booking->id); ?>">
                                                <option value="pending" <?php echo e($booking->status == 'pending' ? 'selected' : ''); ?>>
                                                    <?php echo e(__('messages.Pending')); ?></option>
                                                <option value="completed"
                                                    <?php echo e($booking->status == 'completed' ? 'selected' : ''); ?>>
                                                    <?php echo e(__('messages.Completed')); ?></option>
                                                <option value="cancelled"
                                                    <?php echo e($booking->status == 'cancelled' ? 'selected' : ''); ?>>
                                                    <?php echo e(__('messages.Cancelled')); ?></option>
                                            </select>
                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking-edit')): ?>
                                                <a href="<?php echo e(route('bookings.show', $booking->id)); ?>"
                                                    class="btn btn-sm btn-success">
                                                    <?php echo e(__('messages.Show')); ?>

                                                </a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking-edit')): ?>
                                                <?php if($booking->user_can_edit()): ?>
                                                    <a href="<?php echo e(route('bookings.createOrEdit', $booking->id)); ?>"
                                                        class="btn btn-sm btn-primary">
                                                        <?php echo e(__('messages.Edit')); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking-delete')): ?>
                                                <form action="<?php echo e(route('bookings.destroy', $booking->id)); ?>" method="POST"
                                                    style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('<?php echo e(__('messages.Are_you_sure')); ?>')">
                                                        <?php echo e(__('messages.Delete')); ?>

                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <br>
                        <?php echo e($bookings->links()); ?>

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

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function() {
            // Handle status change
            $('.status-select').on('change', function() {
                var bookingId = $(this).data('id');
                var newStatus = $(this).val();
                $.ajax({
                    url: '<?php echo e(route('bookings.changeStatus')); ?>', // Define this route in your web.php
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        id: bookingId,
                        status: newStatus,
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.success) {
                            alert('<?php echo e(__('messages.Status_Updated_Successfully')); ?>');
                        } else {
                            alert('<?php echo e(__('messages.Status_Update_Failed')); ?>');
                        }
                    },
                    error: function(xhr) {
                        // console.log(xhr);
                        if(xhr.responseJSON && xhr.responseJSON.message){
                            alert(xhr.responseJSON.message);
                        }
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>