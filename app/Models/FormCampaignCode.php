<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormCampaignCode extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'name',
        'form_campains_id',
        'liberation',
        'course_code',
        'course_name',
        'start_date',
        'end_date'
    ];
}
