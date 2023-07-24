<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class RedisModel extends Model
{
    use HasFactory;


    public static function addData($key,$value){
       $addData = Redis::set($key, $value);
       if($addData){
        return $addData;
       }
       return false;
    }

}
