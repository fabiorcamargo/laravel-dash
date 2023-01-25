<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcoProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'course_id',
        'name',
        'description',
        'tag',
        'category',
        'image',
        'specification',
        'price',
        'percent',
        'public',
    ];
}
