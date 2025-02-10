@extends('layouts.admin')

@section('title')
    {{ __('messages.bookings') }}
@endsection

@section('content')
    <div class="alert alert-danger d-none" role="alert"></div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> @if($booking->id) {{ __('messages.Edit') }} @else {{ __('messages.Add_New') }} @endif {{ __('messages.booking') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('bookings.save',$booking->id) }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Select User') }}</label>
                            <select name="user" class="form-control" id="user_id">
                                <option value="">{{ __('messages.Select User') }}</option>
                                @if ($booking && $booking->user_id)
                                    <option value="{{ $booking->user_id }}" selected>{{ $booking->user->name }}</option>
                                @endif
                            </select>
                            @error('user')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newUserModal">
                            + {{ __('messages.New User') }}
                        </button>
                    </div>

                    <div class="col-md-12 py-2"><div class="row" id="brother-checkboxes"></div></div>

                    <div class="col-md-12 py-2">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label> {{ __('messages.Total Price') }}</label>
                                    <input type="number"value="{{$booking->total_selling_price}}" name="total_selling_price" id="total_price" class="form-control total_selling_price">
                                    <span class="Trip total_selling_price text-danger d-none"></span>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <!-- <label> {{ __('messages.Price Note') }}</label> -->
                                    <textarea placeholder="{{ __('messages.Price Note') }}" name="price_note" id="price_note" class="form-control price_note">{{$booking->price_note}}</textarea>
                                    <span class="Trip price_note text-danger d-none"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">{{ __('messages.Submit') }}</button>
                            <a href="{{ route('bookings.index') }}" class="btn btn-danger">{{ __('messages.Cancel') }}</a>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    @if($booking->id)
    <div class="row p-3 pt-2">
        <div class="table alert alert-danger d-none" role="alert"></div>
        <table id="crudTable" class="table table-bordered table-hover disabled">
            <thead class="custom_thead">
                <th class='row p-0 m-0'>
                  <div class='col-md-10 col-xs-12 p-2 m-0 border-start border-end'>{{ __('messages.Service') }}</div>
                  <div class='col-md-2 col-xs-12 p-2 m-0 border-start border-end' style='border-left:1px white solid;'>{{ __('messages.Action') }}</div>
                </th>
            </thead>
            <tbody>

                @include('admin.bookings.create_services')

                @include('admin.bookings.edit_services',['booking' => $booking])

            </tbody>
        </table>
    </div>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newUserModalLabel">{{ __('messages.New User') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-danger d-none mx-2" role="alert"></div>
            <div class="modal-body">
                <form id="newUserForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Include the user creation form fields here -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('messages.Name') }}<span class='text-danger'> * </span></label>
                                <input name="name" id="name" class="form-control" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> {{ __('messages.Phone') }}<span class='text-danger'> * </span></label>
                                <input name="phone" id="price_notes" class="form-control" value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> {{ __('messages.date_of_birth') }}</label>
                                <input type="date" name="date_of_birth" id="name" class="form-control" value="{{ old('date_of_birth') }}">
                                @error('date_of_birth')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> {{ __('messages.Address') }}</label>
                                <input name="address" id="address" class="form-control" value="{{ old('address') }}">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <img src="" id="image-preview" alt="Selected Image" height="50px" width="50px" style="display: none;">
                              <button class="btn">{{ __('messages.Photo of passport') }} </button>
                             <input  type="file" id="Item_img" name="photo_of_passport" class="form-control" onchange="previewImage()">
                                @error('photo_of_passport')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> {{ __('messages.Date of passport end') }} </label>
                                <input type="date" name="date_of_passport_end" id="name" class="form-control" value="{{ old('date_of_passport_end') }}">
                                @error('date_of_passport_end')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> {{ __('messages.person_or_company') }}<span class='text-danger'> * </span></label>
                                <select name="person_or_company" id="person_or_company" class="form-control">
                                    <option value=""> select</option>
                                    <option @if (old('person_or_company') == 1 || old('person_or_company') == '') selected="selected" @endif value="1"> Personal
                                    </option>
                                    <option @if (old('person_or_company') == 2 and old('person_or_company') != '') selected="selected" @endif value="2">
                                        Company</option>
                                </select>
                                @error('person_or_company')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 d-none" id="company-section">
                            <div class="form-group">
                                <label for="company_id">{{ __('messages.Select Company') }}</label><br>
                                <select name="company[]" class="form-control" id="company_id" multiple>
                                    <option value="">{{ __('messages.Select Company') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="brothers">{{ __('messages.Search and Select Brothers') }}</label>
                                <input type="text" id="brother-search" class="form-control" placeholder="Search for family by name or phone">
                                <select id="brother-select" name="family_id[]" class="form-control" multiple>
                                    <!-- Options will be populated here by JavaScript -->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> {{ __('messages.Activate') }}<span class='text-danger'> * </span></label>
                                <select name="activate" id="activate" class="form-control">
                                    <option value=""> select</option>
                                    <option @if (old('activate') == 1 || old('activate') == '') selected="selected" @endif value="1"> Active
                                    </option>
                                    <option @if (old('activate') == 2 and old('activate') != '') selected="selected" @endif value="2">
                                        disactive</option>
                                </select>
                                @error('activate')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group text-center">
                                <button type="button" id="saveNewUser" class="btn btn-primary">{{ __('messages.Submit') }}</button>
                                <button type="button" class="close-modal btn btn-secondary" data-dismiss="modal" aria-label="Close">{{ __('messages.Cancel') }}</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script>
    var booking_id = {{ $booking->id }};
    var booking_user_id = {{ $booking->user_id }};
</script>
<script>
    $(document).ready(function() {
        $('#company_id').select2({
            placeholder: "{{ __('messages.Select Company') }}",
            allowClear: true,
            ajax: {
                url: '{{ route("api.companies.search") }}', // API route to fetch companies
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
                    url: "{{ route('users.searchBrothers') }}",  // Create this route in your controller
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
                url: '{{ route('user.store.modal') }}',
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
                        alert('{{ __('messages.User Created Successfully') }}');
                    } else {
                        alert("{{ __('messages.Error Creating User') }}");
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                   alert("{{ __('messages.Error Creating User') }}");
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
                url: '{{ route("api.users.search") }}', // API route to fetch users
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
                url: "{{ route('users.getUserFamily') }}",
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
                url: '{{ route("api.countries.search") }}', // API route to fetch users
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
                url: '{{ route("api.hotels.search") }}', // API route to fetch users
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
                url: '{{ route("api.airplanes.search") }}', // API route to fetch users
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

@endsection
