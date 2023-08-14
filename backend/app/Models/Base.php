<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Base extends Model
{
    use HasFactory;

    public static function writeToLogFile($data) {
        $date_today = date('Y-M-D');
        $logFilePath = storage_path('logs/'.$date_today.'/microservice.log');
    
        if (Storage::exists($logFilePath)) {
            // Append data to the existing log file
            Storage::append($logFilePath, $data);
        } else {
            // Create the log file and add data
            Storage::put($logFilePath, $data);
        }
    }

}
