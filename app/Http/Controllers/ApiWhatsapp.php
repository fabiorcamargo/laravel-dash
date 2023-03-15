<?php

namespace App\Http\Controllers;

use App\Models\WhatsappApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiWhatsapp extends Controller
{
    public function msg_receive(Request $request){
        
        $data = $request->all();
        WhatsappApi::create([
            'body' => json_encode($data)
        ]);
        
        Storage::put('whatsapp_api.txt', json_encode($data));
    }
}
