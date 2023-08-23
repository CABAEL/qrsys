<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MyaccountController extends Controller
{
    //
    public static function update(Request $request){

        $current_user = Auth::user();

        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'email' => 'required|email|max:60',
            'description' => 'nullable',
            'contact_number' => 'nullable|numeric|digits_between:7,13',
            'username' => [
                'required',
                'max:60',
                Rule::unique('users', 'username')->ignore($current_user->id, 'id')
            ],
        ]);
    
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        if($current_user->role == 'client'){

            $update_client = Client::where('user_id',$current_user->id)
            ->update([
                'address' => $request->address,
                'email' => $request->email,
                'description' => $request->description,
                'contact_no' => $request->contact_number
            ]);

            $update_username = User::where('id',$current_user->id)
            ->update([
                'username' => $request->username
            ]);

            if($update_client && $update_username){
                return responseBuilder('Success','Account successfully updated!',[],$update_client);
            }

            return false;

        }else if($current_user->role == 'user'){

        }else if($current_user->role == 'admin'){

        }else{
            return false;
        }
    
    }
}
