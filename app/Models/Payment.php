<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'pay_id',
        'user_id',
        'customer',
        'paymentLink',
    ];



    public function user()
    {
        return $this->hasOne(Gateway_Customer::class);
    }
}
