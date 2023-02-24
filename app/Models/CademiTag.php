<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CademiTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_id',
        'name',
    ];
}
