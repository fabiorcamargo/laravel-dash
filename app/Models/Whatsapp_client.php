<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Whatsapp_client extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'phone',
        'body',
        'quality'
    ];

    public function wp_msg(): HasMany
    {
        return $this->hasMany(Whatsapp_msg::class);
    }

    public function client_get(): HasMany
    {
        return $this->HasMany(WhatsappBulkStatus::class, 'user_id', 'user_id');
    }
}
