<?php

namespace App\Http\Middleware;
use Closure;

class AccessNonLicenceAgentDashboard
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
        return redirect()->route('agents/nonLicense/auth/login'); 
       
        
    }
}