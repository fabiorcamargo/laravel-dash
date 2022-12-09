<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCommentRequest;
use App\Models\{
    Cademi,
    User
};

use App\Http\Requests\StoreUpdateCademiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CademiController extends Controller
{
    protected $cademi;
    protected $user;

    public function __construct(Cademi $cademi, User $user)
    {
        $this->cademi = $cademi;
        $this->user = $user;
    }

    public function create($userId)
    {
        if (!$user = $this->user->find($userId)) {
            return redirect()->back();
        }
       // dd($user->id);

        $payload = [
            "token" => env('CADEMI_TOKEN_GATEWAY'),
            "codigo"=> "codc" . $user->id,
            "status"=> "aprovado",
            "produto_id"=> "novo1",
            "cliente_email"=> $user->email,
            "cliente_nome"=> $user->name,
            "cliente_doc"=> $user->document,
            "cliente_celular"=> $user->cellphone,
            "cliente_endereco_cidade"=> $user->city,
            "cliente_endereco_estado"=> $user->uf,
            "produto_nome" => $user->courses
        ];

        //dd($payload);
        

        //Cria um novo aluno na cademi

        Http::post("https://profissionaliza.cademi.com.br/api/postback/custom", $payload);
        
        return redirect()->route('users.index');
    }
    
    public function store(Request $request, $userId)
    {

        $user = $this->user->find($userId);
        
        
        if (!$user = $this->user->find($userId)) {
            return redirect()->back();
        }

        $user->cademi()->create([
            'body' => $request->body,
            'visible' => isset($request->visible)
        ]);

        return response($user, 200);
    }

}