<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\User_profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::user()->role == "admin"){
            $current_user = Auth::user()->id;
            $request = User::all()
            ->where('id', '!=' , $current_user)
            ->where('status','!=',0);
            
            $data = [
                'response_time' => LARAVEL_START,
                'count' => count($request),
                'data' => $request,
            ];
        }
        if(Auth::user()->role == "hr_head"){
            $current_user = Auth::user()->id;
            $request = User::all()
            ->where('id', '!=' , $current_user)
            ->where('status','!=',0)
            ->where('role','!=','admin');
            
            $data = [
                'response_time' => LARAVEL_START,
                'count' => count($request),
                'data' => $request,
            ];
        }

        if(Auth::user()->role == "hr_assistant"){
            $current_user = Auth::user()->id;
            $request = User::all()
            ->where('id', '!=' , $current_user)
            ->where('status','!=',0)
            ->where('role','!=','admin');
            
            $data = [
                'response_time' => LARAVEL_START,
                'count' => count($request),
                'data' => $request,
            ];
        }

        
        return response()->json($data);

    }

    public function employeeList()
    {
        $request = User::join('user_profiles', 'users.id', '=', 'user_profiles.id')
        ->join('employees','employees.user_id','=','user_profiles.id')->get();
        $data = [
            'response_time' => LARAVEL_START,
            'count' => count($request),
            'data' => $request,
        ];
        return response()->json($data);
        
    }

    public function activate($id)
    {
        $request = User::find($id);
        $request->status = 1;
        $request->save();

        $data = [
            'response_time' => LARAVEL_START,
            'data' => $request,
        ];
        
        return response()->json($data);

    }

    public function deactivatedUser()
    {
        $request = User::all()->where('status','=',0);

        $data = [
            'response_time' => LARAVEL_START,
            'count' => count($request),
            'data' => $request,
        ];
        
        return response()->json($data);

    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function user_info($id) 
    {
        $fetch = User::join('user_profiles', 'users.id', '=', 'user_profiles.id')->where('users.id','=',$id)
        ->get(
        ['users.id','fname',
        'mname',
        'lname',
        'age',
        'gender',
        'birthday',
        'address',
        'email',
        'mobile_number',
        'role',
        'username',
        'password']
        );
        $user = $fetch[0];
        return response()->json($user);
    }

    public function store(Request $request) 
    {
        
        //return $request;
        $validated_user = $request->validate([
            'username' => 'unique:users,username|required|max:60',
            'password' => 'required|confirmed|max:60',
            'fname' => 'required|max:60',
            'mname' => 'nullable|max:60',
            'lname' => 'required|max:60',
            'age' => 'required|integer',
            'address' => 'required',
            'gender' => 'required|max:1',
            'birthday' => 'required',
            'email' => 'required|email|max:60',
            'mobile_number' => 'required|numeric',
            'role' => 'required'
        ]);


        $merge_data = array();

        $request_user = User::create([
            'username' => $validated_user['username'],
            'password' => Hash::make($validated_user['password']),
            'role' => $validated_user['role'],
        ]);

        $user_id = $request_user->id;
    
        $request_profile = User_profile::create([
            'id' => $user_id,
            'fname' => $validated_user['fname'],
            'mname' => $validated_user['mname'],
            'lname' => $validated_user['lname'],
            'age' => $validated_user['age'],
            'gender' => $validated_user['gender'],
            'birthday' => $validated_user['birthday'],
            'address' => $validated_user['address'],
            'mobile_number' => $validated_user['mobile_number'],
            'email' => $validated_user['email'],
        ]);

        $merge_data = [
            'user' => $request_user,
            'user_profile' => $request_profile
        ];

        $data = [
            'data' => $merge_data,
            'message' => 'User Created Successfully!'
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivateUser($id)
    {
        $user_table = User::find($id);
        $user_table->status = 0;

        $user_table->save();

        $response = [
            'flag' => 1,
            'message' => 'User deactivated!',
        ];

        return response()->json($response);

    }

    public function update(Request $request,$id)
    {

        $user_table = User::find($id);

        $user_profile_table = User_profile::find($id);        

        if($user_table->username != $request->update_username){
            $validated_update = $request->validate([
                'update_username' => 'unique:users,username|required|max:60',
                'update_password' => 'nullable|max:60',
                'update_fname' => 'required|max:60',
                'update_mname' => 'nullable|max:60',
                'update_lname' => 'required|max:60',
                'update_age' => 'required|integer',
                'update_gender' => 'required|max:60',
                'update_birthday' => 'required|max:60',
                'update_address' => 'required',
                'update_email' => 'required|email|max:60',
                'update_mobile_number' => 'required|numeric',
                //'update_role' => 'required'
            ]);
        }
        else{
            $validated_update = $request->validate([
                'update_username' => 'required|max:60',
                'update_password' => 'nullable|max:60',
                'update_fname' => 'required|max:60',
                'update_mname' => 'nullable|max:60',
                'update_lname' => 'required|max:60',
                'update_age' => 'required|integer',
                'update_gender' => 'required|max:60',
                'update_birthday' => 'required|max:60',
                'update_address' => 'required',                
                'update_email' => 'required|email|max:60',
                'update_mobile_number' => 'required|numeric',
                'update_role' => 'required'
            ]);
        }

        $user_table->username = $validated_update['update_username'];

        if($validated_update['update_password']!=''){
            $user_table->password = Hash::make($validated_update['update_password']);
        }
        
        $user_table->role = $validated_update['update_role'];

        

        $user_profile_table->fname = $validated_update['update_fname'];
        $user_profile_table->mname = $validated_update['update_mname'];
        $user_profile_table->lname = $validated_update['update_lname'];
        $user_profile_table->age = $validated_update['update_age'];
        $user_profile_table->gender = $validated_update['update_gender'];
        $user_profile_table->birthday = $validated_update['update_birthday'];
        $user_profile_table->address = $validated_update['update_address'];
        $user_profile_table->email = $validated_update['update_email'];
        $user_profile_table->mobile_number = $validated_update['update_mobile_number'];
        
        if($user_table->save() && $user_profile_table->save()){
            $response = [
                'flag' => 200,
                'message' => 'User updated succesfully!',
            ];
    
            return response()->json($response);
        
    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $data = [
            'flag' => 1,
            'message' => "User deleted!"
        ];

        return response()->json($data);

    }
}
