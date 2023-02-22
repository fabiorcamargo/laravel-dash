<?php

namespace App\Http\Controllers\Asaas;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\EcoProduct;
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
    public function asaascliente(){
        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));
            $asaas->Cliente()->getAll();
            $clientes = $asaas->Cliente()->getAll();
            dd($clientes);

       

    }

    public function create_client($id, $cep){
        $user = User::find($id);
        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));
        $user->name = $user->name;
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

    public function create_payment($user_id, $product_id, $pay, $codesale){
        $user = User::find($user_id);
        $customer = ($user->eco_client()->first()->customer_id);
        $product = EcoProduct::find($product_id);

        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));

        if($pay->payment == "Pix"){
            $pay1 = "BOLETO";
            $pay2 = "Pix";
            $due_date = (now()->addDays(1)->format('Y-m-d'));
            $product->price = $product->price * 0.9;

            $externalReference = $user->eco_sales()->create([
                'customer_id' => $customer,
                'codesale' => $codesale,
                'seller' => $user->seller,
                'installmentCount' => (float)$pay->parcelac,
                'installmentValue' => (float)$product->price / $pay->parcelac,
            ]);

            //dd($externalReference);

            $cobranca = $asaas->Cobranca()->create([
                'customer'=> $customer,
                'billingType'=> $pay1,
                'dueDate'=> $due_date,
                'value'=> $product->price,
                'externalReference'=> $externalReference,
                'postalService'=> false,
                'description' => "$product->course_id | $product->name | $codesale" 
              ]);
    
            if($pay2 == "Pix"){
                $Pix = $asaas->Pix()->create($cobranca->id);
                if($Pix->success){
                   $cobranca = '<img src="data:image/jpeg;base64, '.$Pix->encodedImage.'" />';
                }
            }
        } else if($pay->payment == "CREDIT_CARD"){
            $pay1 = "CREDIT_CARD";
            $due_date = (now()->addDays(1)->format('Y-m-d'));
            $product->price = $product->price;
            $card = str_replace(array(' ', "\t", "\n"), '', $pay->number);

            //dd($product->price / $pay->parcelac);
            $externalReference = $user->eco_sales()->create([
                'customer_id' => $customer,
                'codesale' => $codesale,
                'seller' => $user->seller,
                'installmentCount' => (float)$pay->parcelac,
                'installmentValue' => (float)$product->price / $pay->parcelac,
            ]);

            //dd($externalReference);

            $dadosAssinatura = array(
                "customer" => "$customer",
                "billingType" => "$pay1",
                "installmentCount" => $pay->parcelac,
                'installmentValue' => $product->price / $pay->parcelac,
                "dueDate" => $due_date,
                "description" => "$product->course_id $product->name",
                'externalReference'=> $externalReference->id,
                "creditCard" => array(
                  "holderName" => "$pay->name",
                  "number" => "$card",
                  "expiryMonth" => "$pay->expiryMonth",
                  "expiryYear" => "$pay->expiryYear",
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
    
        }else if($pay->payment == "BOLETO"){
            $due_date = (now()->addDays(1)->format('Y-m-d'));
            $externalReference = $user->eco_sales()->create([
                'customer_id' => $customer,
                'codesale' => $codesale,
                'seller' => $user->seller,
                'installmentCount' => (float)$pay->parcelac,
                'installmentValue' => (float)$product->price / $pay->parcelac,
            ]);

            $dadosAssinatura = array(
                "customer" => "$customer",
                "billingType" => "$pay->payment",
                "installmentCount" => $pay->parcelab,
                'installmentValue' => $product->price / $pay->parcelab,
                "dueDate" => $due_date,
                "description" => "$product->course_id $product->name",
                'externalReference'=> $externalReference->id,
              );
            $cobranca = $asaas->Cobranca()->create(
            $dadosAssinatura
        );
        }

        //dd($cobranca);
        if(isset($cobranca->errors)){
            $externalReference->update([
                'pay_id' => $cobranca->errors[0]->code,
                'status' => "RECUSED",
                'body' => json_encode($cobranca),
              ]);
        }else{

        $externalReference->update([
            'pay_id' => $cobranca->id,
            'status' => "$cobranca->status",
            'body' => json_encode($cobranca),
          ]);
        }
        
        //dd($cobranca);

        return $externalReference;
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
}
