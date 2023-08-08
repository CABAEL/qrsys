<?php

namespace App\Http\Controllers;

use App\Models\Admin_user;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request) 
    {

        $current_client = Auth::user()->id;
        $current_clientInfo = Admin_user::where('user_id',$current_client)->first();


        $validated_user = $request->validate([
            'fname' => 'required|max:60',
            'mname' => 'nullable|max:60',
            'lname' => 'required|max:60',
            'address' => 'required',
            'email' => 'required|email|max:60',
            'description' => 'nullable',
            'contact_number' => 'required|numeric',
            'username' => 'unique:users,username|required|max:60',
            'password' => 'required|confirmed|max:60|min:8',
        ]);

        $logo_path = env('ADMIN_DIR_PATH')."admin_pictures/";

        if (!file_exists($logo_path)) {
            mkdir($logo_path, 0777, true);
        }

        if(isset($request->logo)){
            $file_params [] = array(
                'filename' => $_FILES['logo']['name'],
                'location' => $logo_path,
                'tmp_name' => $_FILES['logo']['tmp_name'],
                'filesize' => $_FILES['logo']['size']
            );
    
            $add_logo = Upload::fileUpload($file_params)->getData();
    
            if(!empty($add_logo->errors)){
                return responseBuilder("Error",$add_logo->message,$add_logo->errors,[]);
            }
        }

        $merge_data = array();

        $user_creds = User::create([
            'username' => $validated_user['username'],
            'password' => Hash::make($validated_user['password']),
            'role' => 'admin',
            'created_by' => $current_client
        ]);

        $user_id = $user_creds->id;
        
        if($user_creds){

            $admin_profile = Admin_user::create([
                'user_id' => $user_id,
                'client_id' => $current_client,
                'fname' => $validated_user['fname'],
                'mname' => $validated_user['mname'],
                'lname' => $validated_user['lname'],
                'address' => $validated_user['address'],
                'contact_no' => $validated_user['contact_number'],
                'email' => $validated_user['email'],
                'description' => $validated_user['description'],
                'created_by' => $current_client
            ]);

            if(isset($request->logo)){
                $select_admin_user = Admin_user::where('user_id',$user_id)
                ->update(['picture' => $add_logo->data[0]]);
            }
            
            $merge_data = [
                'user' => $user_creds,
                'user_profile' => $admin_profile,
                'picture' => isset($add_logo->data[0])?$add_logo->data[0]:""
            ];

            return responseBuilder("Success","User successfully added!",[],$merge_data);
            
        }

        return responseBuilder("Error","Invalid request.",array('User' => "Unable to add."),$merge_data);

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
    public function updateAdminUser(Request $request, $id)
    {
        // $current_client = Auth::user()->id;
        // // $current_clientInfo = Admin_user::where('user_id',$current_client)->first();

        $validated_user = $request->validate([
            'address' => 'required',
            'email' => 'required|email|max:60',
            'description' => 'nullable',
            'contact_number' => 'nullable|numeric|digits_between:7,13',
            'fname' => [
                'required',
                'max:60',
            ],
            'mname' => [
                'nullable',
                'max:60',
            ],
            'lname' => [
                'required',
                'max:60',
            ],
            'username' => 
            [
                'required',
                'max:60',
                Rule::unique('users')->ignore($request['username'], 'username')
            ]
            ,
            'password' => [
                'nullable',
                'max:60',
                'confirmed',
                Rule::unique('users')->ignore($request['password'], 'password')
            ],
        ]);

        $merge_data = array();

        $user_creds = User::find($id);

        if($validated_user['username'] != "" ){
            $user_creds->username = $validated_user['username'];
        }

        if($validated_user['password'] !=""){
            $user_creds->password = Hash::make($validated_user['password']);
        }

        $user_creds->save();

        if($user_creds){

            $admin_user = Admin_user::where('user_id', $id)->first();

            $admin_user->where('user_id',$id)->update([
                'fname' => $validated_user['fname'],
                'mname' => $validated_user['mname'],
                'lname' => $validated_user['lname'],
                'address' => $validated_user['address'],
                'contact_no' => $validated_user['contact_number'],
                'email' => $validated_user['email'],
                'description' => $validated_user['description']
            ]);

            $admin_user_pic = '';

            if(isset($request->updatelogo)){
                if($request->updatelogo != ''){
                    $logo_path = env('ADMIN_DIR_PATH')."admin_pictures/";
    
                    if (!file_exists($logo_path)) {
                        mkdir($logo_path, 0777, true);
                    }
                    
                    $file_params [] = array(
                        'filename' => $_FILES['updatelogo']['name'],
                        'location' => $logo_path,
                        'tmp_name' => $_FILES['updatelogo']['tmp_name'],
                        'filesize' => $_FILES['updatelogo']['size']
                    );
        
                    $add_logo = Upload::fileUpload($file_params)->getData();
    
                    if(!empty($add_logo->errors)){
                        return responseBuilder("Error",$add_logo->message,$add_logo->errors,[]);
                    }

                    if (File::exists($logo_path.$admin_user->picture)) {
                        File::delete($logo_path.$admin_user->picture);
                    }
                
                    $admin_user_pic = Admin_user::where('user_id', $id)->update(['picture' => $add_logo->data[0]]);
                }
            }


            $merge_data = [
                'user' => $user_creds,
                'user_profile' => $admin_user,
                'picture' => $admin_user->picture
            ];

            return responseBuilder("Success","User successfully added!",[],$merge_data);
            
        }

        return responseBuilder("Error","Invalid request.",array('User' => "Unable to update."),$merge_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function adminList(){

        $current_user = Auth::user();
        
        $data = Admin_user::select('users.id','users.status','admin_users.*')
        ->join("users",'users.id','=','admin_users.user_id')
        ->where('users.role','=','admin')
        ->where('users.deleted_at','=',null)
        ->where('id', '!=' , $current_user->id)
        ->get();
        
        if($data){
            return responseBuilder('Success','Successfully fetch!',[],$data);
        }

        return false;
    }

}
