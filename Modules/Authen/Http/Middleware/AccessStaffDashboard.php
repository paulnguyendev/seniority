<?php
namespace Modules\Authen\Http\Middleware;
use Closure;
class AccessStaffDashboard
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
        return redirect()->route('auth_staff/login'); 
    }
}