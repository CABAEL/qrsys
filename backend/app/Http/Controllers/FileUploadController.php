<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Document_code;
use App\Models\File_upload;
use App\Models\PDFcore;
use App\Models\RedisModel;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class FileUploadController extends Controller
{
    //
    public function uploadFile(Request $request){
        //max file size in KB; 1024 is equivalent to 1kb
        $env_max_file_size = env('MAX_FILE_SIZE') / 1024;
        $formatted_max_file_size = Upload::formatSizeUnits(env('MAX_FILE_SIZE'));

        $current_user_auth = Auth::user();
        $current_user = '';
        $folder_name = '';
        $select_client = null;
        if($current_user_auth->role == 'client'){
            // identifying client
            $current_user = $current_user_auth->client_data;
            $current_user_id = $current_user['user_id'];
            $select_client = Client::where('client_id',$current_user['client_id'])->first();
            $folder_name = md5($current_user['client_name']);

        }else if($current_user_auth->role == 'user'){
            // identifying user
            $current_user = $current_user_auth->client_users_data;
            $current_user_id = $current_user['user_id'];
            $select_client = Client::find( $current_user['client_id'])->first();
            $folder_name = md5($select_client['client_name']);

        }else{

            return abort('404','You are not a User or Client!');

        }

        if($request->has('file_upload')){

            $pdf_file = $request->file('pdf_file')?$request->file('pdf_file'):[];
            //$files2 = $request->file('files2')?$request->file('files2'):[];

                $validated_inputs = $request->validate([
                    'filegroups' => 'required',
                    'code' => 'required',
                    'description' => 'nullable',
                    'password' => ['nullable', 'regex:/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9]).{6}$/'],
                    'pdf_file' => [
                        'required',
                        'file',
                        function ($attribute, $value, $fail) use ($env_max_file_size, $formatted_max_file_size) {
                            $fileName = $value->getClientOriginalName();
                            $extension = $value->getClientOriginalExtension();
                            
                            if ($extension !== 'pdf') {
                                $fail('The file "'.$fileName.'" must be a file of type: application/pdf.');
                            } elseif (($value->getSize() / 1024) > $env_max_file_size) {
                                $fail('The file "'.$fileName.'" is greater than '.$formatted_max_file_size.'.');
                            }
                        },
                    ],
                ],
                [
                    'pdf_file.mimetypes' => 'Files selected in files1 must be in PDF format.',
                    'password' => 'File password must be composed of at least 1 uppercase, 1 special character, and 1 number with a character count of 6.',
                ]);
            

            $fileContainer = array();

            // $uploaded_files_path = env('CLIENT_DIR_PATH').$folder_name."/file_uploads/";

            // if (!file_exists($uploaded_files_path)) {
            //     mkdir($uploaded_files_path, 0777, true);
            // }

            //check document code if exist
            $check_code_exist = Document_code::where('code',strtoupper($validated_inputs['code']))->first();

            $code_id = '';

            if($check_code_exist){
                //code exist
                $code_id = $check_code_exist->id;
            }else{

                //code not exist, Create.
                $created_code = Document_code::create([
                    'client_id' => $current_user['client_id'],
                    'code' => strtoupper($validated_inputs['code']),
                    'description' => $validated_inputs['description'],
                    'created_by' => $current_user_id
                ]);

                $code_id = $created_code->id;
                
            }

            //foreach ($pdf_file as $file) {
                // Process each uploaded file
                if ($pdf_file->isValid()) {
                    // Get the file name, size, and type
                    $filename = $pdf_file->getClientOriginalName();
                    $file_explode = explode('.', $filename);
                    $ext = end($file_explode);
                    $filesize = $pdf_file->getSize();
                    $filetype = $pdf_file->getClientMimeType();
                    $formatted_name = $current_user_id . "_" . time() . "_" . str_replace(" ", "_", $file_explode[0]);
            
                    $file_upload = File_upload::create([
                        'client_id' => $current_user['client_id'],
                        'file_group_id' => $validated_inputs['filegroups'],
                        'document_code_id' => $code_id,
                        'file_name' => strtoupper($validated_inputs['code']) . "_" . $formatted_name . "." . $ext,
                        'blob_qr' => '',
                        'password' => $validated_inputs['password'],
                        'uploaded_by' => $current_user_id,
                    ]);

                    RedisModel::updateQueueData(array([
                        'id' => $file_upload['id'],
                        'file_name' => $file_upload['file_name']
                    ]));
                    

                    $cr_code_value = url_host('uploads/system_files/clients_directory/').$folder_name.'/file_uploads'.'/'.$file_upload->file_name;
                    $logopath = 'uploads/system_files/clients_directory/'.'logo'.'/'.$select_client->logo;
                    $file_upload_id = $file_upload->id;

                    PDFcore::generateQrCode($cr_code_value,$logopath,$file_upload_id);
            
                    // Move the file to a desired location
                    $pdf_file->move(storage_path('tmp'), strtoupper($validated_inputs['code']) . '_' . $formatted_name . "." . $ext);
                    // RedisModel::addData('file_list',[$file_upload->id][storage_path('tmp').'/'.strtoupper($validated_inputs['code']) . '_' . $formatted_name . "." . $ext]);
            
                    // Store the file details in an array
                    $fileContainer[] = [
                        'name' => $filename,
                        'size' => $filesize,
                        'type' => $filetype,
                        // Add any other relevant information
                    ];
            
                    // Perform further operations with the file
                }
            //}

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

            return $file_params;

        }
    
    }


    public function totalCount(){
        return File_upload::all()->count();
    }

    public function clientfileList(){
        
        $current_user_auth = Auth::user();

        if($current_user_auth->role == 'client'){

            // identifying client
            $current_user = $current_user_auth->client_data;
            $current_user_id = $current_user['client_id'];

        }else if($current_user_auth->role == 'user'){

            // identifying user
            $current_user = $current_user_auth->client_users_data;
            $current_user_id = $current_user['client_id'];

        }

        $files = File_upload::select('file_uploads.*','users.username')->join('users','file_uploads.uploaded_by','=','users.id')
        ->where('file_uploads.client_id',$current_user_id)->get();

        if($files){
            return responseBuilder('Successfully fetch!',[],$files);
        }
        return false;
    }

}
