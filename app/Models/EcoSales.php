<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcoSales extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'customer_id',
        'codesale',
        'seller',
        'pay_id',
        'status',
        'installmentCount',
        'installmentValue',
        'body',
    ];

}
