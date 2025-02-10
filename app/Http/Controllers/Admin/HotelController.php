<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;

class HotelController extends Controller
{

    public function search(Request $request)
    {
        $search = $request->input('search');
    
        // Search users by mobile or name
        $users = Hotel::where('name', 'like', "%{$search}%")
                    ->get();
    
        // Return JSON response for Select2
        return response()->json($users);
    }

    public function index(Request $request)
    {
        $query = Hotel::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where(\DB::raw('CONCAT_WS(" ", `name`)'), 'like', '%' . $request->search . '%');
            });
        }

        $data = $query->paginate(PAGINATION_COUNT);

        $searchQuery = $request->search;

        return view('admin.hotels.index', compact('data', 'searchQuery'));
    }


    public function create()
    {
        if (auth()->user()->can('hotel-add')) {
            return view('admin.hotels.create');
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
     
    }


    public function store(Request $request)
    {
        try {
            $hotel = new Hotel();
            $hotel->name = $request->get('name');
           
            if ($hotel->save()) {
            
                return redirect()->route('hotels.index')->with(['success' => 'hotel created']);
            } else {
                return redirect()->back()->with(['error' => 'Something wrong']);
            }
        } catch (\Exception $ex) {
            return redirect()->back()
                ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
                ->withInput();
        }
    }


    


    public function edit($id)
    {
        if (auth()->user()->can('hotel-edit')) {
            $data = Hotel::findorFail($id);
            return view('admin.hotels.edit', compact('data'));
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findorFail($id);
        try {

            $hotel->name = $request->get('name');
           

            if ($hotel->save()) {
        
                return redirect()->route('hotels.index')->with(['success' => 'hotel update']);
            } else {
                return redirect()->back()->with(['error' => 'Something wrong']);
            }
        } catch (\Exception $ex) {
            return redirect()->back()
                ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect()->route('countries.index')->with(['success' => 'hotel Delete']);
    }

}
