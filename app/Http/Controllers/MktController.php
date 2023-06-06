<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
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

    public function send_not_active($name, $phone, $type, $msg)
    {

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

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.mktzap.com.br/company/' . env('MKT_COMPANY') . '/history/active', [
            'body' => "$payload",
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'Authorization' => "Bearer $token"
            ],
        ]);

        return response("Status", $response->getStatusCode());
    }
}
