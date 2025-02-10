<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{

    public function storeCompany(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'company_no' => 'nullable|max:13|unique:companies|min:8',
            'whats_no'   => 'nullable|max:13|:companies|min:8',
        ]);  
        $company = new Company();
        $company->fill($validated);


        $company->save();

        return response()->json([
            'success' => true,
            'company' => $company,
        ]);
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
    
        // Search users by mobile or name
        $users = Company::where('name', 'like', "%{$search}%")
                    ->get();
    
        // Return JSON response for Select2
        return response()->json($users);
    }

    public function index(Request $request)
    {
        $query = Company::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where(\DB::raw('CONCAT_WS(" ", `name`)'), 'like', '%' . $request->search . '%');
            });
        }

        $data = $query->paginate(PAGINATION_COUNT);

        $searchQuery = $request->search;

        return view('admin.companies.index', compact('data', 'searchQuery'));
    }


    public function create()
    {
        return view('admin.companies.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_no' => 'nullable|max:13|unique:companies|min:8',
            'whats_no' => 'nullable|max:13|unique:companies|min:8',
        ]);
        try {
            $company             = new Company();
            $company->name       = $request->get('name');
            $company->company_no = $request->get('company_no');
            $company->whats_no   = $request->get('whats_no');
           
            if ($company->save()) {
            
                return redirect()->route('companies.index')->with(['success' => 'company created']);
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
        if (auth()->user()->can('company-edit')) {
            $data = Company::findorFail($id);
       
            return view('admin.companies.edit', compact('data'));
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }

    public function update(Request $request, $id)
    {
        $company = Company::findorFail($id);
        $request->validate([
            'name'       => 'required|string|max:255',
            'company_no' => 'nullable|max:13|min:8|unique:companies,company_no,'.$company->company_no,
            'whats_no'   => 'nullable|max:13|min:8|unique:companies,whats_no,'.$company->whats_no,
        ]);
        try {
            
            $company->name       = $request->get('name');
            $company->company_no = $request->get('company_no');
            $company->whats_no   = $request->get('whats_no');

            if ($company->save()) {
        
                return redirect()->route('companies.index')->with(['success' => 'company update']);
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
        $Company = Company::findOrFail($id);
        $Company->delete();

        return redirect()->route('Companies.index')->with(['success' => 'Company Delete']);
    }

}
