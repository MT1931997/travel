<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingUser;
use App\Models\BookingTrip;
use App\Models\BookingVisa;
use App\Models\BookingTransport;
use App\Models\BookingTicket;
use App\Models\BookingHotel;
use App\Models\Country;
use App\Models\User;
use App\Models\Airplane;
use App\Models\BookingDocument;
use App\Models\Hotel;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $bookings = Booking::with(['hotel','country', 'user', 'airplane'])->orderBy('id','desc')->paginate(PAGINATION_COUNT); // Paginate the results
        return view('admin.bookings.index', compact('bookings'));
    }

    public function storeUser(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|unique:users,phone',
            'date_of_birth' => 'nullable|date|before:today',
            'address' => 'nullable|string',
            'photo_of_passport' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_passport_end' => 'nullable|date',
            'activate' => 'required|in:1,2',
            'person_or_company' => 'required|in:1,2',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return response()->json(array(
                'success' => false,
                'errors' =>  implode("\n", $validator->errors()->all()),
            ), 200);
        }
        $user = new User();
        $user->fill($validator->validated());
        // Assign or create a family_id

        if ($request->has('family_id') && count($request->get('family_id')) > 0) {
            // If brothers are selected, use the family_id of the first selected brother
            $existingFamilyId = User::find($request->get('family_id')[0])?->family_id;
            $user->family_id = $existingFamilyId ? $existingFamilyId : User::max('family_id') + 1;
        } else {
            // No brothers selected; create a new family_id
            $user->family_id = User::max('family_id') + 1;
        }

        if ($request->has('photo_of_passport')) {
            $the_file_path = uploadImage('assets/admin/uploads', $request->photo_of_passport);
            $user->photo_of_passport = $the_file_path;
        }
        $user->save();

        // Save companies for the user
        if ($request->person_or_company  && $request->person_or_company == 2 && $request->has('company') && is_array($request->get('company'))) {
            $companies = $request->get('company');
            foreach ($companies as $companyId) {
                    \DB::table('user_companies')->insert([
                        'user_id' => $user->id,
                        'company_id' => $companyId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            }
        }

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bookings,id',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $booking = Booking::findOrFail($request->id);

        if ($request->status === 'completed' && !$booking->user_can_completed()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot mark as .'.$request->status.'.',
            ], 400);
        }elseif($request->status === 'pending' && !$booking->user_can_retuen_to_pending()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot mark as .'.$request->status.'.',
            ], 400);
        }elseif ($request->status === 'cancelled' && !$booking->user_can_cancel()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot mark as .'.$request->status.'.',
            ], 400);

        }

        // Check if the status is being changed to 'completed'
        if ($request->status === 'completed') {
            $users = $booking->booking_users; // Assuming there is a relationship defined in the Booking model to fetch the associated user
            $errorMsg = '';
            foreach ($users as $user) {
                if (!$user || is_null($user->photo_of_passport)) {
                    $errorMsg .= ($errorMsg . ' , ' . $user->name);
                }
            }
            if($errorMsg ){
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot mark as completed. The users ( '. $errorMsg .' ) photo of passport is missing.',
                ], 400);
            }
        }

        $booking->status = $request->status;
        $booking->save();

        return response()->json(['success' => true]);
    }

    public function getUserFamily(Request $request)
    {
        $user_id   = $request->get('user_id');
        $family_id = User::where('id', $user_id)->first()?->family_id;
        $query     = User::query();
        $query     = $query->where('family_id', $family_id)->where('id','!=',$user_id);
        $brothers  = $query->get(['id', 'name', 'phone', 'family_id']);
        if($booking_id = $request->booking_id){
            foreach ($brothers as $key => $brother) {
                $brother->checked = BookingUser::where('user_id',$brother->id)->where('booking_id',$booking_id)->first() ? 'checked' : '';
            }
        }
        return response()->json($brothers ?? []);
    }

    /**
     * Show the form for creating a new resource.
    */
    public function createOrEdit(Booking $booking)
    {
        $booking_id = 1;
        $countries  = Country::all();
        $hotels     = Hotel::all();
        $users      = User::all();
        $airplanes  = Airplane::all();
        $defaut_new_service_type  = 'hotel';
        if(!$booking->id){
            $booking = new Booking();
        }else{
            if(!$booking->user_can_edit())abort(403);
        }
        return view('admin.bookings.create-or-edit', compact('countries', 'users', 'airplanes','hotels','booking','defaut_new_service_type'));
    }

    public function save(Request $request ,Booking $booking = null)
    {
        $request->validate([
            'user'                  => 'required|exists:users,id',
            'total_purchase_price'  => 'nullable|numeric|max:9999999|min:.1',
            'total_selling_price'   => 'nullable|numeric|max:9999999|min:.1',
            'price_note'            => 'nullable|string:max:2000',
            'brother_ids'           => 'nullable|array',
            'brother_ids.*'         => 'nullable|exists:users,id',
        ]);
        $booking    = $booking ?? new Booking();

        DB::beginTransaction();
        try {
            // update booking users start
            $booking->user_id              = $request->get('user');
            $booking->total_purchase_price = $request->get('total_purchase_price');
            $booking->total_selling_price  = $request->get('total_selling_price');
            $booking->price_note           = $request->get('price_note');
            $booking->save();
            BookingUser::where('booking_id',$booking->id)->delete();
            BookingUser::Create([
                'user_id'    => $booking->user_id,
                'booking_id' => $booking->id,
            ]);
            if ($request->has('brother_ids') && count($request->get('brother_ids')) > 0) {
                foreach ($request->get('brother_ids') as $user_id) {
                    BookingUser::Create([
                        'user_id'    => $user_id,
                        'booking_id' => $booking->id,
                    ]);
                }
            }
            // update booking users end

            DB::commit();
            return redirect()->route('bookings.createOrEdit',$booking->id)->with('success', 'Booking created successfully, Add Or Update Booking Details');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * create a newly booking service depend on booking->id && service type.
    */
    public function createService(Request $request,Booking $booking)
    {
        $rules = ['service_type' => 'required|in:trip,visa,transport,ticket,hotel'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            throw new \Exception(implode("\n", $validator->errors()->all()));
        }

        DB::beginTransaction();
        try {
            if($request->service_type == 'trip'){
                $service = $this->createTripService($request,$booking);
            }elseif($request->service_type == 'visa'){
                $service = $this->createVisaService($request,$booking);
            }elseif($request->service_type == 'hotel'){
                $service = $this->createHotelService($request,$booking);
            }elseif($request->service_type == 'transport'){
                $service = $this->createTransportService($request,$booking);
            }elseif($request->service_type == 'ticket'){
                $service = $this->createTicketService($request,$booking);
            }
            $booking?->update(['total_selling_price' => $booking->total_prices()]);
            DB::commit();
            return response()->json(array(
                'success' => true,
                'service' => $service,
                'servicesHtml' => view('admin.bookings.edit_services', compact('booking'))->render(),
            ), 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Store a booking hotel service.
    */
    public function createHotelService($request,$booking)
    {
        $rules = [
            'from_date'         => 'required|date',
            'to_date'           => 'required|date|after:from_date',
            'days'              => 'required|integer|min:1|max:222',
            'reserve_no'        => 'required|string|max:50',
            'selling_price'     => 'required|numeric|max:9999999|min:.1',
            // 'purchase_price' => 'nullable|numeric|max:9999999|min:.1',
            'hotel_id'          => 'nullable|exists:hotels,id',
            'hotel_stars'       => 'nullable|integer|min:1|max:5',
            'room_no'           => 'nullable|integer|min:1|max:999999',
            'room_type'         => 'nullable|in:single,trible,double,four,five',
            'private_pathroom'  => 'nullable|in:1,0',
            'is_suite'          => 'nullable|in:1,0',
            'if_breackfast'     => 'nullable|in:1,0',
            'if_lanuch'         => 'nullable|in:1,0',
            'if_dinner'         => 'nullable|in:1,0',
            'note'              => 'nullable|string:max:2000',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            throw new \Exception(implode("\n", $validator->errors()->all()));
        }

        $data = array_merge($validator->validated(),['booking_id' => $booking->id]);
        $service = BookingHotel::Create($data);
        return $service;
    }

    /**
     * Store a booking trip service.
    */
    public function createTripService($request,$booking)
    {
        $rules = [
            'from_date'      => 'required|date',
            'to_date'        => 'required|date|after:from_date',
            // 'purchase_price' => 'nullable|numeric|max:9999999|min:.1',
            'selling_price'  => 'required|numeric|max:9999999|min:.1',
            'note'           => 'nullable|string:max:2000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            throw new \Exception(implode("\n", $validator->errors()->all()));
        }

        $data = array_merge($validator->validated(),['booking_id' => $booking->id]);

        $service = BookingTrip::Create($data);

        return $service;
    }

    /**
     * Store a booking visa service.
    */
    public function createVisaService($request,$booking)
    {
        $rules = [
            'from_date'      => 'required|date',
            'to_date'        => 'required|date|after:from_date',
            // 'purchase_price' => 'nullable|numeric|max:9999999|min:.1',
            'selling_price'  => 'required|numeric|max:9999999|min:.1',
            'note'           => 'nullable|string:max:2000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            throw new \Exception(implode("\n", $validator->errors()->all()));
        }

        $data = array_merge($validator->validated(),['booking_id' => $booking->id]);

        $service = BookingVisa::Create($data);

        return $service;
    }

    /**
     * Store a booking transport service.
    */
    public function createTransportService($request,$booking)
    {
        $rules = [
            'from_date'      => 'required|date',
            'to_date'        => 'required|date|after:from_date',
            // 'purchase_price' => 'nullable|numeric|max:9999999|min:.1',
            'selling_price'  => 'required|numeric|max:9999999|min:.1',
            'note'           => 'nullable|string:max:2000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            throw new \Exception(implode("\n", $validator->errors()->all()));
        }

        $data = array_merge($validator->validated(),['booking_id' => $booking->id]);

        $service = BookingTransport::Create($data);

        return $service;
    }

    /**
     * Store a booking ticket service.
    */
    public function createTicketService($request,$booking)
    {
        $rules = [
            'from_date'      => 'required|date',
            'to_date'        => 'required|date|after:from_date',
            // 'purchase_price' => 'nullable|numeric|max:9999999|min:.1',
            'selling_price'  => 'required|numeric|max:9999999|min:.1',
            'note'           => 'nullable|string:max:2000',
            'degree'         => 'required|string:max:100',
            'flight_no'      => 'required|string:max:100',
            'from_country'   => 'required|exists:countries,id',
            'to_country'     => 'required|exists:countries,id',
            'from_city'      => 'nullable|string:max:100',
            'to_city'        => 'nullable|string:max:100',
            'airplane_id'    => 'nullable|exists:airplanes,id',

            'ticket_type'       => 'required|in:oneway,round',
            'return_from_date'  => 'nullable|required_if:ticket_type,==,round|date',
            'return_to_date'    => 'nullable|required_if:ticket_type,==,round|date|after:return_from_date',
            'return_flight_no'  => 'nullable|required_if:ticket_type,==,round|string:max:100',
            'is_transit'        => 'required|in:1,0',
        ];

        $arrays_rules = [
            'transit'                     => 'nullable|array',
            'transit.*.transit_from_date' => 'required|date',
            'transit.*.transit_to_date'   => 'required|date',
            'transit.*.transit_country_id'=> 'exists:countries,id',
            'transit.*.transit_city'      => 'required|string:max:100',
            'transit.*.transit_airport'   => 'required|string:max:100',

            'return_transit'                     => 'nullable|array',
            'return_transit.*.transit_from_date' => 'required|date',
            'return_transit.*.transit_to_date'   => 'required|date',
            'return_transit.*.transit_country_id'=> 'exists:countries,id',
            'return_transit.*.transit_city'      => 'required|string:max:100',
            'return_transit.*.transit_airport'   => 'required|string:max:100',
        ];

        $validator       = Validator::make($request->all(), $rules);
        $array_validator = Validator::make($request->all(), $arrays_rules);
        if ($validator->fails()) throw new \Exception(implode("\n", $validator->errors()->all()));
        if ($array_validator->fails()) throw new \Exception(implode("\n", $array_validator->errors()->all()));

        $data = array_merge($validator->validated(),['booking_id' => $booking->id]);
        $service = BookingTicket::Create($data);

        if($request->ticket_type == 'oneway'){
            $service->return_from_date = null;
            $service->return_to_date   = null;
            $service->return_flight_no = null;
            $service->Update($data);
        }

        if($request->is_transit == '1' && $request->transit && count($request->transit)){
            foreach ($request->transit as $transit) {
                BookingTicket::Create([
                    'transit_from_date'  => $transit['transit_from_date'],
                    'transit_to_date'    => $transit['transit_to_date'],
                    'transit_country_id' => $transit['transit_country_id'],
                    'transit_city'       => $transit['transit_city'],
                    'transit_airport'    => $transit['transit_airport'],
                    'booking_id'         => $booking->id,
                    'ticket_id'          => $service->id,
                    'ticket_type'        => $service->ticket_type,
                    'is_transit'         => 1,
                    'is_transit_step'    => '1',
                    'transit_step_type'  => 'going',
                ]);
            }
        }

        if($request->is_transit == '1' && $request->return_transit && count($request->return_transit) && $request->ticket_type == 'round'){
            foreach ($request->return_transit as $return_transit) {
                BookingTicket::Create([
                    'transit_from_date'  => $return_transit['transit_from_date'],
                    'transit_to_date'    => $return_transit['transit_to_date'],
                    'transit_country_id' => $return_transit['transit_country_id'],
                    'transit_city'       => $return_transit['transit_city'],
                    'transit_airport'    => $return_transit['transit_airport'],
                    'booking_id'         => $booking->id,
                    'ticket_id'          => $service->id,
                    'ticket_type'        => $service->ticket_type,
                    'is_transit'         => 1,
                    'is_transit_step'    => '1',
                    'transit_step_type'  => 'return',
                ]);
            }
        }

        return $service;
    }

    /**
     * update a newly booking service depend on booking->id && service type.
    */
    public function editService(Request $request,$id,$service_type,$booking_id)
    {
        if($service_type && $service_type == 'trip'){
            $service = $this->editTripService($request,$id);
        }elseif($service_type && $service_type == 'visa'){
            $service = $this->editVisaService($request,$id);
        }elseif($service_type && $service_type == 'hotel'){
            $service = $this->editHotelService($request,$id);
        }elseif($service_type && $service_type == 'transport'){
            $service = $this->editTransportService($request,$id);
        }elseif($service_type && $service_type == 'ticket'){
            $service = $this->editTicketService($request,$id);
        }else{
            throw new \Exception('service type is required');
        }
        $booking = Booking::find($booking_id);
        $booking?->update(['total_selling_price' => $booking->total_prices()]);
        return response()->json(array(
            'success' => true,
            'service' => $service,
        ), 200);
    }

    /**
     * update a booking trip service.
    */
    public function editHotelService($request,$id)
    {
        $hotel = BookingHotel::findOrFail($id);
        $rules = [
            'from_date'         => 'required|date',
            'to_date'           => 'required|date|after:from_date',
            'days'              => 'required|integer|min:1|max:222',
            'reserve_no'        => 'required|string|max:50',
            'selling_price'     => 'required|numeric|max:9999999|min:.1',
            // 'purchase_price' => 'nullable|numeric|max:9999999|min:.1',
            'hotel_id'          => 'nullable|exists:hotels,id',
            'hotel_stars'       => 'nullable|integer|min:1|max:5',
            'room_no'           => 'nullable|integer|min:1|max:999999',
            'room_type'         => 'nullable|in:single,trible,double,four,five',
            'private_pathroom'  => 'nullable|in:1,0',
            'is_suite'          => 'nullable|in:1,0',
            'if_breackfast'     => 'nullable|in:1,0',
            'if_lanuch'         => 'nullable|in:1,0',
            'if_dinner'         => 'nullable|in:1,0',
            'note'              => 'nullable|string:max:2000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            throw new \Exception(implode("\n", $validator->errors()->all()));
        }

        $data = $validator->validated();
        $data['is_suite']         = $request->is_suite         ? $data['is_suite']      = 1 : 0;
        $data['if_breackfast']    = $request->if_breackfast    ? $data['if_breackfast'] = 1 : 0;
        $data['if_lanuch']        = $request->if_lanuch        ? $data['if_lanuch']     = 1 : 0;
        $data['if_dinner']        = $request->if_dinner        ? $data['if_dinner']     = 1 : 0;
        $data['private_pathroom'] = $request->private_pathroom ? $data['if_dinner']     = 1 : 0;
        $data['hotel_id']         = $request->hotel_id         ? $request->hotel_id     = 1 : null;
        // hotel_stars
        $service = $hotel->Update($data);
        return response()->json(array(
            'success'      => true,
            'service'      => $request->all(),
            'data'         => $data,
        ), 200);

        return $hotel;
    }

    /**
     * update a booking trip service.
    */
    public function editTripService($request,$id)
    {
        $trip = BookingTrip::findOrFail($id);
        $rules = [
            'from_date'      => 'required|date',
            'to_date'        => 'required|date|after:from_date',
            // 'purchase_price' => 'nullable|numeric|max:9999999|min:.1',
            'selling_price'  => 'required|numeric|max:9999999|min:.1',
            'note'           => 'nullable|string:max:2000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            throw new \Exception(implode("\n", $validator->errors()->all()));
        }

        $data = $validator->validated();
        $service = $trip->Update($data);

        return $trip;
    }

    /**
     * update a booking visa service.
    */
    public function editVisaService($request,$id)
    {
        $visa = BookingVisa::findOrFail($id);
        $rules = [
            'from_date'      => 'required|date',
            'to_date'        => 'required|date|after:from_date',
            // 'purchase_price' => 'nullable|numeric|max:9999999|min:.1',
            'selling_price'  => 'required|numeric|max:9999999|min:.1',
            'note'           => 'nullable|string:max:2000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            throw new \Exception(implode("\n", $validator->errors()->all()));
        }

        $data = $validator->validated();
        $service = $visa->Update($data);

        return $visa;
    }

    /**
     * update a booking transport service.
    */
    public function editTarnsportService($request,$id)
    {
        $transport = BookingTarnsport::findOrFail($id);
        $rules = [
            'from_date'      => 'required|date',
            'to_date'        => 'required|date|after:from_date',
            // 'purchase_price' => 'nullable|numeric|max:9999999|min:.1',
            'selling_price'  => 'required|numeric|max:9999999|min:.1',
            'note'           => 'nullable|string:max:2000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            throw new \Exception(implode("\n", $validator->errors()->all()));
        }

        $data = $validator->validated();
        $service = $transport->Update($data);

        return $transport;
    }

    /**
     * update a booking ticket service.
    */
    public function editTicketService($request,$id)
    {
        $ticket = BookingTicket::findOrFail($id);
        $rules = [
            'from_date'      => 'required|date',
            'to_date'        => 'required|date|after:from_date',
            // 'purchase_price' => 'nullable|numeric|max:9999999|min:.1',
            'selling_price'  => 'required|numeric|max:9999999|min:.1',
            'note'           => 'nullable|string:max:2000',
            'degree'         => 'required|string:max:100',
            'flight_no'      => 'required|string:max:100',
            'from_country'   => 'required|exists:countries,id',
            'to_country'     => 'required|exists:countries,id',
            'from_city'      => 'nullable|string:max:100',
            'to_city'        => 'nullable|string:max:100',
            'airplane_id'    => 'nullable|exists:airplanes,id',
            'hotel_id'       => 'nullable|exists:hotels,id',

            'ticket_type'       => 'required|in:oneway,round',
            'return_from_date'  => 'nullable|required_if:ticket_type,==,round|date',
            'return_to_date'    => 'nullable|required_if:ticket_type,==,round|date|after:return_from_date',
            'return_flight_no'  => 'nullable|required_if:ticket_type,==,round|string:max:100',
            'is_transit'        => 'required|in:1,0',
        ];

        $arrays_rules = [
            'transit'                     => 'nullable|array',
            'transit.*.transit_from_date' => 'required|date',
            'transit.*.transit_to_date'   => 'required|date',
            'transit.*.transit_country_id'=> 'exists:countries,id',
            'transit.*.transit_city'      => 'required|string:max:100',
            'transit.*.transit_airport'   => 'required|string:max:100',

            'return_transit'                     => 'nullable|array',
            'return_transit.*.transit_from_date' => 'required|date',
            'return_transit.*.transit_to_date'   => 'required|date',
            'return_transit.*.transit_country_id'=> 'exists:countries,id',
            'return_transit.*.transit_city'      => 'required|string:max:100',
            'return_transit.*.transit_airport'   => 'required|string:max:100',
        ];

        $validator       = Validator::make($request->all(), $rules);
        $array_validator = Validator::make($request->all(), $arrays_rules);
        if ($validator->fails()) throw new \Exception(implode("\n", $validator->errors()->all()));
        if ($array_validator->fails()) throw new \Exception(implode("\n", $array_validator->errors()->all()));

        $data = $validator->validated();

        DB::beginTransaction();
        try {
            $ticket->transit_steps()?->delete();
            $service = $ticket->Update($data);

            if($request->ticket_type == 'oneway'){
                $ticket->return_from_date = null;
                $ticket->return_to_date   = null;
                $ticket->return_flight_no = null;
                $ticket->Update($data);
            }

            if($request->is_transit == '1' && $request->transit && count($request->transit)){
                foreach ($request->transit as $transit) {
                    BookingTicket::Create([
                        'transit_from_date'  => $transit['transit_from_date'],
                        'transit_to_date'    => $transit['transit_to_date'],
                        'transit_country_id' => $transit['transit_country_id'],
                        'transit_city'       => $transit['transit_city'],
                        'transit_airport'    => $transit['transit_airport'],
                        'booking_id'         => $ticket->booking_id,
                        'ticket_id'          => $ticket->id,
                        'ticket_type'        => $ticket->ticket_type,
                        'is_transit'         => 1,
                        'is_transit_step'    => '1',
                        'transit_step_type'  => 'going',
                    ]);
                }
            }

            if($request->is_transit == '1' && $request->return_transit && count($request->return_transit) && $request->ticket_type && $request->ticket_type == 'round'){
                foreach ($request->return_transit as $return_transit) {
                    BookingTicket::Create([
                        'transit_from_date'  => $return_transit['transit_from_date'],
                        'transit_to_date'    => $return_transit['transit_to_date'],
                        'transit_country_id' => $return_transit['transit_country_id'],
                        'transit_city'       => $return_transit['transit_city'],
                        'transit_airport'    => $return_transit['transit_airport'],
                        'booking_id'         => $ticket->booking_id,
                        'ticket_id'          => $ticket->id,
                        'ticket_type'        => $ticket->ticket_type,
                        'is_transit'         => 1,
                        'is_transit_step'    => '1',
                        'transit_step_type'  => 'return',
                    ]);
                }
            }

            DB::commit();
            return $ticket;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * delete booking serviec depend on service_id && service_type.
    */
    public function deleteService(Request $request)
    {
        if($request->service_type == 'trip'){
            $service = BookingTrip::findOrFail($request->service_id);
            $service->delete();
        }
        if($request->service_type == 'visa'){
            $service = BookingVisa::findOrFail($request->service_id);
            $service->delete();
        }
        if($request->service_type == 'hotel'){
            $service = BookingHotel::findOrFail($request->service_id);
            $service->delete();
        }
        if($request->service_type == 'transport'){
            $service = BookingTransport::findOrFail($request->service_id);
            $service->delete();
        }
        if($request->service_type == 'ticket'){
            $service = BookingTicket::findOrFail($request->service_id);
            $service->delete();
        }
        $booking = Booking::find($request->booking_id);
        $booking?->update(['total_selling_price' => $booking->total_prices()]);
        return response()->json(array(
            'success'      => true,
            'service_id'   => $request->service_id,
            'service_type' => $request->service_type,
            'booking_id'   => $request->booking_id,
        ), 200);
    }

    /**
     * Display the specified resource.
    */
    public function show($id)
    {
        $booking = Booking::with(['hotel','country', 'user', 'airplane', ])->findOrFail($id);
        $setting = Setting::first();
        return view('admin.bookings.show', compact('booking','setting'));
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        // Delete associated PDFs
        foreach ($booking->bookingPdfs as $pdf) {
            // Delete the file from the system
            $filePath = base_path('assets/admin/uploads/' . $pdf->pdf);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            // Remove the record from the database
            $pdf->delete();
        }

        // Delete the booking
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully');
    }

}
