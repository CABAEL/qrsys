<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasFactory,SoftDeletes;

    //protected $primaryKey = 'client_id';

    protected $fillable = [
        'client_id',
        'user_id',
        'client_name',
        'address',
        'contact_no',
        'email',
        'description',
        'logo',
        'created_by'
    ];

    public function user () : BelongsTo{
        return $this->belongsTo(User::class,'user_id','id');
    }
}
