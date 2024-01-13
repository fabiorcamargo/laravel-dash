<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EcoProduct extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'type',
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
