@if($booking->hotels && $booking->hotels->count())
@php $booking_hotels = $booking->hotels->reverse(); @endphp
@foreach($booking_hotels as $hotel)
<tr id='service{{$hotel->id}}hotel'>
    <td class='p-0'>
        <form id='editServiceHotel{{$hotel->id}}' class='editServiceForm row p-0 m-0'
            action="{{ route('bookings.edit.service',['id'=>$hotel->id,'service_type'=>'hotel','booking_id'=>$booking->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class='col-md-10 col-xs-12 m-0' id='hotels' class="row edit_servive_data">
                <div class="row p-0 m-0">
                    <div id='hotel' class="row service_data">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('messages.Select Hotel') }}</label>
                                <select name="hotel_id" class="Hotel form-control hotel_id">
                                    @if ($hotel->hotel_id)
                                        <option value="{{ $hotel->hotel_id }}" selected>{{ $hotel->hotel->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> {{ __('messages.Reserve no') }}</label>
                                <input required type="number" value="{{ $hotel->reserve_no }}" name="reserve_no" id="reserve_no{{ $hotel->hotel_id }}" class="form-control reserve_no">
                                <span class="Hotel reserve_no text-danger d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> {{ __('messages.Room no') }}</label>
                                <input required type="number" value="{{ $hotel->room_no }}" name="room_no" id="room_no{{ $hotel->hotel_id }}" class="form-control room_no">
                                <span class="Hotel room_no text-danger d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> {{ __('messages.Room type') }}</label>
                                <select name="room_type" class="form-control room_type" id="room_type{{ $hotel->hotel_id }}" placeholder="{{ __('messages.Select Service') }}">
                                    <option value="single" @if($hotel->room_type=='single') selected @endif>{{ __('messages.single') }}</option>
                                    <option value="double" @if($hotel->room_type=='double') selected @endif>{{ __('messages.double') }}</option>
                                    <option value="trible" @if($hotel->room_type=='trible') selected @endif>{{ __('messages.trible') }}</option>
                                    <option value="founr"  @if($hotel->room_type=='founr')  selected @endif>{{ __('messages.founr') }}</option>
                                    <option value="five"   @if($hotel->room_type=='five')   selected @endif>{{ __('messages.five') }}</option>
                                </select>
                                <span class="Hotel room_type text-danger d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> {{ __('messages.From date') }}</label>
                                <input required type="datetime-local" value="{{ $hotel->from_date }}" name="from_date" id="from_date{{ $hotel->hotel_id }}" class="form-control from_date">
                                <span class="Hotel from_date text-danger d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> {{ __('messages.To date') }}</label>
                                <input required type="datetime-local" value="{{ $hotel->to_date }}" name="to_date" id="to_date{{ $hotel->hotel_id }}" class="form-control to_date">
                                <span class="Hotel to_date text-danger d-none"></span>
                            </div>
                        </div>
                        <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Purchase Price') }}</label>
                            <input type="number" name="purchase_price" id="purchase_price{{ $hotel->hotel_id }}" class="form-control purchase_price">
                            <span class="Hotel purchase_price text-danger d-none"></span>
                        </div>
                    </div> -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> {{ __('messages.Price') }}</label>
                                <input required type="number" value="{{ $hotel->selling_price }}" name="selling_price" id="selling_price{{ $hotel->hotel_id }}" class="form-control selling_price">
                                <span class="Hotel selling_price text-danger d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> {{ __('messages.Days') }}</label>
                                <input required type="number" value="{{ $hotel->days }}" name="days" id="days{{ $hotel->hotel_id }}" class="form-control days">
                                <span class="Hotel days text-danger d-none"></span>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label> {{ __('messages.hotel_stars') }}</label>
                                <input required type="number" value="{{ $hotel->hotel_stars }}" name="hotel_stars" id="hotel_stars{{ $hotel->hotel_id }}" class="form-control hotel_stars">
                                <span class="Hotel hotel_stars text-danger d-none"></span>
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-md-4 pt-4">
                            <input type="checkbox" value="1" @if($hotel->private_pathroom) checked @endif name="private_pathroom" id="private_pathroom{{ $hotel->hotel_id }}">
                            <label for="private_pathroom{{ $hotel->hotel_id }}" class="px-2"> {{ __('messages.private_pathroom') }}</label>
                        </div>

                        <div class="form-group col-lg-2 col-md-4 pt-4">
                            <input type="checkbox" value="1" @if($hotel->is_suite) checked @endif name="is_suite" id="is_suite{{ $hotel->hotel_id }}">
                            <label for="is_suite{{ $hotel->hotel_id }}" class="px-2"> {{ __('messages.Is suite') }}</label>
                        </div>
                        <div class="form-group col-lg-2 col-md-4 pt-4">
                            <input type="checkbox" value="1" @if($hotel->if_breackfast) checked @endif name="if_breackfast" id="if_breackfast{{ $hotel->hotel_id }}">
                            <label for="if_breackfast{{ $hotel->hotel_id }}" class="px-2"> {{ __('messages.Is breackfast') }}</label>
                        </div>
                        <div class="form-group col-lg-2 col-md-4 pt-4">
                            <input type="checkbox" value="1" @if($hotel->if_lanuch) checked @endif name="if_lanuch" id="if_lanuch{{ $hotel->hotel_id }}">
                            <label for="if_lanuch{{ $hotel->hotel_id }}" class="px-2"> {{ __('messages.Is lanuch') }}</label>
                        </div>
                        <div class="form-group col-lg-2 col-md-4 pt-4">
                            <input type="checkbox" value="1" @if($hotel->if_dinner) checked @endif name="if_dinner" id="if_dinner{{ $hotel->hotel_id }}">
                            <label for="if_dinner{{ $hotel->hotel_id }}" class="px-2"> {{ __('messages.Is dinner') }}</label>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <!-- <label> {{ __('messages.Note') }}</label> -->
                                <textarea placeholder="{{ __('messages.Note') }}" name="note" id="note{{ $hotel->hotel_id }}" class="form-control note">
                                    {{ $hotel->note }}
                                </textarea>
                                <span class="Hotel note text-danger d-none"></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class='col-md-2 col-xs-12 m-0 border-start border-end' style='border-left:1px lightgray solid;'>
                <h5 class="text-center pt-2"> {{ __('messages.Edit Hotel') }}</h5>
                <div class="d-flex justify-content-center">
                    <div class="form-group text-center m-2">
                        <button data-id='editServiceHotel{{$hotel->id}}' title="{{ __('messages.Edit') }}" type="button" class="btn btn-primary editServiceButton"><i class="fa fa-edit fa-md"></i></button>
                    </div>
                    <div class="form-group text-center m-2">
                        <button data-service_type='hotel' data-id='{{$hotel->id}}' title="{{ __('messages.Delete') }}" type="button" class="btn btn-danger deleteServiceButton"><i class="fa fa-trash fa-md"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </td>
</tr>
@endforeach
@endif

@if($booking->tickets && $booking->tickets->count())
@php $tickets = $booking->tickets->reverse(); @endphp
@foreach($tickets as $ticket)
<tr id='service{{$ticket->id}}ticket'>
    <td class='p-0'>
        <form id='editServiceTicket{{$ticket->id}}' class='editServiceForm row p-0 m-0'
            action="{{ route('bookings.edit.service',['id'=>$ticket->id,'service_type'=>'ticket','booking_id'=>$booking->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class='col-md-10 col-xs-12 m-0' id='ticket' class="row edit_servive_data">
                <div class="row p-0 m-0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Flight no') }}</label>
                            <input value="{{$ticket->flight_no}}" name="flight_no" id="flight_no" class="form-control flight_no">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Leave date') }}</label>
                            <input required type="datetime-local" value="{{$ticket->from_date}}" name="from_date" id="from_date" class="form-control from_date">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Arrival date') }}</label>
                            <input required type="datetime-local" value="{{$ticket->to_date}}" name="to_date" id="to_date" class="form-control to_date">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{ __('messages.Select Airplane') }}</label>
                            <select name="airplane_id" class="form-control airplane_id">
                                @if ($ticket->airplane_id)
                                <option value="{{ $ticket->airplane_id }}" selected>{{ $ticket->airplane->name }}
                                </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>{{ __('messages.From Country') }}</label>
                        <select value="{{$ticket->from_country}}" name="from_country" class="form-control from_country country_id">
                            @if ($ticket->from_country)
                            <option value="{{ $ticket->from_country }}" selected>{{ $ticket->get_country($ticket->from_country)?->name }}
                            </option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.From City') }}</label>
                            <input value="{{$ticket->from_city}}" name="from_city" id="from_city" class="form-control from_city">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>{{ __('messages.To Country') }}</label>
                        <select value="{{$ticket->to_country}}" name="to_country" class="form-control country_id to_country">
                            @if ($ticket->to_country)
                            <option value="{{ $ticket->to_country }}" selected>{{ $ticket->get_country($ticket->to_country)?->name }}
                            </option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.To City') }}</label>
                            <input value="{{$ticket->to_city}}" name="to_city" id="to_city" class="form-control to_city">
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <label> {{ __('messages.Purchase Price') }}</label>
                                    <input type="number" value="{{$ticket->purchase_price}}" name="purchase_price" id="purchase_price" class="form-control purchase_price">
                                </div>
                            </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Price') }}</label>
                            <input required type="number" value="{{$ticket->selling_price}}" name="selling_price" class="form-control selling_price">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Degree') }}</label>
                            <input value="{{$ticket->degree}}" name="degree" id="degree" class="form-control degree">
                        </div>
                    </div>
                    <!-- transit  -->
                    <div class="col-12 if_transit @if($ticket->is_transit == '0') d-none @endif">
                        <hr>
                    </div>

                    <div class="col-md-3">
                        <label> {{ __('messages.Is Transit') }} ?</label>
                        <select value="{{$ticket->is_transit}}" name="is_transit" class="form-control is_transit">
                            <option value="0" @if($ticket->is_transit == '0') selected @endif>{{ __('messages.No') }}</option>
                            <option value="1" @if($ticket->is_transit == '1') selected @endif>{{ __('messages.Yes') }}</option>
                        </select>
                    </div>

                    <div class="col-12 if_transit @if($ticket->is_transit == '0') d-none @endif">
                        <h5 class='pt-2'>{{ __('messages.Transit steps') }}</h5>
                        <table class='table table-bordered table-hover disabled bg-white' id='addNewTransitStep{{$ticket->id}}'>
                            <thead>
                                <th>{{ __('messages.Country') }}</th>
                                <th>{{ __('messages.City') }}</th>
                                <th>{{ __('messages.Airport') }}</th>
                                <th>{{ __('messages.Arrival date') }}</th>
                                <th>{{ __('messages.Leave date') }}</th>
                                <th><i class="add-new-step fa fa-plus text-primary p-2"></i></th>
                            </thead>
                            <tbody>
                                @if($ticket->go_transit_steps && $ticket->go_transit_steps->count())
                                @php $go_transit_steps = $ticket->go_transit_steps->reverse(); @endphp
                                @foreach($go_transit_steps as $step)
                                <tr class='transit-step-example'>
                                    <td class='col-2 p-1'>
                                        <select name='transit[old_{{$step->id}}][transit_country_id]' class='form-control transit_country_id'>
                                            @if($step->transit_country_id)
                                            <option value="{{$step->transit_country_id}}">{{$step->get_country($step->transit_country_id)?->name}}</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="{{$step->transit_airport}}" name='transit[old_{{$step->id}}][transit_airport]' class='form-control transit_airport'>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="{{$step->transit_city}}" name='transit[old_{{$step->id}}][transit_city]' class='form-control transit_city'>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="{{$step->transit_from_date}}" type='datetime-local' name='transit[old_{{$step->id}}][transit_from_date]' class='form-control transit_from_date'>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="{{$step->transit_to_date}}" type='datetime-local' name='transit[old_{{$step->id}}][transit_to_date]' class='form-control transit_to_date'>
                                    </td>
                                    <td>
                                        <i class='delete-transit-step fa fa-trash text-danger p-2'></i>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 if_transit @if($ticket->is_transit == '0') d-none @endif bottom">
                        <hr>
                    </div>
                    <!-- transit  -->

                    <!-- ticket_type -->
                    <div class="col-12 if_round @if($ticket->ticket_type == 'round') d-none @endif top">
                        <hr>
                    </div>
                    <h5 class='if_round  d-none pl-2'> {{ __('messages.Return Back') }}
                        <hr>
                    </h5>
                    <div class="col-12 if_round @if($ticket->ticket_type == 'oneway') d-none @endif"></div>

                    <div class="col-md-3 ">
                        <label id="rout_label"> @if($ticket->ticket_type == 'oneway') {{ __('messages.One Way') }} @else {{ __('messages.Round') }} @endif ?</label>
                        <select name="ticket_type" class="form-control ticket_type">
                            <option value="oneway" @if($ticket->ticket_type == 'oneway') selected @endif >{{ __('messages.One Way') }}</option>
                            <option value="round" @if($ticket->ticket_type == 'round') selected @endif >{{ __('messages.Round') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group  if_round @if($ticket->ticket_type == 'oneway') d-none @endif">
                            <label> {{ __('messages.Return flight no') }}</label>
                            <input value="{{$ticket->return_flight_no}}" name="return_flight_no" id="return_flight_no" class="form-control return_flight_no">
                        </div>
                    </div>

                    <div class="col-md-3 if_round @if($ticket->ticket_type == 'oneway') d-none @endif">
                        <div class="form-group">
                            <label> {{ __('messages.Return Leave date') }}</label>
                            <input required type="datetime-local" value="{{$ticket->return_from_date}}" name="return_from_date" id="return_from_date" class="form-control return_from_date">
                        </div>
                    </div>
                    <div class="col-md-3 if_round @if($ticket->ticket_type == 'oneway') d-none @endif">
                        <div class="form-group">
                            <label> {{ __('messages.Return Arrival date') }}</label>
                            <input required type="datetime-local" value="{{$ticket->return_to_date}}" name="return_to_date" id="return_to_date" class="form-control return_to_date">
                        </div>
                    </div>

                    <div class="col-12 if_round if_round_transit @if($ticket->is_transit == '0' || $ticket->ticket_type == 'oneway') d-none @endif">
                        <h5 class='pt-2'>{{ __('messages.Return steps') }}</h5>
                        <table class='table table-bordered table-hover disabled bg-white' id='addNewReturnTransitStep{{$ticket->id}}'>
                            <thead>
                                <th>{{ __('messages.Country') }}</th>
                                <th>{{ __('messages.City') }}</th>
                                <th>{{ __('messages.Airport') }}</th>
                                <th>{{ __('messages.Arrival date') }}</th>
                                <th>{{ __('messages.Leave date') }}</th>
                                <th><i class="add-new-return-step fa fa-plus text-primary"></i></th>
                            </thead>
                            <tbody>
                                @if($ticket->return_transit_steps && $ticket->return_transit_steps->count())
                                @php $return_transit_steps = $ticket->return_transit_steps->reverse(); @endphp
                                @foreach($return_transit_steps as $step)
                                <tr class='transit-step-example'>
                                    <td class='col-2 p-1'>
                                        <select name='return_transit[old_{{$step->id}}][transit_country_id]' class='form-control transit_country_id'>
                                            @if($step->transit_country_id)
                                            <option value="{{$step->transit_country_id}}">{{$step->get_country($step->transit_country_id)?->name}}</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="{{$step->transit_airport}}" name='return_transit[old_{{$step->id}}][transit_airport]' class='form-control transit_airport'>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="{{$step->transit_city}}" name='return_transit[old_{{$step->id}}][transit_city]' class='form-control transit_city'>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="{{$step->transit_from_date}}" type='datetime-local' name='return_transit[old_{{$step->id}}][transit_from_date]' class='form-control transit_from_date'>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="{{$step->transit_to_date}}" type='datetime-local' name='return_transit[old_{{$step->id}}][transit_to_date]' class='form-control transit_to_date'>
                                    </td>
                                    <td>
                                        <i class='delete-transit-step fa fa-trash text-danger p-2'></i>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- ticket_type -->

                    <div class="col-12 if_round @if($ticket->ticket_type == 'oneway') d-none @endif">
                        <hr>
                    </div>

                    <div class="col-12 pt-3">
                        <div class="form-group">
                            <textarea placeholder="{{ __('messages.Note') }}" value="{{$ticket->note}}" name="note" id="note" class="form-control note"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-2 col-xs-12 m-0 border-start border-end' style='border-left:1px lightgray solid;'>
                <h5 class="text-center pt-2"> {{ __('messages.Edit Ticket') }}</h5>
                <div class="d-flex justify-content-center">
                    <div class="form-group text-center m-2">
                        <button data-id='editServiceTicket{{$ticket->id}}' title="{{ __('messages.Edit') }}" type="button" class="btn btn-primary editServiceButton"><i class="fa fa-edit fa-md"></i></button>
                    </div>
                    <div class="form-group text-center m-2">
                        <button data-service_type='ticket' data-id='{{$ticket->id}}' title="{{ __('messages.Delete') }}" type="button" class="btn btn-danger deleteServiceButton"><i class="fa fa-trash fa-md"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </td>
</tr>
@endforeach
@endif

@if($booking->trips && $booking->trips->count())
@php $trips = $booking->trips->reverse(); @endphp
@foreach($trips as $trip)
<tr id='service{{$trip->id}}trip'>
    <td class='p-0'>
        <form id='editServiceTrip{{$trip->id}}' class='editServiceForm row p-0 m-0'
            action="{{ route('bookings.edit.service',['id'=>$trip->id,'service_type'=>'trip','booking_id'=>$booking->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class='col-md-10 col-xs-12 m-0' id='trip' class="row edit_servive_data">
                <div class="row p-0 m-0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.From date') }}</label>
                            <input required value="{{$trip->from_date}}" type="datetime-local" name="from_date" id="edit_from_date" class="form-control from_date">
                            <span class="Trip from_date text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.To date') }}</label>
                            <input required value="{{$trip->to_date}}" type="datetime-local" name="to_date" id="edit_to_date" class="form-control to_date">
                            <span class="Trip to_date text-danger d-none"></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                            <div class="form-group">
                                <label> {{ __('messages.Purchase Price') }}</label>
                                <input  value="{{$trip->purchase_price}}" type="number" name="purchase_price" id="edit_purchase_price" class="form-control purchase_price">
                                <span class="Trip purchase_price text-danger d-none"></span>
                            </div>
                        </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Price') }}</label>
                            <input required value="{{$trip->selling_price}}" type="number" name="selling_price" class="form-control selling_price">
                            <span class="Trip selling_price text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <textarea placeholder="{{ __('messages.Note') }}" name="note" id="edit_note" class="form-control note">{{$trip->note}}</textarea>
                            <span class="Trip note text-danger d-none"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-2 col-xs-12 m-0 border-start border-end' style='border-left:1px lightgray solid;'>
                <h5 class="text-center pt-2"> {{ __('messages.Edit Trip') }}</h5>
                <div class="d-flex justify-content-center">
                    <div class="form-group text-center m-2">
                        <button data-id='editServiceTrip{{$trip->id}}' title="{{ __('messages.Edit') }}" type="button" class="btn btn-primary editServiceButton"><i class="fa fa-edit fa-md"></i></button>
                    </div>
                    <div class="form-group text-center m-2">
                        <button data-service_type='trip' data-id='{{$trip->id}}' title="{{ __('messages.Delete') }}" type="button" class="btn btn-danger deleteServiceButton"><i class="fa fa-trash fa-md"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </td>
</tr>
@endforeach
@endif

@if($booking->visas && $booking->visas->count())
@php $visas = $booking->visas->reverse(); @endphp
@foreach($visas as $visa)
<tr id='service{{$visa->id}}visa'>
    <td class='p-0'>
        <form id='editServiceVisa{{$visa->id}}' class='editServiceForm row p-0 m-0'
            action="{{ route('bookings.edit.service',['id'=>$visa->id,'service_type'=>'visa','booking_id'=>$booking->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class='col-md-10 col-xs-12 m-0' id='visa' class="row edit_servive_data">
                <div class="row p-0 m-0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.From date') }}</label>
                            <input required value="{{$visa->from_date}}" type="datetime-local" name="from_date" id="edit_from_date" class="form-control from_date">
                            <span class="Visa from_date text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.To date') }}</label>
                            <input required value="{{$visa->to_date}}" type="datetime-local" name="to_date" id="edit_to_date" class="form-control to_date">
                            <span class="Visa to_date text-danger d-none"></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                            <div class="form-group">
                                <label> {{ __('messages.Purchase Price') }}</label>
                                <input  value="{{$visa->purchase_price}}" type="number" name="purchase_price" id="edit_purchase_price" class="form-control purchase_price">
                                <span class="Visa purchase_price text-danger d-none"></span>
                            </div>
                        </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Price') }}</label>
                            <input required value="{{$visa->selling_price}}" type="number" name="selling_price" id="edit_selling_price" class="form-control selling_price">
                            <span class="Visa selling_price text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <textarea placeholder="{{ __('messages.Note') }}" name="note" id="edit_note" class="form-control note">{{$visa->note}}</textarea>
                            <span class="Visa note text-danger d-none"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-2 col-xs-12 m-0 border-start border-end' style='border-left:1px lightgray solid;'>
                <h5 class="text-center pt-2"> {{ __('messages.Edit Visa') }}</h5>
                <div class="d-flex justify-content-center">
                    <div class="form-group text-center m-2">
                        <button data-id='editServiceVisa{{$visa->id}}' title="{{ __('messages.Edit') }}" type="button" class="btn btn-primary editServiceButton"><i class="fa fa-edit fa-md"></i></button>
                    </div>
                    <div class="form-group text-center m-2">
                        <button data-service_type='visa' data-id='{{$visa->id}}' title="{{ __('messages.Delete') }}" type="button" class="btn btn-danger deleteServiceButton"><i class="fa fa-trash fa-md"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </td>
</tr>
@endforeach
@endif

@if($booking->transports && $booking->transports->count())
@php $transports = $booking->transports->reverse(); @endphp
@foreach($transports as $transport)
<tr id='service{{$transport->id}}transport'>
    <td class='p-0'>
        <form id='editServiceTransport{{$transport->id}}' class='editServiceForm row p-0 m-0'
            action="{{ route('bookings.edit.service',['id'=>$transport->id,'service_type'=>'transport','booking_id'=>$booking->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class='col-md-10 col-xs-12 m-0' class="row edit_servive_data">
                <div class="row p-0 m-0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.From date') }}</label>
                            <input required value="{{$transport->from_date}}" type="datetime-local" name="from_date" id="edit_from_date" class="form-control from_date">
                            <span class="Transport from_date text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.To date') }}</label>
                            <input required value="{{$transport->to_date}}" type="datetime-local" name="to_date" id="edit_to_date" class="form-control to_date">
                            <span class="Transport to_date text-danger d-none"></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                            <div class="form-group">
                                <label> {{ __('messages.Purchase Price') }}</label>
                                <input  value="{{$transport->purchase_price}}" type="number" name="purchase_price" id="edit_purchase_price" class="form-control purchase_price">
                                <span class="Transport purchase_price text-danger d-none"></span>
                            </div>
                        </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Price') }}</label>
                            <input required value="{{$transport->selling_price}}" type="number" name="selling_price" id="edit_selling_price" class="form-control selling_price">
                            <span class="Transport selling_price text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <textarea placeholder="{{ __('messages.Note') }}" name="note" id="edit_note" class="form-control note">{{$transport->note}}</textarea>
                            <span class="Transport note text-danger d-none"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-2 col-xs-12 m-0 border-start border-end' style='border-left:1px lightgray solid;'>
                <h5 class="text-center pt-2"> {{ __('messages.Edit Transport') }}</h5>
                <div class="d-flex justify-content-center">
                    <div class="form-group text-center m-2">
                        <button data-id='editServiceTransport{{$transport->id}}' title="{{ __('messages.Edit') }}" type="button" class="btn btn-primary editServiceButton"><i class="fa fa-edit fa-md"></i></button>
                    </div>
                    <div class="form-group text-center m-2">
                        <button data-service_type='transport' data-id='{{$transport->id}}' title="{{ __('messages.Delete') }}" type="button" class="btn btn-danger deleteServiceButton"><i class="fa fa-trash fa-md"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </td>
</tr>
@endforeach
@endif

@push('js')
<script>
    $(document).ready(function() {

        var booking_status = "{{$booking->status}}";
        var booking_id     = "{{$booking->id}}";
        if (booking_status == 'completed') {
            $('form input,label,select,textarea,button,table,a').attr('disabled', 'disabled');
            $('form *').addClass('disabled');
            $('form *').on('click', function(event) {
                return false;
            });
        }

        $(document).on('click', 'tbody .editServiceButton', function() {
            var this_id = $(this).attr('data-id');
            var formData = new FormData($('tbody #' + this_id)[0]);
            var url = $('tbody #' + this_id).attr('action');
            $(this).attr('disabled', 'disabled');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response, this_id, formData, url);
                    $('tbody .editServiceButton').removeAttr('disabled');
                    $('.table.alert.alert-danger').addClass('d-none');

                    if (response.success) {
                        alert("{{ __('messages.Service Edited Successfully') }}");
                    } else {
                        alert("{{ __('messages.Error Editing Service') }}");
                    }

                },
                error: function(xhr) {
                    $('tbody .editServiceButton').removeAttr('disabled');
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                    console.log(xhr.responseJSON);
                        $('.table.alert.alert-danger').removeClass('d-none');
                        $('.table.alert.alert-danger').text(xhr.responseJSON.message);
                    }
                }
            });
        });
        $(document).on('click', '.deleteServiceButton', function() {
            let service_id   = $(this).data('id');
            let service_type = $(this).data('service_type');
            if (confirm("{{ __('messages.Are You Sure') }}")) {
                $.ajax({
                    url: "{{ route('bookings.delete.service') }}",
                    type: 'POST',
                    data: {
                        service_id: service_id,
                        service_type: service_type,
                        booking_id: booking_id,
                    },
                    success: function(response) {
                        console.log(response, service_id, service_type, '#service' + service_id + service_type);
                        $('#service' + service_id + service_type).remove();
                        $('.table.alert.alert-danger').addClass('d-none');

                        if (response.success) {
                            alert("{{ __('messages.Service Deleted Successfully') }}");
                            let total_price = 0;
                            $('.service_data:not(.d-none) input.selling_price , .editServiceForm input.selling_price').each(function() {
                                if(this.value){
                                    total_price += parseInt(this.value);
                                    $('#total_price').val(total_price);
                                }
                            });
                        } else {
                            alert("{{ __('messages.Error Deleting Service') }}");
                        }

                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            $('.table.alert.alert-danger').removeClass('d-none');
                            $('.table.alert.alert-danger').text(xhr.responseJSON.message);
                        }
                    }
                });
            }
        });
    });
</script>
@endpush