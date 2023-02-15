<?php

namespace App\Models;

use App\Http\Controllers\ChatbotAsset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotSend extends Model
{
    use HasFactory;

    public function send()
    {
        $chat = new ChatbotAsset;
        return $chat->chatbot_send();
    }

}
