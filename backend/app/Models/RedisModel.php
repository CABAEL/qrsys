<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class RedisModel extends Model
{
    use HasFactory;


    public static function addData($value){

        $key = 'file_queue';

       $addData = Redis::set($key, $value);
       if($addData){
        return $addData;
       }
       return false;
       
    }

    public function getData(){

        $existingData = Redis::get('file_queue');

        if($existingData){
            return $existingData;
        }else{
            return json_encode([]);
        }
        

    }

    public static function updateQueueData($newData){

        $redisHandler = new RedisModel();
        $existingData = $redisHandler->getData();

        if ($existingData) {
            $existingData = json_decode($existingData, true); // Decode the existing data if necessary
            $updatedData = array_merge($existingData, $newData);

            // return $updatedData;
        } else {
            $updatedData = $newData;
        }
        
        Redis::set('file_queue', json_encode($updatedData));
        return json_encode($updatedData);
    }

}
