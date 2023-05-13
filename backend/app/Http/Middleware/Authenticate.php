<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if($request->user())
        {
            if (Auth::user()->role == 'admin'){
                //return 'admin/home';
                return route('admin_home');
            }

            else if (Auth::user()->role == 'hr_head'){
                //return 'hr_head/home';
                return route('hr_head_home');
            }

            else{
                return route('login');
            }
            
        }else{
            return route('login');
        }
        
    }
}
