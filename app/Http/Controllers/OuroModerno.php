<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OuroModerno extends Controller
{

    public function request($payload, $url, $data, $type){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => env('OURO_API_TOKEN')
        ])->$type("$url", $payload != "" ? json_decode($payload, true) :"");
        return $response;
    }
    public function criar_aluno($liberation){
        //dd($liberation);
        $user = Auth::user();
        $options = [
            'multipart' => [
              [
                'name' => 'token',
                'contents' => env('OURO_API_TOKEN')
              ],
              [
                'name' => 'nome',
                'contents' => $user->name
              ],
              [
                'name' => 'doc_cpf',
                'contents' => $user->document
              ],
              [
                'name' => 'senha',
                'contents' => '123456'
              ],
              [
                'name' => 'data_nascimento',
                'contents' => '1900-01-01'
              ],
              [
                'name' => 'email',
                'contents' => $user->email
              ],
              [
                'name' => 'fone',
                'contents' => $user->cellphone
              ],
              [
                'name' => 'doc_rg',
                'contents' => '00000000'
              ],
              [
                'name' => 'celular',
                'contents' => $user->cellphone
              ],
              [
                'name' => 'pais',
                'contents' => 'Brasil'
              ],
              [
                'name' => 'uf',
                'contents' => 'PR'
              ],
              [
                'name' => 'cidade',
                'contents' => 'Maringá'
              ],
              [
                'name' => 'endereco',
                'contents' => 'rua'
              ],
              [
                'name' => 'complemento',
                'contents' => 'outro'
              ],
              [
                'name' => 'bairro',
                'contents' => 'centro'
              ],
              [
                'name' => 'cep',
                'contents' => '87020035'
              ]
          ]];

          dd($options);
        
        
       
    }

    public function criar_matricula(){
        
    }
}
