<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class chat extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'from',
        'to',
        'msg',
        'status',
    ];
}
