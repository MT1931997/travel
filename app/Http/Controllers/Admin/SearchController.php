<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\BookingUser;
use App\Models\User;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');
        $model = $request->get('model');

        // Validate the model parameter
        if (!class_exists($model)) {
            return response()->json(['error' => 'Invalid model'], 400);
        }
        
        $results = $model::where('name', 'like', "%{$query}%")->limit(10)->get();

        
        //return response()->json($results);
        return view('inputs.search_results', ['results' => $results]);
    }
    
    /**
     * get user bookings
     **/
    public function getUserBookings($user_id) {

        $bookingID = BookingUser::where('user_id', $user_id)->pluck('booking_id')->toArray();
        $bookings = Booking::whereIn('id', $bookingID)
                            ->with('trips', 'visas', 'transports', 'tickets', 'hotels')
                            ->get();

        return response()->json(['booking' => $bookings]);


    }
}
