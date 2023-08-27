<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_name',
        'data',
        'created_by',
    ];

}
