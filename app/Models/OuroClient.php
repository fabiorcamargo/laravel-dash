<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OuroClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'ouro_id',
        'nome',
        'usuario',
        'senha',
        'login_auto',
    ];

    public function matricula_ouro(): HasMany
    {
        return $this->hasMany(OuroCourse::class);
    }
}
