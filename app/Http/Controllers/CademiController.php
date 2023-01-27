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
            "codigo"=> "codd" . $user->username,
            "status"=> "aprovado",
            "produto_id"=> $user->courses,
            "produto_nome"=> $user->courses,
            "cliente_email"=> $user->email2,
            "cliente_nome"=> $user->name,
            //"cliente_doc"=> $user->document,
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
        
       
        $r = str_replace(" ", "", $row['courses']);
        $courses = explode(",",  $r);

        //dd($courses);
            //dd($row);
            
            //dd($username);
           
            //return redirect()->route('cademi.create', $username);

              
        $user = (User::firstWhere('username', $row['username']));
        
                  //$user = $data;
        //dd($user);
        //foreach(){

            foreach($courses as $course){

         $payload = [
             "token" => env('CADEMI_TOKEN_GATEWAY'),
             "codigo"=> "CODD-$course-$user->username",
             "status"=> "aprovado",
             "produto_id"=> $course,
             "produto_nome"=> $course,
             "cliente_email"=> $user->email2,
             "cliente_nome"=> $user->name . " " . $user->lastname,
             "cliente_doc"=> $user->username,
             "cliente_celular"=> $user->cellphone,
             //"cliente_endereco_cidade"=> $user->city2,
             //"cliente_endereco_estado"=> $user->uf2,
             "produto_nome" => $course
         ];

         //dd($payload);
         if (env('APP_DEBUG') == true){
         //dd("não");
         $data = Storage::get('file1.txt', "$user->username, $user->email2, $user->name, $user->document, $user->cellphone, $course, CODD-$course-$user->username, Debug" . PHP_EOL);
         Storage::put('file1.txt', "$user->username, $user->email2, $user->name, $user->document, $user->cellphone, $course, CODD-$course-$user->username, Debug" . PHP_EOL);
 
         } else {
            //dd("sim");
            $data = Storage::get('file1.txt', "$user->username, $user->email2, $user->name, $user->document, $user->cellphone, $course, CODD-$course-$user->username" . PHP_EOL);
            Storage::put('file1.txt', "$user->username, $user->email2, $user->name, $user->document, $user->cellphone, $course, CODD-$course-$user->username" . PHP_EOL);
   
            Http::post("https://profissionaliza.cademi.com.br/api/postback/custom", $payload);
         }
         //dd($payload);


         //

            }
        
               
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
    public function delete(Request $request, $userId){
  
    }

}