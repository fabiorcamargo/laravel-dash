<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcoCoupon extends Model
{
    use HasFactory;
    protected $fillable = [
    'name',
    'eco_product_id',
    'discount',
    'token',
    'seller'
    ];
}

