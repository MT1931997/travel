<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Country;
use App\Models\User;
use App\Models\Airplane;
use App\Models\BookingDocument;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BookingController_old extends Controller
{

    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $bookings = Booking::with(['hotel','country', 'user', 'airplane'])->paginate(PAGINATION_COUNT); // Paginate the results
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
    
        // Check if the status is being changed to 'completed'
        if ($request->status === 'completed') {
            $user = $booking->user; // Assuming there is a relationship defined in the Booking model to fetch the associated user
            if (!$user || is_null($user->photo_of_passport)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot mark as completed. The user\'s photo of passport is missing.',
                ], 400);
            }
        }
    
        $booking->status = $request->status;
        $booking->save();
    
        return response()->json(['success' => true]);
    }
    
    public function getUserFamily(Request $request)
    {
        $query     = $request->get('query');
        $family_id = User::where('id', $query)->first()?->family_id;
        $brothers  = User::where('family_id', $family_id)->where('id','!=',$query)->get(['id', 'name', 'phone', 'family_id']);
        return response()->json($brothers ?? []);
    }

    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        $countries = Country::all();
        $hotels = Hotel::all();
        $users = User::all();
        $airplanes = Airplane::all();
        return view('admin.bookings.create', compact('countries', 'users', 'airplanes','hotels'));
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $request->validate([
            'date_of_travel' => 'required|date',
            'date_of_come' => 'required|date|after_or_equal:date_of_travel',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'country' => 'required|exists:countries,id',
            'user' => 'required|exists:users,id',
            'airplane' => 'nullable|exists:airplanes,id',
            'is_transet' => 'nullable|boolean',
            'transet_desc' => 'nullable|string|max:500',
            'is_transport' => 'nullable|boolean',
            'transport_desc' => 'nullable|string|max:500',
            'is_trip' => 'nullable|boolean',
            'trip_desc' => 'nullable|string|max:500',
        ]);

        $booking = new Booking();
        $booking->date_of_travel = $request->get('date_of_travel');
        $booking->date_of_come = $request->get('date_of_come');
        $booking->purchase_price = $request->get('purchase_price');
        $booking->selling_price = $request->get('selling_price');
        $booking->country_id = $request->get('country');
        $booking->hotel_id = $request->get('hotel');
        $booking->user_id = $request->get('user');
        $booking->airplane_id = $request->get('airplane');
        $booking->is_transet = $request->has('is_transet') ? 1 : 2;
        $booking->transet_desc = $request->transet_desc;
        $booking->is_transport = $request->has('is_transport') ? 1 : 2;
        $booking->transport_desc = $request->transport_desc;
        $booking->is_trip = $request->has('is_trip') ? 1 : 2;
        $booking->trip_desc = $request->trip_desc;
        $booking->save();

        if ($request->hasFile('pdf')) {
            $pdfs = $request->file('pdf');
            foreach ($pdfs as $pdf) {
                $pdfPath = uploadImage('assets/admin/uploads', $pdf); // Use the uploadpdf function
                if ($pdfPath) {
                    // Create a record in the booking_pdfs table for each pdf using the relationship
                    $bookingPdf = new BookingDocument();
                    $bookingPdf->pdf = $pdfPath;

                    $booking->bookingPdfs()->save($bookingPdf); // Associate the pdf with the booking
                }
            }
        }

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully');
    }

    /**
     * Display the specified resource.
    */
    public function show($id)
    {
        $booking = Booking::with(['hotel','country', 'user', 'airplane', ])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
    */
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $countries = Country::all();
        $hotels = Hotel::all();
        $users = User::all();
        $airplanes = Airplane::all();
        return view('admin.bookings.edit', compact('booking', 'countries', 'users', 'airplanes','hotels'));
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date_of_travel' => 'required|date',
            'date_of_come' => 'required|date|after_or_equal:date_of_travel',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'country' => 'required|exists:countries,id',
            'user' => 'required|exists:users,id',
            'airplane' => 'nullable|exists:airplanes,id',
            'is_transet' => 'nullable|boolean',
            'transet_desc' => 'nullable|string|max:500',
            'is_transport' => 'nullable|boolean',
            'transport_desc' => 'nullable|string|max:500',
            'is_trip' => 'nullable|boolean',
            'trip_desc' => 'nullable|string|max:500',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->date_of_travel = $request->get('date_of_travel');
        $booking->date_of_come = $request->get('date_of_come');
        $booking->purchase_price = $request->get('purchase_price');
        $booking->selling_price = $request->get('selling_price');
        $booking->country_id = $request->get('country');
        $booking->hotel_id = $request->get('hotel');
        $booking->user_id = $request->get('user');
        $booking->airplane_id = $request->get('airplane');
        $booking->is_transet = $request->has('is_transet') ? 1 : 2;
        $booking->transet_desc = $request->transet_desc;
        $booking->is_transport = $request->has('is_transport') ? 1 : 2;
        $booking->transport_desc = $request->transport_desc;
        $booking->is_trip = $request->has('is_trip') ? 1 : 2;
        $booking->trip_desc = $request->trip_desc;
        $booking->save();

         // Handle file deletion
        if ($request->has('delete_pdfs')) {
            $deletePdfs = $request->delete_pdfs;
            foreach ($deletePdfs as $pdfId) {
                $pdf = BookingDocument::find($pdfId);
                if ($pdf) {
                    // Delete the file from the system
                    $filePath = base_path('assets/admin/uploads/' . $pdf->pdf);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                    // Remove the record from the database
                    $pdf->delete();
                }
            }
        }

        // Handle new file uploads
        if ($request->hasFile('pdf')) {
            $pdfs = $request->file('pdf');
            foreach ($pdfs as $pdf) {
                $pdfPath = uploadImage('assets/admin/uploads', $pdf); // Use your file upload function
                if ($pdfPath) {
                    $bookingPdf = new BookingDocument();
                    $bookingPdf->pdf = $pdfPath;
                    $booking->bookingPdfs()->save($bookingPdf); // Associate the pdf with the booking
                }
            }
        }

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully');
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
