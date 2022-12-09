<?php

namespace App\Http\Controllers\Asaas;

use App\Http\Controllers\Controller;
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
