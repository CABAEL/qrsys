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


    public function Greetings(){

        $greetings = [
        "Hello, there!",
        "Greetings, human!",
        "Good day!",
        "Hi, how can I assist you today?",
        "Hey, what can I do for you?",
        "Hello, friend!",
        "How's it going?",
        "Hi, I'm here to help!",
        "Good to see you!",
        "Hey there, how can I be of service?",
        "Greetings and salutations!",
        "Hello, lovely person!",
        "How can I make your day better?",
        "Hi, how's everything on your end?",
        "Good to be of service!",
        "Hey, ready for some automation magic?",
        "Hello, what's on your mind today?",
        "Greetings, esteemed user!",
        "Hi there, how can I assist you today?",
        "Hello, world!",
        "Good morning! How can I assist you?",
        "Hey, what's the word?",
        "Greetings, valued user!",
        "Hi, ready to automate some tasks?",
        "Hello, how's your day going?",
        "Good day, how may I help you?",
        "Hey, I'm at your service!",
        "Hello, how can I make your day better?",
        "Hi, how can I simplify your life today?",
        "Greetings, how may I be of assistance?",
        "Hello, ready to get things done?",
        "Hi there, what can I automate for you?",
        "Hey, what's on your to-do list?",
        "Hello, what's the plan today?",
        "Good day, how can I assist you today?",
        "Hi, how's it going on your end?",
        "Greetings, how may I assist you?",
        "Hello, what can I do to help?",
        "Hey, how can I make your day smoother?",
        "Hello, ready for some automated solutions?",
        "Hi there, what's on your agenda?",
        "Hey, what's new in your world?",
        "Hello, what can I automate for you today?",
        "Greetings, how may I simplify your day?",
        "Hi, how can I assist you right now?",
        "Hello, how can I be of service today?",
        "Hey, what's the latest?",
        "Hello, how can I make your life easier?",
        "Hi there, what's the task at hand?",
        "Greetings, how can I assist you today?",
        "Hello, how's everything on your end?",
        "Hey, what can I do for you today?",
        "Hello, what's on your mind?",
        "Good day, ready for some automation?",
        "Hi, how can I make your day better?",
        "Hello, how may I be of assistance?",
        "Hey, what can I automate for you?",
        "Hello, ready for some system magic?",
        "Hi there, how can I assist you today?",
        "Greetings, how can I simplify your tasks?",
        "Hello, what's on your plate today?",
        "Good day, how can I make things easier?",
        "Hey, how's it going on your end?",
        "Hello, what's the plan?",
        "Hi, how can I be of service right now?",
        "Hello, what can I do to help you?",
        "Hey, what's on your to-do list?",
        "Hello, ready for some automation solutions?",
        "Greetings, how can I assist you?",
        "Hi, how can I make your day smoother?",
        "Hello, ready to get things done efficiently?",
        "Hi there, what can I automate for you today?",
        "Hey, how can I assist you today?",
        "Hello, what's new in your world?",
        "Good day, how can I make your life easier?",
        "Hello, how may I simplify your day?",
        "Hey, what can I do for you right now?",
        "Hello, how's everything going?",
        "Hi, how can I help you today?",
        "Greetings, how can I assist you right now?",
        "Hello, what can I automate for you today?",
        "Hey, what's on your mind today?",
        "Hello, ready for some system optimization?",
        "Hi there, how can I be of service?",
        "Good day, how can I make your tasks easier?",
        "Hello, what's on your agenda?",
        "Hi, how can I simplify your workflow?",
        "Hello, how can I assist you today?",
        "Hey, what's on your plate?",
        "Hello, how's it going on your end?",
        "Hi, how can I make things more efficient?",
        "Greetings, how can I assist you?",
        "Hello, ready to automate your day?",
        "Hey, what can I do to make your life better?",
        "Hello, what can I automate for you?",
        "Hi, how can I be of service today?",
        "Hello, how may I make your day smoother?",
        "Hey, what's on your to-do list?",
        "Hello, how can I help you achieve your goals?",
        "Greetings, how can I simplify your tasks?",
        "Hi, how can I assist you right now?",
        "Hello, ready to optimize your workflow?",
        "Good day, how can I make your life easier?",
        "Hello, what's new in your world?",
        ];


        $randomGreeting = $greetings[array_rand($greetings)];

        $user = Auth::user()->username;

        $role =  Auth::user()->role;

        return response()->json(['greeting' => $randomGreeting .'    You are: <b>['.strtoupper($role).'] ['.strtoupper($user).']<b>']);

    }

}
