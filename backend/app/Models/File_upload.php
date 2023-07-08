<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File_upload extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable = [
        'client_id',
        'file_group_id',
        'document_code_id',
        'file_name',
        'password',
        'blob_qr',
        'uploaded_by',
    ];

}
