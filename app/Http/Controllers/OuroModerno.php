<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OuroModerno extends Controller
{

    public function request($payload, $url, $data, $type){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => env('OURO_API_TOKEN')
        ])->$type("$url", $payload != "" ? json_decode($payload, true) :"");
        return $response;
    }
    public function criar_aluno(){
       
    }

    public function criar_matricula(){
        
    }
}
