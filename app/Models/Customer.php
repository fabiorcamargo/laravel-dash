<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'gateway_id',
        'dateCreated',
        'cpfCnpj',
        'name',
        'phone',
        'mobilePhone',
        'externalReference',
        'notificationDisabled',
    ];


    public function user()
    {
        return $this->hasOne(User::class);
    }
}
