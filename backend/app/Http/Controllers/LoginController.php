<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\URL;


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
            }
            if($role === 'hr_head'){
                $rdr = '/hr_head/home';
            }

            $data = [
                'flag' => 1,
                'role' => $role,
                'rdr' => $rdr,
                'status' => 200,
            ];
           return $data;

        }

    }

    /*public function google_auth(Request $request)
    {

        $validated_user = $request->validate([
            'email' => 'required|email',
            'google_id' => 'required|string|max:255',
            'fname' => 'required|max:60',
            'lname' => 'required|max:60',
        ]);

        if(User::where('google_id',$validated_user['google_id'])){
            
            $user_data = User::all();

            Auth::loginUsingId($user_data[0]['id']);
            $role = Auth::user()->role;
            
            $data = [
                'flag' => 1,
                'role' => $role,
                'status' => 200,
            ];

            return response()->json($data);

        }else{

            $request_profile = User::create([
                'google_id' => $validated_user['google_id'],
                'username' => $validated_user['email'],
                'password' => ''
            ]);

            $data = [
                'data' => $request_profile,
                'message' => 'Google user created successfully!'
            ];
    
            return response()->json($data);
        
        }

    }*/

}
