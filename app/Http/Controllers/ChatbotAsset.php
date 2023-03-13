<?php

namespace App\Http\Controllers;

use App\Models\ChatbotAsset as ModelsChatbotAsset;
use App\Models\ChatbotMessage;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ChatbotAsset extends Controller
{
    public function chatbot_send ($chip, $number, $message){

        //dd($request->all());
        $ativo = ModelsChatbotAsset::find($chip);
        //dd($ativo);
        //$number = "4299162289";
        //$message = "Oi";

        $response = Http::withHeaders([
            'Authorization' => $ativo->token
        ])->post('https://v5.chatpro.com.br/' . $ativo->asset . '/api/v1/send_message', [
            "number" => $number,
            "message" => $message
        ]);


        //dd($response->getBody());
    }

    public function queue_send(){

        dd(ChatbotMessage::all());
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://v5.chatpro.com.br/chatpro-3caeb4022d/api/v1/send_message', [
          'body' => '{"number":"5542991622889","message":"Oi"}',
          'headers' => [
            'Authorization' => 'f7d6e4d5b650b3f7bdc2a4b319f58d9d',
            'accept' => 'application/json',
            'content-type' => 'application/json',
          ],
        ]);
        
        echo $response->getBody();
    }

    public function chatbot_convert_data (Request $request){

        $date_i = Carbon::now()->format("d-m-Y h:i");
        $date_f = Carbon::now()->addDays(1)->format("d-m-Y h:i");
        dd("$date_i | $date_f");
       
    }

   
}
