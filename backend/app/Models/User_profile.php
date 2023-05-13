<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_profile extends Model
{
    use HasFactory;
    
    public $incrementing = false;

    protected $fillable = [
        'id',
        'fname',
        'mname',
        'lname',
        'age',
        'gender',
        'birthday',
        'address',
        'email',
        'mobile_number'
    ];

}
