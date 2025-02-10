<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();

        // Check if the admin is a super admin (tenant_id is null)
        if (is_null($admin->tenant_id) && $admin->is_super) {
            return $next($request); // Proceed if the user is a super admin
        }

        // If not a super admin, redirect or abort with unauthorized access
        return abort(403, 'Unauthorized access.');
    }
}
