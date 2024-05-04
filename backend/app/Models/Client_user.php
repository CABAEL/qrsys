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
        'picture',
        'fname',
        'mname',
        'lname',
        'file_group_id',
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

    public function myClient()
    {
        return $this->belongsTo(Client::class,'client_id','client_id');
    }

    public function fileUploads()
    {
        return $this->hasMany(File_upload::class, 'uploaded_by','user_id');
    }
    
}
