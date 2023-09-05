<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    
    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        
        $remember = false;

        if(isset($request['remember'])){
            $remember = true;
        }
        

        if (Auth::attempt(['username' => $credentials['username'],
         'password' => $credentials['password'],
         'deleted_at' => null,
         'status'=>1],
         $remember)){

            session()->regenerate();

            $role = Auth::user()->role;
            $rdr ='';
            if($role === 'admin'){
                $rdr = '/admin/home';
                $logged_in = 'logged_in_admin';
            }
            if($role === 'client'){
                $rdr = '/client/home';
                $logged_in = 'logged_in_client';
            }
            if($role === 'user'){
                $rdr = '/user/home';
                $logged_in = 'logged_in_user';
            }

            $data = [
                'flag' => 1,
                'role' => $role,
                'rdr' => $rdr,
                'status' => 200,
            ];

            $message = '['.strtoupper($role)."] : [".Auth::user()->username."] : [".Auth::user()->id."] has logged in.";

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

            Base::serviceInfo($message,$logged_in,Auth::user());

           return $data;

        }

    }


    public static function changePass(Request $request)
    {
        $user = Auth::user();
    
        if (!Hash::check($request->oldpassword, $user->password)) {
            return responseBuilder('Error', 'Old password does not match!', ['password' => 'not match'], []);
        }
    
        // Update the user's password
        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);
    
        return responseBuilder('Success', 'Password updated successfully!', [], []);
    }


}
