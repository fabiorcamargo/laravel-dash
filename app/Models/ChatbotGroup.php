<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotGroup extends Model
{
    use HasFactory;

    protected $fillable = [
    'group_id',
    'group_code',
    'periodo',
    'group_name',
    'responsavel',
    'group_link',
    'seller',
    'city',
    ];
}
