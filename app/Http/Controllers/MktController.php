<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserMessage;
use App\Models\UserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
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
            
            return $token;
        }
    }

    public function send_not_active($name, $phone, $type, $msg, $user_id)
    {
        $phone = '55'.$phone;
        $token = $this->getToken();
        $payload = '{
                    "type": "whatsapp",
                    "channel_phone": "' . env('MKT_PHONE') . '",
                    "phone_number": "' . $phone . '",
                    "name": "' . $name . '",
                    "only_active": true,
                    "messages": [
                    {
                        "type": "text",
                        "content": "' . $msg . '"
                    }
                    ]
                 }';

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://api.mktzap.com.br/company/" . env('MKT_COMPANY') . "/history/active");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_HEADER, FALSE);
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "$payload");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/json",
                    "Authorization: Bearer $token"
                    ));
                    $response = curl_exec($ch);
                    if ($response === false) {
                        $error = curl_error($ch);
                        // Lidar com o erro de acordo com suas necessidades
                        $status = $error;
                    }else{
                        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);
                    }
                    
                foreach((array)$user_id as $user){
                   $user = User::find($user);
                   $user->usermsg()->create([
                    'name' => $name,
                    'msg' => $msg,
                    'cellphone' => $phone,
                    'status' => $status
              ]);
                }
                return $status;
        }

public function send_profile_msg(Request $request)
    {
        
        $dados = explode(",", str_replace(" ", "", $request->cellphone));
        $name = $dados[0];
        $phone = $dados[1];
        $phone = '55'.$phone;
        $type = "text";
        $de = array('\r', '\n');
        $para = array('', '');
        $msg = preg_replace( '/\r\n/', '\n', $request->obs);
        $user_id = $request->id;
        $active = $request->chamadoativo == "on" ? "false" : "true";
        $token = $this->getToken();

        $payload = '{
            "type": "whatsapp",
            "channel_phone": "' . env('MKT_PHONE') . '",
            "phone_number": "'. $phone . '",
            "name": "'. $name .'",
            "only_active": '. $active .',
            "messages": [
            {
                "type": "text",
                "content": "' . $msg . '"
            }
            ]
         }';

         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, "https://api.mktzap.com.br/company/" . env('MKT_COMPANY') . "/history/active");
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
         curl_setopt($ch, CURLOPT_HEADER, FALSE);
         curl_setopt($ch, CURLOPT_POST, TRUE);
         curl_setopt($ch, CURLOPT_POSTFIELDS, "$payload");
         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
         "Content-Type: application/json",
         "Authorization: Bearer $token"
         ));
         $response = curl_exec($ch);
         if ($response === false) {
             $error = curl_error($ch);
             // Lidar com o erro de acordo com suas necessidades
             $status = $error;
         }else{
             $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
             curl_close($ch);
         }
         
     foreach((array)$user_id as $user){
        $user = User::find($user);
        $user->usermsg()->create([
         'name' => $name,
         'msg' => $msg,
         'cellphone' => $phone,
         'status' => $status
   ]);
     }
     return $status;
}


public function resend_not_active($msg_id)
    {
        
        //$user = User::find($user_id);
        $msg_use = UserMessage::find($msg_id);
        $phone = $msg_use->cellphone;
        $msg = $msg_use->msg;
        $phone = '55'.$phone;
        $token = $this->getToken();

        $payload = '{
                    "type": "whatsapp",
                    "channel_phone": "' . env('MKT_PHONE') . '",
                    "phone_number": "' . $phone . '",
                    "name": "",
                    "only_active": true,
                    "messages": [
                    {
                        "type": "text",
                        "content": "' . $msg . '"
                    }
                    ]
                 }';

                 
                 $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://api.mktzap.com.br/company/" . env('MKT_COMPANY') . "/history/active");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_HEADER, FALSE);
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "$payload");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/json",
                    "Authorization: Bearer $token"
                    ));
                    $response = curl_exec($ch);
                    if ($response === false) {
                        $error = curl_error($ch);
                        // Lidar com o erro de acordo com suas necessidades
                        $status = $error;
                    }else{
                        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);
                    }
                    
                    $msg_use->status = $status;
                    $msg_use->save();
    
                    Auth::user()->getusernotification()->create([
                        'resume'=>"Msg $phone",
                        'msg'=> "Reenviar -> $msg",
                        'status'=> "success",
                        'show'=> 1,
                        'action'=> "/modern-dark-menu/aluno/profile/$msg_use->user_id",
                        'icon'=> "message",
                        'body'=> json_encode($msg_use)
                    ]);
    
                return $status;
        }
    }
