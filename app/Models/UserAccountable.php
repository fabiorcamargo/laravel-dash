<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserAccountable extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'cellphone',
        'document',
        'active',
        'secretary'
    ];

    public function getuser(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
