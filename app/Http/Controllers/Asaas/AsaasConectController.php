<?php

namespace App\Http\Controllers\Asaas;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use CodePhix\Asaas;
use CodePhix\Asaas\Asaas as AsaasAsaas;
use Illuminate\Support\Facades\Http;

class AsaasConectController extends Controller
{
    

    public function Asaas_Create_id($id){
        $user = User::find($id);
        dd($user);
        $response = Http::withHeaders([
            'access_token' => '$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwMDYwMjY6OiRhYWNoXzc5YWEwNWMzLTNkMTEtNGIwZi04MjUzLWJjN2NiMmNjNDk2Yg=='
        ])->post('https://sandbox.asaas.com/api/v3/customers/', [
            'name' => $user->name,
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
        $data = json_decode($response->body());
        dd($data->id);

    }

  
}
