<?php

namespace App\Http\Controllers;

use App\Models\App_key;
use App\Models\Base;
use App\Models\Client;
use App\Models\File_group;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
class FilegroupsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user();
        
        $requestor_client = $user_id->client_data;

        $file_groups = File_group::where('client_id',$requestor_client->client_id)->get();


        if($file_groups){
            return responseBuilder('Success','Successfully fetch!',[],$file_groups);
        }

        return false;
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

        $user_id = Auth::user();

        $requestor_client = $user_id->client_data;
        
        $validated_user = $request->validate([
            'group_name' => 'unique:file_groups,group_name|required|max:60',
            'description' => 'nullable',
        ]);


        $user_creds = File_group::create([
            'client_id' => $requestor_client->client_id,
            'group_name' => $validated_user['group_name'],
            'description' => $validated_user['description'],
            'created_by' => $requestor_client->client_id,
        ]);


        if($user_creds){

            $message = "[".strtoupper($user_id->role).'] : ['.$user_id->username.'] : ['.$user_id->id.'] has added new file group.';
            Base::serviceInfo($message,Base::ADD_FILEGROUP,$user_creds);

            return responseBuilder('Success','Successfully added!',[],$user_creds);
        }

        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $filegroup = File_group::where('id',$id)->first();
        if($filegroup){
            return responseBuilder('Success','Successfully added!',[],$filegroup);
        }
        return false;
    }


    public function showFilegroups(){
        $user = Auth::user();
       
        if($user->role == "client"){
            $requestor = User::select('users.id','users.status','users.username','clients.client_id')
            ->join('clients', 'users.id', '=', 'clients.user_id')->where('users.id','=',$user->id)
            ->first();
        }else if($user->role == "user"){
            $requestor = User::select('users.id','users.status','users.username','client_users.client_id','client_users.file_group_id')
            ->join('client_users', 'users.id', '=', 'client_users.user_id')->where('users.id','=',$user->id)
            ->first();
        }

        if($user->role == "client"){
            $filegroups = File_group::where('client_id',$requestor->client_id)->get();
        }
        if($user->role == "user"){
            $filegroups = File_group::where('client_id',$requestor->client_id)
            ->where('id',$requestor->file_group_id)
            ->get();
        }

        if($filegroups){
            return responseBuilder('Success','Successfully fetch!',[],$filegroups);
        }
        
        return false;

    }


    public function ApishowFilegroups(Request $request){

        $errors = array();
        if(!isset($request->timestamp)){
            $errors [] = ['timestamp' => "Timestamp is required."];
        }
        if(is_numeric($request->timestamp) && strtotime(date('Y-m-d H:i:s', $request->timestamp)) === (int)$request->timestamp){

            // Get the server's current Unix timestamp using the current date function
            $serverTimestamp = strtotime(date('Y-m-d H:i:s'));

            // Calculate the difference in seconds between the given timestamp and the server's current timestamp
            $difference = $serverTimestamp - $request->timestamp;

            // Check if the difference is less than 60 seconds (1 minute)
            //return $difference >= 60;
            if($difference >= 60){
                $errors [] = ['timestamp' => "Timestamp expired."];
            }

        }else{
            $errors [] = ['timestamp' => "Invalid Timestamp."];
        }

        if($request->has('appkey') && $request->has('appsecret')){

            $validate_keys = App_key::select('clients.*')
            ->where('appkey',$request->appkey)
            ->join('clients','clients.client_id','=','app_keys.client_id')
            ->where('appsecret',$request->appsecret)
            ->first();

            if(!$validate_keys){
                $errors [] = ['validate_keys' => "request error."]; 
            }

        }else{
            $errors [] = ['appkey_appsecret' => "Both the 'appkey' and 'appsecret' are required."];
        }


        if(empty($errors)){

            $select_client = Client::where('client_id',$validate_keys->client_id)->first();
            
            $user_id = $select_client->user_id;

            $requestor = User::select('users.id','users.status','users.username','clients.client_id')
            ->join('clients', 'users.id', '=', 'clients.user_id')->where('users.id','=',$user_id)
            ->first();
    
            $filegroups = File_group::select("id","group_name","description","created_at")
            ->where('client_id',$requestor->client_id)->get();
    
            if($filegroups){
                return responseBuilder('Success','Successfully fetch!',[],$filegroups);
            }

        }else{
           return responseBuilder('Error','An error occured.',$errors,[]);
        }



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

        $validated_filegroups = $request->validate([
            'group_name' => [
                'required',
                'max:60',
                Rule::unique('file_groups', 'group_name')->ignore($id),
            ],
            'description' => 'nullable',
        ]);
        
        $user_id = Auth::user()->id;

        $requestor = User::select('users.id','users.status','users.username','clients.client_id')
        ->join('clients', 'users.id', '=', 'clients.user_id')->where('users.id','=',$user_id)
        ->first();

        $update_filegroup = File_group::where('id',$id);
        $old_filegroup = $update_filegroup->get();
        $update_filegroup->update([
            'client_id' => $requestor->client_id,
            'group_name' => $validated_filegroups['group_name'],
            'description' => $validated_filegroups['description'],
            'created_by' => $user_id,
        ]);
        $new_filegroup = $update_filegroup->get();

        if($update_filegroup){

            $message = "[".strtoupper(Auth::user()->role).'] : ['.Auth::user()->username.'] : ['.Auth::user()->id.'] has updated file group ID: ['.$id.']';
            Base::serviceInfo($message,Base::UPDATE_FILEGROUP,['from'=> $old_filegroup,'to' => $new_filegroup]);

            return responseBuilder('Success','Successfully updated!',[],$update_filegroup);
        }
        return false;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $user = File_group::find($id);

        $message = "[".strtoupper(Auth::user()->role).'] : ['.Auth::user()->username.'] : ['.Auth::user()->id.'] has deleted file group ID: ['.$id.']';
        Base::serviceInfo($message,Base::UPDATE_FILEGROUP,$user);

        $user->delete();
        $data = [
            'flag' => 1,
            'message' => "File_group deleted!"
        ];

        return response()->json($data);
    }
}
