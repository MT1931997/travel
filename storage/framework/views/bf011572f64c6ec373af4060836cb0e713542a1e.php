<?php if($booking->hotels && $booking->hotels->count()): ?>
<?php $booking_hotels = $booking->hotels->reverse(); ?>
<?php $__currentLoopData = $booking_hotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr id='service<?php echo e($hotel->id); ?>hotel'>
    <td class='p-0'>
        <form id='editServiceHotel<?php echo e($hotel->id); ?>' class='editServiceForm row p-0 m-0'
            action="<?php echo e(route('bookings.edit.service',['id'=>$hotel->id,'service_type'=>'hotel','booking_id'=>$booking->id])); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class='col-md-10 col-xs-12 m-0' id='hotels' class="row edit_servive_data">
                <div class="row p-0 m-0">
                    <div id='hotel' class="row service_data">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo e(__('messages.Select Hotel')); ?></label>
                                <select name="hotel_id" class="Hotel form-control hotel_id">
                                    <?php if($hotel->hotel_id): ?>
                                        <option value="<?php echo e($hotel->hotel_id); ?>" selected><?php echo e($hotel->hotel->name); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.Reserve no')); ?></label>
                                <input required type="number" value="<?php echo e($hotel->reserve_no); ?>" name="reserve_no" id="reserve_no<?php echo e($hotel->hotel_id); ?>" class="form-control reserve_no">
                                <span class="Hotel reserve_no text-danger d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.Room no')); ?></label>
                                <input required type="number" value="<?php echo e($hotel->room_no); ?>" name="room_no" id="room_no<?php echo e($hotel->hotel_id); ?>" class="form-control room_no">
                                <span class="Hotel room_no text-danger d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.Room type')); ?></label>
                                <select name="room_type" class="form-control room_type" id="room_type<?php echo e($hotel->hotel_id); ?>" placeholder="<?php echo e(__('messages.Select Service')); ?>">
                                    <option value="single" <?php if($hotel->room_type=='single'): ?> selected <?php endif; ?>><?php echo e(__('messages.single')); ?></option>
                                    <option value="double" <?php if($hotel->room_type=='double'): ?> selected <?php endif; ?>><?php echo e(__('messages.double')); ?></option>
                                    <option value="trible" <?php if($hotel->room_type=='trible'): ?> selected <?php endif; ?>><?php echo e(__('messages.trible')); ?></option>
                                    <option value="founr"  <?php if($hotel->room_type=='founr'): ?>  selected <?php endif; ?>><?php echo e(__('messages.founr')); ?></option>
                                    <option value="five"   <?php if($hotel->room_type=='five'): ?>   selected <?php endif; ?>><?php echo e(__('messages.five')); ?></option>
                                </select>
                                <span class="Hotel room_type text-danger d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.From date')); ?></label>
                                <input required type="datetime-local" value="<?php echo e($hotel->from_date); ?>" name="from_date" id="from_date<?php echo e($hotel->hotel_id); ?>" class="form-control from_date">
                                <span class="Hotel from_date text-danger d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.To date')); ?></label>
                                <input required type="datetime-local" value="<?php echo e($hotel->to_date); ?>" name="to_date" id="to_date<?php echo e($hotel->hotel_id); ?>" class="form-control to_date">
                                <span class="Hotel to_date text-danger d-none"></span>
                            </div>
                        </div>
                        <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.Purchase Price')); ?></label>
                            <input type="number" name="purchase_price" id="purchase_price<?php echo e($hotel->hotel_id); ?>" class="form-control purchase_price">
                            <span class="Hotel purchase_price text-danger d-none"></span>
                        </div>
                    </div> -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.Price')); ?></label>
                                <input required type="number" value="<?php echo e($hotel->selling_price); ?>" name="selling_price" id="selling_price<?php echo e($hotel->hotel_id); ?>" class="form-control selling_price">
                                <span class="Hotel selling_price text-danger d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.Days')); ?></label>
                                <input required type="number" value="<?php echo e($hotel->days); ?>" name="days" id="days<?php echo e($hotel->hotel_id); ?>" class="form-control days">
                                <span class="Hotel days text-danger d-none"></span>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.hotel_stars')); ?></label>
                                <input required type="number" value="<?php echo e($hotel->hotel_stars); ?>" name="hotel_stars" id="hotel_stars<?php echo e($hotel->hotel_id); ?>" class="form-control hotel_stars">
                                <span class="Hotel hotel_stars text-danger d-none"></span>
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-md-4 pt-4">
                            <input type="checkbox" value="1" <?php if($hotel->private_pathroom): ?> checked <?php endif; ?> name="private_pathroom" id="private_pathroom<?php echo e($hotel->hotel_id); ?>">
                            <label for="private_pathroom<?php echo e($hotel->hotel_id); ?>" class="px-2"> <?php echo e(__('messages.private_pathroom')); ?></label>
                        </div>

                        <div class="form-group col-lg-2 col-md-4 pt-4">
                            <input type="checkbox" value="1" <?php if($hotel->is_suite): ?> checked <?php endif; ?> name="is_suite" id="is_suite<?php echo e($hotel->hotel_id); ?>">
                            <label for="is_suite<?php echo e($hotel->hotel_id); ?>" class="px-2"> <?php echo e(__('messages.Is suite')); ?></label>
                        </div>
                        <div class="form-group col-lg-2 col-md-4 pt-4">
                            <input type="checkbox" value="1" <?php if($hotel->if_breackfast): ?> checked <?php endif; ?> name="if_breackfast" id="if_breackfast<?php echo e($hotel->hotel_id); ?>">
                            <label for="if_breackfast<?php echo e($hotel->hotel_id); ?>" class="px-2"> <?php echo e(__('messages.Is breackfast')); ?></label>
                        </div>
                        <div class="form-group col-lg-2 col-md-4 pt-4">
                            <input type="checkbox" value="1" <?php if($hotel->if_lanuch): ?> checked <?php endif; ?> name="if_lanuch" id="if_lanuch<?php echo e($hotel->hotel_id); ?>">
                            <label for="if_lanuch<?php echo e($hotel->hotel_id); ?>" class="px-2"> <?php echo e(__('messages.Is lanuch')); ?></label>
                        </div>
                        <div class="form-group col-lg-2 col-md-4 pt-4">
                            <input type="checkbox" value="1" <?php if($hotel->if_dinner): ?> checked <?php endif; ?> name="if_dinner" id="if_dinner<?php echo e($hotel->hotel_id); ?>">
                            <label for="if_dinner<?php echo e($hotel->hotel_id); ?>" class="px-2"> <?php echo e(__('messages.Is dinner')); ?></label>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <!-- <label> <?php echo e(__('messages.Note')); ?></label> -->
                                <textarea placeholder="<?php echo e(__('messages.Note')); ?>" name="note" id="note<?php echo e($hotel->hotel_id); ?>" class="form-control note">
                                    <?php echo e($hotel->note); ?>

                                </textarea>
                                <span class="Hotel note text-danger d-none"></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class='col-md-2 col-xs-12 m-0 border-start border-end' style='border-left:1px lightgray solid;'>
                <h5 class="text-center pt-2"> <?php echo e(__('messages.Edit Hotel')); ?></h5>
                <div class="d-flex justify-content-center">
                    <div class="form-group text-center m-2">
                        <button data-id='editServiceHotel<?php echo e($hotel->id); ?>' title="<?php echo e(__('messages.Edit')); ?>" type="button" class="btn btn-primary editServiceButton"><i class="fa fa-edit fa-md"></i></button>
                    </div>
                    <div class="form-group text-center m-2">
                        <button data-service_type='hotel' data-id='<?php echo e($hotel->id); ?>' title="<?php echo e(__('messages.Delete')); ?>" type="button" class="btn btn-danger deleteServiceButton"><i class="fa fa-trash fa-md"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if($booking->tickets && $booking->tickets->count()): ?>
<?php $tickets = $booking->tickets->reverse(); ?>
<?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr id='service<?php echo e($ticket->id); ?>ticket'>
    <td class='p-0'>
        <form id='editServiceTicket<?php echo e($ticket->id); ?>' class='editServiceForm row p-0 m-0'
            action="<?php echo e(route('bookings.edit.service',['id'=>$ticket->id,'service_type'=>'ticket','booking_id'=>$booking->id])); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class='col-md-10 col-xs-12 m-0' id='ticket' class="row edit_servive_data">
                <div class="row p-0 m-0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.Flight no')); ?></label>
                            <input value="<?php echo e($ticket->flight_no); ?>" name="flight_no" id="flight_no" class="form-control flight_no">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.Leave date')); ?></label>
                            <input required type="datetime-local" value="<?php echo e($ticket->from_date); ?>" name="from_date" id="from_date" class="form-control from_date">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.Arrival date')); ?></label>
                            <input required type="datetime-local" value="<?php echo e($ticket->to_date); ?>" name="to_date" id="to_date" class="form-control to_date">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?php echo e(__('messages.Select Airplane')); ?></label>
                            <select name="airplane_id" class="form-control airplane_id">
                                <?php if($ticket->airplane_id): ?>
                                <option value="<?php echo e($ticket->airplane_id); ?>" selected><?php echo e($ticket->airplane->name); ?>

                                </option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label><?php echo e(__('messages.From Country')); ?></label>
                        <select value="<?php echo e($ticket->from_country); ?>" name="from_country" class="form-control from_country country_id">
                            <?php if($ticket->from_country): ?>
                            <option value="<?php echo e($ticket->from_country); ?>" selected><?php echo e($ticket->get_country($ticket->from_country)?->name); ?>

                            </option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.From City')); ?></label>
                            <input value="<?php echo e($ticket->from_city); ?>" name="from_city" id="from_city" class="form-control from_city">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label><?php echo e(__('messages.To Country')); ?></label>
                        <select value="<?php echo e($ticket->to_country); ?>" name="to_country" class="form-control country_id to_country">
                            <?php if($ticket->to_country): ?>
                            <option value="<?php echo e($ticket->to_country); ?>" selected><?php echo e($ticket->get_country($ticket->to_country)?->name); ?>

                            </option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.To City')); ?></label>
                            <input value="<?php echo e($ticket->to_city); ?>" name="to_city" id="to_city" class="form-control to_city">
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <label> <?php echo e(__('messages.Purchase Price')); ?></label>
                                    <input type="number" value="<?php echo e($ticket->purchase_price); ?>" name="purchase_price" id="purchase_price" class="form-control purchase_price">
                                </div>
                            </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.Price')); ?></label>
                            <input required type="number" value="<?php echo e($ticket->selling_price); ?>" name="selling_price" class="form-control selling_price">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.Degree')); ?></label>
                            <input value="<?php echo e($ticket->degree); ?>" name="degree" id="degree" class="form-control degree">
                        </div>
                    </div>
                    <!-- transit  -->
                    <div class="col-12 if_transit <?php if($ticket->is_transit == '0'): ?> d-none <?php endif; ?>">
                        <hr>
                    </div>

                    <div class="col-md-3">
                        <label> <?php echo e(__('messages.Is Transit')); ?> ?</label>
                        <select value="<?php echo e($ticket->is_transit); ?>" name="is_transit" class="form-control is_transit">
                            <option value="0" <?php if($ticket->is_transit == '0'): ?> selected <?php endif; ?>><?php echo e(__('messages.No')); ?></option>
                            <option value="1" <?php if($ticket->is_transit == '1'): ?> selected <?php endif; ?>><?php echo e(__('messages.Yes')); ?></option>
                        </select>
                    </div>

                    <div class="col-12 if_transit <?php if($ticket->is_transit == '0'): ?> d-none <?php endif; ?>">
                        <h5 class='pt-2'><?php echo e(__('messages.Transit steps')); ?></h5>
                        <table class='table table-bordered table-hover disabled bg-white' id='addNewTransitStep<?php echo e($ticket->id); ?>'>
                            <thead>
                                <th><?php echo e(__('messages.Country')); ?></th>
                                <th><?php echo e(__('messages.City')); ?></th>
                                <th><?php echo e(__('messages.Airport')); ?></th>
                                <th><?php echo e(__('messages.Arrival date')); ?></th>
                                <th><?php echo e(__('messages.Leave date')); ?></th>
                                <th><i class="add-new-step fa fa-plus text-primary p-2"></i></th>
                            </thead>
                            <tbody>
                                <?php if($ticket->go_transit_steps && $ticket->go_transit_steps->count()): ?>
                                <?php $go_transit_steps = $ticket->go_transit_steps->reverse(); ?>
                                <?php $__currentLoopData = $go_transit_steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class='transit-step-example'>
                                    <td class='col-2 p-1'>
                                        <select name='transit[old_<?php echo e($step->id); ?>][transit_country_id]' class='form-control transit_country_id'>
                                            <?php if($step->transit_country_id): ?>
                                            <option value="<?php echo e($step->transit_country_id); ?>"><?php echo e($step->get_country($step->transit_country_id)?->name); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="<?php echo e($step->transit_airport); ?>" name='transit[old_<?php echo e($step->id); ?>][transit_airport]' class='form-control transit_airport'>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="<?php echo e($step->transit_city); ?>" name='transit[old_<?php echo e($step->id); ?>][transit_city]' class='form-control transit_city'>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="<?php echo e($step->transit_from_date); ?>" type='datetime-local' name='transit[old_<?php echo e($step->id); ?>][transit_from_date]' class='form-control transit_from_date'>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="<?php echo e($step->transit_to_date); ?>" type='datetime-local' name='transit[old_<?php echo e($step->id); ?>][transit_to_date]' class='form-control transit_to_date'>
                                    </td>
                                    <td>
                                        <i class='delete-transit-step fa fa-trash text-danger p-2'></i>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 if_transit <?php if($ticket->is_transit == '0'): ?> d-none <?php endif; ?> bottom">
                        <hr>
                    </div>
                    <!-- transit  -->

                    <!-- ticket_type -->
                    <div class="col-12 if_round <?php if($ticket->ticket_type == 'round'): ?> d-none <?php endif; ?> top">
                        <hr>
                    </div>
                    <h5 class='if_round  d-none pl-2'> <?php echo e(__('messages.Return Back')); ?>

                        <hr>
                    </h5>
                    <div class="col-12 if_round <?php if($ticket->ticket_type == 'oneway'): ?> d-none <?php endif; ?>"></div>

                    <div class="col-md-3 ">
                        <label id="rout_label"> <?php if($ticket->ticket_type == 'oneway'): ?> <?php echo e(__('messages.One Way')); ?> <?php else: ?> <?php echo e(__('messages.Round')); ?> <?php endif; ?> ?</label>
                        <select name="ticket_type" class="form-control ticket_type">
                            <option value="oneway" <?php if($ticket->ticket_type == 'oneway'): ?> selected <?php endif; ?> ><?php echo e(__('messages.One Way')); ?></option>
                            <option value="round" <?php if($ticket->ticket_type == 'round'): ?> selected <?php endif; ?> ><?php echo e(__('messages.Round')); ?></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group  if_round <?php if($ticket->ticket_type == 'oneway'): ?> d-none <?php endif; ?>">
                            <label> <?php echo e(__('messages.Return flight no')); ?></label>
                            <input value="<?php echo e($ticket->return_flight_no); ?>" name="return_flight_no" id="return_flight_no" class="form-control return_flight_no">
                        </div>
                    </div>

                    <div class="col-md-3 if_round <?php if($ticket->ticket_type == 'oneway'): ?> d-none <?php endif; ?>">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.Return Leave date')); ?></label>
                            <input required type="datetime-local" value="<?php echo e($ticket->return_from_date); ?>" name="return_from_date" id="return_from_date" class="form-control return_from_date">
                        </div>
                    </div>
                    <div class="col-md-3 if_round <?php if($ticket->ticket_type == 'oneway'): ?> d-none <?php endif; ?>">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.Return Arrival date')); ?></label>
                            <input required type="datetime-local" value="<?php echo e($ticket->return_to_date); ?>" name="return_to_date" id="return_to_date" class="form-control return_to_date">
                        </div>
                    </div>

                    <div class="col-12 if_round if_round_transit <?php if($ticket->is_transit == '0' || $ticket->ticket_type == 'oneway'): ?> d-none <?php endif; ?>">
                        <h5 class='pt-2'><?php echo e(__('messages.Return steps')); ?></h5>
                        <table class='table table-bordered table-hover disabled bg-white' id='addNewReturnTransitStep<?php echo e($ticket->id); ?>'>
                            <thead>
                                <th><?php echo e(__('messages.Country')); ?></th>
                                <th><?php echo e(__('messages.City')); ?></th>
                                <th><?php echo e(__('messages.Airport')); ?></th>
                                <th><?php echo e(__('messages.Arrival date')); ?></th>
                                <th><?php echo e(__('messages.Leave date')); ?></th>
                                <th><i class="add-new-return-step fa fa-plus text-primary"></i></th>
                            </thead>
                            <tbody>
                                <?php if($ticket->return_transit_steps && $ticket->return_transit_steps->count()): ?>
                                <?php $return_transit_steps = $ticket->return_transit_steps->reverse(); ?>
                                <?php $__currentLoopData = $return_transit_steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class='transit-step-example'>
                                    <td class='col-2 p-1'>
                                        <select name='return_transit[old_<?php echo e($step->id); ?>][transit_country_id]' class='form-control transit_country_id'>
                                            <?php if($step->transit_country_id): ?>
                                            <option value="<?php echo e($step->transit_country_id); ?>"><?php echo e($step->get_country($step->transit_country_id)?->name); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="<?php echo e($step->transit_airport); ?>" name='return_transit[old_<?php echo e($step->id); ?>][transit_airport]' class='form-control transit_airport'>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="<?php echo e($step->transit_city); ?>" name='return_transit[old_<?php echo e($step->id); ?>][transit_city]' class='form-control transit_city'>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="<?php echo e($step->transit_from_date); ?>" type='datetime-local' name='return_transit[old_<?php echo e($step->id); ?>][transit_from_date]' class='form-control transit_from_date'>
                                    </td>
                                    <td class='col-2 p-1'>
                                        <input value="<?php echo e($step->transit_to_date); ?>" type='datetime-local' name='return_transit[old_<?php echo e($step->id); ?>][transit_to_date]' class='form-control transit_to_date'>
                                    </td>
                                    <td>
                                        <i class='delete-transit-step fa fa-trash text-danger p-2'></i>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- ticket_type -->

                    <div class="col-12 if_round <?php if($ticket->ticket_type == 'oneway'): ?> d-none <?php endif; ?>">
                        <hr>
                    </div>

                    <div class="col-12 pt-3">
                        <div class="form-group">
                            <textarea placeholder="<?php echo e(__('messages.Note')); ?>" value="<?php echo e($ticket->note); ?>" name="note" id="note" class="form-control note"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-2 col-xs-12 m-0 border-start border-end' style='border-left:1px lightgray solid;'>
                <h5 class="text-center pt-2"> <?php echo e(__('messages.Edit Ticket')); ?></h5>
                <div class="d-flex justify-content-center">
                    <div class="form-group text-center m-2">
                        <button data-id='editServiceTicket<?php echo e($ticket->id); ?>' title="<?php echo e(__('messages.Edit')); ?>" type="button" class="btn btn-primary editServiceButton"><i class="fa fa-edit fa-md"></i></button>
                    </div>
                    <div class="form-group text-center m-2">
                        <button data-service_type='ticket' data-id='<?php echo e($ticket->id); ?>' title="<?php echo e(__('messages.Delete')); ?>" type="button" class="btn btn-danger deleteServiceButton"><i class="fa fa-trash fa-md"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if($booking->trips && $booking->trips->count()): ?>
<?php $trips = $booking->trips->reverse(); ?>
<?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr id='service<?php echo e($trip->id); ?>trip'>
    <td class='p-0'>
        <form id='editServiceTrip<?php echo e($trip->id); ?>' class='editServiceForm row p-0 m-0'
            action="<?php echo e(route('bookings.edit.service',['id'=>$trip->id,'service_type'=>'trip','booking_id'=>$booking->id])); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class='col-md-10 col-xs-12 m-0' id='trip' class="row edit_servive_data">
                <div class="row p-0 m-0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.From date')); ?></label>
                            <input required value="<?php echo e($trip->from_date); ?>" type="datetime-local" name="from_date" id="edit_from_date" class="form-control from_date">
                            <span class="Trip from_date text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.To date')); ?></label>
                            <input required value="<?php echo e($trip->to_date); ?>" type="datetime-local" name="to_date" id="edit_to_date" class="form-control to_date">
                            <span class="Trip to_date text-danger d-none"></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.Purchase Price')); ?></label>
                                <input  value="<?php echo e($trip->purchase_price); ?>" type="number" name="purchase_price" id="edit_purchase_price" class="form-control purchase_price">
                                <span class="Trip purchase_price text-danger d-none"></span>
                            </div>
                        </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.Price')); ?></label>
                            <input required value="<?php echo e($trip->selling_price); ?>" type="number" name="selling_price" class="form-control selling_price">
                            <span class="Trip selling_price text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <textarea placeholder="<?php echo e(__('messages.Note')); ?>" name="note" id="edit_note" class="form-control note"><?php echo e($trip->note); ?></textarea>
                            <span class="Trip note text-danger d-none"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-2 col-xs-12 m-0 border-start border-end' style='border-left:1px lightgray solid;'>
                <h5 class="text-center pt-2"> <?php echo e(__('messages.Edit Trip')); ?></h5>
                <div class="d-flex justify-content-center">
                    <div class="form-group text-center m-2">
                        <button data-id='editServiceTrip<?php echo e($trip->id); ?>' title="<?php echo e(__('messages.Edit')); ?>" type="button" class="btn btn-primary editServiceButton"><i class="fa fa-edit fa-md"></i></button>
                    </div>
                    <div class="form-group text-center m-2">
                        <button data-service_type='trip' data-id='<?php echo e($trip->id); ?>' title="<?php echo e(__('messages.Delete')); ?>" type="button" class="btn btn-danger deleteServiceButton"><i class="fa fa-trash fa-md"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if($booking->visas && $booking->visas->count()): ?>
<?php $visas = $booking->visas->reverse(); ?>
<?php $__currentLoopData = $visas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr id='service<?php echo e($visa->id); ?>visa'>
    <td class='p-0'>
        <form id='editServiceVisa<?php echo e($visa->id); ?>' class='editServiceForm row p-0 m-0'
            action="<?php echo e(route('bookings.edit.service',['id'=>$visa->id,'service_type'=>'visa','booking_id'=>$booking->id])); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class='col-md-10 col-xs-12 m-0' id='visa' class="row edit_servive_data">
                <div class="row p-0 m-0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.From date')); ?></label>
                            <input required value="<?php echo e($visa->from_date); ?>" type="datetime-local" name="from_date" id="edit_from_date" class="form-control from_date">
                            <span class="Visa from_date text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.To date')); ?></label>
                            <input required value="<?php echo e($visa->to_date); ?>" type="datetime-local" name="to_date" id="edit_to_date" class="form-control to_date">
                            <span class="Visa to_date text-danger d-none"></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.Purchase Price')); ?></label>
                                <input  value="<?php echo e($visa->purchase_price); ?>" type="number" name="purchase_price" id="edit_purchase_price" class="form-control purchase_price">
                                <span class="Visa purchase_price text-danger d-none"></span>
                            </div>
                        </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.Price')); ?></label>
                            <input required value="<?php echo e($visa->selling_price); ?>" type="number" name="selling_price" id="edit_selling_price" class="form-control selling_price">
                            <span class="Visa selling_price text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <textarea placeholder="<?php echo e(__('messages.Note')); ?>" name="note" id="edit_note" class="form-control note"><?php echo e($visa->note); ?></textarea>
                            <span class="Visa note text-danger d-none"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-2 col-xs-12 m-0 border-start border-end' style='border-left:1px lightgray solid;'>
                <h5 class="text-center pt-2"> <?php echo e(__('messages.Edit Visa')); ?></h5>
                <div class="d-flex justify-content-center">
                    <div class="form-group text-center m-2">
                        <button data-id='editServiceVisa<?php echo e($visa->id); ?>' title="<?php echo e(__('messages.Edit')); ?>" type="button" class="btn btn-primary editServiceButton"><i class="fa fa-edit fa-md"></i></button>
                    </div>
                    <div class="form-group text-center m-2">
                        <button data-service_type='visa' data-id='<?php echo e($visa->id); ?>' title="<?php echo e(__('messages.Delete')); ?>" type="button" class="btn btn-danger deleteServiceButton"><i class="fa fa-trash fa-md"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if($booking->transports && $booking->transports->count()): ?>
<?php $transports = $booking->transports->reverse(); ?>
<?php $__currentLoopData = $transports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr id='service<?php echo e($transport->id); ?>transport'>
    <td class='p-0'>
        <form id='editServiceTransport<?php echo e($transport->id); ?>' class='editServiceForm row p-0 m-0'
            action="<?php echo e(route('bookings.edit.service',['id'=>$transport->id,'service_type'=>'transport','booking_id'=>$booking->id])); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class='col-md-10 col-xs-12 m-0' class="row edit_servive_data">
                <div class="row p-0 m-0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.From date')); ?></label>
                            <input required value="<?php echo e($transport->from_date); ?>" type="datetime-local" name="from_date" id="edit_from_date" class="form-control from_date">
                            <span class="Transport from_date text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.To date')); ?></label>
                            <input required value="<?php echo e($transport->to_date); ?>" type="datetime-local" name="to_date" id="edit_to_date" class="form-control to_date">
                            <span class="Transport to_date text-danger d-none"></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                            <div class="form-group">
                                <label> <?php echo e(__('messages.Purchase Price')); ?></label>
                                <input  value="<?php echo e($transport->purchase_price); ?>" type="number" name="purchase_price" id="edit_purchase_price" class="form-control purchase_price">
                                <span class="Transport purchase_price text-danger d-none"></span>
                            </div>
                        </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> <?php echo e(__('messages.Price')); ?></label>
                            <input required value="<?php echo e($transport->selling_price); ?>" type="number" name="selling_price" id="edit_selling_price" class="form-control selling_price">
                            <span class="Transport selling_price text-danger d-none"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <textarea placeholder="<?php echo e(__('messages.Note')); ?>" name="note" id="edit_note" class="form-control note"><?php echo e($transport->note); ?></textarea>
                            <span class="Transport note text-danger d-none"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-2 col-xs-12 m-0 border-start border-end' style='border-left:1px lightgray solid;'>
                <h5 class="text-center pt-2"> <?php echo e(__('messages.Edit Transport')); ?></h5>
                <div class="d-flex justify-content-center">
                    <div class="form-group text-center m-2">
                        <button data-id='editServiceTransport<?php echo e($transport->id); ?>' title="<?php echo e(__('messages.Edit')); ?>" type="button" class="btn btn-primary editServiceButton"><i class="fa fa-edit fa-md"></i></button>
                    </div>
                    <div class="form-group text-center m-2">
                        <button data-service_type='transport' data-id='<?php echo e($transport->id); ?>' title="<?php echo e(__('messages.Delete')); ?>" type="button" class="btn btn-danger deleteServiceButton"><i class="fa fa-trash fa-md"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php $__env->startPush('js'); ?>
<script>
    $(document).ready(function() {

        var booking_status = "<?php echo e($booking->status); ?>";
        var booking_id     = "<?php echo e($booking->id); ?>";
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
                        alert("<?php echo e(__('messages.Service Edited Successfully')); ?>");
                    } else {
                        alert("<?php echo e(__('messages.Error Editing Service')); ?>");
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
            if (confirm("<?php echo e(__('messages.Are You Sure')); ?>")) {
                $.ajax({
                    url: "<?php echo e(route('bookings.delete.service')); ?>",
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
                            alert("<?php echo e(__('messages.Service Deleted Successfully')); ?>");
                            let total_price = 0;
                            $('.service_data:not(.d-none) input.selling_price , .editServiceForm input.selling_price').each(function() {
                                if(this.value){
                                    total_price += parseInt(this.value);
                                    $('#total_price').val(total_price);
                                }
                            });
                        } else {
                            alert("<?php echo e(__('messages.Error Deleting Service')); ?>");
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
<?php $__env->stopPush(); ?><?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/admin/bookings/edit_services.blade.php ENDPATH**/ ?>