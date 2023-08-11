<?php

namespace App\Http\Controllers;

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
        $user_id = Auth::user()->id;

        $requestor = User::select('users.id','users.status','users.username','clients.client_id')
        ->join('clients', 'users.id', '=', 'clients.user_id')->where('users.id','=',$user_id)
        ->first();

        $filegroups = File_group::where('client_id',$requestor->client_id)->get();

        if($filegroups){
            return responseBuilder('Success','Successfully fetch!',[],$filegroups);
        }
        return false;

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

        $update_filegroup = File_group::where('id',$id)->update([
            'client_id' => $requestor->client_id,
            'group_name' => $validated_filegroups['group_name'],
            'description' => $validated_filegroups['description'],
            'created_by' => $user_id,
        ]);

        if($update_filegroup){
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
        $user = File_group::find($id);
        $user->delete();
        $data = [
            'flag' => 1,
            'message' => "File_group deleted!"
        ];

        return response()->json($data);
    }
}
