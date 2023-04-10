<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flow extends Model
{
    use HasFactory;

    protected $fillable = [
    'id',
    'name',
    'context',
    'item',
    'steps'
    ];

    public function entry(): HasMany
    {
        return $this->hasMany(FlowEntry::class);
    }
}
