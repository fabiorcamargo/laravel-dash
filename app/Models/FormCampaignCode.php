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
        'course',
        'code',
        'end_date'
    ];
}
