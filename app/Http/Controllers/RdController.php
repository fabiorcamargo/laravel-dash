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
    public function rd_client_register($id, $password, $product){
    
        if (env('RD_EXPIRITY') < Carbon::now()){
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://api.rd.services/auth/token', [
            'body' => '{"client_id":"' . env('RD_CLIENT_ID') . '","client_secret":"' . env('RD_CLIENT_SECRET') . '","refresh_token":"' . env('RD_REFRESH_TOKEN') . '"}',
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
            ]);
            $response = (json_decode($response->getBody()));
            $date = new Carbon();
            $date = Carbon::now();
            $date = $date->addDays(1);
            $date = $date->toDateTimeString();
            $token = $response->access_token;
            $refresh_token = $response->refresh_token;

            $path = base_path('.env');
            $test = file_get_contents($path);
            
            if (file_exists($path)) {
                $ini = [env('RD_EXPIRITY'), env('RD_ACCESS_TOKEN'), env('RD_REFRESH_TOKEN')];
                $fim = [$date, $token, $refresh_token];
                file_put_contents($path, str_replace($ini, $fim, $test));
                }
        }else{

        }
       
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
              "client_tracking_id": "' . $user->id . '",
              "traffic_source": "' . $product->course_id . "|" . $product->name . '",
              "traffic_medium": "cpc",
              "traffic_campaign": "easter-50-off",
              "traffic_value": "easter eggs",
              "tags": [
                "mql",
                "2019"
              ],
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

            
            $user->rd()->create([
              'body' => $response->getBody()
            ]);
        
    }

    public function rd_create_oportunity(){

        $payload = json_decode('
        {
            "token": "62e8338a7d88be000cc740d1",
            "deal": {
            "name": "Fábio Camargo",
            "user_id": "62e8338a7d88be000cc740cf",
            "rating": 1,
            "deal_stage_id": "63e3a68368ef11000b5158b0"
            },
            "contacts": [
            {
            "name": "Fábio Camargo",
            "emails": [
            {
            "email": "fabio.xina@gmail.com"
            }
            ],
            "phones": [
            {
            "phone": "42991622889",
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
            ],
            "deal_source": {
            "_id": "63e3ee4de1e7af000189ddda"
            },
            "campaign": {
            "_id": "63e4ddbb9cb1c00001d4b09f"
            }
            }
        ');

           $response = Http::post("https://crm.rdstation.com/api/v1/deals?token=62e8338a7d88be000cc740d1", $payload);
           $json = json_decode($response->getBody());        
           $json = json_encode($json);
           //dd($json);
           
            $user = User::find(21569);
            $user->rd()->create([
                'body' => $json
            ]);
            
           if ((RdCrmOportunity::find(1) == null)){
            $rd_crm = RdCrmOportunity::find(1);
           }else{
            $rd_crm = new RdCrmOportunity();
           }
            $rd_crm->user_id = 1;
            $rd_crm->body = $json;
            $rd_crm->save();
           
        
        dd(json_decode($response->getBody()));
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