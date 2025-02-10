<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {

        $data = Setting::paginate(PAGINATION_COUNT);

        return view('admin.settings.index', ['data' => $data]);
    }

    public function create()
    {
        if (auth()->user()->can('setting-add')) {
            return view('admin.settings.create');
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }

    public function store(Request $request)
    {
        if (auth()->user()->can('setting-add')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'company_no' => 'nullable|max:13|unique:settings|min:8',
                'whats_no' => 'nullable|max:13|unique:settings|min:8',
                'lat'        => 'nullable|numeric|between:-90,90',
                'lng'        => 'nullable|numeric|between:-180,180',                
            ]);
            try {

                $setting = new Setting();

                $setting->name = $request->get('name');
                $setting->company_no = $request->get('company_no');
                $setting->whats_no = $request->get('whats_no');
                $setting->link_google = $request->get('link_google');
                $setting->address = $request->get('address');
                $setting->lat = $request->get('lat');
                $setting->lng = $request->get('lng');                

                if ($request->has('logo')) {
                    $the_file_path = uploadImage('assets/admin/uploads', $request->logo);
                    $setting->logo = $the_file_path;
                }


                if ($setting->save()) {
                    return redirect()->route('settings.index')->with(['success' => 'setting created']);
                } else {
                    return redirect()->back()->with(['error' => 'Something wrong']);
                }
            } catch (\Exception $ex) {
                return redirect()->back()
                    ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
                    ->withInput();
            }
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }

    public function edit($id)
    {
        if (auth()->user()->can('setting-edit')) {
            $data = Setting::findorFail($id);
            return view('admin.settings.edit', compact('data'));
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->can('setting-edit')) {
            $setting = Setting::findorFail($id);
            $request->validate([
                'name'       => 'required|string|max:255',
                'company_no' => 'nullable|max:13|min:8|unique:settings,company_no,'.$setting->company_no,
                'whats_no'   => 'nullable|max:13|min:8|unique:settings,whats_no,'.$setting->whats_no,
                'lat'        => 'nullable|numeric|between:-90,90',
                'lng'        => 'nullable|numeric|between:-180,180',
            ]);
            try {
                $setting->name = $request->get('name');
                $setting->company_no = $request->get('company_no');
                $setting->whats_no = $request->get('whats_no');
                $setting->link_google = $request->get('link_google');
                $setting->address = $request->get('address');
                $setting->lat = $request->get('lat');
                $setting->lng = $request->get('lng');
                
                if ($request->has('logo')) {
                    $the_file_path = uploadImage('assets/admin/uploads', $request->logo);
                    $setting->logo = $the_file_path;
                }

                if ($setting->save()) {
                    return redirect()->route('settings.index')->with(['success' => 'setting update']);
                } else {
                    return redirect()->back()->with(['error' => 'Something wrong']);
                }
            } catch (\Exception $ex) {
                return redirect()->back()
                    ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
                    ->withInput();
            }
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }
}
