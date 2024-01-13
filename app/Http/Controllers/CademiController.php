<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCommentRequest;
use App\Models\{
    Cademi,
    CademiImport,
    CademiListCourse,
    CademiTag,
    User
};

use App\Http\Requests\StoreUpdateCademiRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
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
    


    public function lote($row, $user)
    {
        $r = str_replace(" ", "", $row['courses']);
        $courses = explode(",",  $r);
        //$user = (User::firstWhere('username', $row['username']));
        //dd($user);
        foreach($courses as $course){
         $payload = [
             "token" => env('CADEMI_TOKEN_GATEWAY'),
             "codigo"=> "CODD-$course-$user->username",
             "status"=> "aprovado",
             "recorrencia_id" => "CODD-$course-$user->username",
             "recorrencia_status" => "ativo",
             "produto_id"=> $course,
             "produto_nome"=> $course,
             "cliente_email"=> $user->email2,
             "cliente_nome"=> $user->name . " " . $user->lastname,
             //"cliente_doc"=> $user->document,
             "cliente_celular"=> $user->cellphone,
             //"cliente_endereco_cidade"=> $user->city2,
             //"cliente_endereco_estado"=> $user->uf2,
             "produto_nome" => $course
         ];
         

         if (env('APP_DEBUG') == true){
            //dd('s');
            $data = Storage::get('file1.txt', "$user->username, $user->email2, $user->name, $user->document, $user->cellphone, $course, CODD-$course-$user->username, Debug" . PHP_EOL);
            Storage::put('file1.txt', $data . "$user->username, $user->email2, $user->name, $user->document, $user->cellphone, $course, CODD-$course-$user->username, Debug" . PHP_EOL);
            /*
            $url = "https://profissionaliza.cademi.com.br/api/v1/entrega/enviar";
            $cademi = json_decode(Http::withHeaders([
                'Authorization' => env('CADEMI_TOKEN_API')
            ])->post("$url", $payload));*/

            $cademi = json_decode('{
                "success": true,
                "code": 200,
                "data":
                [
                    {
                        "id": 12330850,
                        "instancia_id": 1543,
                        "integracao_id": 21462,
                        "importacao_id": null,
                        "importacao_comecou_em": null,
                        "processado": 1,
                        "engine": "custom",
                        "engine_id": "COD-1234G",
                        "recorrencia_id": null,
                        "recorrencia_status": null,
                        "recorrencia_encerra_em": null,
                        "status": "aprovado",
                        "pagamento": null,
                        "produto_id": "AG55",
                        "produto_nome": null,
                        "itens": null,
                        "cliente_nome": "Evandro Miranda",
                        "cliente_doc": "123.123.123-12",
                        "cliente_email": "fabio.xina@gmail.com",
                        "cliente_telefone": "5511991232020",
                        "cliente_endereco": null,
                        "cliente_endereco_cep": null,
                        "cliente_endereco_comp": null,
                        "cliente_endereco_n": null,
                        "cliente_endereco_bairro": null,
                        "cliente_endereco_cidade": null,
                        "cliente_endereco_estado": null,
                        "valor": null,
                        "erro": null,
                        "updated_at": "30/01/2023 às 10:18",
                        "created_at": "30/01/2023 às 10:18"
                    }
                ],
                "profiler":
                {
                    "start": 1683642813.891291,
                    "finish": 1683642813.915258,
                    "process": 0.02396702766418457
                }
            }');
            
           //dd($cademi);

         } else {
            $data = Storage::get('file1.txt', "$user->username, $user->email2, $user->name, $user->document, $user->cellphone, $course, CODD-$course-$user->username" . PHP_EOL);
                    Storage::put('file1.txt', $data . "$user->username, $user->email2, $user->name, $user->document, $user->cellphone, $course, CODD-$course-$user->username" . PHP_EOL);
   
            //Http::post("https://profissionaliza.cademi.com.br/api/postback/custom", $payload);
            $url = "https://profissionaliza.cademi.com.br/api/v1/entrega/enviar";
            $cademi = json_decode(Http::withHeaders([
                'Authorization' => env('CADEMI_TOKEN_API')
            ])->post("$url", $payload));
         }
        //dd($cademi);
         
            if (isset($cademi->data->Carga->erro)){
                //dd($cademi);
                $import = new CademiImport();
                $import->username = $user->username;
                $import->status = "error";
                $import->msg = $cademi->data[0]->erro;
                $import->body = json_encode($cademi);
                $import->save();

            }else{
                //dd($cademi);
                $import = new CademiImport();
                $import->username = $user->username;
                $import->status = "success";
                $import->course = $course;
                $import->code = $payload['codigo'];
                $import->msg = "success";
                $import->body = json_encode($cademi);
                $import->save();
            }
    }        
        //sleep(1);
        return $cademi;
    }


    public function get_user ($id){
        $user = User::find($id);
        $url = "https://profissionaliza.cademi.com.br/api/v1/usuario/$user->email2";
        $cademi = json_decode(Http::withHeaders([
            'Authorization' => env('CADEMI_TOKEN_API')
        ])->get("$url"));
        //dd($cademi);
		if(!isset($cademi->success)){
			return;
		}
        if ($cademi->success == true){
            if(Cademi::where('email', $cademi->data->usuario->email)->first() == null){
                $response = $user->cademis()->create([
                    'user' => $cademi->data->usuario->id,
                    'nome' => $cademi->data->usuario->nome,
                    'email' => $cademi->data->usuario->email,
                    'login_auto' => $cademi->data->usuario->login_auto,
                    'gratis' => $cademi->data->usuario->gratis == true ? 1 : 0
                                                    ]);
                                                    $user->first = 2;
                                                    $user->save();
            }else{
                $response = $user->cademis()->update([
                    'user' => $cademi->data->usuario->id,
                    'nome' => $cademi->data->usuario->nome,
                    'email' => $cademi->data->usuario->email,
                    'login_auto' => $cademi->data->usuario->login_auto,
                    'gratis' => $cademi->data->usuario->gratis == true ? 1 : 0
                                                    ]);
                                                    $user->first = 2;
                                                    $user->save();
                }
			return $response;
                }
        //dd($response);
       
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

    public function cademi_tag(){

            $url = "https://profissionaliza.cademi.com.br/api/v1/tag";
            $response = json_decode(Http::withHeaders([
                'Authorization' => env('CADEMI_TOKEN_API')
            ])->get("$url"));

            //dd($cademi);
        $json = $response->data->itens; 
        //dd($json);
        foreach($json as $tag){
           // dd($tag->id);
            if(CademiTag::where('tag_id', $tag->id)->first()){
                
            }else{
                $cademi_tag = new CademiTag();
                $cademi_tag->tag_id = $tag->id;
                $cademi_tag->name = $tag->nome;
                $cademi_tag->save();
            }
        }
        return back();

}
    
    public function change_token(Request $request){
        //dd($request->all());
        $cademi = Cademi::where('user_id', $request->user_id)->first();
        $cademi->login_auto = $request->login_auto;
        $cademi->save();
        
        $status = "Token de Login Automático atualizado com sucesso!";
        return back()->with('status', __($status));
    }
    public function req($url, $type, $payload){
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => $type,
          CURLOPT_POSTFIELDS => $payload,
          CURLOPT_HTTPHEADER => array(
            'Authorization: ' . env('CADEMI_TOKEN_API'),
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        return $response;

        

        
    }

    public function get_courses_list(){

        $url = 'https://profissionaliza.cademi.com.br/api/v1/produto';
        $type = 'GET';
        $payload = '';
        $response = $this->req($url, $type, $payload);
        
        $courses = json_decode($response);
        $courses = $courses->data->produto;
        //dd($courses[0]->id);
        

        foreach($courses as $course){
          if(CademiListCourse::where('course_id', $course->id)->first()){
          }else{
            $url = 'https://profissionaliza.cademi.com.br/api/v1/produto/'.$course->id;
            $response = $this->req($url, $type, $payload);
            $nome_completo = json_decode($response)->data->produto->vitrine->nome;

            CademiListCourse::create([
              'course_id' => $course->id,
              'nome' => $course->nome,
              'ordem' => $course->ordem,
              'nome_completo' => $nome_completo
            ]);
          }
        }
        $status = "Lista atualizada com sucesso!";
        return back()->with('status', __($status));
        exit();
      }

}