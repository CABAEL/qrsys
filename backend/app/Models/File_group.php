<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class File_group extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = [
        'client_id',
        'group_name',
        'description',
        'created_by',
    ];

}
