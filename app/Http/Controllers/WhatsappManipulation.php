<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Whatsapp_client;
use Illuminate\Http\Request;

class WhatsappManipulation extends Controller {

    //Verifica se client whatsapp existe ou cria um novo
    public function client ($phone, $name){

        //Modificadores do telefone
        $phone_t[0] = $phone;
        $phone_t[1] = (str_replace("55","", $phone));
        $phone_t[2] = (substr($phone_t[1], 0, 2) . 9 . substr($phone_t[1], 2, 10));
        $phone_t[3] = (substr($phone_t[1], 0, 2) . substr($phone_t[1], 3, 10));

        //Passa pelos modificadores para achar usuário com o telefone
        foreach($phone_t as $ph){
            if(User::where('cellphone', 'like', "%$ph%")->first()){
                $user = (User::where('cellphone', 'like', "%$ph%")->first());
                //Verifica se o cliente whatsapp já existe
                if(Whatsapp_client::where('phone', $phone)->first()){
                        $client = Whatsapp_client::where('phone', $phone)->first();
                        $client->user_id == "" ? $client->user_id = $user->id : "";
                        $user->cellphone = $phone;
                        $user->save();
                        $client->save();
                        return $client;
                    }else{
                        $client = Whatsapp_client::create([
                            'user_id' => $user->id,
                            'name' => $name,
                            'phone' => $phone
                        ]);
                        return $client;
                    }
            }else if(Whatsapp_client::where('phone', $phone)->first()){
                $client = Whatsapp_client::where('phone', $phone)->first();
                return $client;
            }else{
                $client = Whatsapp_client::create([
                    'name' => $name,
                    'phone' => $phone
                ]);
                return $client;
            }
        }
    }
}
