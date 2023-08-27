<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Client;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
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
    public function storeClient(Request $request) 
    {
        $current_user = Auth::user();


        $validated_user = $request->validate([
            'address' => 'required',
            'email' => 'required|email|max:60',
            'description' => 'nullable',
            'contact_number' => 'nullable|numeric|digits_between:7,13',
            'client_name' => 'unique:clients|required|max:100',
            'username' => 'unique:users,username|required|max:60',
            'password' => 'required|confirmed|max:60|min:8',
        ]);

        

        //$folder_name = md5($validated_user['client_name']);
        $logo_path = env('CLIENT_DIR_PATH')."/logo/";

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
    
            $add_logo = Upload::fileUpload($file_params)->getData();
            
            if(!empty($add_logo->errors)){
                return responseBuilder('Error',$add_logo['message'],$add_logo['errors'],[]);
            }
        }


        $merge_data = array();

        $user_creds = User::create([
            'username' => $validated_user['username'],
            'password' => Hash::make($validated_user['password']),
            'created_by' => $current_user->id
        ]);

        $user_id = $user_creds->id;
        
        if($user_creds){

            $client_profile = Client::create([
                'user_id' => $user_id,
                'client_name' => $validated_user['client_name'],
                'address' => $validated_user['address'],
                'contact_no' => $validated_user['contact_number'],
                'email' => $validated_user['email'],
                'description' => $validated_user['description'],
                'created_by' => $current_user->id
            ]);

            if(isset($request->logo)){
            $select_client = Client::where('user_id',$user_id)
            ->update(['logo' => $add_logo->data[0]]);
            }
            
            $merge_data = [
                'user' => $user_creds,
                'client_profile' => $client_profile,
                'logo' => isset($add_logo->data[0])?$add_logo->data[0]:""
            ];

            Base::serviceInfo('add_client',array('added_by' => Auth::user()->id,'client' => $client_profile->client_name));

            return responseBuilder("Success","User successfully added!",[],$merge_data);
            
        }

        return responseBuilder("Error","Invalid request.",['User' => "Unable to add."],$merge_data);

    }

    public function activeClients(){

        $clients = User::join('clients', 'users.id', '=', 'clients.user_id')
        ->select('clients.*', 'users.id')
        ->where('users.role','client')
        ->where('users.status',1)
        ->get();


        if($clients){
            return responseBuilder("Success","Successfully loaded.",[],$clients);
        }
        
        return false;

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
