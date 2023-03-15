<?php

namespace App\Http\Controllers;

use App\Models\WhatsappApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiWhatsapp extends Controller
{
    public function msg_receive(Request $request){
        
        //$data = $request->all();
        $data = (json_decode($request->getContent()));
        //dd($data->hub_challenge);
        WhatsappApi::create([
            'body' => json_encode($data)
        ]);
        
        Storage::put('whatsapp_api.txt', json_encode($data));



        return response("$data->hub_challenge", 200);
    }
}
