<?php

namespace App\Http\Controllers;
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
            ->join("clients",'clients.user_id','=','users.id','inner')
            ->where('id', '!=' , $current_user)
            ->where('users.status','!=',0)
            ->where('users.deleted_at','=',null)
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
        $fetch = User::select('users.id','users.username','clients.*')
        ->join('clients', 'users.id', '=', 'clients.user_id')->where('users.id','=',$id)
        ->first();
        
        $user = $fetch;
        return response()->json($user);
    }

    public function storeClient(Request $request) 
    {


        $validated_user = $request->validate([
            'address' => 'required',
            'email' => 'required|email|max:60',
            'description' => 'nullable',
            'contact_number' => 'required|numeric',
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

        // $select = Client::with(['user' => function($query){
        //     $query->where('status',1);
        // }])
        // //->where('user.status','=',1)
        // ->get();


        $clients = User::join('clients', 'users.id', '=', 'clients.user_id')
        ->select('clients.*', 'users.id')
        ->where('users.role','client')
        ->where('users.status',1)
        ->get();

        return responseBuilder("Successfully loaded.",[],$clients);


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

        // ->update([
        //     'username' => $validated_user['username'],
        //     'password' => Hash::make($validated_user['password']),
        // ]);
        
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

            
            $merge_data = [
                'user' => $user_creds,
                'client_profile' => $client,
                'logo' => $logo_file
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
