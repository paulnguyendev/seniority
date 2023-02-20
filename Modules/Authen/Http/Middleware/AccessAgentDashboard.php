<?php
namespace Modules\Authen\Http\Middleware;
use Closure;
class AccessAgentDashboard
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
        if($request->session()->has('agentInfo')) {
            return $next($request);
        }
        return redirect()->route('auth_agent/login'); 
    }
}