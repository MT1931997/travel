                <form id='editService{{$ticket->id}}' class='editServiceForm row p-0 m-0' 
                    action="{{ route('bookings.edit.service',['id'=>$tickets->id,'service_type'=>'ticket']) }}" method="post" enctype="multipart/form-data">
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
                                        <option value="{{ $booking->to_country }}" selected>{{ $ticket->get_country($ticket->to_country)?->name }}
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('messages.Select Hotel') }}</label>
                                    <select value="{{$ticket->hotel_id}}" name="hotel_id" class="form-control hotel_id">
                                        @if ($ticket->hotel_id)
                                            <option value="{{ $booking->hotel_id }}" selected>{{ $ticket->hotel->name }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label> {{ __('messages.Purchase Price') }}</label>
                                    <input type="number" value="{{$ticket->purchase_price}}" name="purchase_price" id="purchase_price" class="form-control purchase_price">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label> {{ __('messages.Price') }}</label>
                                    <input required type="number" value="{{$ticket->selling_price}}" name="selling_price" id="selling_price" class="form-control selling_price">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label> {{ __('messages.Degree') }}</label>
                                    <input value="{{$ticket->degree}}" name="degree" id="degree" class="form-control degree">
                                </div>
                            </div>
                            <!-- transit  -->
                                <div class="col-12 if_transit @if($ticket->is_transit == '1') d-none @endif"><hr></div>

                                    <div class="col-md-3">
                                        <label> {{ __('messages.Is Transit') }} ?</label>
                                        <select value="{{$ticket->is_transit}}" name="is_transit" class="form-control is_transit">
                                            <option value="0" @if($ticket->ticket_type == '0') selected @endif>{{ __('messages.No') }}</option>
                                            <option value="1" @if($ticket->ticket_type == '1') selected @endif>{{ __('messages.Yes') }}</option>
                                        </select>
                                    </div>

                                    <div class="col-12 if_transit @if($ticket->is_transit == '1') d-none @endif">
                                        <h5 class='pt-2'>{{ __('messages.Transit steps') }}</h5>
                                        <table class='table table-bordered table-hover disabled bg-white' id='addNewTransitStep'>
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
                                                        <select name='transit[${transit_index}][transit_country_id]' class='form-control transit_country_id'>
                                                            @if($step->transit_country_id)
                                                                <option value="{{$step->transit_country_id}}">{{$step->country($step->transit_country_id)}}</option>
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td class='col-2 p-1'>
                                                        <input value="{{$step->transit_airport}}" name='transit[${transit_index}][transit_airport]' class='form-control transit_airport'>
                                                    </td>
                                                    <td class='col-2 p-1'>
                                                        <input value="{{$step->transit_city}}" name='transit[${transit_index}][transit_city]' class='form-control transit_city'>
                                                    </td>
                                                    <td class='col-2 p-1'>
                                                        <input value="{{$step->transit_from_date}}"  type='datetime-local' name='transit[${transit_index}][transit_from_date]' class='form-control transit_from_date'>
                                                    </td>
                                                    <td class='col-2 p-1'>
                                                        <input value="{{$step->transit_to_date}}"  type='datetime-local' name='transit[${transit_index}][transit_to_date]' class='form-control transit_to_date'>
                                                    </td>
                                                    <td>
                                                        <i class='delete-transit-step fa fa-trash text-danger p-2'></i>
                                                        <i class='edit-transit-step fa fa-edit text-primaty p-2'></i>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>

                                <div class="col-12 if_transit @if($ticket->is_transit == '1') d-none @endif bottom"><hr></div>
                            <!-- transit  -->

                            <!-- ticket_type -->
                                <div class="col-12 if_round @if($ticket->ticket_type == 'round') d-none @endif top"><hr></div>
                                <h5 class='if_round  d-none pl-2'> {{ __('messages.Return Back') }} <hr> </h5>
                                <div class="col-12 if_round d-none"></div>

                                <div class="col-md-3 ">
                                    <label id="rout_label"> {{ __('messages.One Way') }} ?</label>
                                    <select name="ticket_type" class="form-control ticket_type" >
                                        <option value="oneway" @if($ticket->ticket_type == 'oneway') selected @endif >{{ __('messages.One Way') }}</option>
                                        <option value="round" @if($ticket->ticket_type == 'round') selected @endif >{{ __('messages.Round') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group  if_round d-none">
                                        <label> {{ __('messages.Return flight no') }}</label>
                                        <input value="{{$ticket->return_flight_no}}" name="return_flight_no" id="return_flight_no" class="form-control return_flight_no">
                                    </div>
                                </div>

                                <div class="col-md-3 if_round d-none">
                                    <div class="form-group">
                                        <label> {{ __('messages.Return Leave date') }}</label>
                                        <input required type="datetime-local" value="{{$ticket->return_from_date}}" name="return_from_date" id="return_from_date" class="form-control return_from_date">
                                    </div>
                                </div>
                                <div class="col-md-3 if_round d-none">
                                    <div class="form-group">
                                        <label> {{ __('messages.Return Arrival date') }}</label>
                                        <input required type="datetime-local" value="{{$ticket->return_to_date}}" name="return_to_date" id="return_to_date" class="form-control return_to_date">
                                    </div>
                                </div>

                                <div class="col-12 if_round if_round_transit d-none">
                                    <h5 class='pt-2'>{{ __('messages.Return steps') }}</h5>
                                    <table class='table table-bordered table-hover disabled bg-white' id='addNewReturnTransitStep'>
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
                                                    <select name='return_transit[{{$step->index}}][transit_country_id]' class='form-control transit_country_id'>
                                                        @if($step->transit_country_id)
                                                            <option value="{{$step->transit_country_id}}">{{$step->country($step->transit_country_id)}}</option>
                                                        @endif
                                                    </select>
                                                </td>
                                                <td class='col-2 p-1'>
                                                    <input value="{{$step->transit_airport}}" name='return_transit[{{$step->index}}][transit_airport]' class='form-control transit_airport'>
                                                </td>
                                                <td class='col-2 p-1'>
                                                    <input value="{{$step->transit_city}}" name='return_transit[{{$step->index}}][transit_city]' class='form-control transit_city'>
                                                </td>
                                                <td class='col-2 p-1'>
                                                    <input value="{{$step->transit_from_date}}"  type='datetime-local' name='return_transit[{{$step->index}}][transit_from_date]' class='form-control transit_from_date'>
                                                </td>
                                                <td class='col-2 p-1'>
                                                    <input value="{{$step->transit_to_date}}"  type='datetime-local' name='return_transit[{{$step->index}}][transit_to_date]' class='form-control transit_to_date'>
                                                </td>
                                                <td>
                                                    <i class='delete-transit-step fa fa-trash text-danger p-2'></i>
                                                    <i class='edit-transit-step fa fa-edit text-primaty p-2'></i>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                            <!-- ticket_type -->

                            <div class="col-12 if_round d-none"><hr></div>

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
                                <button data-id='editService{{$ticket->id}}' title="{{ __('messages.Edit') }}" type="button" class="btn btn-primary editServiceButton"><i class="fa fa-edit fa-md"></i></button>
                            </div>
                            <div class="form-group text-center m-2">
                                <button data-service_type='ticket' data-id='{{$ticket->id}}' title="{{ __('messages.Delete') }}" type="button" class="btn btn-danger deleteServiceButton"><i class="fa fa-trash fa-md"></i></button>
                            </div>
                        </div>
                    </div>
                </form>