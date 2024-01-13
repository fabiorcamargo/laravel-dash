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

    public function get_seller(){
        return $this->hasOne(EcoSeller::class,'id','seller')->withDefault();
    }
    public function get_product(){
        return $this->hasOne(EcoProduct::class,'id','eco_product_id')->withDefault();
    }
}

