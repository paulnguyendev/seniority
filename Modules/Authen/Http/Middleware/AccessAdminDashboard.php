<?php

namespace Modules\Authen\Http\Middleware;

use App\Helpers\User;
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
        
        
        if($request->session()->has('adminInfo')) {
            return $next($request);
            
        }
        return redirect()->route('auth_admin/login'); 
       
        
    }
}
