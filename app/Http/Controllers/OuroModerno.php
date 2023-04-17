<?php

namespace App\Http\Controllers;

use App\Imports\OuroBulk;
use App\Models\OuroClient;
use App\Models\OuroList;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class OuroModerno extends Controller
{

    public function check_token(){
     
        $token = env('OURO_TOKEN') . ":"; 
        $url = "https://ead.ouromoderno.com.br/ws/v2/unidades/token/check/" . env('OURO_POST_TOKEN');
        $curl = curl_init();
                  curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    //CURLOPT_POSTFIELDS => $payload,
                    CURLOPT_HTTPHEADER => array(
                      'Authorization: Basic ' . base64_encode($token)
                    ),
                  ));
                  $response = curl_exec($curl);
                  curl_close($curl);
        if(curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200){
          return true;
        }else{
          $url = "https://ead.ouromoderno.com.br/ws/v2/unidades/token/" . env('OURO_UNIDADE');
                  curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    //CURLOPT_POSTFIELDS => $payload,
                    CURLOPT_HTTPHEADER => array(
                      'Authorization: Basic ' . base64_encode($token)
                    ),
                  ));
                  $response = curl_exec($curl);
                  curl_close($curl);
                  if(curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200){
                    $path = base_path('.env');
                    $content = file_get_contents($path);
                    if (file_exists($path)) {
                        $ini = [env('OURO_POST_TOKEN')];
                        $fim = [json_decode($response)->data->token];
                        file_put_contents($path, str_replace($ini, $fim, $content));
                    }
                    return true;
                  }else{
                    return false;
                  }
                   
                }
                return false;

    }

    public function req($payload, $url, $type){
      $token = env('OURO_TOKEN') . ":";  
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
            'Authorization: Basic ' . base64_encode($token)
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    
    public function criar_aluno_auth($liberation){

        if(OuroModerno::check_token() == false){
          $msg = "Por favor insira o código novamente";
          return back()->withErrors(__($msg));
        }
        $url = 'https://ead.ouromoderno.com.br/ws/v2/alunos';
        $type = "POST";
        $user = User::find(Auth::user()->id);
        //$user->client_ouro()->delete();
        $payload = [
          'token' => env('OURO_POST_TOKEN'),
          'nome' => "$user->name $user->lastname",
          'doc_cpf' => $user->document,
          'senha' => '123456',
          'data_nascimento' => '1986-11-13',
          'email' => "$user->username@profissionalizaead.com.br",
          'fone' => '00000000',
          'doc_rg' => '00000000',
          'celular' => '000000000',
          'pais' => 'BR',
          'uf' => 'PR',
          'cidade' => 'Maringá',
          'endereco' => 'rua',
          'complemento' => 'outro',
          'bairro' => 'centro',
          'cep' => '87020035',
          'login_info' => 'EMAIL',
          'senha_inicial' => 0
        ];
        //dd($payload);
        $request = OuroModerno::req($payload, $url, $type);
        if($request->status !== "true" || $request->data->id == 0){
          $msg = "Não liberado contatar suporte!";
          return back()->withErrors(__($msg));
        }else{
          sleep(1);
          $url = "https://ead.ouromoderno.com.br/ws/v2/alunos/token/" . $request->data->id;
          $payload = "";
          $type = "GET";
          $expiration = (Carbon::now()->addHour(6));
          $reposta = OuroModerno::req($payload, $url, $type);
          $ouro_user = $user->client_ouro()->create([
            'ouro_id' => $request->data->id,
            'nome' => $request->data->nome,
            'usuario' => $request->data->usuario,
            'senha' => $request->data->senha,
            'login_auto' => $reposta->data->token,
            'expiration' => $expiration
          ]);
          return $ouro_user;
        }
    }

    public function criar_matricula($liberation, $ouro){
          //dd($liberation);
          $url = "https://ead.ouromoderno.com.br/ws/v2/alunos/matricula/$ouro->ouro_id";
          $payload = [
            'token' => env('OURO_POST_TOKEN'),
            'cursos' => $liberation->course_code
          ];
          $type = "POST";
          $request = OuroModerno::req($payload, $url, $type);
          $response = $ouro->matricula_ouro()->create([
            'ouro_id' => $ouro->ouro_id,
            'ouro_course_id' => $request->data->id,
            'code' => $liberation->course_code,
            'name' => $liberation->course_name,
            'data_fim' => $request->data->data_fim,
          ]);

          $msg = "Curso liberado com sucesso acompanhe a data de finalização para não perder o prazo!";
          return $msg;

    }

    public function avalia_liberacao($liberation){
      $date = new Carbon;
      if($liberation->start_date <= $date->now() && $liberation->end_date >= $date->now()){
        return true;
      }else{
        return false;
      }
    }

    public function check_user_token(){
      $user = Auth::user();
      if(Carbon::now() > OuroClient::where('user_id', (Auth::user()->id))->value('expiration')){
        $url = "https://ead.ouromoderno.com.br/ws/v2/alunos/token/" . OuroClient::where('user_id', (Auth::user()->id))->value('ouro_id');
        $payload = "";
        $type = "GET";
        $expiration = (Carbon::now()->addHour(6));
        $reposta = OuroModerno::req($payload, $url, $type);
        $user->client_ouro()->update([
          'login_auto' => $reposta->data->token,
          'expiration' => $expiration
        ]);
        return false;
      }
    }

    public function bulk_user_create_show(){
      return view('pages.app.user.lote_ouro', ['title' => 'Profissionaliza EAD | Início', 'breadcrumb' => 'Início']);
}

    public function bulk_user_create(Request $request){
            $file = $request->file;
            $name = $file->getClientOriginalName();
            $path = ($file->getPath());
            $ouros = Excel::toCollection(new OuroBulk, $file);
            foreach($ouros[0] as &$ouro){
            //dd($ouro['username']);
            if(User::where('username', $ouro['username'])->first()){
              $ouro['exist'] = true;
            }else{
              $ouro['exist'] = false;
            }
          }
          $status = "Fluxo criado com sucesso";
          return back()->with('status', __($status));        
    }
    public function bulk_user_ouro($ouro){

    }

    public function bulk_user_show($id){

      $user = User::find($id);
      //dd($user);
      $client_ouro = (User::find($id)->client_ouro()->first());
      $course_ouro = ($client_ouro->matricula_ouro()->get());
      return view('pages.app.user.list_ouro', ['title' => 'Profissionaliza EAD Ouro - Lista de Cursos', 'breadcrumb' => 'This Breadcrumb']);
    }

    public function get_courses_list(){
      $url = "https://ead.ouromoderno.com.br/ws/v2/unidades/cursos/" . env('OURO_UNIDADE');
      $ouro = new OuroModerno;
      $payload ="";
      $data = "";
      $courses = ($ouro->req($payload, $url, "GET")->data);

      foreach($courses as $course){
        if(OuroList::where('course_id', $course->id)->first()){
        }else{
          OuroList::create([
            'course_id' => $course->id,
            'name' => $course->nome,
            'modulo' => $course->modulo,
            'aulas' => $course->aulas,
            'carga' => $course->carga,
            'descricao' => $course->descricao
          ]);
        }
      }
    }

    public function ouro_create_liberation(Request $request, $id){
       $user = (User::find($id));
       
      dd($id);
       dd($request->ouro_course);
       
    }

}
