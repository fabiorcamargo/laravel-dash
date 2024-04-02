<?php

namespace App\Http\Controllers\Asaas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MktController;
use App\Http\Controllers\OldAsaasController;
use App\Jobs\Mkt_send_not_active;
use App\Models\Customer;
use App\Models\EcoProduct;
use App\Models\FlowEntry;
use App\Models\Payment;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use CodePhix\Asaas;
use CodePhix\Asaas\Asaas as AsaasAsaas;
use Illuminate\Support\Facades\Http;
use stdClass;

class AsaasController extends Controller
{

    public function cria_cobranca($id, $value, $token)
  {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.asaas.com/v3/payments/$id");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"value\": $value
                        }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      $token
    ));

    $response = curl_exec($ch);
    $dec = json_decode($response);
  }


    public function asaascliente(){
        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));
            $asaas->Cliente()->getAll();
            $clientes = $asaas->Cliente()->getAll();
            dd($clientes);

       

    }

    public function create_client($user, $cep){
        //$user = User::find($id);
        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));
        $user->name = $user->name . ((isset($user->lastname)) ? " " . $user->lastname : "");
            $clientes = $asaas->Cliente()->create([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->cellphone,
                'mobilePhone' => (isset($user->cellphone2)) ? $user->cellphone2 : $user->cellphone,
                'cpfCnpj' => $user->document,
                'postalCode' => $cep,
                'externalReference' => $user->id,
                'notificationDisabled' => ' false',
                'groupName' => $user->seller,
              ]);
                    $client = $user->eco_client()->create([
                        'customer_id' => $clientes->id,
                        'seller' => $user->seller,
                        'body' => json_encode($clientes),
                    ]);
        
          return $clientes;
    }

    public function create_payment($user, $product, $pay, $codesale){

        //dd($pay);
        $customer = ($user->eco_client()->first()->customer_id);
        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));
        
        if($pay->payment == "pix"){
            $pay1 = "BOLETO";
            $pay2 = "Pix";
            $due_date = (now()->addDays(1)->format('Y-m-d'));

            
            $externalReference = $user->eco_sales()->create([
                'product_id' => $product->id,
                'customer_id' => $customer,
                'codesale' => $codesale,
                'seller' => $user->seller,
                'type' => $pay1,
                'installmentCount' => json_decode($pay->pix_dados)->x,
                'installmentValue' => json_decode($pay->pix_dados)->v,
            ]);

            $cobranca = $asaas->Cobranca()->create([
                'customer'=> $customer,
                'billingType'=> $pay1,
                'dueDate'=> $due_date,
                'installmentCount' => json_decode($pay->pix_dados)->x,
                'installmentValue' => json_decode($pay->pix_dados)->v,
                'externalReference'=> $externalReference->id,
                'postalService'=> false,
                'description' => "$product->course_id | $product->name | $codesale" 
              ]);

            } else if($pay->payment == "card"){
                    $pay1 = "CREDIT_CARD";
                    $due_date = (now()->addDays(1)->format('Y-m-d'));
                    $card = str_replace(array(' ', "\t", "\n"), '', $pay->number);
                    $expiry = (explode("/", str_replace(" ", "", $pay->expiry)));

                    $externalReference = $user->eco_sales()->create([
                        'product_id' => $product->id,
                        'customer_id' => $customer,
                        'codesale' => $codesale,
                        'seller' => $user->seller,
                        'type' => $pay1,
                        'installmentCount' => json_decode($pay->card_dados)->x,
                        'installmentValue' => json_decode($pay->card_dados)->v,
                    ]);

                    $dadosAssinatura = array(
                        "customer" => "$customer",
                        "billingType" => "$pay1",
                        'installmentCount' => json_decode($pay->card_dados)->x,
                        'installmentValue' => json_decode($pay->card_dados)->v,
                        "dueDate" => $due_date,
                        "description" => "$product->course_id $product->name",
                        'externalReference'=> $externalReference->id,
                        "creditCard" => array(
                        "holderName" => "$pay->name",
                        "number" => "$card",
                        "expiryMonth" => "$expiry[0]",
                        "expiryYear" => "$expiry[1]",
                        "ccv" => "$pay->cvc"
                        ),
                        "creditCardHolderInfo" => array(
                        "name" => "$user->name $user->lastname",
                        "email" => "$user->email",
                        "cpfCnpj" => "$user->document",
                        "postalCode" => "$pay->cep",
                        "addressNumber" => "$pay->numero",
                        "addressComplement" => null,
                        "phone" => "$user->cellphone",
                        "mobilePhone" => "$user->cellphone"
                        )
                    );

                    $cobranca = $asaas->Cobranca()->create(
                        $dadosAssinatura
                    );

    
        }else if($pay->payment == "boleto"){

                    $pay1 = "BOLETO";
                    $due_date = (now()->addDays(1)->format('Y-m-d'));
                    $externalReference = $user->eco_sales()->create([
                        'product_id' => $product->id,
                        'customer_id' => $customer,
                        'codesale' => $codesale,
                        'seller' => $user->seller,
                        'type' => $pay1,
                        'installmentCount' => json_decode($pay->boleto_dados)->x,
                        'installmentValue' => json_decode($pay->boleto_dados)->v,
                    ]);

                    $dadosAssinatura = array(
                        "customer" => "$customer",
                        "billingType" => "$pay->payment",
                        'installmentCount' => json_decode($pay->boleto_dados)->x,
                        'installmentValue' => json_decode($pay->boleto_dados)->v,
                        "dueDate" => $due_date,
                        "description" => "$product->course_id $product->name",
                        'externalReference'=> $externalReference->id,
                    );
                    
                    $cobranca = $asaas->Cobranca()->create(
                    $dadosAssinatura
                    );

        }

        if(isset($cobranca->errors)){
            //dd($cobranca);  
            if($pay->payment == "card"){
            $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));
            $dadosAssinatura = array(
                "customer" => "$customer",
                "billingType" => "$pay1",
                'installmentCount' => json_decode($pay->card_dados)->x,
                'installmentValue' => json_decode($pay->card_dados)->v,
                "dueDate" => $due_date,
                "description" => "$product->course_id $product->name",
                'externalReference'=> $externalReference->id,
                'postalService'=> false
            );

            $cobranca = $asaas->Cobranca()->create(
                $dadosAssinatura
            );
        }

            $externalReference->update([
                'pay_id' => $cobranca->id,
                'status' => "NÃO AUTORIZADA",
                'body' => json_encode($cobranca),
              ]);

        }else{

            $externalReference->update([
                'pay_id' => $cobranca->id,
                'installment' => $cobranca->installment,
                'status' => "$cobranca->status",
                'body' => json_encode($cobranca),
            ]);

            $pay->payment != "card" ? $cobranca = AsaasController::get_pix_qrcode($cobranca) : "" ;
        }
        
        return $externalReference;
    }

    public function get_pix_qrcode($cobranca){
                            $token = env('ASAAS_TOKEN');
                            $client = new \GuzzleHttp\Client();
                            $response = $client->request('GET', 'https://sandbox.asaas.com/api/v3/payments/'. $cobranca->id . '/pixQrCode', [
                            'headers' => [
                                'accept' => 'application/json',
                                'content-type' => 'application/json',
                                'access_token' => "$token"
                            ],
                            ]);
                            $response = (json_decode($response->getBody()));
                            $cobranca->pix = $response->encodedImage;
                            $cobranca->copy = $response->payload;
                            $cobranca->expiry = $response->expirationDate;
                            return $cobranca;
    }
    public function get_client($id){
        //($id);
        $user = User::find($id);
        dd($user);
        $customer = Customer::find($user->user_id);
        dd($customer);
        if ($customer != null){
        return $customer;
        }
        
        //$curstomer = AsaasController::create_client($id);

        


    }


    public function cademi(){
        $header = $headers = [
            'Authorization' => env('CADEMI_TOKEN_API')
        ];
        $recorded =(Http::withToken(env('CADEMI_TOKEN_API'))->get('https://profissionaliza.cademi.com.br/api/v1/usuario'));
        
        dd($recorded->object()->data->usuario);

    }

    public function cademiall()
    {
        //Lista Todos os clientes Cademi
        $header = $headers = [
            'Authorization' => env('CADEMI_TOKEN_API')
        ];
        $recorded =(Http::withToken(env('CADEMI_TOKEN_API'))->get('https://profissionaliza.cademi.com.br/api/v1/usuario'));
        
        dd($recorded->object()->data->usuario);
    }

    public function cademione($id)
    {
        //Cria um novo aluno na cademi
        $header = $headers = [
            'Authorization' => env('CADEMI_TOKEN_API')
        ];
        $recorded =(Http::withToken(env('CADEMI_TOKEN_API'))->get("https://profissionaliza.cademi.com.br/api/v1/usuario$id"));
        
        dd($recorded->object()->data->usuario);
    }

    public function cademinew($data)
    {
        //Cria um novo aluno na cademi
        $header = $headers = [
            'Authorization' => env('CADEMI_TOKEN_API')
        ];
        $recorded =(Http::withToken(env('CADEMI_TOKEN_API'))->get("https://profissionaliza.cademi.com.br/api/v1/usuario$data"));
        
        dd($recorded->object()->data->usuario);
    }

    public function get_customer(){
        $user = auth()->user();

        $filtros = array(
            "cpfCnpj" => "05348908908"
        );

        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));
        $clientes = $asaas->Cliente()->getAll($filtros)->data;

        
        if($clientes == null){
            dd('vazio');
        }else{
            dd('cheio');
        }

        dd($clientes);
        
        $user->eco_client()->create([
            'seller' => $user->seller,
            'customer_id' => $clientes->id,
            'body' => json_encode($clientes),
        ]);
        //dd($user);
    }
}