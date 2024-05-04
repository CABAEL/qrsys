<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\File_upload;
use Illuminate\Http\Request;
use App\Models\Document_code;
use Illuminate\Support\Facades\Auth;

class Document_CodeController extends Controller
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

    public function list()
    {
        $current_user_auth = Auth::user();
        $current_user = '';

        if($current_user_auth->role == 'client'){
            // identifying client
            $current_user = $current_user_auth->client_data;
            $client_id = $current_user['client_id'];

        }else if($current_user_auth->role == 'user'){
            // identifying user
            $current_user = $current_user_auth->client_users_data;
            $client_id = $current_user['client_id'];

        }else{

            return abort('404','You are not a User or Client!');

        }

        $fetch_document_list = Document_code::where('client_id',$client_id)->get();

        if($fetch_document_list){
            return responseBuilder('Successfully fetch!',[],$fetch_document_list);
        }

        return false;

    }

    public function CodeDocuments($id)
    {
        
        $fetch_document_code = File_upload::where('document_code_id',$id)->get();

        if($fetch_document_code){
            return responseBuilder('Successfully fetch!',[],$fetch_document_code);
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
