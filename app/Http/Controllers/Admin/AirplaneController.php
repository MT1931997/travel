<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airplane;

class AirplaneController extends Controller
{

    public function search(Request $request)
    {
        $search = $request->input('search');
    
        // Search users by mobile or name
        $users = Airplane::where('name', 'like', "%{$search}%")
                    ->get();
    
        // Return JSON response for Select2
        return response()->json($users);
    }

    public function index(Request $request)
    {
        $query = Airplane::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where(\DB::raw('CONCAT_WS(" ", `name`)'), 'like', '%' . $request->search . '%');
            });
        }

        $data = $query->paginate(PAGINATION_COUNT);

        $searchQuery = $request->search;

        return view('admin.airplanes.index', compact('data', 'searchQuery'));
    }


    public function create()
    {
        return view('admin.airplanes.create');
    }


    public function store(Request $request)
    {
        try {
            $airplane = new Airplane();
            $airplane->name = $request->get('name');
           
            if ($airplane->save()) {
            
                return redirect()->route('airplanes.index')->with(['success' => 'Airplane created']);
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
        if (auth()->user()->can('airplane-edit')) {
            $data = Airplane::findorFail($id);
       
            return view('admin.airplanes.edit', compact('data'));
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }

    public function update(Request $request, $id)
    {
        $airplane = Airplane::findorFail($id);
        try {

            $airplane->name = $request->get('name');
           

            if ($airplane->save()) {
        
                return redirect()->route('airplanes.index')->with(['success' => 'Airplane update']);
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
        $airplane = Airplane::findOrFail($id);
        $airplane->delete();

        return redirect()->route('airplanes.index')->with(['success' => 'Airplane Delete']);
    }

}
