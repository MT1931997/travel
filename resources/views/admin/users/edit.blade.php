@extends('layouts.admin')
@section('title')
    {{ __('messages.Edit') }} {{ __('messages.users') }}
@endsection



@section('contentheaderlink')
    <a href="{{ route('users.index') }}"> {{ __('messages.users') }} </a>
@endsection

@section('contentheaderactive')
    {{ __('messages.Edit') }}
@endsection


@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> {{ __('messages.Edit') }} {{ __('messages.users') }} </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

                <form action="{{ route('users.update', $data['id']) }}" method="POST" enctype='multipart/form-data'>
                    <div class="row">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Name') }}</label>
                            <input name="name" id="name" class="form-control"
                                value="{{ old('name', $data['name']) }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>



                    <div class="col-md-6">
                        <div class="form-group">
                            <label> {{ __('messages.Phone') }}</label>
                            <input name="phone" id="phone" class="form-control"
                                value="{{ old('phone', $data['phone']) }}" />
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> {{ __('messages.date_of_birth') }} </label>
                            <input type="date" name="date_of_birth" id="name" class="form-control" value="{{ old('date_of_birth',$data['date_of_birth']) }}">
                            @error('date_of_birth')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label> {{ __('messages.Address') }}</label>
                            <input name="address" id="address" class="form-control"
                                value="{{ old('address', $data['address']) }}" />
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
                                <!-- Populate with current brothers and allow searching for new brothers -->
                                @foreach($currentBrothers as $brother)
                                    <option value="{{ $brother->id }}" selected>{{ $brother->name }} ({{ $brother->phone }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>






                    <div class="form-group col-md-6">
                        <label for="photo_of_passport">{{ __('messages.Photo of passport') }} </label>
                        <input type="file" name="photo_of_passport" id="photo_of_passport" class="form-control-file">
                        @if ($data->photo_of_passport)
                            <img src="{{ asset('assets/admin/uploads').'/'.$data->photo_of_passport }}" id="image-preview" alt="Selected Image" height="50px" width="50px">
                        @else
                            <img src="" id="image-preview" alt="Selected Image" height="50px" width="50px" style="display: none;">
                        @endif
                        @error('photo_of_passport')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> {{ __('messages.Date of passport end') }} </label>
                            <input type="date" name="date_of_passport_end" id="name" class="form-control" value="{{ old('date_of_passport_end', $data['date_of_passport_end']) }}">
                            @error('date_of_passport_end')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>



                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Activate') }}</label>
                            <select name="active" id="active" class="form-control">
                                <option value="">Select</option>
                                <option @if ($data->active == 1) selected="selected" @endif value="1">Active</option>
                                <option @if ($data->active == 2) selected="selected" @endif value="2">Inactive</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.person_or_company') }}</label>
                            <select name="person_or_company" id="person_or_company" class="form-control">
                                <option value="">Select</option>
                                <option @if ($data->person_or_company == 1) selected="selected" @endif value="1">Personal</option>
                                <option @if ($data->person_or_company == 2) selected="selected" @endif value="2">Company</option>
                            </select>
                            @error('person_or_company')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6" id="company-section">
                        <div class="form-group">
                            <label for="user_id">{{ __('messages.Select Company') }}</label>
                            <select name="company[]" class="form-control" id="user_id" multiple>
                                <option value="">{{ __('messages.Select Company') }}</option>
                                @foreach($selectedCompanies as $company)
                                    <option value="{{ $company->id }}" selected>{{ $company->name }}</option>
                                @endforeach
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
                            <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> {{ __('messages.Update') }}</button>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('messages.Name') }}</label>
                                    <input name="name" id="name" class="form-control" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
             </div>
        </div>
   </div>
@endsection



@section('script')
<script>
    $(document).ready(function() {
        // Pre-fill the Select2 dropdown with existing companies
        $('#user_id').select2({
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

        // Handle new company form submission
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
                        var newOption = new Option(response.company.name, response.company.id, true, true);
                        $('#user_id').append(newOption).trigger('change');
                        $('#newUserModal').modal('hide');
                        alert('{{ __('messages.Company Created Successfully') }}');
                    } else {
                        alert('{{ __('messages.Error Creating Company') }}');
                    }
                },
                error: function(xhr) {
                    alert('{{ __('messages.Error Creating Company') }}');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#brother-search').on('input', function () {
            var searchQuery = $(this).val();
            if (searchQuery.length > 2) {
                $.ajax({
                    url: "{{ route('users.searchBrothers') }}",
                    method: "GET",
                    data: { query: searchQuery },
                    success: function (data) {
                        $('#brother-select').empty();

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
@endsection
