@extends('layouts.admin')

@section('title')
    {{ __('messages.bookings') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> {{ __('messages.bookings') }} </h3>

            <a href="{{ route('bookings.createOrEdit') }}" class="btn btn-sm btn-success"> {{ __('messages.New') }}
                {{ __('messages.booking') }}</a>
        </div>
        <div class="card-body">


            <div class="clearfix"></div>

            <div id="ajax_responce_serarchDiv" class="col-md-12">
                @can('booking-table')
                    @if (@isset($bookings) && !@empty($bookings) && count($bookings) > 0)
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <th>{{ __('messages.User') }}</th>
                                <th>{{ __('messages.Travellers No') }}</th>
                                <th>{{ __('messages.Create at') }}</th>
                                <th>{{ __('messages.Country') }}</th>
                                <!-- <th>{{ __('messages.Date_of_Travel') }}</th>
                                <th>{{ __('messages.Date_of_Come') }}</th> -->
                                <th>{{ __('messages.Purchase_Price') }}</th>
                                <th>{{ __('messages.Selling_Price') }}</th>
                                <th>{{ __('messages.Status') }}</th>
                                <th>{{ __('messages.Actions') }}</th>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->user->name ?? __('messages.Unknown') }}</td>
                                        <td>{{ $booking->booking_users?->count() }}</td>
                                        <td>{{ $booking->created_at }}</td>
                                        <td>{{ $booking->get_service_country() ??  __('messages.Unknown') }}</td>
                                        <!-- <td>{{ $booking->date_of_travel }}</td>
                                        <td>{{ $booking->date_of_come }}</td> -->
                                        <td>{{ $booking->total_purchase_price }}</td>
                                        <td>{{ $booking->total_selling_price }}</td>
                                        <td>
                                            <select class="form-control status-select" data-id="{{ $booking->id }}">
                                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                                    {{ __('messages.Pending') }}</option>
                                                <option value="completed"
                                                    {{ $booking->status == 'completed' ? 'selected' : '' }}>
                                                    {{ __('messages.Completed') }}</option>
                                                <option value="cancelled"
                                                    {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                                    {{ __('messages.Cancelled') }}</option>
                                            </select>
                                        </td>
                                        <td>
                                            @can('booking-edit')
                                                <a href="{{ route('bookings.show', $booking->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    {{ __('messages.Show') }}
                                                </a>
                                            @endcan

                                            @can('booking-edit')
                                                @if($booking->user_can_edit())
                                                    <a href="{{ route('bookings.createOrEdit', $booking->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        {{ __('messages.Edit') }}
                                                    </a>
                                                @endif
                                            @endcan

                                            @can('booking-delete')
                                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('{{ __('messages.Are_you_sure') }}')">
                                                        {{ __('messages.Delete') }}
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $bookings->links() }}
                    @else
                        <div class="alert alert-danger">
                            {{ __('messages.No_data') }}
                        </div>
                    @endif
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Handle status change
            $('.status-select').on('change', function() {
                var bookingId = $(this).data('id');
                var newStatus = $(this).val();
                $.ajax({
                    url: '{{ route('bookings.changeStatus') }}', // Define this route in your web.php
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: bookingId,
                        status: newStatus,
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.success) {
                            alert('{{ __('messages.Status_Updated_Successfully') }}');
                        } else {
                            alert('{{ __('messages.Status_Update_Failed') }}');
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
@endsection
