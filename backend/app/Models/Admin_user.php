<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_user extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'picture',
        'fname',
        'mname',
        'lname',
        'contact_no',
        'email',
        'address',
        'description',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
