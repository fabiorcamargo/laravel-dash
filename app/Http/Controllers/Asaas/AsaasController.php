<?php

namespace App\Http\Controllers\Asaas;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use CodePhix\Asaas;
use CodePhix\Asaas\Asaas as AsaasAsaas;
use Illuminate\Support\Facades\Http;

class AsaasController extends Controller
{
    public function asaascliente(){
        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));
            $asaas->Cliente()->getAll();
            $clientes = $asaas->Cliente()->getAll();
            dd($clientes->data[3]->name);

       

    }

    public function create_client($id){
        //($id);
        $user = User::find($id);
        //dd($user);
        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));

        $filtro = array(
            'name'                 => '',
            'cpfCnpj'              => $user->document,
            'email'                => '',
            'phone'                => '',
            'mobilePhone'          => '',
            'address'              => '',
            'addressNumber'        => '',
            'complement'           => '',
            'province'             => '',
            'postalCode'           => '',
            'externalReference'    => '',
            'notificationDisabled' => '',
            'additionalEmails'     => ''
        );

            $client = $asaas->Cliente()->getAll($filtro);
            //dd($clientes->data[3]->name);
            /*
            $user->customer()->create([
                'gateway_id' => $request->body,
                'visible' => isset($request->visible)
            ]);  */  
            $request = ($client->data[0]);
            //dd($request);

            $customer = ($user->customer()->create([
                        'gateway_id' => $request->id,
                        'dateCreated' => $request->dateCreated,
                        'cpfCnpj' => $request->cpfCnpj, 
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'mobilePhone' => $request->mobilePhone,
                        'externalReference' => $user->username,
                        'notificationDisabled' => $request->notificationDisabled,
                    ]));

       
                return $customer;
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
