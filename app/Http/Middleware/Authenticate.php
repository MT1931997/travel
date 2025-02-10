<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {

        if (!$request->expectsJson()) {
            // Check if the request is for a tenant subdomain
            if ($this->isTenantRequest($request)) {
                // Redirect tenant admins to tenant login
                // if(tenant() && tenant()->id != auth()->user()->tenant_id) abort(404);
                return route('admin.showlogin');
            } else {
                // Redirect to super admin login for central domain requests
                return route('superAdmin.showlogin');
            }
        }
    }

    /**
     * Determine if the request is for a tenant or central domain.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isTenantRequest(Request $request)
    {
        return !in_array($request->getHost(), config('tenancy.central_domains'));
    }
}
