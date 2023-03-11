<?php

namespace App\Http\Middleware;
use Closure;

class AccessAdminDashboard
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
        
        if($request->session()->has('staffInfo')) {
            return $next($request);
            
        }
        return redirect()->route('admin/auth/login'); 
       
        
    }
}