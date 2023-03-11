<?php

namespace App\Http\Middleware;
use Closure;

class AccessLicenseDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if($request->session()->has('licenseInfo')) {
            return $next($request);
            
        }
        $redirectName = config('prefix.portal_license') . "/login";
        return redirect()->route($redirectName); 
       
        
    }
}