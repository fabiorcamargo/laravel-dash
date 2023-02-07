<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCademiRequest;
use App\Jobs\cademi as JobsCademi;
use App\Models\{
  Cademi,
    CademiCourse,
    Chatbot_Message,
    Chatbot_Program,
    ChatbotMessage,
    ChatbotProgram,
    Customer,
    Payment,
    User
};
use Canducci\Cep\Cep;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

                  $tabela->first = 2;
                  
                  $tabela->save();
                  //dd($tabela);
                  $response->first = $tabela->first;
                      return response($response, 200);

                  }     
                
          }

          public function verify()
                {
                  $array = array(
                    array('developer' => array('name' => 'Taylor')),
                    array('developer' => array('name' => 'Dayle')),
                    array('developer' => array('name' => 'Dayle')),
                    array('developer' => array('name' => 'Dayle')),
                    array('developer' => array('name' => 'Dayle')),
                    array('developer' => array('name' => 'Dayle')),
                    array('developer' => array('name' => 'Dayle')),
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
                  if (!isset($jsonData['data']['paginator']['next_page_url'])){
                    return 'fim';
                  }
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
                      //dd($i);
        }



                public function course_store(Request $request){

                  {
                   
                    $data = json_decode($request->getContent(), true);
                    //dd($data);
                    $arr = (object)$data['event']['usuario'];
                    //dd($arr->id);
                    $entrega = (object)$data['event']['entrega'];
                    //dd($entrega);
                    $cademi = Cademi::where('user', $arr->id)->first();
                    //dd($cademi);
                    if(empty($cademi)){
                      return response("Aluno não existe", 403);
                    }
                    $user = User::where('id', $cademi->user_id)->first();
                    //dd($user);
                    $course = CademiCourse::where('doc', $entrega->id)->where('user', $arr->id)->first();
                    //dd($course);
                
                    if(empty($course)){
                      //dd('sim');
                    $course =  $user->cademicourses()->create([
                      'user' => $arr->id,
                      'course_id' => $entrega->engine_id,
                      'course_name' => $entrega->nome,
                      'doc' => $entrega->id,
                      ]);

                      
                      } else {
                        return response("Curso já cadastrado: $user->username - $course->doc", 403);
                      }
                      
    
                        return response("Aluno: $user->username | Curso: $course->id", 200);
  
                         
                  
            }
          }

/*
          public function course_transf (){

            $cademis = Cademi::all();
            //$cademicourse = CademiCourse::all();

            foreach( $cademis as $cademi) {
              dd($cademi);
              $this->$user->where('id')
              $cademicourse = Cademi::where('')

            }
            

          }
*/

          public function gateway_pay_post (Request $request){
            //$body = json_encode($request);
            //dd(($request->getContent()));
            
            $event = (object)json_decode($request->getContent(), true);
            //dd($event);
            if($event->event == "PAYMENT_RECEIVED"){
              
              $data = (object)json_decode($request->getContent(), true)['payment'];
              $user_id = Customer::where('gateway_id',$data->customer)->first()->id;
              $body = json_encode($data);

              
              $payment = new Payment();
              $payment->pay_id = $data->id;
              $payment->user_id = $user_id;
              $payment->customer = $data->customer;
              $payment->dateCreated = $data->dateCreated;
              $payment->paymentDate = $data->paymentDate;
              $payment->status = $data->status;
              $payment->body = $body;
              $payment->save();

              


              return response("User: $user_id | Payment: $payment->id", 200);
            }
            
            
          }

                public function chatbot_pre_hen (Request $request){
                  
                  $response = (json_decode($request->getContent()));
                  $header1 = (json_encode($request->header()));
                  $header = (json_decode($header1));
                  $de = array('+','-', ' ');
                  $para = array('','', '');
                  $number = str_replace($de, $para,$response->senderName);
                  $client = ChatbotMessage::where('number', $number)->first();
                  
                  
                  if(empty($client)){
                     if (!isset((ChatbotProgram::where('tipo', 'LIKE', $header->tipo)->where('i_fluxo', null)->where('message', 'LIKE', "$response->senderMessage%")->first())->response)){
                      $resposta = (ChatbotProgram::where('tipo', 'LIKE', $header->tipo)->where('i_fluxo', "Ocupado")->first())->response;
                      $resposta = '{
                        "data":[{
                                "message":"' . $resposta . '"
                        }]
                      }';
                      return  response($resposta, 200);
                     }
                      $data = (ChatbotProgram::where('tipo', 'LIKE', $header->tipo)->where('message', 'LIKE', "$response->senderMessage%")->first());
                      $resposta = '{
                        "data":[{
                                "message":"' . $data->response . '"
                        }]
                      }';
                      $client = new ChatbotMessage();
                      $client->number = $number;
                      $client->message = $response->senderMessage;
                      $client->body = json_encode($request->getContent(), true);
                      $client->i_fluxo = $data->f_fluxo;
                      $client->fluxo = $data->tipo;
                      $data->f_fluxo == "" ? "" : $client->save();;
                      return  response($resposta, 200);

                      
                  } else {

                    if(str_contains("$client->i_fluxo", "f")){
                      $resposta = ((ChatbotProgram::where('i_fluxo', 'LIKE', "$client->i_fluxo"))->first()->response);
                      $resposta = '{
                        "data":[{
                                "message":"' . $resposta . '"
                        }]
                      }';
                      return  response($resposta, 200);
                    } 
                    
                    if (isset((ChatbotProgram::where('tipo', 'LIKE', $header->tipo)->where('message', 'LIKE', "$response->senderMessage%")->where('i_fluxo', 'LIKE', "$client->i_fluxo%")->first())->response)){
                      $data = (ChatbotProgram::where('tipo', 'LIKE', $header->tipo)->where('message', 'LIKE', "$response->senderMessage%")->where('i_fluxo', 'LIKE', "$client->i_fluxo%")->first());

                      //dd($response->response);
                      $resposta = '{
                        "data":[{
                                "message":"' . $data->response . '"
                        }]
                      }';
                      $client->message = $response->senderMessage;
                      $client->body = json_encode($request->getContent(), true);
                      $client->i_fluxo = $data->f_fluxo;
                      $client->fluxo = $data->tipo;
                      $client->save();
                      return  response($resposta, 200);
                     } else {
                     $data = (ChatbotProgram::where('tipo', 'LIKE', $header->tipo)->where('i_fluxo', 'LIKE', "erro")->first());
                     $resposta = '{
                      "data":[{
                              "message":"' . $data->response . '"
                      }]
                    }';
                    return  response($resposta, 200);
                  }

                  }

                  


                }

   }
            
        
      

         
