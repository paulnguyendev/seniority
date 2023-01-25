<?php
namespace Modules\Authen\Http\Middleware;
use Closure;
class CheckLoginAdmin
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
        if ($request->session()->has('adminInfo')) {
            return redirect()->route('admin/index');
        }
        return $next($request);
    }
}