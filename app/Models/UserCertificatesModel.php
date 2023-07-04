<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCertificatesModel extends Model
{
    use HasFactory;
    protected $fillable = [
            'type',
            'name',
            'hours',
            'content',
            'body'
    ];
}
