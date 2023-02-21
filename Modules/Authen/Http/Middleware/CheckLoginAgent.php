<?php
namespace Modules\Authen\Http\Middleware;
use Closure;
class CheckLoginAgent
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
        if ($request->session()->has('agentInfo')) {
            return redirect()->route('dashboard_agent/index');
        }
        return $next($request);
    }
}