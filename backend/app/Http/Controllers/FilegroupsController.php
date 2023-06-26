<?php

namespace App\Http\Controllers;

use App\Models\File_group;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class FilegroupsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        
        $requestor = User::select('users.id','users.status','users.username','clients.client_id')
        ->join('clients', 'users.id', '=', 'clients.user_id')->where('users.id','=',$user_id)
        ->first();

        $file_groups = File_group::where('client_id',$requestor->client_id)->get();


        if($file_groups){
            return responseBuilder('Successfully fetch!',[],$file_groups);
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

        $user_id = Auth::user()->id;

        $requestor = User::select('users.id','users.status','users.username','clients.client_id')
        ->join('clients', 'users.id', '=', 'clients.user_id')->where('users.id','=',$user_id)
        ->first();
        
        $validated_user = $request->validate([
            'group_name' => 'unique:file_groups,group_name|required|max:60',
            'description' => 'nullable',
        ]);


        $user_creds = File_group::create([
            'client_id' => $user_id,
            'group_name' => $validated_user['group_name'],
            'description' => $validated_user['description'],
            'created_by' => $requestor->client_id,
        ]);

        if($user_creds){
            return responseBuilder('Successfully added!',[],$user_creds);
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
            return responseBuilder('Successfully added!',[],$filegroup);
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
        $validated_user = $request->validate([
            'group_name' => 'unique:file_groups,group_name|required|max:60',
            'description' => 'nullable',
        ]);
        
        $user_id = Auth::user()->id;

        $requestor = User::select('users.id','users.status','users.username','clients.client_id')
        ->join('clients', 'users.id', '=', 'clients.user_id')->where('users.id','=',$user_id)
        ->first();

        $update_filegroup = File_group::update([
            'client_id' => $user_id,
            'group_name' => $validated_user['group_name'],
            'description' => $validated_user['description'],
            'created_by' => $requestor->client_id,
        ]);

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
