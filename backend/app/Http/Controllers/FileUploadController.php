<?php

namespace App\Http\Controllers;
use App\Models\Applicant_data;
use Illuminate\Http\Request;
use App\Models\User;

class FileUploadController extends Controller
{
    //
    public function uploadResume(Request $request){
            if(isset($_FILES['file']['name'])){

            /* Getting file name */
            $filename = $_FILES['file']['name'];

            //return $user;
            /* Location */
            $location = "upload/resume/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
         
            /* Valid extensions */
            $valid_extensions = array("pdf");
         
            $response = 0;
            /* Check file extension */
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
               /* Upload file */
               if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                $user = $request->user()->id;
                $qry = Applicant_data::where('user_profile_id',$user)->update(['resume_link'=>$filename]);
                  $response = $location;
               }
            }
            
            $response = [
                'flag' => 1,
                'message' => 'Resume Uploaded!'
            ];

            return response()->json($response);
            
         }
    }

}
