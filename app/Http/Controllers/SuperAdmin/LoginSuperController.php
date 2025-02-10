<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class LoginSuperController extends Controller
{
  public function show_login_view()
  {
    return view('superAdmin.auth.login');
  }

  public function login(LoginRequest $request)
  {
      // Attempt to authenticate using the provided username and password
      if (auth()->guard('admin')->attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {

          // Get the currently authenticated admin
          $admin = auth()->guard('admin')->user();

          // Check if the admin is a super admin (tenant_id is null)
          if (is_null($admin->tenant_id)) {
              // Redirect to the super admin dashboard
              return redirect()->route('superAdmin.dashboard');
          } else {
              // If not a super admin, log out and redirect to the login page with an error
              auth()->guard('admin')->logout();
              return redirect()->route('superAdmin.showlogin')->withErrors(['error' => 'Unauthorized access.']);
          }
      } else {
          // If authentication fails, redirect back to the login page with an error
          return redirect()->route('superAdmin.showlogin')->withErrors(['error' => 'Invalid credentials.']);
      }
  }


  public function logout()
  {
    auth()->logout();
    return redirect()->route('superAdmin.showlogin');
  }


  public function editlogin($id)
  {
    $data = Admin::findorFail($id);
    return view('superAdmin.auth.edit', compact('data'));
  }



  public function updatelogin(Request $request, $id)
  {
    $admin = Admin::findorFail($id);
    try {
      $admin->username = $request->get('username');
      $admin->password = Hash::make($request->password);

      if ($admin->save()) {
        auth()->logout();
        return redirect()->route('superAdmin.showlogin');
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
