@extends('layouts.admin')

@section('title')
    {{ __('messages.Edit') }} {{ __('messages.booking') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('bookings.index') }}"> {{ __('messages.bookings') }} </a>
@endsection

@section('contentheaderactive')
    {{ __('messages.Edit') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> {{ __('messages.Edit') }} {{ __('messages.booking') }} </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('bookings.update', $booking->id) }}" method="POST" enctype='multipart/form-data'>
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Date_of_Travel') }}</label>
                            <input type="datetime-local" name="date_of_travel" class="form-control"
                                value="{{ old('date_of_travel', $booking->date_of_travel) }}">
                            @error('date_of_travel')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Date_of_Come') }}</label>
                            <input type="datetime-local" name="date_of_come" class="form-control"
                                value="{{ old('date_of_come', $booking->date_of_come) }}">
                            @error('date_of_come')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Purchase_Price') }}</label>
                            <input type="number" step="0.01" name="purchase_price" class="form-control"
                                value="{{ old('purchase_price', $booking->purchase_price) }}">
                            @error('purchase_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Selling_Price') }}</label>
                            <input type="number" step="0.01" name="selling_price" class="form-control"
                                value="{{ old('selling_price', $booking->selling_price) }}">
                            @error('selling_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Is Transet') }}</label><br>
                            <input type="checkbox" name="is_transet" value="1" id="is_transet"
                                {{ old('is_transet', $booking->is_transet) == 1 ? 'checked' : '' }}> Yes
                            <textarea name="transet_desc" id="transet_desc" class="form-control mt-2" placeholder="Describe Transet"
                                style="{{ old('is_transet', $booking->is_transet) == 1 ? '' : 'display: none;' }}">
                                {{ old('transet_desc', $booking->transet_desc) }}
                            </textarea>
                            @error('transet_desc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Is Transport') }}</label><br>
                            <input type="checkbox" name="is_transport" value="1" id="is_transport"
                                {{ old('is_transport', $booking->is_transport) == 1 ? 'checked' : '' }}> Yes
                            <textarea name="transport_desc" id="transport_desc" class="form-control mt-2" placeholder="Describe Transport"
                                style="{{ old('is_transport', $booking->is_transport) == 1 ? '' : 'display: none;' }}">
                                {{ old('transport_desc', $booking->transport_desc) }}
                            </textarea>
                            @error('transport_desc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Is Trip') }}</label><br>
                            <input type="checkbox" name="is_trip" value="1" id="is_trip"
                                {{ old('is_trip', $booking->is_trip) == 1 ? 'checked' : '' }}> Yes
                            <textarea name="trip_desc" id="trip_desc" class="form-control mt-2" placeholder="Describe Trip"
                                style="{{ old('is_trip', $booking->is_trip) == 1 ? '' : 'display: none;' }}">
                                {{ old('trip_desc', $booking->trip_desc) }}
                            </textarea>
                            @error('trip_desc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Select Country') }}</label>
                            <select name="country" class="form-control" id="country_id">
                                @if ($booking->country_id)
                                    <option value="{{ $booking->country_id }}" selected>{{ $booking->country->name }}
                                    </option>
                                @endif
                            </select>
                            @error('country')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Select Hotel') }}</label>
                            <select name="hotel" class="form-control" id="hotel_id">
                                @if ($booking->hotel_id)
                                    <option value="{{ $booking->hotel_id }}" selected>{{ $booking->hotel->name }}</option>
                                @endif
                            </select>
                            @error('hotel')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Select User') }}</label>
                            <select name="user" class="form-control" id="user_id">
                                @if ($booking->user_id)
                                    <option value="{{ $booking->user_id }}" selected>{{ $booking->user->name }}</option>
                                @endif
                            </select>
                            @error('user')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Select Airplane') }}</label>
                            <select name="airplane" class="form-control" id="airplane_id">
                                @if ($booking->airplane_id)
                                    <option value="{{ $booking->airplane_id }}" selected>{{ $booking->airplane->name }}
                                    </option>
                                @endif
                            </select>
                            @error('airplane')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">

                            <!-- Display existing files -->
                            @if ($booking->bookingPdfs->count() > 0)
                                <div class="mb-3">
                                    <label>{{ __('messages.Existing Documents') }}</label>
                                    <ul class="list-group">
                                        @foreach ($booking->bookingPdfs as $pdf)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <a href="{{ asset('assets/admin/uploads') . '/' . $pdf->pdf }}"
                                                    target="_blank">{{ __('messages.View Document') }}</a>
                                                <div class="form-check">
                                                    <input type="checkbox" name="delete_pdfs[]"
                                                        value="{{ $pdf->id }}" class="form-check-input"
                                                        id="delete_pdf_{{ $pdf->id }}">
                                                    <label class="form-check-label"
                                                        for="delete_pdf_{{ $pdf->id }}">{{ __('messages.Delete') }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <label>{{ __('messages.Upload Documents') }}</label>
                            <!-- Input for uploading new files -->
                            <input type="file" name="pdf[]" class="form-control" multiple>
                            @error('pdf')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">{{ __('messages.Update') }}</button>
                            <a href="{{ route('bookings.index') }}"
                                class="btn btn-danger">{{ __('messages.Cancel') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toggleTextArea('is_transet', 'transet_desc');
            toggleTextArea('is_transport', 'transport_desc');
            toggleTextArea('is_trip', 'trip_desc');

            function toggleTextArea(checkboxId, textAreaId) {
                const checkbox = document.getElementById(checkboxId);
                const textArea = document.getElementById(textAreaId);

                // Initial display based on checkbox state
                textArea.style.display = checkbox.checked ? 'block' : 'none';

                // Add event listener to toggle text area on checkbox change
                checkbox.addEventListener('change', function() {
                    textArea.style.display = this.checked ? 'block' : 'none';
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Country select2
            $('#country_id').select2({
                placeholder: "{{ __('messages.Select Country') }}",
                allowClear: true,
                ajax: {
                    url: '{{ route('api.countries.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name,
                                };
                            }),
                        };
                    },
                    cache: true,
                },
            });

            // Hotel select2
            $('#hotel_id').select2({
                placeholder: "{{ __('messages.Select Hotel') }}",
                allowClear: true,
                ajax: {
                    url: '{{ route('api.hotels.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name,
                                };
                            }),
                        };
                    },
                    cache: true,
                },
            });

            // User select2
            $('#user_id').select2({
                placeholder: "{{ __('messages.Select User') }}",
                allowClear: true,
                ajax: {
                    url: '{{ route('api.users.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name,
                                };
                            }),
                        };
                    },
                    cache: true,
                },
            });

            // Airplane select2
            $('#airplane_id').select2({
                placeholder: "{{ __('messages.Select Airplane') }}",
                allowClear: true,
                ajax: {
                    url: '{{ route('api.airplanes.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name,
                                };
                            }),
                        };
                    },
                    cache: true,
                },
            });
        });
    </script>
@endsection
