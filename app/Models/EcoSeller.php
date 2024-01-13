<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcoSeller extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'type',
        'secretary'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id')->withDefault();
    }
}
