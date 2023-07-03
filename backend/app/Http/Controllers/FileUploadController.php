<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\File_upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FileUploadController extends Controller
{
    //
    public function uploadFile(Request $request){

        $current_user_auth = Auth::user();
        $current_user = '';

        if($current_user_auth->role = 'client'){
            $current_user = $current_user_auth->client_data;
        }else if($current_user_auth->role = 'user'){
            $current_user = $current_user_auth->client_users_data;
        }else{
            return abort('404','You are not a User or Client!');
        }

        return $current_user;
        // $current_user = Client::select('client_id','client_name')
        // ->find('user_id',$current_user_id);

        $folder_name = md5($current_user['client_name']);

        
        // return $request->file_upload;
        if($request->has('file_upload')){

            $validated_inputs = $request->validate([
                'filegroups' => 'required',
                'code' => 'required',
                'description' => 'nullable',
                'password' => ['nullable', 'regex:/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9]).{6}$/'],
            ],[
                'files1.*' => 'required|file|max:'.env('MAX_FILE_SIZE').'|mimetypes:application/pdf,image/jpeg,image/png,image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/x-mspublisher,application/vnd.ms-excel.sheet.binary.macroenabled.12,application/vnd.ms-excel.sheet.macroenabled.12,application/vnd.ms-powerpoint.presentation.macroenabled.12,application/vnd.ms-word.document.macroenabled.12',
                'files2.*' => 'required|file|max:'.env('MAX_FILE_SIZE').'|mimetypes:application/pdf,image/jpeg,image/png,image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/x-mspublisher,application/vnd.ms-excel.sheet.binary.macroenabled.12,application/vnd.ms-excel.sheet.macroenabled.12,application/vnd.ms-powerpoint.presentation.macroenabled.12,application/vnd.ms-word.document.macroenabled.12',
            ],
            [
                'files1.*.max' => 'Selected files must not be greater than 2048 kilobytes.',
                'files1.*.mimetypes' => 'Files selected must be in one of the following formats: PDF, JPEG, PNG, GIF, Word, Excel, PowerPoint, Publisher.',
                'files2.*.max' => 'Selected files must not be greater than 2048 kilobytes.',
                'files2.*.mimetypes' => 'Files selected must be in one of the following formats: PDF, JPEG, PNG, GIF, Word, Excel, PowerPoint, Publisher.',
                'password' => 'File password must be composed of atleast 1 uppercase, 1 special character and 1 number with a character count of 6.'
            ]);


            $files1 = $request->file('files1')?$request->file('files1'):[];
            $files2 = $request->file('files2')?$request->file('files2'):[];

            if(count($files1) + count($files2) > env("ALLOWED_FILE_COUNT")){
                // Handle the error accordingly, e.g., return a response or redirect with an error message
                abort(400, 'files selected exceeds the allowed count of ('.env("ALLOWED_FILE_COUNT").') files only.');
            }
            

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
                    $file_explode1 = explode('.',$filename);
                    $ext = end($file_explode1);
                    $filesize = $file->getSize();
                    $filetype = $file->getClientMimeType();
                    $formatted_name = $current_user_id."_".time()."_".str_replace(" ","_",$file_explode1[0]);

                    File_upload::create([
                        'client_id' => $current_user['client_id'],
                        'file_group_id' => $validated_inputs['filegroups'],
                        'document_code' => strtoupper($validated_inputs['code']),
                        'file_name' => strtoupper($validated_inputs['code'])."_".$formatted_name.".".$ext,
                        'password' => $validated_inputs['password'],
                        'description' => $validated_inputs['description'],
                        'uploaded_by' => $current_user_id,
                    ]);

                    // Move the file to a desired location
                    $file->move(public_path($uploaded_files_path), strtoupper($validated_inputs['code']).'_'.$formatted_name.".".$ext);
                    
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
                    $file_explode2 = explode('.',$filename);
                    $ext2 = end($file_explode2);
                    $filesize = $file->getSize();
                    $filetype = $file->getClientMimeType();
                    $formatted_name2 = $current_user_id."_".time()."_".str_replace(" ","_",$file_explode2[0]);

                    File_upload::create([
                        'client_id' => $current_user['client_id'],
                        'file_group_id' => $validated_inputs['filegroups'],
                        'document_code' => strtoupper($validated_inputs['code']),
                        'file_name' => strtoupper($validated_inputs['code'])."_".$formatted_name2.".".$ext2,
                        'password' => $validated_inputs['password'],
                        'description' => $validated_inputs['description'],
                        'uploaded_by' => $current_user_id,
                    ]);

                    // Move the file to a desired location
                    $file->move(public_path($uploaded_files_path), strtoupper($validated_inputs['code'])."_".$formatted_name2.".".$ext2);
                    
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


    public function totalCount(){
        return File_upload::all()->count();
    }

    public function clientfileList(){
       $current_user_id = Auth::user()->id;

        $files = File_upload::select('file_uploads.*','users.username')->join('users','file_uploads.uploaded_by','=','users.id')
        ->where('file_uploads.client_id',$current_user_id)->get();

        if($files){
            return responseBuilder('Successfully fetch!',[],$files);
        }
        return false;
    }

}
