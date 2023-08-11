<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Client_user;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
class ClientUsersController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $fetch = User::select('clients.client_name','users.id','users.status','users.username','client_users.*')
        ->join('client_users','users.id','=','client_users.user_id')
        ->join('clients','client_users.client_id','=','clients.client_id')
        ->where('users.id',$id)
        ->first();

        if($fetch){
            return $fetch;
        }

        return false;
    }

    public function activeClientUsers(){

        $current_user = Auth::user();
        $client = $current_user->client_data;
        //return json_encode($client);

        $client_users = User::select('client_users.*', 'users.id','users.username','users.status')
        ->join('client_users', 'client_users.user_id', '=', 'users.id')
        ->where('users.role','user')
        //->where('users.status',1)
        ->where('client_users.client_id',$client->client_id)
        ->get();

        if($client_users){
            return responseBuilder("Success","Successfully loaded.",[],$client_users);
        }

        return false;
        

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
            'filegroups' => 'required',
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

            $client_user = Client_user::where('user_id', $id)->first();

            $client_user->where('user_id', $id)
            ->update([
                'fname' => $validated_user['fname'],
                'mname' => $validated_user['mname'],
                'lname' => $validated_user['lname'],
                'file_group_id' => $validated_user['filegroups'],
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

                    if (File::exists($logo_path.$client_user->picture)) {
                        File::delete($logo_path.$client_user->picture);
                    }
                
                    $client_user_pic = Client_user::where('user_id', $id)->update(['picture' => $add_logo['responseJSON']['data'][0]]);
                    $logo_file = $add_logo['responseJSON']['data'][0];
                }
            }


            $merge_data = [
                'user' => $user_creds,
                'user_profile' => $client_user,
                'picture' => $client_user->picture
            ];

            return responseBuilder("Success","User successfully added!",[],$merge_data);
            
        }

        return responseBuilder("Error","Invalid request.",array('User' => "Unable to update."),$merge_data);
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
    public function update(Request $request, $id)
    {
        //
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
}
