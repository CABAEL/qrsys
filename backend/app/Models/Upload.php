<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    public function fileUpload($tmp_name,$location){


        if(move_uploaded_file($tmp_name,$location)){
            return "pasok";
        }else{
            return "hindi";
        }

        //$filename = $file['file']['name'];
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
}
