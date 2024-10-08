<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotificationCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
            'title',
            'body',
            'image',
            'send',
            'successes',
            'failures'
    ];
}
