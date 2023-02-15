<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatbotAsset extends Controller
{
    public function chatbot_send (){

        //dd($request->all());
        $number = "4299162289";
        $message = "Oi";

    $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://v5.chatpro.com.br/chatpro-3caeb4022d/api/v1/send_message', [
        'body' => '{"number":"' . $number . '","message":"' . $message . '"}',
        'headers' => [
            'Authorization' => 'f7d6e4d5b650b3f7bdc2a4b319f58d9d',
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ],
        ]);
    }

    public function chatbot_convert_data (Request $request){

        $date_i = Carbon::now()->format("d-m-Y h:i");
        $date_f = Carbon::now()->addDays(1)->format("d-m-Y h:i");
        dd("$date_i | $date_f");
       
    }

   
}
