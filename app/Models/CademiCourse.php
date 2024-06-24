<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CademiCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'user_id',
        'course_id',
        'course_name',
        'doc',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function cademiTag()
    {
        return $this->hasMany(CademiTag::class, 'name', 'course_name');
    }

}
