<?php

namespace App\Http\Controllers\Asaas;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\EcoProduct;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use CodePhix\Asaas;
use CodePhix\Asaas\Asaas as AsaasAsaas;
use Illuminate\Support\Facades\Http;
use stdClass;

class AsaasController extends Controller
{
    public function asaascliente(){
        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));
            $asaas->Cliente()->getAll();
            $clientes = $asaas->Cliente()->getAll();
            dd($clientes);

       

    }

    public function create_client($id){
 
        $user = User::find($id);

        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));
        $user->name = $user->name;
        $user->name = $user->name . ((isset($user->lastname)) ? " " . $user->lastname : "");

        //dd($user);

        $clientes = $asaas->Cliente()->create([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->cellphone,
            'mobilePhone' => (isset($user->cellphone2)) ? $user->cellphone2 : $user->cellphone,
            'cpfCnpj' => $user->document,
            'externalReference' => $user->id,
            'notificationDisabled' => ' false',
          ]);
          return $clientes;
    }

    public function create_payment($user_id, $product_id, $sales_id, $type){
        $user = User::find($user_id);
        $customer = Customer::where("user_id", $user_id)->first();
        $product = EcoProduct::find($product_id);

        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));

        if($type->payment == "Pix"){
            $type1 = "BOLETO";
            $type2 = "Pix";
            $due_date = (now()->addDays(1)->format('Y-m-d'));
            $product->price = $product->price * 0.9;

            $cobranca = $asaas->Cobranca()->create([
                'customer'=> $customer->gateway_id,
                'billingType'=> $type1,
                'dueDate'=> $due_date,
                'value'=> $product->price,
                'externalReference'=> $sales_id,
                'postalService'=> false,
                'description' => "$product->course_id | $product->name" 
              ]);
    
            if($type2 == "Pix"){
                $Pix = $asaas->Pix()->create($cobranca->id);
                if($Pix->success){
                   // $cobranca = '<img src="data:image/jpeg;base64, '.$Pix->encodedImage.'" />';
                }
            }
        }

        if($type->payment == "CREDIT_CARD"){
            $type1 = "CREDIT_CARD";
            $due_date = (now()->addDays(1)->format('Y-m-d'));
            $product->price = $product->price;
            $card = str_replace(array(' ', "\t", "\n"), '', $type->number);

            $dadosAssinatura = array(
                "customer" => "$customer->gateway_id",
                "billingType" => "$type1",
                "value" => $product->price,
                "dueDate" => $due_date,
                "description" => "$product->course_id $product->name",
                "creditCard" => array(
                  "holderName" => "$type->name",
                  "number" => "$card",
                  "expiryMonth" => "$type->expiryMonth",
                  "expiryYear" => "$type->expiryYear",
                  "ccv" => "$type->cvc"
                ),
                "creditCardHolderInfo" => array(
                  "name" => "$user->name $user->lastname",
                  "email" => "$user->email",
                  "cpfCnpj" => "$user->document",
                  "postalCode" => "$type->cep",
                  "addressNumber" => "$type->numero",
                  "addressComplement" => null,
                  "phone" => "$user->cellphone",
                  "mobilePhone" => "$user->cellphone"
                )
              );

            $cobranca = $asaas->Cobranca()->create(
                $dadosAssinatura
            );
    
        }
        
        //dd($cobranca);

        $sales = Sales::find($sales_id);
        $sales->pay_id = $cobranca->id;
        $sales->body = json_encode($cobranca);
        $sales->save();

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
        
        $curstomer = AsaasController::create_client($id);

        


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
}
