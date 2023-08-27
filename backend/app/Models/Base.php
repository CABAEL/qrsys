<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Base extends Model
{
    use HasFactory;

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


    public static function serviceInfo($operation,$data){
       
        if(Auth::user()->id){
            $user_id =Auth::user()->id;
            $created_by = $user_id;
        }else{
            $created_by = 'system';
        }

        $logs = Service_report::create([
            'report_name' => $operation,
            'data' => json_encode($data),
            'created_by' => $created_by
        ]);

        if($logs){
            return responseBuilder('Success','log added!',[],$logs);
        }

        return false;
        
    }

}
