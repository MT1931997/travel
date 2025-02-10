<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {

        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Get the authenticated admin
                $admin = Auth::guard($guard)->user();

                // Check if this is a request for a tenant or central domain
                if ($this->isTenantRequest($request)) {
                    // Redirect tenant admin based on tenant_id
                    // if(tenant() && tenant()->id != auth()->user()->tenant_id) abort(404);
                    return redirect()->route('admin.dashboard');
                } else {
                    // Redirect super admin based on central domain
                    if (is_null($admin->tenant_id)) {
                        return redirect()->route('superAdmin.dashboard');
                    }
                }
            }
        }

        return $next($request);
    }

    /**
     * Determine if the request is for a tenant or central domain.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isTenantRequest($request)
    {
        // Check if the request is from a tenant subdomain
        return !in_array($request->getHost(), config('tenancy.central_domains'));
    }
}
