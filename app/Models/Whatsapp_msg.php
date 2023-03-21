<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Whatsapp_msg extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'whatsapp_client_id',
        'msg_id',
        'body',
        'send',
        'type',
    ];

    public function wp_client()
    {
        return $this->belongsTo(Whatsapp_client::class);
    }
}
