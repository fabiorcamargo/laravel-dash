<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCertificatesCondition extends Model
{
    use HasFactory;

    protected $fillable = [
            'name',
            'user_certificates_models_id',
            'percent',
            'type',
            'body'
    ];
}
