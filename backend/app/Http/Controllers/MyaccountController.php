<?php

namespace App\Http\Controllers;

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

            $validator = Validator::make($request->all(), [
                'client_name' => [
                    'required',
                    'max:100',
                    Rule::unique('clients')->ignore($current_user->id, 'user_id') // Replace $clientId with the actual client's ID
                ],
            ]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422); // 422 Unprocessable Entity
            }


            return "client";

        }else if($current_user->role == 'user'){

        }else if($current_user->role == 'admin'){

        }else{
            return false;
        }
    
    }
}
