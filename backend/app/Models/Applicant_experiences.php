<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Applicant_experiences extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_name',
        'position',
        'from',
        'to',
    ];
}
