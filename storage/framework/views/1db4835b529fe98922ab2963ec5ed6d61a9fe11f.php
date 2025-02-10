<?php $__env->startSection('title'); ?>
    <?php echo e(__('messages.bookings')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="alert alert-danger d-none" role="alert"></div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> <?php if($booking->id): ?> <?php echo e(__('messages.Edit')); ?> <?php else: ?> <?php echo e(__('messages.Add_New')); ?> <?php endif; ?> <?php echo e(__('messages.booking')); ?></h3>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('bookings.save',$booking->id)); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?php echo e(__('messages.Select User')); ?></label>
                            <select name="user" class="form-control" id="user_id">
                                <option value=""><?php echo e(__('messages.Select User')); ?></option>
                                <?php if($booking && $booking->user_id): ?>
                                    <option value="<?php echo e($booking->user_id); ?>" selected><?php echo e($booking->user->name); ?></option>
                                <?php endif; ?>
                            </select>
                            <?php $__errorArgs = ['user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newUserModal">
                            + <?php echo e(__('messages.New User')); ?>

                        </button>
                    </div>

                    <div class="col-md-12 py-2"><div class="row" id="brother-checkboxes"></div></div>

                    <div class="col-md-12 py-2">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label> <?php echo e(__('messages.Total Price')); ?></label>
                                    <input type="number"value="<?php echo e($booking->total_selling_price); ?>" name="total_selling_price" id="total_price" class="form-control total_selling_price">
                                    <span class="Trip total_selling_price text-danger d-none"></span>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <!-- <label> <?php echo e(__('messages.Price Note')); ?></label> -->
                                    <textarea placeholder="<?php echo e(__('messages.Price Note')); ?>" name="price_note" id="price_note" class="form-control price_note"><?php echo e($booking->price_note); ?></textarea>
                                    <span class="Trip price_note text-danger d-none"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary"><?php echo e(__('messages.Submit')); ?></button>
                            <a href="<?php echo e(route('bookings.index')); ?>" class="btn btn-danger"><?php echo e(__('messages.Cancel')); ?></a>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <?php if($booking->id): ?>
    <div class="row p-3 pt-2">
        <div class="table alert alert-danger d-none" role="alert"></div>
        <table id="crudTable" class="table table-bordered table-hover disabled">
            <thead class="custom_thead">
                <th class='row p-0 m-0'>
                  <div class='col-md-10 col-xs-12 p-2 m-0 border-start border-end'><?php echo e(__('messages.Service')); ?></div>
                  <div class='col-md-2 col-xs-12 p-2 m-0 border-start border-end' style='border-left:1px white solid;'><?php echo e(__('messages.Action')); ?></div>
                </th>
            </thead>
            <tbody>

                <?php echo $__env->make('admin.bookings.create_services', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('admin.bookings.edit_services',['booking' => $booking], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Modal -->
    <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newUserModalLabel"><?php echo e(__('messages.New User')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-danger d-none mx-2" role="alert"></div>
            <div class="modal-body">
                <form id="newUserForm" action="<?php echo e(route('users.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <!-- Include the user creation form fields here -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo e(__('messages.Name')); ?><span class='text-danger'> * </span></label>
                                <input name="name" id="name" class="form-control" value="<?php echo e(old('name')); ?>">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.Phone')); ?><span class='text-danger'> * </span></label>
                                <input name="phone" id="price_notes" class="form-control" value="<?php echo e(old('phone')); ?>">
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.date_of_birth')); ?></label>
                                <input type="date" name="date_of_birth" id="name" class="form-control" value="<?php echo e(old('date_of_birth')); ?>">
                                <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.Address')); ?></label>
                                <input name="address" id="address" class="form-control" value="<?php echo e(old('address')); ?>">
                                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <img src="" id="image-preview" alt="Selected Image" height="50px" width="50px" style="display: none;">
                              <button class="btn"><?php echo e(__('messages.Photo of passport')); ?> </button>
                             <input  type="file" id="Item_img" name="photo_of_passport" class="form-control" onchange="previewImage()">
                                <?php $__errorArgs = ['photo_of_passport'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.Date of passport end')); ?> </label>
                                <input type="date" name="date_of_passport_end" id="name" class="form-control" value="<?php echo e(old('date_of_passport_end')); ?>">
                                <?php $__errorArgs = ['date_of_passport_end'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.person_or_company')); ?><span class='text-danger'> * </span></label>
                                <select name="person_or_company" id="person_or_company" class="form-control">
                                    <option value=""> select</option>
                                    <option <?php if(old('person_or_company') == 1 || old('person_or_company') == ''): ?> selected="selected" <?php endif; ?> value="1"> Personal
                                    </option>
                                    <option <?php if(old('person_or_company') == 2 and old('person_or_company') != ''): ?> selected="selected" <?php endif; ?> value="2">
                                        Company</option>
                                </select>
                                <?php $__errorArgs = ['person_or_company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-6 d-none" id="company-section">
                            <div class="form-group">
                                <label for="company_id"><?php echo e(__('messages.Select Company')); ?></label><br>
                                <select name="company[]" class="form-control" id="company_id" multiple>
                                    <option value=""><?php echo e(__('messages.Select Company')); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="brothers"><?php echo e(__('messages.Search and Select Brothers')); ?></label>
                                <input type="text" id="brother-search" class="form-control" placeholder="Search for family by name or phone">
                                <select id="brother-select" name="family_id[]" class="form-control" multiple>
                                    <!-- Options will be populated here by JavaScript -->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.Activate')); ?><span class='text-danger'> * </span></label>
                                <select name="activate" id="activate" class="form-control">
                                    <option value=""> select</option>
                                    <option <?php if(old('activate') == 1 || old('activate') == ''): ?> selected="selected" <?php endif; ?> value="1"> Active
                                    </option>
                                    <option <?php if(old('activate') == 2 and old('activate') != ''): ?> selected="selected" <?php endif; ?> value="2">
                                        disactive</option>
                                </select>
                                <?php $__errorArgs = ['activate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group text-center">
                                <button type="button" id="saveNewUser" class="btn btn-primary"><?php echo e(__('messages.Submit')); ?></button>
                                <button type="button" class="close-modal btn btn-secondary" data-dismiss="modal" aria-label="Close"><?php echo e(__('messages.Cancel')); ?></button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    var booking_id = <?php echo e($booking->id); ?>;
    var booking_user_id = <?php echo e($booking->user_id); ?>;
</script>
<script>
    $(document).ready(function() {
        $('#company_id').select2({
            placeholder: "<?php echo e(__('messages.Select Company')); ?>",
            allowClear: true,
            ajax: {
                url: '<?php echo e(route("api.companies.search")); ?>', // API route to fetch companies
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (company) {
                            return {
                                id: company.id,
                                text: company.name
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });

        $('.select2.select2-container').css('width','100%').css('padding','0px');
        let person_or_company = $(this).val();
        if(person_or_company == 2){
            $('#company-section').removeClass('d-none');
        }else{
            $('#company-section').addClass('d-none');
        }
        $('#person_or_company').on('click', function () {
            let person_or_company = $(this).val();
            if(person_or_company == 2){
                $('#company-section').removeClass('d-none');
            }else{
                $('#company-section').addClass('d-none');
            }
         });
        $('input.selling_price').on('input', function () {
            let total_price = 0;
            $('.service_data:not(.d-none) input.selling_price , .editServiceForm input.selling_price').each(function() {
                if(this.value){
                    total_price += parseInt(this.value);
                    $('#total_price').val(total_price);
                }
            });
         });

        $('.close-modal').on('click', function () { $('.modal').modal('hide'); });
        $('.modal').on('hidden.bs.modal', function () { $('.modal .alert.alert-danger').addClass('d-none');
        });
        $('#brother-search').on('input', function () {
            var searchQuery = $(this).val();
            // Only perform search if query is not empty
            if (searchQuery.length > 2) {
                $.ajax({
                    url: "<?php echo e(route('users.searchBrothers')); ?>",  // Create this route in your controller
                    method: "GET",
                    data: {
                        query: searchQuery
                    },
                    success: function (data) {
                        // Clear existing options
                        $('#brother-select').empty();
                        // Populate the select dropdown with search results
                        $.each(data, function (index, user) {
                            $('#brother-select').append(
                                `<option value="${user.id}">${user.name} (${user.phone})</option>`
                            );
                        });
                    }
                });
            }
        });
        // Handle new user form submission
        $('#saveNewUser').click(function() {
            var formData = new FormData($('#newUserForm')[0]);
            $.ajax({
                url: '<?php echo e(route('user.store.modal')); ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('.modal .alert.alert-danger').addClass('d-none');
                    if (response.success === false) {
                        $('.modal .alert.alert-danger').removeClass('d-none');
                        $('.modal .alert.alert-danger').text(response.errors);
                        return false;
                    }else if (response.success) {
                        // Add the new user to the Select2 dropdown
                        var newOption = new Option(response.user.name, response.user.id, true, true);
                        $('#user_id').append(newOption).trigger('change');
                        // Close the modal
                        $('#newUserModal').modal('hide');
                        alert('<?php echo e(__('messages.User Created Successfully')); ?>');
                    } else {
                        alert("<?php echo e(__('messages.Error Creating User')); ?>");
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                   alert("<?php echo e(__('messages.Error Creating User')); ?>");
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        toggleTextArea('is_transet', 'transet_desc');
        toggleTextArea('is_transport', 'transport_desc');
        toggleTextArea('is_trip', 'trip_desc');

        function toggleTextArea(checkboxId, textAreaId) {
            const checkbox = document.getElementById(checkboxId);
            const textArea = document.getElementById(textAreaId);
            textArea.style.display = checkbox.checked ? 'block' : 'none';
            checkbox.addEventListener('change', function () {
                textArea.style.display = this.checked ? 'block' : 'none';
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: "Select User",
            allowClear: true,
            ajax: {
                url: '<?php echo e(route("api.users.search")); ?>', // API route to fetch users
                dataType: 'json',
                delay: 250, // Delay to prevent too many requests
                data: function (params) {
                    return {
                        search: params.term, // Search term to query
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (user) {
                            return {
                                id: user.id,
                                text: user.name // Display mobile and name
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1 // Only start searching after 1 character is typed
        });

        if(booking_user_id && booking_id) {
            get_booking_users(booking_user_id , booking_id);
        }

        $('#user_id').on('change', function () {
            var user_id = $(this).val();
            if(user_id){
                get_booking_users(user_id , booking_id);
            }else{
                $('#brother-checkboxes').html('');
            }
        });

        function get_booking_users(user_id,booking_id) {
            $.ajax({
                url: "<?php echo e(route('users.getUserFamily')); ?>",
                method: "GET",
                data: {
                    user_id:    user_id,
                    booking_id: booking_id,
                },
                success: function (data) {
                    $('#brother-checkboxes').html('');
                    $.each(data, function (index, user) {
                        $('#brother-checkboxes').append(
                            `<div class="form-group col-lg-6 col-sm-12 col-xs-12">
                            <input type="checkbox"` + `${user.checked}` + ` name="brother_ids[]" value="${user.id}" id="brothers_${user.id}">
                            <label for="brothers_${user.id}" class="px-2">${user.name} (${user.phone})</label>
                            </div>`
                        );
                    });
                },
                error: function(xhr) {
                    $('#brother-checkboxes').html('');
                    console.log(xhr);
                }
            });
        }
    });
</script>

<!-- country_id -->
<script>
    $(document).ready(function() {
        $('#country_id').select2({
            placeholder: "Select country",
            allowClear: true,
            ajax: {
                url: '<?php echo e(route("api.countries.search")); ?>', // API route to fetch users
                dataType: 'json',
                delay: 250, // Delay to prevent too many requests
                data: function (params) {
                    return {
                        search: params.term, // Search term to query
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (user) {
                            return {
                                id: user.id,
                                text: user.name // Display mobile and name
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1 // Only start searching after 1 character is typed
        });
    });
</script>

 <!-- hotel_id -->
<script>
    $(document).ready(function() {
        $('#hotel_id').select2({
            placeholder: "Select hotel",
            allowClear: true,
            ajax: {
                url: '<?php echo e(route("api.hotels.search")); ?>', // API route to fetch users
                dataType: 'json',
                delay: 250, // Delay to prevent too many requests
                data: function (params) {
                    return {
                        search: params.term, // Search term to query
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (user) {
                            return {
                                id: user.id,
                                text: user.name // Display mobile and name
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1 // Only start searching after 1 character is typed
        });
    });
</script>

<!-- airplane_id -->
<script>
    $(document).ready(function() {
        $('#airplane_id').select2({
            placeholder: "Select airplane",
            allowClear: true,
            ajax: {
                url: '<?php echo e(route("api.airplanes.search")); ?>', // API route to fetch users
                dataType: 'json',
                delay: 250, // Delay to prevent too many requests
                data: function (params) {
                    return {
                        search: params.term, // Search term to query
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (user) {
                            return {
                                id: user.id,
                                text: user.name // Display mobile and name
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1 // Only start searching after 1 character is typed
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/admin/bookings/create-or-edit.blade.php ENDPATH**/ ?>