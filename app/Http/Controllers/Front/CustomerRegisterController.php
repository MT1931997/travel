<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;


class CustomerRegisterController extends Controller
{

    public function create()
    {
        $countries = Country::all();
        return view('layouts.front',compact('countries'));
    }

    public function store(Request $request)
    {
        try {
            $user        = new User();
            $user->name  = $request->get('name');
            $user->email = $request->get('email');
            $user->phone = $request->get('phone');
            $user->address              = $request->get('address');
            $user->date_of_birth        = $request->get('date_of_birth');
            $user->date_of_passport_end = $request->get('date_of_passport_end');
            $user->budget               = $request->get('budget');

            if ($request->activate) {
                $user->activate = $request->get('activate');
            }

            if ($request->has('photo')) {
                $the_file_path = uploadImage('assets/admin/uploads', $request->photo);
                $user->photo = $the_file_path;
            }

            if ($request->has('photo_of_passport')) {
                $the_file_path = uploadImage('assets/admin/uploads', $request->photo_of_passport);
                $user->photo_of_passport = $the_file_path;
            }

              // Handle months_that_love_to_travel
            if ($request->has('months_that_love_to_travel')) {
                $user->months_that_love_to_travel = implode(',', $request->get('months_that_love_to_travel'));
            }

            if ($user->save()) {
             
                 // Save selected countries
                if ($request->has('countries')) {
                    $countries = $request->get('countries');
                    foreach ($countries as $countryId) {
                        \DB::table('country_users')->insert([
                            'user_id' => $user->id,
                            'country_id' => $countryId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
                return redirect()->back()->with(['success' => 'Thanks Your Form Submit Successfully!']);
            } else {
                return redirect()->back()->with(['error' => 'Something wrong']);
            }
        } catch (\Exception $ex) {
            return redirect()->back()
                ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
                ->withInput();
        }
    }
    
}