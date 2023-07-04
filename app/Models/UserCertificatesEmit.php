<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCertificatesEmit extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'percent',
        'validity',
        'body'
        ];

        public function getuser()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->first();
    }

        public function getCertModel()
    {
        return $this->hasOne(UserCertificatesModel::class, 'id', 'user_certificates_models_id')->first();
    }
}
