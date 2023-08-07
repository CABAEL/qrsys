<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_key extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'appkey',
        'appsecret',
        'created_by',
    ];
}
