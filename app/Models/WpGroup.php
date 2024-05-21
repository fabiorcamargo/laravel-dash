<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'cademi_code',
        'name',
        'description',
        'link',
        'inicio',
        'fim',
    ];
}
