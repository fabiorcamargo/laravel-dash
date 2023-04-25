<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
    public function get_course(): HasOne
    {
        return $this->hasone(OuroList::class, 'course_id', 'ouro_course_id');
    }
}
