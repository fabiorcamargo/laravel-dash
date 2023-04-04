<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OuroCourse extends Model
{
    use HasFactory;

    protected $fillable = [
            'id',
            'ouro_client_id',
            'ouro_course_id',
            'ouro_id',
            'code',
            'name',
            'data_fim',
    ];
}
