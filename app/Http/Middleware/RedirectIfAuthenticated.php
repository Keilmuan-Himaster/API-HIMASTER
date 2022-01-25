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
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
      
      if($guard == 'hima' && Auth::guard($guard)->check()){
         return redirect('/dekancup/contest');
      }
      if($guard == 'admindc' && Auth::guard($guard)->check()){
         return redirect('dekancup/admin/dashboard');
      }
        
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        
      
           
        return $next($request);
    }
}
