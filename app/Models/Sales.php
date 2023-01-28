<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'customer',
        'codesale',
        'seller',
        'pay_id',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
}
