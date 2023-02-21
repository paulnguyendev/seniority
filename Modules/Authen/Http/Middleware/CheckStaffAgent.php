<?php
namespace Modules\Authen\Http\Middleware;
use Closure;
class CheckStaffAgent
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
        if ($request->session()->has('staffInfo')) {
            return redirect()->route('dashboard_staff/index');
        }
        return $next($request);
    }
}