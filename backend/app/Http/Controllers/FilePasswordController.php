<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\File_upload;
use Illuminate\Http\Request;

class FilePasswordController extends Controller
{
    //
    public function VerifyFilePassword($id){
        $file_id = $id;
        return view('file_password',compact('file_id'));
    }
    public function submitFilePassword(Request $request,$id){

        $submitted = md5($request->password);

        $find_file = File_upload::select('file_name','client_id','password')->find($id);

        $file_pass = md5($find_file->password);
       
        if($find_file){
            if($submitted == $file_pass){
                $select_client = Client::select('client_name')->where('client_id',$find_file->client_id)->first();
                $folder_name = md5($select_client->client_name);
                return redirect(url_host('uploads/system_files/clients_directory/').$folder_name.'/file_uploads'.'/'.$find_file->file_name);
            }else{
                return redirect()->back()->with('error', "Password mismatch!");
            }
        }

    }

}
