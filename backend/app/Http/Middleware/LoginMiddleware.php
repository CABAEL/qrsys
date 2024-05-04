<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){

            if($request->user())
            {
                $role = Auth::user()->role;
                if ($role){
                    return redirect($role.'/home');
                }
                else{
                    return route('login');
                }
                
            }else{
                return route('login');
            }
        
        }
        return $next($request);
    }
}
