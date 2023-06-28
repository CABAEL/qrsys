<?php

namespace App\Http\Controllers;
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
        
        $fetch_user = User::where('users.id','=',$id)->first();
        $fetch = [];
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

    public function storeClient(Request $request) 
    {


        $validated_user = $request->validate([
            'address' => 'required',
            'email' => 'required|email|max:60',
            'description' => 'nullable',
            'contact_number' => 'nullable|numeric|digits_between:7,13',
            'client_name' => 'unique:clients|required|max:100',
            'username' => 'unique:users,username|required|max:60',
            'password' => 'required|confirmed|max:60|min:8',
        ]);

        

        $folder_name = md5($validated_user['client_name']);
        $logo_path = env('CLIENT_DIR_PATH').$folder_name."/logo/";

        if (!file_exists($logo_path)) {
            mkdir($logo_path, 0777, true);
        }

        //return $logo_path;

        if(isset($request->logo)){
            $file_params [] = array(
                'filename' => $_FILES['logo']['name'],
                'location' => $logo_path,
                'tmp_name' => $_FILES['logo']['tmp_name'],
                'filesize' => $_FILES['logo']['size']
            );
    
            $add_logo = Upload::fileUpload($file_params);
    
            if(!empty($add_logo['responseJSON']['errors'])){
                return responseBuilder($add_logo['responseJSON']['message'],$add_logo['responseJSON']['errors'],[]);
            }
        }


        $merge_data = array();

        $user_creds = User::create([
            'username' => $validated_user['username'],
            'password' => Hash::make($validated_user['password']),
        ]);

        $user_id = $user_creds->id;
        
        if($user_creds){

            $client_profile = Client::create([
                'user_id' => $user_id,
                'client_name' => $validated_user['client_name'],
                'address' => $validated_user['address'],
                'contact_no' => $validated_user['contact_number'],
                'email' => $validated_user['email'],
                'description' => $validated_user['description']
            ]);

            if(isset($request->logo)){
            $select_client = Client::where('user_id',$user_id)
            ->update(['logo' => $add_logo['responseJSON']['data'][0]]);
            }
            
            $merge_data = [
                'user' => $user_creds,
                'client_profile' => $client_profile,
                'logo' => isset($add_logo['responseJSON']['data'][0])?$add_logo['responseJSON']['data'][0]:""
            ];

            return responseBuilder("User successfully added!",[],$merge_data);
            
        }

        return responseBuilder("Invalid request.",array('User' => "Unable to add."),$merge_data);

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
    
            $add_logo = Upload::fileUpload($file_params);
    
            if(!empty($add_logo['responseJSON']['errors'])){
                return responseBuilder($add_logo['responseJSON']['message'],$add_logo['responseJSON']['errors'],[]);
            }
        }

        $merge_data = array();

        $user_creds = User::create([
            'username' => $validated_user['username'],
            'password' => Hash::make($validated_user['password']),
            'role' => 'user'
        ]);

        $user_id = $user_creds->id;
        
        if($user_creds){

            $client_profile = Client_user::create([
                'user_id' => $user_id,
                'client_id' => $current_client,
                'fname' => $validated_user['fname'],
                'mname' => $validated_user['mname'],
                'lname' => $validated_user['lname'],
                'address' => $validated_user['address'],
                'contact_no' => $validated_user['contact_number'],
                'email' => $validated_user['email'],
                'description' => $validated_user['description']
            ]);

            if(isset($request->logo)){
                $select_client_user = Client_user::where('user_id',$user_id)
                ->update(['picture' => $add_logo['responseJSON']['data'][0]]);
            }
            
            $merge_data = [
                'user' => $user_creds,
                'user_profile' => $client_profile,
                'picture' => isset($add_logo['responseJSON']['data'][0])?$add_logo['responseJSON']['data'][0]:""
            ];

            return responseBuilder("User successfully added!",[],$merge_data);
            
        }

        return responseBuilder("Invalid request.",array('User' => "Unable to add."),$merge_data);

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

    public function activeClients(){

        $clients = User::join('clients', 'users.id', '=', 'clients.user_id')
        ->select('clients.*', 'users.id')
        ->where('users.role','client')
        ->where('users.status',1)
        ->get();

        return responseBuilder("Successfully loaded.",[],$clients);


    }

    public function activeClientUsers(){

        $current_client_id = Auth::user()->id;


        $client_users = User::join('client_users', 'client_users.user_id', '=', 'users.id')
        ->select('client_users.*', 'users.id','users.username','users.status')
        ->where('users.role','user')
        //->where('users.status',1)
        ->where('client_users.client_id',$current_client_id)
        ->get();

        return responseBuilder("Successfully loaded.",[],$client_users);


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
            return responseBuilder("User Deactivated!",[],$user_table);
        }


    }

    public function update(Request $request,$id)
    {

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

        if($validated_user['username'] != "" ){
            $user_creds->username = $validated_user['username'];
        }

        if($validated_user['password'] !=""){
            $user_creds->password = Hash::make($validated_user['password']);
        }

        $user_creds->save();
        
        if($user_creds){

            $client = Client::where('user_id', $id)->first();
            
            $client->update([
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
                    $folder_name = md5($validated_user['client_name']);
                    $logo_path = env('CLIENT_DIR_PATH').$folder_name."/logo/";
    
                    if (!file_exists($logo_path)) {
                        mkdir($logo_path, 0777, true);
                    }
                    
                    $file_params [] = array(
                        'filename' => $_FILES['updatelogo']['name'],
                        'location' => $logo_path,
                        'tmp_name' => $_FILES['updatelogo']['tmp_name'],
                        'filesize' => $_FILES['updatelogo']['size']
                    );
        
                    $add_logo = Upload::fileUpload($file_params);
    
                    if(!empty($add_logo['responseJSON']['errors'])){
                        return responseBuilder($add_logo['responseJSON']['message'],$add_logo['responseJSON']['errors'],[]);
                    }
        
                    $client->update(['logo' => $add_logo['responseJSON']['data'][0]]);
                    $logo_file = $add_logo['responseJSON']['data'][0];
                }
            }

            
            $merge_data = [
                'user' => $user_creds,
                'client_profile' => $client,
                'logo' => $logo_file
            ];

            return responseBuilder("User successfully added!",[],$merge_data);
            
        }

        return responseBuilder("Invalid request.",array('User' => "Unable to update."),$merge_data);


    }


    public function updateClientUser(Request $request,$id)
    {
        $current_client = Auth::user()->id;
        $current_clientInfo = Client::where('user_id',$current_client)->first();

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

            $client = Client_user::where('user_id', $id)->update([
                'fname' => $validated_user['fname'],
                'mname' => $validated_user['mname'],
                'lname' => $validated_user['lname'],
                'address' => $validated_user['address'],
                'contact_no' => $validated_user['contact_number'],
                'email' => $validated_user['email'],
                'description' => $validated_user['description']
            ]);

            $client_user_pic = '';

            if(isset($request->updatelogo)){
                if($request->updatelogo != ''){
                    $folder_name = md5($current_clientInfo->client_name);
                    $logo_path = env('CLIENT_DIR_PATH').$folder_name."/user_pictures/";
    
                    if (!file_exists($logo_path)) {
                        mkdir($logo_path, 0777, true);
                    }
                    
                    $file_params [] = array(
                        'filename' => $_FILES['updatelogo']['name'],
                        'location' => $logo_path,
                        'tmp_name' => $_FILES['updatelogo']['tmp_name'],
                        'filesize' => $_FILES['updatelogo']['size']
                    );
        
                    $add_logo = Upload::fileUpload($file_params);
    
                    if(!empty($add_logo['responseJSON']['errors'])){
                        return responseBuilder($add_logo['responseJSON']['message'],$add_logo['responseJSON']['errors'],[]);
                    }
                    
                    $client_user_pic = Client_user::where('user_id', $id)->update(['picture' => $add_logo['responseJSON']['data'][0]]);
                    $logo_file = $add_logo['responseJSON']['data'][0];
                }
            }


            $merge_data = [
                'user' => $user_creds,
                'user_profile' => $client,
                'picture' => $client_user_pic
            ];

            return responseBuilder("User successfully added!",[],$merge_data);
            
        }

        return responseBuilder("Invalid request.",array('User' => "Unable to update."),$merge_data);
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
