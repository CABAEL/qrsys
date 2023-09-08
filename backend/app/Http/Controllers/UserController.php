<?php

namespace App\Http\Controllers;
use App\Models\Base;
use App\Models\Client_user;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\User_profile;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

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

            $request = DB::table('users')
            ->select('users.id','users.status','clients.*')
            ->join("clients",'clients.user_id','=','users.id','inner')
            ->where('id', '!=' , $current_user)
            ->where('users.deleted_at','=',null)
            ->where('users.role','=','client')
            ->orderBy('users.created_at','DESC')
            ->get();
            
            $data = [
                'response_time' => LARAVEL_START,
                'count' => is_array($request)?count($request):0,
                'data' => $request,
            ];
        }

        if(Auth::user()->role == "client"){

            $current_user = Auth::user()->id;


            $request = DB::table('users')
            ->select('users.id','users.status','client_users.*')
            ->join("client_users",'client_users.client_user_id','=','users.id','inner')
            ->where('id', '!=' , $current_user)
            ->where('users.deleted_at','=',null)
            ->where('users.role','=','user')
            ->where('client_users.client_user_id','=',$current_user)
            ->orderBy('users.created_at','DESC')
            ->get();
            
            $data = [
                'response_time' => LARAVEL_START,
                'count' => is_array($request)?count($request):0,
                'data' => $request,
            ];
        }

       return response()->json($data);

    }

    public function activate($id)
    {
        $request = User::find($id);
        $request->status = 1;
        $request->save();

        $message = "[".strtoupper(Auth::user()->role).'] : ['.Auth::user()->id.'] has activate admin ID : ['.$id.']';
        Base::serviceInfo($message,Base::ACTIVATE_ADMIN,$request);

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

        $fetch_user = User::where('id','=',$id)->first();

        $fetch = [];
        if($fetch_user->role == 'admin'){
            $fetch = User::select('users.id','users.status','users.username','admin_users.*')
            ->join('admin_users', 'users.id', '=', 'admin_users.user_id')->where('users.id','=',$id)
            ->first();
        }
        if($fetch_user->role == 'client'){
            
            $fetch = User::select('users.id','users.status','users.username','clients.*')
            ->join('clients', 'users.id', '=', 'clients.user_id')->where('users.id','=',$id)
            ->first();
        }
        if($fetch_user->role == 'user'){
            
            $fetch = User::select('clients.client_name','users.id','users.status','users.username','client_users.*')
            ->join('client_users', 'users.id', '=', 'client_users.user_id')->where('users.id','=',$id)
            ->join('clients', 'clients.client_id', '=', 'client_users.client_id')
            ->first();
        }
        
        return response()->json($fetch);
    }

    public function storeUser(Request $request) 
    {

        $current_client = Auth::user()->id;
        $current_clientInfo = Client::where('user_id',$current_client)->first();


        $validated_user = $request->validate([
            'fname' => 'required|max:60',
            'mname' => 'nullable|max:60',
            'lname' => 'required|max:60',
            'lastname' => 'nullable',
            'filegroups' => 'required|not_in:null',
            'address' => 'required',
            'email' => 'required|email|max:60',
            'description' => 'nullable',
            'contact_number' => 'required|numeric',
            'username' => 'unique:users,username|required|max:60',
            'password' => 'required|confirmed|max:60|min:8',
        ]);

        $folder_name = md5($current_clientInfo->client_name);
        $logo_path = env('CLIENT_DIR_PATH').$folder_name."/user_pictures/";

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
                return responseBuilder('Error',$add_logo->message,$add_logo->errors,[]);
            }
        }

        $merge_data = array();

        $user_creds = User::create([
            'username' => $validated_user['username'],
            'password' => Hash::make($validated_user['password']),
            'role' => 'user',
            'created_by' => $current_client
        ]);

        $user_id = $user_creds->id;
        
        if($user_creds){

            $client_profile = Client_user::create([
                'user_id' => $user_id,
                'client_id' => $current_clientInfo->client_id,
                'fname' => $validated_user['fname'],
                'mname' => $validated_user['mname'],
                'lname' => $validated_user['lname'],
                'file_group_id' => $validated_user['filegroups'],
                'address' => $validated_user['address'],
                'contact_no' => $validated_user['contact_number'],
                'email' => $validated_user['email'],
                'description' => $validated_user['description'],
                'created_by' => $current_client
            ]);

            if(isset($request->logo)){
                $select_client_user = Client_user::where('user_id',$user_id)
                ->update(['picture' => $add_logo->data[0]]);
            }
            
            $merge_data = [
                'user' => $user_creds,
                'user_profile' => $client_profile,
                'picture' => isset($add_logo->data[0])?$add_logo->data[0]:""
            ];

            $message = "[".strtoupper(Auth::user()->role).'] : ['.Auth::user()->id.'] has added new user ['.$validated_user['username'].']';
            Base::serviceInfo($message,Base::ADD_CLIENT_API_ACCESS,$merge_data);

            return responseBuilder('Success',"User successfully added!",[],$merge_data);
            
        }

        return responseBuilder('Error',"Invalid request.",array('User' => "Unable to add."),$merge_data);

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

        if($user_table->save()){

            $message = "[".strtoupper(Auth::user()->role).'] : ['.Auth::user()->id.'] has deactivated admin ID : ['.$id.']';
            Base::serviceInfo($message,Base::DEACTIVATE_ADMIN,$user_table);

            return responseBuilder("User Deactivated!",[],$user_table);
        }


    }

    public function updateClient(Request $request,$id)
    {
        $current_user = Auth::user();

        $validated_user = $request->validate([
            'address' => 'required',
            'email' => 'required|email|max:60',
            'description' => 'nullable',
            'contact_number' => 'nullable|numeric|digits_between:7,13',
            'client_name' => [
                'required',
                'max:100',
                Rule::unique('clients')->ignore($request['client_name'], 'client_name')
            ],
            'username' => 
            [
                'required',
                'max:60',
                Rule::unique('users')->ignore($request['username'], 'username')
            ]
            ,
            'password' =>             [
                'nullable',
                'max:60',
                'confirmed',
                Rule::unique('users')->ignore($request['password'], 'password')
            ],
        ]);

        $merge_data = array();

        $user_creds = User::find($id);
        $old_user_creds = $user_creds;
        if($validated_user['username'] != "" ){
            $user_creds->username = $validated_user['username'];
        }

        if($validated_user['password'] !=""){
            $user_creds->password = Hash::make($validated_user['password']);
        }

        $user_creds->save();
        $new_user_creds = $user_creds;
        
        if($user_creds){

            $client = Client::where('user_id', $id)->first();
            if($client){
                $old_merge_data = [
                    'user' => $old_user_creds,
                    'client_profile' => $client,
                    'logo' => $client->logo
                ];
            }


            $client->where('user_id', $id)->update([
                'client_name' => $validated_user['client_name'],
                'address' => $validated_user['address'],
                'contact_no' => $validated_user['contact_number'],
                'email' => $validated_user['email'],
                'description' => $validated_user['description']
            ]);

            //return $logo_path;
            $logo_file = '';
            if(isset($request->updatelogo)){
                if($request->updatelogo != ''){
                    // $folder_name = md5($validated_user['client_name']);
                    $logo_path = env('CLIENT_DIR_PATH')."logo/";
    
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

                    if (File::exists($logo_path.$client->logo)) {
                        File::delete($logo_path.$client->logo);
                    }

                    $client->where('user_id',$id)->update(['logo' => $add_logo->data[0]]);

                    $logo_file = $add_logo->data[0];
                }
            }

            $new_client_data = Client::where('user_id', $id)->first();

            $merge_data = [
                'user' => $new_user_creds,
                'client_profile' => $new_client_data,
                'logo' => $new_client_data->logo
            ];

            $message = '['.strtoupper($current_user->role).'] : ['.$current_user->username.'] : ['.$current_user->id.'] has updated client information for client id: ('.$client->client_name.')';
            Base::serviceInfo($message,Base::UPDATE_CLIENT,array('from' => $old_merge_data,'to' => $merge_data));


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
        $user = User::find($id);
        $user->delete();

        $message = "[".strtoupper(Auth::user()->role).'] : ['.Auth::user()->id.'] has deleted admin ID : ['.$id.']';
        Base::serviceInfo($message,Base::DELETE_ADMIN,$user);

        $data = [
            'flag' => 1,
            'message' => "User deleted!"
        ];

        return response()->json($data);

    }


    public static function myAccountView($id){

        $user = User::where('id',$id)->first();
        
        if($user->role == 'client'){

            $fetch = User::select('clients.*','users.role','users.id','users.status','users.username')
            ->join('clients','users.id','=','clients.user_id')
            ->where('users.id',$id)
            ->first();

            if($fetch){
                $data = array(
                    'data' => $fetch,
                    'img_path' => env('CLIENT_DIR_PATH').'logo'
                );
    
                return responseBuilder('Success','Successfully fetch!',[],$data);
            }

            return false;

        }else if($user->role == 'user'){

            $fetch = User::select('client_users.*','users.role','users.id','users.status','users.username')
            ->join('client_users','users.id','=','client_users.user_id')
            ->where('users.id',$id)
            ->first();

            $select_client = Client::select('client_name')->where('client_id',$fetch->client_id)->first();

            if($fetch){
                $data = array(
                    'data' => $fetch,
                    'img_path' => env('CLIENT_DIR_PATH').md5($select_client->client_name)
                );
    
                return responseBuilder('Success','Successfully fetch!',[],$data);
            }
            
        }else if($user->role == 'admin'){

        }else{
            return false;
        }

    }

}
