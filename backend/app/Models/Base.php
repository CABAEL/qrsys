<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Base extends Model
{
    use HasFactory;

    const ADMIN_LOGGED_IN = 'admin_logged_in';
    const ADMIN_LOGGED_OUT = 'admin_logged_out';
    const CLIENT_LOGGED_IN = 'client_logged_in';
    const CLIENT_LOGGED_OUT = 'client_logged_out';
    const USER_LOGGED_IN = 'user_logged_in';
    const USER_LOGGED_OUT = 'user_logged_out';

    const ADD_ADMIN = 'add_admin';
    const DELETE_ADMIN = 'delete_admin';
    const UPDATE_ADMIN = 'update_admin';

    const ADD_CLIENT = 'add_client';
    const DELETE_CLIENT = 'delete_client';
    const UPDATE_CLIENT = 'update_client';
    const ADD_USER = 'add_user';
    const DELETE_USER = 'delete_user';
    const UPDATE_USER = 'update_user';

    const ADD_CLIENT_API_ACCESS = 'add_client_api_access';

    public static function writeToLogFile($data_params) {
        $data = json_encode($data_params);
        $date_today = date('Y-m-d');
    
        $logFilePath = 'logs' . DIRECTORY_SEPARATOR . $date_today . DIRECTORY_SEPARATOR . 'microservice.log';

        if (Storage::exists($logFilePath)) {
            // Append data to the existing log file
            Storage::append($logFilePath, "[".date('Y-m-d H:i:s')."]".$data);
        } else {
            // Create the log file and add data
            Storage::put($logFilePath, $data);
        
            // Set file permissions to 0750
            if (Storage::exists($logFilePath)) {
                Storage::chmod($logFilePath, 0750);
            }
        }
    }


    public static function serviceInfo($description,$operation,$data){
       
        if(Auth::user()->id){
            $user_id =Auth::user()->id;
            $created_by = $user_id;
        }else{
            $created_by = 'system';
        }

        $logs = Service_report::create([
            'report_name' => $operation,
            'data' => json_encode($data),
            'description' => $description,
            'created_by' => $created_by
        ]);

        if($logs){
            return responseBuilder('Success','log added!',[],$logs);
        }

        return false;
        
    }

}
