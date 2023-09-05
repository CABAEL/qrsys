<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Client;
use App\Models\Client_user;
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

        if($current_user->role == 'client'){
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
        }

        if($current_user->role == 'user'){
            $validator = Validator::make($request->all(), [
                'fname' => 'required',
                'mname' => 'required',
                'lname' => 'required',
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
        }
    
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        if($current_user->role == 'client'){

            $update_client = Client::where('user_id',$current_user->id);
            $old_data = $update_client->first();
            $update_client->update([
                'address' => $request->address,
                'email' => $request->email,
                'description' => $request->description,
                'contact_no' => $request->contact_number
            ]);
            $new_data = $update_client->first();

            $update_username = User::where('id',$current_user->id)
            ->update([
                'username' => $request->username
            ]);

            if($update_client && $update_username){

                $message = "[".strtoupper($current_user->role).'] : ['.$current_user->username.'] : ['.$current_user->id.'] has updated personal information';
                Base::serviceInfo($message,Base::UPDATE_MY_ACCOUNT,'from: ['.json_encode($old_data).'] - to:['.json_encode($new_data).']');

                return responseBuilder('Success','Account successfully updated!',[],$update_client);
            }

            return false;

        }else if($current_user->role == 'user'){

            $update_user = Client_user::where('user_id',$current_user->id);
            $old_data = $update_user->first();
            $update_user->update([
                'fname' => $request->fname,
                'mname' => $request->mname,
                'lname' => $request->lname,
                'address' => $request->address,
                'email' => $request->email,
                'description' => $request->description,
                'contact_no' => $request->contact_number
            ]);
            $new_data = $update_user->first();

            $update_username = User::where('id',$current_user->id)
            ->update([
                'username' => $request->username
            ]);

            if($update_user && $update_username){

                $message = "[".strtoupper($current_user->role).'] : ['.$current_user->username.'] : ['.$current_user->id.'] has updated personal information';
                Base::serviceInfo($message,Base::UPDATE_MY_ACCOUNT,'from: ['.json_encode($old_data).'] - to:['.json_encode($new_data).']');

                return responseBuilder('Success','Account successfully updated!',[],$update_user);
            }

            return false;

        }else{
            return false;
        }
        
    }
}
