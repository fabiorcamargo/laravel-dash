<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'expiration'
    ];

    public function matricula_ouro(): HasMany
    {
        return $this->hasMany(OuroCourse::class);
    }
     /**
     * Get the user that owns the OuroClient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function get_user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
