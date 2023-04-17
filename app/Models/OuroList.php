<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OuroList extends Model
{
    use HasFactory;

    protected $fillable = [
    'course_id',
    'name',
    'modulo',
    'aulas',
    'carga',
    'descricao'
];
    
}
