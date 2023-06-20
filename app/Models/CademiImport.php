<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CademiImport extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'status',
        'course',
        'body',
        'code',
        'msg',
    ];
}
