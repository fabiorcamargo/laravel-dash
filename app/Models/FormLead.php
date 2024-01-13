<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormLead extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'form_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function interact()
    {
        return $this->hasMany(Whatsapp_client::class, 'user_id', 'user_id');
    }

}
