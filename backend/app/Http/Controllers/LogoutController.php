<?php

namespace App\Http\Controllers;

use App\Models\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout_user(Request $request){
        
        $role = Auth::user()->role;
        $message = '['.strtoupper($role)."] : ".Auth::user()->id." Has logged out.";
        $operation = '';
        if($role == 'admin'){
            $operation = Base::ADMIN_LOGGED_OUT;
        }else if($role = 'client'){
            $operation = Base::CLIENT_LOGGED_OUT;
        }else if($role = 'client'){
            $operation = Base::USER_LOGGED_OUT;
        }else{
            $operation = '';
        }
        Base::serviceInfo($message,$operation,Auth::user());

        Auth::logout();

        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
}
