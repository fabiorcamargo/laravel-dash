<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FlowEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'flow_id',
        'user_id',
        'step',
        'body',
        'seller',
        'product_id'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id')->withDefault();
    }
    public function get_seller(){
        return $this->hasOne(EcoSeller::class,'id','seller')->withDefault();
    }

}
