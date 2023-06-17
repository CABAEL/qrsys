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

        
        $success_count = 0;
        $upload_error = array ();
        $data = array();
    
        foreach($file_params as $key => $value ){

            $raw_filename = $value['filename'];
            $exploded_filename = explode(".",$raw_filename);
            $name_hash = $current_user."_".$time."_".base64_encode($exploded_filename[0]);
            //$extension = $exploded_filename[1];
            $extension =  strtolower(pathinfo($raw_filename, PATHINFO_EXTENSION));

            $final_filename = $name_hash.".".$extension;

            if(move_uploaded_file($value['tmp_name'],$value['location'].$final_filename)){
                
                //success uploads
                $success_count += 1;
                $data [] = $final_filename;

            }else{
                $upload_error [] = $raw_filename." failed to upload";  
            }

        }

        return responseBuilder($success_count." file(s) successfully Uploaded!",$upload_error,$data);

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
            $file_type = self::acceptedFormat($extension);

            if($file_type === 'image'){
                
                if($filesize > env('IMAGE_ALLOWED_SIZE')){
                    $image_err [] = ($raw_filename." image file size is larger than the allowed value (".self::formatSizeUnits(env('IMAGE_ALLOWED_SIZE')).")");
                    $errors ['image'] = $image_err; 
                }

            }else if ($file_type === 'document'){
                $document_err [] = ($raw_filename." image file size is larger than the allowed value (".self::formatSizeUnits(env('IMAGE_ALLOWED_SIZE')).")");
                $errors ['document'] = $document_err; 
            }

        }

        if(!empty($errors)){
            return responseBuilder("Invalid file size.",$errors,$raw_filename);
        }

        return false;

    }

    static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = round(number_format($bytes / 1073741824, 2)) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = round(number_format($bytes / 1048576, 2)) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = round(number_format($bytes / 1024, 2)) . ' KB';
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

    static function acceptedFormat($file){

        $is_image = ['img','jpg','jpeg','png'];
        $is_document = ['docx','xlsx','pptx','pdf'];

        if(in_array($file,$is_image)){

            return "image";

        }else if(in_array($file,$is_document)){

            return "document";

        }else{

            return false;

        }

    }
    
    


}
