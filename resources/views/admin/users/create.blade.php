@extends('layouts.admin')
@section('title')
{{ __('messages.users') }}
@endsection

@section('css')
<style>
.hidden {
    display: none;
}
</style>

@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> {{ __('messages.Add_New') }}  {{ __('messages.users') }} </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


            <form action="{{ route('users.store') }}" method="post" enctype='multipart/form-data'>
                <div class="row">
                    @csrf

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>  {{ __('messages.Name') }} </label>
                            <input name="name" id="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> {{ __('messages.Phone') }}</label>
                            <input name="phone" id="notes" class="form-control" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> {{ __('messages.date_of_birth') }} </label>
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
                        <label for="brothers">{{ __('messages.Search and Select Brothers') }}</label>
                        <input type="text" id="brother-search" class="form-control" placeholder="Search for family by name or phone">
                        <select id="brother-select" name="family_id[]" class="form-control" multiple>
                            <!-- Options will be populated here by JavaScript -->
                        </select>
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
                            <label> {{ __('messages.Activate') }}</label>
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

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.person_or_company') }}</label>
                            <select name="person_or_company" id="person_or_company" class="form-control" onchange="toggleCompanySection()">
                                <option value="">Select</option>
                                <option @if (old('person_or_company') == 1 || old('person_or_company') == '') selected="selected" @endif value="1">Personal</option>
                                <option @if (old('person_or_company') == 2 && old('person_or_company') != '') selected="selected" @endif value="2">Company</option>
                            </select>
                            @error('person_or_company')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                        <div class="col-md-6 hidden" id="company-section">
                            <div class="form-group">
                                <select name="company[]" class="form-control" id="user_id" multiple>
                                    <option value="">{{ __('messages.Select Company') }}</option>
                                </select>
                                @error('company')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newUserModal">
                            + {{ __('messages.New Company') }}
                        </button>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group text-center">
                            <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> {{ __('messages.Submit') }}</button>
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-danger">{{ __('messages.Cancel') }}</a>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    </div>
    <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newUserModalLabel">{{ __('messages.New Company') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <form id="newUserForm" action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Include the user creation form fields here -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('messages.Name') }}</label>
                                <input name="name" id="name" class="form-control" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group text-center">
                                <button type="button" id="saveNewUser" class="btn btn-primary">{{ __('messages.Submit') }}</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.Cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('script')
<script>

    function toggleCompanySection() {
        const personOrCompany = document.getElementById('person_or_company').value;
        const companySection = document.getElementById('company-section');
        if (personOrCompany === '2') {
            companySection.classList.remove('hidden');
            $('.select2.select2-container').css('width','100%').css('padding','0px');
        } else {
            companySection.classList.add('hidden');
        }
    }

    // Initialize visibility on page load
    document.addEventListener('DOMContentLoaded', function () {
        toggleCompanySection();
    });

</script>

<script>
    $(document).ready(function() {
        // Handle new user form submission
        $('#saveNewUser').click(function() {
            var formData = new FormData($('#newUserForm')[0]);

            $.ajax({
                url: '{{ route('company.store.modal') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Add the new user to the Select2 dropdown
                        var newOption = new Option(response.company.name, response.company.id, true, true);
                        $('#user_id').append(newOption).trigger('change');
                        // Close the modal
                        $('#newUserModal').modal('hide');
                        alert('{{ __('messages.Company Created Successfully') }}');
                    } else {
                        alert('{{ __('messages.Error Creating Company') }}');
                    }
                },
                error: function(xhr) {
                    // Handle errors and display them
                    alert('{{ __('messages.Error Creating Company') }}');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: "Select Company",
            allowClear: true,
            ajax: {
                url: '{{ route("api.companies.search") }}', // API route to fetch users
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
<script>
    $(document).ready(function () {
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
    });
</script>



<script>
    function previewImage() {
      var preview = document.getElementById('image-preview');
      var input = document.getElementById('Item_img');
      var file = input.files[0];
      if (file) {
      preview.style.display = "block";
      var reader = new FileReader();
      reader.onload = function() {
        preview.src = reader.result;
      }
      reader.readAsDataURL(file);
    }else{
        preview.style.display = "none";
    }
    }
</script>


@endsection
