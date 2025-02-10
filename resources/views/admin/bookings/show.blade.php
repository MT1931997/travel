@extends('layouts.admin')

@section('title')
    {{ __('messages.View') }} {{ __('messages.booking') }}
@endsection

@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
    @media print {
        body {
            size: A4;
            margin: 10mm 10mm;
        }
        .container {
            width: 100%;
        }
        .no-print, .admin-footer {
            display: none !important;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        .header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            margin-top: 30px;
        }
    }
</style>
@endsection

@section('content')


    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <img src="{{ url('assets/admin/uploads/' . $setting->logo) }}" alt="Logo" style="width: 150px; height: auto;">
            <h3>{{$setting->name}}</h3>
            <p>{{$setting->address}}</p>
            <p>Tel: {{$setting->company_no}}, Whatsapp: {{$setting->whats_no}}</p>
            <hr>
        </div>

        <h1 class="text-center">{{ __('messages.Confirmation Letter') }}</h1>

     <!-- Booking Information (Left) & Booking Users (Right) -->
    <div class="d-flex justify-content-between align-items-start">
        <!-- Left Section: Booking Information -->
        <div class="booking-info w-50 pr-3">
            <div class="info-box">
                <p><strong>{{ __('messages.Created At') }}:</strong> {{ $booking->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="info-box">
                <p><strong>{{ __('messages.Total Selling Price') }}:</strong> {{ number_format($booking->total_selling_price, 2) }} {{ __('messages.currency') }}</p>
            </div>
        </div>

        <!-- Right Section: Booking Users -->
        <div class="user-list w-50 pl-3">
            @if($booking->booking_users->count() > 0)
                <h2>{{ __('messages.Family Members') }}</h2>
                @foreach ($booking->booking_users as $user)
                    <div class="user-item">
                        <p><strong>{{ __('messages.Name') }}:</strong> {{ $user->name }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>


        <!-- Flight Information -->
        @if($booking->tickets->count() > 0)
            <h2>{{ __('messages.Flight Information') }}</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('messages.From Date') }}</th>
                        <th>{{ __('messages.To Date') }}</th>
                        <th>{{ __('messages.Flight No') }}</th>
                        <th>{{ __('messages.Degree') }}</th>
                        <th>{{ __('messages.From City') }}</th>
                        <th>{{ __('messages.To City') }}</th>
                        <th>{{ __('messages.Ticket Type') }}</th>
                        <th>{{ __('messages.Is Transit') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($booking->tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->from_date }}</td>
                            <td>{{ $ticket->to_date }}</td>
                            <td>{{ $ticket->flight_no }}</td>
                            <td>{{ $ticket->degree }}</td>
                            <td>{{ $ticket->from_city }}</td>
                            <td>{{ $ticket->to_city }}</td>
                            <td>{{ ucfirst($ticket->ticket_type) }}</td>
                            <td>{{ $ticket->is_transit == '1' ? __('messages.Yes') : __('messages.No') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

         <!-- Hotel Bookings -->
         @if($booking->hotels->count() > 0)
         <h2>{{ __('messages.Hotel Information') }}</h2>

         <!-- Table 1: General Hotel Information -->
         <table class="table table-bordered">
             <thead>
                 <tr>
                     <th>{{ __('messages.Check In') }}</th>
                     <th>{{ __('messages.Check Out') }}</th>
                     <th>{{ __('messages.Room Type') }}</th>
                     <th>{{ __('messages.Hotel Stars') }}</th>
                     <th>{{ __('messages.Selling Price') }}</th>
                     <th>{{ __('messages.Room No') }}</th>
                     <th>{{ __('messages.Reserve No') }}</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($booking->hotels as $hotel)
                     <tr>
                         <td>{{ $hotel->from_date }}</td>
                         <td>{{ $hotel->to_date }}</td>
                         <td>{{ ucfirst($hotel->room_type) }}</td>
                         <td>{{ $hotel->hotel_stars }}★</td>
                         <td>{{ number_format($hotel->selling_price, 2) }} {{ __('messages.currency') }}</td>
                         <td>{{ $hotel->room_no }}</td>
                         <td>{{ $hotel->reserve_no }}</td>
                     </tr>
                 @endforeach
             </tbody>
         </table>

         <!-- Table 2: Hotel Amenities -->
         <h3>{{ __('messages.Hotel Amenities') }}</h3>
         <table class="table table-bordered">
             <thead>
                 <tr>
                     <th>{{ __('messages.Hotel Name') }}</th>
                     <th>{{ __('messages.Suite') }}</th>
                     <th>{{ __('messages.Breakfast') }}</th>
                     <th>{{ __('messages.Lunch') }}</th>
                     <th>{{ __('messages.Dinner') }}</th>
                     <th>{{ __('messages.Private Bathroom') }}</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($booking->hotels as $hotel)
                     <tr>
                         <td>{{ $hotel->hotel->name }}</td>
                         <td>{{ $hotel->is_suite ? __('messages.Yes') : __('messages.No') }}</td>
                         <td>{{ $hotel->if_breackfast ? __('messages.Yes') : __('messages.No') }}</td>
                         <td>{{ $hotel->if_lanuch ? __('messages.Yes') : __('messages.No') }}</td>
                         <td>{{ $hotel->if_dinner ? __('messages.Yes') : __('messages.No') }}</td>
                         <td>{{ $hotel->private_pathroom ? __('messages.Yes') : __('messages.No') }}</td>
                     </tr>
                 @endforeach
             </tbody>
         </table>
     @endif


        <!-- Transport Details -->
        @if($booking->transports->count() > 0)
            <h2>{{ __('messages.Transport Information') }}</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('messages.From Date') }}</th>
                        <th>{{ __('messages.To Date') }}</th>
                        <th>{{ __('messages.Vehicle') }}</th>
                        <th>{{ __('messages.Note') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($booking->transports as $transport)
                        <tr>
                            <td>{{ $transport->from_date }}</td>
                            <td>{{ $transport->to_date }}</td>
                            <td>{{ $transport->service_type }}</td>
                            <td>{{ $transport->note }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- FOOTER -->
        <div class="footer">
            <p><strong>{{$setting->name}}</strong></p>
            <p>{{$setting->address}}</p>
            <p>Tel: {{$setting->company_no}}, Whatsapp: {{$setting->whats_no}}</p>
        </div>

        <!-- PRINT BUTTON -->
        <button class="btn btn-primary no-print" onclick="window.print()">{{ __('messages.Print Invoice') }}</button>
    </div>
@endsection
