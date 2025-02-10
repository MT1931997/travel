<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::query();
        $employees = Admin::get();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('employee')) {
            $query->where('employee_id', $request->employee);
        }

        $bookings = $query->with(['country', 'user', 'airplane'])->get();

        return view('reports.booking', compact('bookings','employees'));
    }


}
