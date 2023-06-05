<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Upload extends Model
{
    public static function fileUpload($file_params){

        $current_user = Auth::user()->id;
        $time = time();

        $sizeChecker = self::sizeChecker($file_params);

        if($sizeChecker){
            return $sizeChecker;
        }

        

        foreach($file_params as $key => $value ){

            $raw_filename = $value['filename'];
            $exploded_filename = explode(".",$raw_filename);
            $name_hash = $current_user."_".$time."_".base64_encode($exploded_filename[0]);
            $extension = $exploded_filename[1];

            $final_filename = $name_hash.".".$extension;

            if(move_uploaded_file($value['tmp_name'],$value['location'].$final_filename)){
                return $value;
            }else{
                return "hindi";
            }

        }



        //
        // if(isset($_FILES['file']['name'])){

        //     /* Getting file name */
        //     $filename = $_FILES['file']['name'];

        //     //return $user;
        //     /* Location */
        //     $location = "uploads/system_files/".$request['request_dir']."/".$filename;
        //     $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
        //     $imageFileType = strtolower($imageFileType);
        
        //     /* Valid extensions */
        //     $valid_extensions = array("pdf");
        
        //     $response = 0;
        //     /* Check file extension */
        //     if(in_array(strtolower($imageFileType), $valid_extensions)) {
        //         /* Upload file */
        //         if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
        //             $user = $request->user()->id;
        //             $qry = Client::where('user_profile_id',$user)->update(['resume_link'=>$filename]);
        //             $response = $location;
        //         }
        //     }
            
        //     $response = [
        //         'flag' => 1,
        //         'message' => 'Resume Uploaded!'
        //     ];

        //     return response()->json($response);
        
        // }
    }

    static function sizeChecker($file_params){

        $errors = array();
        $image_err = array();
        $document_err = array();

        foreach($file_params as $key => $value ){

            $raw_filename = $value['filename'];
            $exploded_filename = explode(".",$raw_filename);
            $extension = $exploded_filename[1];
            $filesize = $value['filesize'];
            $file_type = $value['type'];

            if($file_type === 'image'){
                
                if($filesize > env('IMAGE_ALLOWED_SIZE')){
                    $image_err [] = ($raw_filename." image file size if larger than the allowed value (".env('IMAGE_ALLOWED_SIZE').")");
                    $errors ['image'] = $image_err; 
                }

            }else if ($type === 'document'){
                $document_err [] = ($raw_filename." image file size if larger than the allowed value (".env('IMAGE_ALLOWED_SIZE').")");
                $errors ['document'] = $document_err; 
            }

        }

        if(!empty($errors)){

            return array(
                'message' => "Invalid file size.",
                'errors' => $errors
            );
        }

        return false;

    }

    static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

}
