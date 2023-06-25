<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client_user extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
        'name',
        'contact_no',
        'email',
        'address',
        'description',
    ];

}
