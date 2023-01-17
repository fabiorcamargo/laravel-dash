<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCademiRequest;
use App\Jobs\cademi as JobsCademi;
use App\Models\{
  Cademi,
    CademiCourse,
    User
};
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use stdClass;

class ApiController extends Controller
{
  protected $cademi;
  protected $user;

    public function __construct(Cademi $cademi, User $user, CademiCourse $cademicourses)
    {
        $this->cademi = $cademi;
        $this->cademi = $cademicourses;
        $this->user = $user;
    }

        public function getAllUsers(Request $request){

                $explode_id = json_decode($request->getContent(), true);
               // Storage::disk('local')->put('example.txt', $explode_id['event_id']);
                $user = $explode_id['event']['usuario']['email'];
              // $user = $this->model->find(10);
                $id = DB::table('users')->where('email', $user)->value('id');

                return redirect()->route('api.cademi.store', $id);
        }




        public function store(Request $request)
                {
                
                  $data = json_decode($request->getContent(), true);
                  $arr = (object)$data['event']['usuario'];
                  //dd($arr->id);

                  //$tabela = $this->user->where('email', $arr->email)->first();
                  $tabela = $this->user->where('email2', $arr->email)->first();

                  if(empty($tabela['id'])){
                    return response("Usuário não encontrado");
                  }else{
                    $userId =$tabela['id'];
                    if (!$user = $this->user->find($userId)) {
                      return redirect()->back();
                      return response("Usuário não confere");
                    }
                    $response =  $user->cademis()->create([
                      'user' => $arr->id,
                      'nome' => $arr->nome,
                      'email' => $arr->email,
                      'celular' => $arr->celular,
                      'login_auto' => $arr->login_auto,
                      'gratis' => $arr->gratis,
                      'visible' => isset($arr->visible)
                  ]);
                    
  
                      return response($response, 200);

                  }     
                
          }

          public function verify()
                {
                  $array = array(
                    array('developer' => array('name' => 'Taylor')),
                    array('developer' => array('name' => 'Dayle')),
                    array('developer' => array('name' => 'Dayle')),
                );
                $i = 0;
                $url = "https://profissionaliza.cademi.com.br/api/v1/usuario";
                foreach($array as $arr){
                  $response = Http::withHeaders([
                    'Authorization' => env('CADEMI_TOKEN_API')
                ])->get("$url");
  
                  $jsonData = $response->json();
                  //dd($jsonData);
                  $users = ($jsonData['data']['usuario']);
                  $url = ($jsonData['data']['paginator']['next_page_url']);
                  //dd($page);
                  //dd($users);




                  foreach($users as $user){
                    //$email = User::where('email', $user['email'])->first();
                    //$email2 = User::where('email2', $user['email'])->first();
                    if (!empty($email = User::where('email', $user['email'])->first())){
                      $cademi = new Cademi();

                      $cademi->user_id = $email['id'];
                      $cademi->user = $user['id'];
                      $cademi->nome = $user['nome'];
                      $cademi->email = $user['email'];
                      $cademi->celular = $user['celular'];
                      $cademi->login_auto = $user['login_auto'];
                      $cademi->gratis = $user['gratis'];


                      if (Cademi::where('user_id', $email['id'])->first()){
                        
                      } else {
                        $cademi->save();
                        //dd($cademi);
                      }
                      
                      
                      

                    } else if (!empty($email = User::where('email2', $user['email'])->first())){
                      $cademi = new Cademi();

                      $cademi->user_id = $email['id'];
                      $cademi->user = $user['id'];
                      $cademi->nome = $user['nome'];
                      $cademi->email = $user['email'];
                      $cademi->celular = $user['celular'];
                      $cademi->login_auto = $user['login_auto'];
                      $cademi->gratis = $user['gratis'];



                      if (Cademi::where('user_id', $email['id'])->first()){
                        
                      } else {
                        $cademi->save();
                        
                        //dd($cademi);
                      }
                      
                     


                    }
          
                  
                  
            }
                      $i++;
                      }
                      dd($i);
        }



                public function course_store(Request $request){

                  {
                
                    $data = json_decode($request->getContent(), true);
                    //dd($data);
                    $arr = (object)$data['event']['usuario'];
                    //dd($arr->id);
                    $entrega = (object)$data['event']['entrega'];
                    //dd($entrega);
                  
                    $user = $this->user->where('email2', $arr->email)->first();
                 
                     // dd($tabela);
                  
                    //$tabela = $this->user->where('email', $arr->email)->first();
                    
                    //dd("não");

                  
                    //dd($user);
                    //$cademi = Cademi::where('user', $arr->id)->first();
                    //dd($cademi);
                    if(empty($cademi = Cademi::where('user', $arr->id)->first())){
                    
                    if(empty($user['id'])){
                      return response("Usuário não encontrado");
                    }else{
                      $userId = $user['id'];
                      if (!$user = $this->user->find($userId)) {
                        return redirect()->back();
                        return response("Usuário não confere");
                      }

                      
                      $aluno =  $user->cademis()->create([
                        'user' => $arr->id,
                        'nome' => $arr->nome,
                        'email' => $arr->email,
                        'celular' => $arr->celular,
                        'course_id' => $entrega->engine_id,
                        'course_name' => $entrega->nome,
                        'login_auto' => $arr->login_auto,
                        'gratis' => $arr->gratis,
                        'visible' => isset($arr->visible)
                    ]);
                  }
                }
                
                
                
                    if(empty($course = CademiCourse::where('doc', $entrega->id)->first())){
                    $course =  $user->cademicourses()->create([
                      'user' => $arr->id,
                      'course_id' => $entrega->engine_id,
                      'course_name' => $entrega->nome,
                      'doc' => $entrega->id,
                      ]);
                      
                      } else if($course = CademiCourse::where('doc', $entrega->id)->first()) {
                        
                      }
                      
    
                        return response("Aluno: $user->username | Curso: $course->id", 200);
  
                         
                  
            }
          }


         
}