<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CademiListCourse extends Model
{
    use HasFactory;

    protected $fillable = [
            'course_id',
            'nome',
            'nome_completo',
            'ordem'
    ];
}
