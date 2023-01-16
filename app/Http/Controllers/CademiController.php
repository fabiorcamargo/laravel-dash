<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCommentRequest;
use App\Models\{
    Cademi,
    User
};

use App\Http\Requests\StoreUpdateCademiRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CademiController extends Controller
{
   
    

    public function create($userId)
    {
        
        if (!$user = $this->user->find($userId)) {
            return redirect()->back();
        }
       //dd($user);

        $payload = [
            "token" => env('CADEMI_TOKEN_GATEWAY'),
            "codigo"=> "codc" . $user->username,
            "status"=> "aprovado",
            "produto_id"=> $user->courses,
            "produto_nome"=> $user->courses,
            "cliente_email"=> $user->email,
            "cliente_nome"=> $user->name,
            "cliente_doc"=> $user->document,
            "cliente_celular"=> $user->cellphone,
            "produto_nome" => $user->courses
        ];
        $data = Storage::get('file.txt', $user->username);
        Storage::put('file.txt', $data . $user->username);
        
        

        //Cria um novo aluno na cademi

        //Http::post("https://profissionaliza.cademi.com.br/api/postback/custom", $payload);
        
       // return redirect()->route('users.index');
    }
    


    public function lote($row)
    {
        
       
      
        
            //dd($row);
            
            //dd($username);
           
            //return redirect()->route('cademi.create', $username);

              
        $user = (User::firstWhere('username', $row['username']));
        
                  //$user = $data;
        //dd($user);
 
         $payload = [
             "token" => env('CADEMI_TOKEN_GATEWAY'),
             "codigo"=> "codc" . $user->username,
             "status"=> "aprovado",
             "produto_id"=> $user->courses,
             "produto_nome"=> $user->courses,
             "cliente_email"=> $user->email,
             "cliente_nome"=> $user->name . " " . $user->lastname,
             "cliente_doc"=> $user->document,
             "cliente_celular"=> $user->cellphone,
             //"cliente_endereco_cidade"=> $user->city2,
             //"cliente_endereco_estado"=> $user->uf2,
             "produto_nome" => $user->courses
         ];
         if (env('APP_DEBUG') == true){
         
         $data = Storage::get('file1.txt', $user->username . $user->email . $user->name . $user->document . $user->cellphone  . $user->courses . PHP_EOL);
         Storage::put('file1.txt', $data .$user->username . $user->email . $user->name . $user->document . $user->cellphone . $user->uf2 . $user->courses . PHP_EOL);
 
         } else {
            $data = Storage::get('file1.txt', $user->username . $user->email . $user->name . $user->document . $user->cellphone . $user->courses . PHP_EOL);
            Storage::put('file1.txt', $data .$user->username . $user->email . $user->name . $user->document . $user->cellphone . $user->courses . PHP_EOL);
   
            Http::post("https://profissionaliza.cademi.com.br/api/postback/custom", $payload);
         }
         //dd($payload);
         
 
         //Cria um novo aluno na cademi
 
         
         //

        
        
               
        return '';
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