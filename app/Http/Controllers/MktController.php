<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class MktController extends Controller
{
    public function getToken()
    {
        // Obtém o token atual
        $currentToken = env('MKT_TOKEN');

        // Faz a requisição para renovar o token
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $currentToken,
        ])->get('https://api.mktzap.com.br/company/' . env('MKT_COMPANY') . '/user');

        // Verifica se a requisição foi bem-sucedida
        if ($response->successful()) {
            return $currentToken;
        } else {
            $response = Http::get("https://api.mktzap.com.br/company/" . env('MKT_COMPANY') . "/token?clientKey=" . env('MKT_KEY'));
            $response  = (json_decode($response->body()));
            $token = $response->accessToken;
            $date = new Carbon();
            $date = Carbon::now();
            $date = $date->addMinutes(55);
            $date = $date->toDateTimeString();

            $path = base_path('.env');
            $test = file_get_contents($path);
            if (file_exists($path)) {
                $ini = [env('MKT_EXPIRITY'), env('MKT_TOKEN')];
                $fim = [$date, $token];
                file_put_contents($path, str_replace($ini, $fim, $test));
            }
            return $token;
        }
    }

    public function send_not_active($name, $phone, $type, $msg, $user_id)
    {
        $user = User::find($user_id);

        $renew = new MktController;
        $token = $renew->getToken();
        //dd($token);

        $payload = '{
                    "type": "whatsapp",
                    "channel_phone": "' . env('MKT_PHONE') . '",
                    "phone_number": "' . $phone . '",
                    "name": "' . $name . '",
                    "only_active": true,
                    "messages": [
                    {
                        "type": "' . $type . '",
                        "content": "' . $msg . '"
                    }
                    ]
                 }';

        $client = new Client();

        try {
            $response = $client->request('POST', 'https://api.mktzap.com.br/company/' . env('MKT_COMPANY') . '/history/active', [
                'body' => "$payload",
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'Authorization' => "Bearer $token"
                ],
            ]);
            // Processar a resposta
            
            $user->usermsg()->create([
                'msg' => $msg,
                'status' => $response->getStatusCode()
              ]);
 
              return $response->getStatusCode();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                
                $user->usermsg()->create([
                    'msg' => $msg,
                    'status' => $e->getResponse()->getStatusCode()
                  ]);
                // Se a requisição falhou e houver uma resposta HTTP, você pode acessá-la assim:
                return $e->getResponse()->getStatusCode(); // Código de status HTTP
                //echo $e->getResponse()->getBody(); // Corpo da resposta HTTP
            } else {
                
                $user->usermsg()->create([
                    'msg' => $msg,
                    'status' => $e->getMessage()
                  ]);
                // Se a requisição não obteve uma resposta HTTP, você pode acessar o erro assim:
                return $e->getMessage();
                
            }
        }



/*
        $response = $client->request('POST', 'https://api.mktzap.com.br/company/' . env('MKT_COMPANY') . '/history/active', [
            'body' => "$payload",
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'Authorization' => "Bearer $token"
            ],
        ]);

        return response("Status", $response->getStatusCode());*/
    }
}
