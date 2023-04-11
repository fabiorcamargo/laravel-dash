<?php

namespace App\Http\Controllers;


use App\Models\RdCrmFlow;
use App\Models\RdCrmOportunity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RdController extends Controller
{

    public function re_token_update(){

      if (env('RD_EXPIRITY') < Carbon::now()){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.rd.services/auth/token', [
        'body' => '{"client_id":"' . env('RD_CLIENT_ID') . '","client_secret":"' . env('RD_CLIENT_SECRET') . '","refresh_token":"' . env('RD_REFRESH_TOKEN') . '"}',
        'headers' => [
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ],
        ]);
  
        //dd(json_decode($response->getBody()));
        
        if($response->getStatusCode() == 200){

        $response = (json_decode($response->getBody()));

        $date = new Carbon();
        $date = Carbon::now();
        $date = $date->addDays(1);
        $date = $date->toDateTimeString();
        $token = $response->access_token;
        $refresh_token = $response->refresh_token;

        $path = base_path('.env');
        $test = file_get_contents($path);

        } 
        
        if (file_exists($path)) {
            $ini = [env('RD_EXPIRITY'), env('RD_ACCESS_TOKEN'), env('RD_REFRESH_TOKEN')];
            $fim = [$date, $token, $refresh_token];
            file_put_contents($path, str_replace($ini, $fim, $test));
            }
    }else{

    }

    }

    public function rd_client_register($id, $password, $product){
    
        $rtoken = new RdController;
        $rtoken->re_token_update();
       
        $user = User::find($id);
        $payload = '
        {
            "event_type": "CONVERSION",
            "event_family": "CDP",
            "payload": {
              "conversion_identifier": "Conversion_Fabio",
              "name": "' . $user->name . " $user->lastname" . '",
              "email": "' . $user->email . '",
              "personal_phone": "' . $user->cellphone . '",
              "mobile_phone": "' . $user->cellphone . '",
              "cf_custom_field_api_identifier": "convert_test_fabio_api",
              "traffic_source": "' . $product->course_id . " | " . $product->name . '",
              "traffic_medium": "cpc",
              "available_for_mailing": true,
              "cf_id_ead": "' . $user->username . '",
              "cf_pw_inicial": "' . $password . '",
              "legal_bases": [
                {
                  "category": "communications",
                  "type": "consent",
                  "status": "granted"
                }
              ]
            }
          }';
            
            $token = env('RD_ACCESS_TOKEN');
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://api.rd.services/platform/events', [
            'body' => $payload,
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'Authorization' => "Bearer $token"
            ],
            ]);
        
    }

    public function rd_create_opportunity($id, $product){

        $flow = RdCrmFlow::where("name", $product->flow)->first();
        $etapas = json_decode($flow->body);
        $user = User::find($id);
        $payload = json_decode('
        {
            "token": "'. env('RD_TOKEN') . '",
            "deal": {
            "name": "' . $user->name . " $user->lastname | " . $product->name . "($product->course_id)" . '",
            "user_id": "62e8338a7d88be000cc740cf",
            "rating": 5,
            "deal_stage_id": "' . $etapas[0]->id . '"
            },
            "contacts": [
            {
            "name": "' . $user->name . " $user->lastname" . '",
            "emails": [
            {
            "email": "' . $user->email . '"
            }
            ],
            "phones": [
            {
            "phone": "' . $user->cellphone . '",
            "type": "cellphone"
            }
            ],
            "legal_bases": [
            {
            "category": "data_processing",
            "type": "consent",
            "status": "granted"
            },
            {
            "category": "communications",
            "type": "vital_interest",
            "status": "granted"
            }
            ]
            }
            ]
            }
        ');

           $response = Http::post("https://crm.rdstation.com/api/v1/deals?token=62e8338a7d88be000cc740d1", $payload);
           $json = json_decode($response->getBody());        
           $json = json_encode($json);
           //dd($json);
           
            $user->rd()->create([
                'product' => $product->id,
                'body' => $json
            ]);
        //dd(json_decode($response->getBody()));
    }

    public function rd_update_opportunity($user, $product){
/*
      $flow = RdCrmFlow::where("name", $product->flow)->first();
      $opportunity = RdCrmOportunity::where(["user_id" => $user->id, "product" => $product->id])->first();
      $body = json_decode($opportunity->body);
      $id_op = $body->id;
      $etapas = json_decode($flow->body);
      

      if($product->cobranca->status == "PENDING"){
        $etapa = 1;
      }else if($product->cobranca->status == "RECUSED"){
        $etapa = 2;
      }else if($product->cobranca->status == "CONFIRMED" || $product->cobranca->status == "RECEIVED"){
        $etapa = 3;
      }

      $payload = json_decode('
        {
          "token": "'. env('RD_TOKEN') . '",
          "deal_stage_id": "' . $etapas[$etapa]->id . '"
          }
      ');

         $response = Http::put("https://crm.rdstation.com/api/v1/deals/$id_op?token=62e8338a7d88be000cc740d1", $payload);
         $json = json_decode($response->getBody());        
         $json = json_encode($json);
         //dd($json);
         
          $user->rd()->update([
              'product' => $product->id,
              'body' => $json
          ]);*/
      //dd(json_decode($response->getBody()));
  }

    public function rd_fluxos(){
        $response = Http::get("https://crm.rdstation.com/api/v1/deal_pipelines?token=62e8338a7d88be000cc740d1");
        $json = json_decode($response->getBody()); 

        foreach($json as $fluxos){
        if(RdCrmFlow::where('fluxo_id', $fluxos->id)->first() == ""){
          $fluxo = new RdCrmFlow();
          $fluxo->fluxo_id = $fluxos->id;
          $fluxo->name = $fluxos->name;
          $fluxo->body = json_encode($fluxos->deal_stages);
          $fluxo->save();
        }else{
          $fluxo = RdCrmFlow::where('fluxo_id', $fluxos->id)->first();
          $fluxo->fluxo_id = $fluxos->id;
          $fluxo->name = $fluxos->name;
          $fluxo->body = json_encode($fluxos->deal_stages);

          //dd($fluxo);
          $fluxo->save();
        }
        }
        return back();
    }

    


}