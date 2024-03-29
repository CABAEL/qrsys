<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class AuthorizedUser
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
            $url = $request->url();
            $segment = explode('/',$url);
            $user_dir = (isset($segment[3])?$segment[3]:0);
            $user_role = Auth::user()->role;
    
            if ($user_dir != $user_role)
            {
                return redirect('/'.$user_role.'/home');
            }
        
        }
        return $next($request);
    }
}
