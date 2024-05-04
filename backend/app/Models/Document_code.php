<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Document_code extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'client_id',
        'code',
        'description',
        'created_by',
    ];

}
