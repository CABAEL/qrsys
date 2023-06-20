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

        $current_user_id = Auth::user()->id;
        $current_user = Client::select('client_id','client_name')
        ->find($current_user_id);

        $folder_name = md5($current_user['client_name']);

        
        // return $request->file_upload;
        if($request->has('file_upload')){

            $request->validate([
                'files1.*' => 'required|file|max:2048|mimetypes:application/pdf,image/jpeg,image/png,image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/x-mspublisher,application/vnd.ms-excel.sheet.binary.macroenabled.12,application/vnd.ms-excel.sheet.macroenabled.12,application/vnd.ms-powerpoint.presentation.macroenabled.12,application/vnd.ms-word.document.macroenabled.12',
                'files2.*' => 'required|file|max:2048|mimetypes:application/pdf,image/jpeg,image/png,image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/x-mspublisher,application/vnd.ms-excel.sheet.binary.macroenabled.12,application/vnd.ms-excel.sheet.macroenabled.12,application/vnd.ms-powerpoint.presentation.macroenabled.12,application/vnd.ms-word.document.macroenabled.12',
            ]);


            $files1 = $request->file('files1')?$request->file('files1'):[];
            $files2 = $request->file('files2')?$request->file('files2'):[];
            

            $fileContainer = array();

            $uploaded_files_path = env('CLIENT_DIR_PATH').$folder_name."/file_uploads/";

            if (!file_exists($uploaded_files_path)) {
                mkdir($uploaded_files_path, 0777, true);
            }

            foreach ($files1 as $file) {
                // Process each uploaded file
                if ($file->isValid()) {
                    // Get the file name, size, and type
                    $filename = $file->getClientOriginalName();
                    $filesize = $file->getSize();
                    $filetype = $file->getClientMimeType();
                    
                    // Move the file to a desired location
                    $file->move(public_path($uploaded_files_path), $filename);
                    
                    // Store the file details in an array
                    $fileContainer[] = [
                        'name' => $filename,
                        'size' => $filesize,
                        'type' => $filetype,
                        // Add any other relevant information
                    ];
                    
                    // Perform further operations with the file
                }
            }

            foreach ($files2 as $file) {
                // Process each uploaded file
                if ($file->isValid()) {
                    // Get the file name, size, and type
                    $filename = $file->getClientOriginalName();
                    $filesize = $file->getSize();
                    $filetype = $file->getClientMimeType();
                    
                    // Move the file to a desired location
                    $file->move(public_path($uploaded_files_path), $filename);
                    
                    // Store the file details in an array
                    $fileContainer[] = [
                        'name' => $filename,
                        'size' => $filesize,
                        'type' => $filetype,
                        // Add any other relevant information
                    ];
                    
                    // Perform further operations with the file
                }
            }

            return $fileContainer;


        }else{

            $validatedData = $request->validate([
                'file' => 'required|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,pub,xlsb,xlsm,pptm,docm',
            ]);

            $logo_path = env('CLIENT_DIR_PATH').$folder_name."/logo/";
    
            if (!file_exists($logo_path)) {
                mkdir($logo_path, 0777, true);
            }
    
            $file_params = array();

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

}
