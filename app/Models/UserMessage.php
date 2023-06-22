<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'cellphone',
        'msg',
        'status'
    ];
 
}
