<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class App_key extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'client_id',
        'description',
        'appkey',
        'appsecret',
        'created_by',
    ];
}