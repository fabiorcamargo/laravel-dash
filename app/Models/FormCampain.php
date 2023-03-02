<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormCampain extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'city',
        'description',
        'redirect',
        'chip',
    ];

    public function leads()
    {
        return $this->hasMany(FormLead::class);
    }
}
