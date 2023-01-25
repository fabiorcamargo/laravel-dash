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
            dd($clientes);

       

    }

    public function create_client($id){
        //($id);
        $user = User::find($id);
        //dd($user);
        $asaas = new AsaasAsaas(env('ASAAS_TOKEN'), env('ASAAS_TIPO'));

        //dd($asaas);

        $dados = array(
            'name' => ' Marcelo Almeida',
            'email' => ' marcelo.almeida@gmail.com',
            'phone' => ' 4738010919',
            'mobilePhone' => ' 4799376637',
            'cpfCnpj' => ' 24971563792',
            'postalCode' => ' 01310-000',
            'address' => ' Av. Paulista',
            'addressNumber' => ' 150',
            'complement' => ' Sala 201',
            'province' => ' Centro',
            'externalReference' => ' 12987382',
            'notificationDisabled' => ' false',
            'additionalEmails' => ' marcelo.almeida2@gmail.commarcelo.almeida3@gmail.com',
            'municipalInscription' => ' 46683695908',
            'stateInscription' => ' 646681195275',
            'observations' => ' ótimo pagador nenhum problema até o momento'
          );
        //dd($dados);
        $clientes = $asaas->Cliente()->create([
            'name' => ' Marcelo Almeida',
            'email' => ' marcelo.almeida@gmail.com',
            'phone' => ' 4738010919',
            'mobilePhone' => ' 4799376637',
            'cpfCnpj' => ' 24971563792',
            'postalCode' => ' 01310-000',
            'address' => ' Av. Paulista',
            'addressNumber' => ' 150',
            'complement' => ' Sala 201',
            'province' => ' Centro',
            'externalReference' => ' 12987382',
            'notificationDisabled' => ' false',
            'additionalEmails' => ' marcelo.almeida2@gmail.commarcelo.almeida3@gmail.com',
            'municipalInscription' => ' 46683695908',
            'stateInscription' => ' 646681195275',
            'observations' => ' ótimo pagador nenhum problema até o momento'
          ]);
        dd($clientes);
               // return $clientes;
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
