<?php

namespace App\Http\Controllers;
use App\Models\App_key;
use App\Models\Base;
use App\Models\Client;
use App\Models\Document_code;
use App\Models\File_upload;
use App\Models\PDFcore;
use App\Models\RedisModel;
use App\Models\Upload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;


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
            $select_client = Client::where('client_id',$current_user['client_id'])->first();
            $folder_name = md5($select_client['client_name']);

        }else{

            return abort('404','You are not a User or Client!');

        }

        if($request->has('file_upload')){

            $pdf_file = $request->file('pdf_file')?$request->file('pdf_file'):[];

                $validated_inputs = $request->validate([
                    'filegroups' => 'required',
                    'code' => 'required|unique:file_uploads,document_code',
                    'description' => 'nullable',
                    'password' => ['nullable', 'regex:/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9]).{6,60}$/'],
                    'pdf_file' => [
                        'required',
                        'file',
                        'mimetypes:application/pdf',
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
                    'password.regex' => 'File password must be composed of at least 1 uppercase, 1 special character, and 1 number with a character count of atleast 6 to 60',
                ]);
            

            $fileContainer = array();

                // Process each uploaded file
                if ($pdf_file->isValid()) {
                    // Get the file name, size, and type
                    $filename = $pdf_file->getClientOriginalName();
                    $file_explode = explode('.', $filename);
                    $ext = end($file_explode);
                    $filesize = $pdf_file->getSize();
                    $filetype = $pdf_file->getClientMimeType();
                    //$formatted_name = $current_user_id . "_" . time() . "_" . str_replace(" ", "_", $file_explode[0]);
                    $formatted_name = str_replace(" ", "_", $file_explode[0]);
            
                    $file_upload = File_upload::create([
                        'client_id' => $current_user['client_id'],
                        'file_group_id' => $validated_inputs['filegroups'],
                        'document_code' => strtoupper($validated_inputs['code']),
                        //'file_name' => strtoupper($validated_inputs['code']) . "_" . $formatted_name . "." . $ext,
                        'file_name' => $formatted_name . "." . $ext,
                        'description' => $validated_inputs['description'],
                        'blob_qr' => '',
                        'password' => $validated_inputs['password'],
                        'uploaded_by' => $current_user_id,
                    ]);

                    if($file_upload){
                        RedisModel::updateQueueData(array([
                            'id' => $file_upload['id'],
                            'client_id' => $file_upload['client_id'],
                            'file_name' => $file_upload['file_name']
                        ]));
    
                        //$cr_code_value = url_host('uploads/system_files/clients_directory/').$folder_name.'/file_uploads'.'/'.$file_upload->file_name;
                        $cr_code_value = url_host('file_info/'.base64_encode($file_upload['id']));
                        $logopath = 'uploads/system_files/clients_directory/'.'logo'.'/'.$select_client->logo;
                        $file_upload_id = $file_upload->id;
    
                        PDFcore::generateQrCode($cr_code_value,$logopath,$file_upload_id);
                
                        // Move the file to a desired location
                        //$pdf_file->move(storage_path('tmp'), strtoupper($validated_inputs['code']) . '_' . $formatted_name . "." . $ext);
                        $pdf_file->move(storage_path('tmp'), $formatted_name . "." . $ext);
    
                        // Store the file details in an array
                        $fileContainer[] = [
                            'name' => $file_upload->file_name,
                            'size' => $filesize,
                            'type' => $filetype
                        ];

                        $message = '['.strtoupper(Auth::user()->role).'] : ['.Auth::user()->id.'] has uploaded new file ID:['.$file_upload['id'].'] ['.$file_upload->file_name.']';
                        Base::serviceInfo($message,Base::FILE_UPLOAD,$file_upload,$fileContainer);

                    }else{
                        return responseBuilder("Error",'File upload error',['File upload error'],[]);
                    }

                }

            return responseBuilder("Success","Successfully uploaded!",[],$fileContainer);


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


    public function APIuploadFile(Request $request){

        //max file size in KB; 1024 is equivalent to 1kb
        $env_max_file_size = env('MAX_FILE_SIZE') / 1024;
        $formatted_max_file_size = Upload::formatSizeUnits(env('MAX_FILE_SIZE'));

        $errors = array();

        if(is_numeric($request->timestamp) && strtotime(date('Y-m-d H:i:s', $request->timestamp)) === (int)$request->timestamp){

            // Get the server's current Unix timestamp using the current date function
            $serverTimestamp = strtotime(date('Y-m-d H:i:s'));

            // Calculate the difference in seconds between the given timestamp and the server's current timestamp
            $difference = $serverTimestamp - $request->timestamp;

            // Check if the difference is less than 60 seconds (1 minute)
            //return $difference >= 60;
            if($difference >= 60){
               $err = ["timestamp" => "Timestamp expired."];
               return responseBuilder("Error","request error.",$err,[]);
            }

        }else{
           $err = ["timestamp" => "Invalid timestamp."];
           return responseBuilder("Error","request error.",$err,[]);
        }



        if($request->has('appkey') && $request->has('appsecret')){

            $validate_keys = App_key::select('clients.*')
            ->join('clients','clients.client_id','=','app_keys.client_id')
            ->where('appkey',$request->appkey)
            ->where('appsecret',$request->appsecret)
            ->first();

            $errors = array();
            if(!$validate_keys){
                return responseBuilder("Error","request error.",['api_access' => 'Access error'],[]);
            }else{

                $current_user_id = $validate_keys['user_id'];
                $select_client = $validate_keys;
                $folder_name = md5($select_client['client_name']);
            }

            $pdf_file = $request->file('pdf_file')?$request->file('pdf_file'):[];

            $validated_inputs = Validator::make($request->all(), [
                'filegroups' => [
                    'required',
                    Rule::exists('file_groups', 'id')->where(function ($query) use ($select_client) {
                        $query->where('client_id', $select_client['client_id']);
                    }),
                ],
                'code' => 'required|unique:file_uploads,document_code',
                'description' => 'nullable',
                'password' => ['nullable', 'regex:/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9]).{6,60}$/'],
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
                'timestamp' => [
                    'required',
                    'integer', // Ensure it's an integer
                    'min:0', // Ensure it's not negative
                    function ($attribute, $value, $fail) {
                        if (strlen($value) !== 10) {
                            $fail('The '.$attribute.' must be a valid Unix Epoch timestamp.');
                        }
                    },
                ],
            ],
            [
                'pdf_file.mimetypes' => 'Files selected in files1 must be in PDF format.',
                'password.regex' => 'File password must be composed of at least 1 uppercase, 1 special character, and 1 number with a character count of atleast 6 to 60',
            ]);
        
            // Check if validation fails
            if ($validated_inputs->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validated_inputs->errors(),
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }

            $fileContainer = array();

                // Process each uploaded file
                if ($pdf_file->isValid()) {
                    // Get the file name, size, and type
                    $filename = $pdf_file->getClientOriginalName();
                    $file_explode = explode('.', $filename);
                    $ext = end($file_explode);
                    $filesize = $pdf_file->getSize();
                    $filetype = $pdf_file->getClientMimeType();
                    //$formatted_name = $current_user_id . "_" . time() . "_" . str_replace(" ", "_", $file_explode[0]);
                    $formatted_name = str_replace(" ", "_", $file_explode[0]);
            
                    $file_upload = File_upload::create([
                        'client_id' => $select_client['client_id'],
                        'file_group_id' => $request->filegroups,
                        'document_code' => $request->code,
                        //'file_name' => strtoupper($request->code) . "_" . $formatted_name . "." . $ext,
                        'file_name' => $formatted_name . "." . $ext,
                        'blob_qr' => '',
                        'description' => $request->description,
                        'password' => $request->password,
                        'uploaded_by' => $current_user_id,
                    ]);

                    RedisModel::updateQueueData(array([
                        'id' => $file_upload['id'],
                        'client_id' => $file_upload['client_id'],
                        'file_name' => $file_upload['file_name']
                    ]));
                    

                    //$cr_code_value = url_host('uploads/system_files/clients_directory/').$folder_name.'/file_uploads'.'/'.$file_upload->file_name;
                    $cr_code_value = url_host('file_info/'.base64_encode($file_upload['id']));
                    $logopath = 'uploads/system_files/clients_directory/'.'logo'.'/'.$select_client->logo;
                    $file_upload_id = $file_upload->id;

                    PDFcore::generateQrCode($cr_code_value,$logopath,$file_upload_id);
            
                    // Move the file to a desired location
                    //$pdf_file->move(storage_path('tmp'), strtoupper($request->code) . '_' . $formatted_name . "." . $ext);
                    $pdf_file->move(storage_path('tmp'), $formatted_name . "." . $ext);
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

                $message = '[CLIENT] : Client ID ['.$validate_keys['client_id'].'] has uploaded new file using API.';
                Base::serviceInfo($message,Base::API_UPLOAD,$file_upload,$validate_keys['user_id']);

            return responseBuilder('success',"Your file is currently being processed. Once the processing is complete, you will find it listed.",[],$fileContainer);


        }else{
            return responseBuilder("error","Both the 'appkey' and 'appsecret' are required.",["access key required"],[]);
        }
    
    }    


    public function totalCount(){
        return File_upload::all()
        ->where('deleted_at','=',null)
        ->count();
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
        ->where('file_uploads.client_id',$current_user_id)
        ->where('file_uploads.status',1)
        ->get();

        if($files){
            return responseBuilder('Success','Successfully fetch!',[],$files);
        }
        return false;
    }


    public function fileInfo($id){

        $id = base64_decode($id);

        $get_file_information = File_upload::select('document_code','file_name','client_id')->find($id);

        if(!$get_file_information)abort(404, 'File Not Found');

        $client = Client::select('client_name')->where('client_id',$get_file_information->client_id)->first();

        $client_folder = md5($client->client_name);

        $file_name = $get_file_information->file_name;

        $file_path = public_path(env('CLIENT_DIR_PATH').$client_folder.'/'.'file_uploads'.'/'.$file_name); 

        if (file_exists($file_path)) {
            // Get file size in bytes
            $file_size = filesize($file_path);
        
            // Get the MIME type of the file
            $file_mime_type = mime_content_type($file_path);
        
            // Get file last modified timestamp
            $file_last_modified = filemtime($file_path);
        
        } else {
            // Handle the case where the file does not exist
        }


        $file = array(
            'file_name' => $file_name,
            'code' => $get_file_information->document_code,
            'type' => $file_mime_type,
            'size' => Upload::formatSizeUnits($file_size),
        );
    
        return view('template.iframe_views.file_info',compact('file'));
    }

    public function saveFileData(Request $request,$id){

        $validated_inputs = $request->validate([
            'code' => [
                'required',
                Rule::unique('file_uploads', 'document_code')->ignore($request->input('code'), 'document_code'),
            ],
            'description' => 'nullable',
            'password' => ['nullable', 'regex:/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9]).{6,60}$/'],
        ],
        [
            'password.regex' => 'File password must be composed of at least 1 uppercase, 1 special character, and 1 number with a character count of atleast 6 to 60',
        ]);



        $file = File_upload::find($id);

        $file->update([
            'document_code' => $validated_inputs['code'],
            'description' => $validated_inputs['description'],
            'password' => $validated_inputs['password'],
        ]);

        if($file){
            return responseBuilder('Success','Successfully updated!',[],$file);
        }

        return false;

    }

    public function DeleteFile($id) {

        $file = File_upload::find($id)->first();
        
        $file->delete();

        $message = "[".strtoupper(Auth::user()->role).'] : ['.Auth::user()->id.'] has deleted file ID : ['.$id.']';
        Base::serviceInfo($message,Base::DELETE_FILE,$file);
    
        return $file;
    
    }

}
