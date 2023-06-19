<?php

namespace App\Http\Controllers;
use App\Models\Applicant_data;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FileUploadController extends Controller
{
    //
    public function uploadFile(Request $request){

        $validatedData = $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,pub,xlsb,xlsm,pptm,docm',
        ]);

        $file_params = array();

        $current_user_id = Auth::user()->id;
        $current_user = Client::select('client_id','client_name')
        ->find($current_user_id);

        $folder_name = md5($current_user['client_name']);

        $logo_path = env('CLIENT_DIR_PATH').$folder_name."/logo/";

        if (!file_exists($logo_path)) {
            mkdir($logo_path, 0777, true);
        }

        foreach($request->file as $file_k => $file_v){
            $file_params [] = array(
                'filename' => $_FILES['file']['name'],
                'location' => $logo_path,
                'tmp_name' => $_FILES['file']['tmp_name'],
                'filesize' => $_FILES['file']['size']
            );
        }

    
    }

}
