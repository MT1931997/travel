<tr id='create_services' class='mb-2'>

    <td class='p-0 '>
        <form class='row p-0 m-0 py-4' id='newServiceForm' action="{{ route('bookings.create.service',$booking->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            
            <div class="col-md-10 col-xs-12 m-0">

                <div id='trip' class="row service_data d-none">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.From date') }}</label>
                            <input required type="datetime-local" name="from_date" id="from_date" class="form-control from_date">
                            <span class="Trip from_date text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.To date') }}</label>
                            <input required type="datetime-local" name="to_date" id="to_date" class="form-control to_date">
                            <span class="Trip to_date text-danger d-none"></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Purchase Price') }}</label>
                            <input type="number" name="purchase_price" id="purchase_price" class="form-control purchase_price">
                            <span class="Trip purchase_price text-danger d-none"></span>
                        </div>
                    </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Price') }}</label>
                            <input required type="number" name="selling_price" id="selling_price" class="form-control selling_price">
                            <span class="Trip selling_price text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <!-- <label> {{ __('messages.Note') }}</label> -->
                            <textarea placeholder="{{ __('messages.Note') }}" name="note" id="note" class="form-control note"></textarea>
                            <span class="Trip note text-danger d-none"></span>
                        </div>
                    </div>
                </div>

                <div id='visa' class="row service_data d-none">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.From date') }}</label>
                            <input required type="datetime-local" name="from_date" id="from_date" class="form-control from_date">
                            <span class="Trip from_date text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.To date') }}</label>
                            <input required type="datetime-local" name="to_date" id="to_date" class="form-control to_date">
                            <span class="Trip to_date text-danger d-none"></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Purchase Price') }}</label>
                            <input type="number" name="purchase_price" id="purchase_price" class="form-control purchase_price">
                            <span class="Trip purchase_price text-danger d-none"></span>
                        </div>
                    </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Price') }}</label>
                            <input required type="number" name="selling_price" id="selling_price" class="form-control selling_price">
                            <span class="Trip selling_price text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <!-- <label> {{ __('messages.Note') }}</label> -->
                            <textarea placeholder="{{ __('messages.Note') }}" name="note" id="note" class="form-control note"></textarea>
                            <span class="Trip note text-danger d-none"></span>
                        </div>
                    </div>
                </div>

                <div id='transport' class="row service_data d-none">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.From date') }}</label>
                            <input required type="datetime-local" name="from_date" id="from_date" class="form-control from_date">
                            <span class="Trip from_date text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.To date') }}</label>
                            <input required type="datetime-local" name="to_date" id="to_date" class="form-control to_date">
                            <span class="Trip to_date text-danger d-none"></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Purchase Price') }}</label>
                            <input type="number" name="purchase_price" id="purchase_price" class="form-control purchase_price">
                            <span class="Trip purchase_price text-danger d-none"></span>
                        </div>
                    </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Price') }}</label>
                            <input required type="number" name="selling_price" id="selling_price" class="form-control selling_price">
                            <span class="Trip selling_price text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <!-- <label> {{ __('messages.Note') }}</label> -->
                            <textarea placeholder="{{ __('messages.Note') }}" name="note" id="note" class="form-control note"></textarea>
                            <span class="Trip note text-danger d-none"></span>
                        </div>
                    </div>
                </div>

                <div id='hotel' class="row service_data d-none">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{ __('messages.Select Hotel') }}</label>
                            <select name="hotel_id" class="Hotel form-control hotel_id">
                                @if ($booking->hotel_id)
                                    <option value="{{ $booking->hotel_id }}" selected>{{ $booking->hotel->name }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Reserve no') }}</label>
                            <input required type="number" name="reserve_no" id="reserve_no" class="form-control reserve_no">
                            <span class="Hotel reserve_no text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Room no') }}</label>
                            <input required type="number" name="room_no" id="room_no" class="form-control room_no">
                            <span class="Hotel room_no text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Room type') }}</label>
                            <select name="room_type" class="form-control room_type" id="room_type" placeholder="{{ __('messages.Select Service') }}">
                                <option value="single">{{ __('messages.single') }}</option>
                                <option value="double">{{ __('messages.double') }}</option>
                                <option value="trible">{{ __('messages.trible') }}</option>
                                <option value="founr" >{{ __('messages.founr') }}</option>
                                <option value="five"  >{{ __('messages.five') }}</option>
                            </select>
                            <span class="Hotel room_type text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.From date') }}</label>
                            <input required type="datetime-local" name="from_date" id="from_date" class="form-control from_date">
                            <span class="Hotel from_date text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.To date') }}</label>
                            <input required type="datetime-local" name="to_date" id="to_date" class="form-control to_date">
                            <span class="Hotel to_date text-danger d-none"></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Purchase Price') }}</label>
                            <input type="number" name="purchase_price" id="purchase_price" class="form-control purchase_price">
                            <span class="Hotel purchase_price text-danger d-none"></span>
                        </div>
                    </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Price') }}</label>
                            <input required type="number" name="selling_price" id="selling_price" class="form-control selling_price">
                            <span class="Hotel selling_price text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Days') }}</label>
                            <input required type="number" name="days" id="days" class="form-control days">
                            <span class="Hotel days text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                            <div class="form-group">
                                <label> {{ __('messages.hotel_stars') }}</label>
                                <input required type="number" name="hotel_stars" id="hotel_stars" class="form-control hotel_stars">
                                <span class="Hotel hotel_stars text-danger d-none"></span>
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-md-4 pt-4">
                            <input type="checkbox" value="1" name="private_pathroom" id="private_pathroom">
                            <label for="private_pathroom" class="px-2"> {{ __('messages.private_pathroom') }}</label>
                        </div>

                    <div class="form-group col-lg-2 col-md-4 pt-4">
                        <input type="checkbox" value="1" name="is_suite" id="is_suite">
                        <label for="is_suite" class="px-2"> {{ __('messages.Is suite') }}</label>
                    </div>
                    <div class="form-group col-lg-2 col-md-4 pt-4">
                        <input type="checkbox" value="1" name="if_breackfast" id="if_breackfast">
                        <label for="if_breackfast" class="px-2"> {{ __('messages.Is breackfast') }}</label>
                    </div>
                    <div class="form-group col-lg-2 col-md-4 pt-4">
                        <input type="checkbox" value="1" name="if_lanuch" id="if_lanuch">
                        <label for="if_lanuch" class="px-2"> {{ __('messages.Is lanuch') }}</label>
                    </div>
                    <div class="form-group col-lg-2 col-md-4 pt-4">
                        <input type="checkbox" value="1" name="if_dinner" id="if_dinner">
                        <label for="if_dinner" class="px-2"> {{ __('messages.Is dinner') }}</label>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <!-- <label> {{ __('messages.Note') }}</label> -->
                            <textarea placeholder="{{ __('messages.Note') }}" name="note" id="note" class="form-control note"></textarea>
                            <span class="Hotel note text-danger d-none"></span>
                        </div>
                    </div>
                </div>

                <div id='ticket' class="row service_data d-none">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Flight no') }}</label>
                            <input name="flight_no" id="flight_no" class="form-control flight_no">
                            <span class="Trip flight_no text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Leave date') }}</label>
                            <input required type="datetime-local" name="from_date" id="from_date" class="form-control from_date">
                            <span class="Trip from_date text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Arrival date') }}</label>
                            <input required type="datetime-local" name="to_date" id="to_date" class="form-control to_date">
                            <span class="Trip to_date text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{ __('messages.Select Airplane') }}</label>
                            <select name="airplane_id" class="form-control airplane_id">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>{{ __('messages.From Country') }}</label>
                        <select name="from_country" class="form-control from_country country_id">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.From City') }}</label>
                            <input name="from_city" id="from_city" class="form-control from_city">
                            <span class="Trip from_city text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>{{ __('messages.To Country') }}</label>
                        <select name="to_country" class="form-control country_id to_country">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.To City') }}</label>
                            <input name="to_city" id="to_city" class="form-control to_city">
                            <span class="Trip to_city text-danger d-none"></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Purchase Price') }}</label>
                            <input type="number" name="purchase_price" id="purchase_price" class="form-control purchase_price">
                            <span class="Trip purchase_price text-danger d-none"></span>
                        </div>
                    </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Price') }}</label>
                            <input required type="number" name="selling_price" id="selling_price" class="form-control selling_price">
                            <span class="Trip selling_price text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{ __('messages.Degree') }}</label>
                            <input name="degree" id="degree" class="form-control degree">
                            <span class="Trip degree text-danger d-none"></span>
                        </div>
                    </div>
                     <!-- transit  -->
                        <div class="col-12 if_transit d-none"><hr></div>

                            <div class="col-md-3">
                                <label> {{ __('messages.Is Transit') }} ?</label>
                                <select name="is_transit" class="form-control is_transit">
                                    <option value="0">{{ __('messages.No') }}</option>
                                    <option value="1">{{ __('messages.Yes') }}</option>
                                </select>
                            </div>

                            <div class="col-12 if_transit d-none">
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
                                    </tbody>
                                </table>
                            </div>

                        <div class="col-12 if_transit bottom d-none"><hr></div>
                     <!-- transit  -->

                    <!-- ticket_type -->
                        <div class="col-12 if_round d-none top"><hr></div>
                        <h5 class='if_round  d-none pl-2'> {{ __('messages.Return Back') }} <hr> </h5>
                        <div class="col-12 if_round d-none"></div>

                        <div class="col-md-3 ">
                            <label id="rout_label"> {{ __('messages.One Way') }} ?</label>
                            <select name="ticket_type" class="form-control ticket_type" >
                                <option value="oneway">{{ __('messages.One Way') }}</option>
                                <option value="round">{{ __('messages.Round') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group  if_round d-none">
                                <label> {{ __('messages.Return flight no') }}</label>
                                <input name="return_flight_no" id="return_flight_no" class="form-control return_flight_no">
                                <span class="Ticket return_flight_no text-danger d-none"></span>
                            </div>
                        </div>

                        <div class="col-md-3 if_round d-none">
                            <div class="form-group">
                                <label> {{ __('messages.Return Leave date') }}</label>
                                <input required type="datetime-local" name="return_from_date" id="return_from_date" class="form-control return_from_date">
                                <span class="Ticket return_from_date text-danger d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-3 if_round d-none">
                            <div class="form-group">
                                <label> {{ __('messages.Return Arrival date') }}</label>
                                <input required type="datetime-local" name="return_to_date" id="return_to_date" class="form-control return_to_date">
                                <span class="Trip return_to_date text-danger d-none"></span>
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
                                    <th><i class="add-new-return-step fa fa-plus text-primary p-2"></i></th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    <!-- ticket_type -->

                    <div class="col-12 if_round d-none"><hr></div>

                    <div class="col-12 pt-3">
                        <div class="form-group">
                            <textarea placeholder="{{ __('messages.Note') }}" name="note" id="note" class="form-control note"></textarea>
                            <span class="Trip note text-danger d-none"></span>
                        </div>
                    </div>
                </div>

            </div>
            <!-- create and select service type start -->
            <div class='col-md-2 col-xs-12 m-0 border-start border-end' style='border-left:1px lightgray solid;'>
                  <label> {{ __('messages.Select Service') }}</label>
                    <select name="service_type" class="form-control" id="service_type" placeholder="{{ __('messages.Select Service') }}">
                        <option value="ticket" @if($defaut_new_service_type == 'ticket') selected @endif>{{ __('messages.Ticket') }}</option>
                        <option value="visa" @if($defaut_new_service_type == 'visa') selected @endif>{{ __('messages.Visa') }}</option>
                        <option value="trip" @if($defaut_new_service_type == 'trip') selected @endif>{{ __('messages.Trip') }}</option>
                        <option value="hotel" @if($defaut_new_service_type == 'hotel') selected @endif>{{ __('messages.Hotel') }}</option>
                        <option value="transport" @if($defaut_new_service_type == 'transport') selected @endif>{{ __('messages.Transport') }}</option>
                    </select>
                    <div class="form-group text-center my-2">
                        <button type="button" id='saveNewService' class="btn btn-primary">{{ __('messages.Create') }} <i class="fa fa-plus fa-md"></i></button>
                    </div>
            </div>
            <!-- create and select service type end -->
       </form>
    </td>

</tr>

@push('js')
<script>
    var transit_index = 0;
    var return_transit_index = 0;
    $(document).ready(function() {
        let default_service_type = "{{$defaut_new_service_type}}";
        $('#newServiceForm .service_data input').attr('disabled','disabled');
        $('#newServiceForm .service_data select').attr('disabled','disabled');
        $('#newServiceForm .service_data textarea').attr('disabled','disabled');
        if(default_service_type){
            $('#'+default_service_type).removeClass('d-none');
            $('#'+default_service_type+' input').removeAttr('disabled','disabled');
            $('#'+default_service_type+' select').removeAttr('disabled','disabled');
            $('#'+default_service_type+' textarea').removeAttr('disabled','disabled');
        }
        $('body').on('change', '#service_type', function () {
            var service_type = $(this).val();
            if(service_type){
                $('.service_data').addClass('d-none');
                $('#newServiceForm .service_data input').attr('disabled','disabled');
                $('#newServiceForm .service_data select').attr('disabled','disabled');
                $('#newServiceForm .service_data textarea').attr('disabled','disabled');
                $('#'+service_type).removeClass('d-none');
                $('#'+service_type+'.service_data input').removeAttr('disabled','disabled');
                $('#'+service_type+'.service_data select').removeAttr('disabled','disabled');
                $('#'+service_type+'.service_data textarea').removeAttr('disabled','disabled');
            }
        });
        $('body').on('change', '.ticket_type', function () {
            let form_id = $(this).closest('form').attr('id');
            let ticket_type = $('#'+form_id+' .ticket_type option:selected').text();
            let if_round = $('#'+form_id+' .ticket_type').val();
            $('#'+form_id+' rout_label').text(ticket_type + ' ?');
            if(if_round == 'round'){
                $('.if_round').removeClass('d-none');
                if($('#'+form_id+' .is_transit').val() == '1'){
                    $('#'+form_id+' .if_transit.bottom').addClass('d-none');
                    $('#'+form_id+' .if_round_transit').removeClass('d-none');
                }else{
                    $('#'+form_id+' .if_round_transit').addClass('d-none');
                }
            }else{
                $('#'+form_id+' .if_round').addClass('d-none');
            }
        });
        $('body').on('change', '.is_transit', function () {
            let form_id = $(this).closest('form').attr('id');
            let if_transit = $('#'+form_id+' .is_transit').val();
            if(if_transit == '1'){
                $('#'+form_id+' .if_transit').removeClass('d-none');
                if($('#'+form_id+' .ticket_type').val() == 'round'){
                    $('#'+form_id+' .if_transit.bottom').addClass('d-none');
                    $('#'+form_id+' .if_round_transit').removeClass('d-none');
                }else{
                    $('#'+form_id+' .if_round_transit').addClass('d-none');
                }
            }else{
                $('#'+form_id+' .if_round_transit').addClass('d-none');
                $('#'+form_id+' .if_transit').addClass('d-none');
            }
            $('#'+form_id+' .ticket_type').addClass('mb-3');
        });
        $('body').on('click', '.delete-new-step,.delete-transit-step', function () {
            let table_id = $(this).closest('table').attr('id');
            $(this).closest('tr').remove();
        });
        $('body').on('click', 'table .add-new-step', function () {
            let table_id = $(this).closest('table').attr('id');
            transit_index++;
            $('#'+table_id+' tbody').prepend(
                `<tr class='transit-step-example'>
                    <td class='col-2 p-1'>
                        <select name='transit[${transit_index}][transit_country_id]' class='form-control transit_country_id'></select>
                    </td>
                    <td class='col-2 p-1'>
                        <input name='transit[${transit_index}][transit_airport]' class='form-control transit_airport'>
                    </td>
                    <td class='col-2 p-1'>
                        <input name='transit[${transit_index}][transit_city]' class='form-control transit_city'>
                    </td>
                    <td class='col-2 p-1'>
                        <input required type='datetime-local' name='transit[${transit_index}][transit_from_date]' class='form-control transit_from_date'>
                    </td>
                    <td class='col-2 p-1'>
                        <input required type='datetime-local' name='transit[${transit_index}][transit_to_date]' class='form-control transit_to_date'>
                    </td>
                    <td><i class='delete-new-step fa fa-trash text-danger p-2'></i></td>
                </tr>`);

            country_id_select('transit_country_id');
        });
        $('body').on('click', 'table .add-new-return-step', function () {
            let table_id = $(this).closest('table').attr('id');
            return_transit_index++;
            $('#'+table_id+' tbody').prepend(
                `<tr class='transit-step-example'>
                    <td class='col-2 p-1'>
                        <select name='return_transit[${return_transit_index}][transit_country_id]' class='form-control transit_country_id'></select>
                    </td>
                    <td class='col-2 p-1'>
                        <input name='return_transit[${return_transit_index}][transit_airport]' class='form-control transit_airport'>
                    </td>
                    <td class='col-2 p-1'>
                        <input name='return_transit[${return_transit_index}][transit_city]' class='form-control transit_city'>
                    </td>
                    <td class='col-2 p-1'>
                        <input required type='datetime-local' name='return_transit[${return_transit_index}][transit_from_date]' class='form-control transit_from_date'>
                    </td>
                    <td class='col-2 p-1'>
                        <input required type='datetime-local' name='return_transit[${return_transit_index}][transit_to_date]' class='form-control transit_to_date'>
                    </td>
                    <td><i class='delete-new-step fa fa-trash text-danger p-2'></i></td>
                </tr>`);

            country_id_select('transit_country_id');
        });
        $('#saveNewService').on('click',   function () {
            var formData = new FormData($('#newServiceForm')[0]);
            var url      = $('#newServiceForm').attr('action');
            $(this).attr('disabled','disabled');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                     $('#saveNewService').removeAttr('disabled');
                    $('.table.alert.alert-danger').addClass('d-none');
                    if (response.success) {
                        $('#crudTable > tbody  > tr:not(#create_services)').remove();
                        $('tr#create_services').after(response.servicesHtml);
                        alert("{{ __('messages.Service Created Successfully') }}");
                    } else {
                        alert("{{ __('messages.Error Creating Service') }}");
                    }
                },
                error: function(xhr) {
                     $('#saveNewService').removeAttr('disabled');
                    if(xhr.responseJSON && xhr.responseJSON.message){
                        $('.table.alert.alert-danger').removeClass('d-none');
                        $('.table.alert.alert-danger').text(xhr.responseJSON.message);
                    }
                }
            });
        });
    });
</script>

<!-- select 2 -->
<script>
    // country_id 
    $(document).ready(function() {
        country_id_select();
        hotel_id_select();
        airplane_id_select();
    });
    function country_id_select(country_id = 'country_id') {
        $('body '+'.'+country_id).select2({
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
    }
    // hotel_id 
    function hotel_id_select() {
        $('body .hotel_id').select2({
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
    }
    // airplane_id 
    function airplane_id_select() {
        $('body .airplane_id').select2({
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
    }
</script>
@endpush