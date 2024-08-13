<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get the getUser that owns the CademiCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function cademiTag()
    {
        return $this->hasMany(CademiTag::class, 'name', 'course_name');
    }

}
