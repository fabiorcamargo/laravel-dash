<?php

namespace App\Http\Controllers;

use App\Imports\OuroBulk;
use App\Models\OuroClient;
use App\Models\OuroCombo;
use App\Models\OuroCourse;
use App\Models\OuroList;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
          exit();
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

    public function criar_aluno($id){

      if(OuroModerno::check_token() == false){
        $msg = "Por favor insira o código novamente";

        return back()->withErrors(__($msg));
      }
      $url = 'https://ead.ouromoderno.com.br/ws/v2/alunos';
      $type = "POST";
      $user = User::find($id);
      $payload = [
        'token' => env('OURO_POST_TOKEN'),
        'nome' => "$user->name $user->lastname",
        'doc_cpf' => 25798847004,
        'senha' => '123456',
        'data_nascimento' => '1986-11-13',
        'email' => "$user->username@profissionalizaead.com.br",
        'fone' => '00000000',
        'doc_rg' => '00000000',
        'celular' => '000000000',
        'pais' => 'BR',
        'uf' => "$user->uf2",
        'cidade' => "$user->city2",
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
        $msg = "Erro na requisição: $request->info";
        //dd($request);
        return back()->withErrors(__($msg));
        exit();
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
        //dd($request);
        return $ouro_user;
      }
  }

    public function criar_matricula($liberation, $ouro){
          //dd($liberation);

          if(OuroModerno::check_token() == false){
            $msg = "Por favor insira o código novamente";
    
            return back()->withErrors(__($msg));
            exit();
          }

          $url = "https://ead.ouromoderno.com.br/ws/v2/alunos/matricula/$ouro->ouro_id";
          $payload = [
            'token' => env('OURO_POST_TOKEN'),
            'cursos' => $liberation->course_code
          ];
          $type = "POST";
          $request = OuroModerno::req($payload, $url, $type);
			
			if(!isset($request->data->id)){
            $msg = "Por favor refaça a liberação";
    
            return false;
            exit();	
          }
		//dd($request->data->id);
          $libs = (explode(",", $liberation->course_code));

			
          foreach($libs as $lib){
            $course = (OuroList::where('course_id', $lib)->first());
            $ouro->matricula_ouro()->create([
              'ouro_id' => $ouro->ouro_id,
              'ouro_course_id' => $course->course_id,
              'code' => $request->data->id,
              'name' => $course->name,
              'data_fim' => $request->data->data_fim,
            ]);
          }

          $msg = "Curso liberado com sucesso acompanhe a data de finalização para não perder o prazo!";
          return true;

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
        //dd($reposta->status);
        if($reposta->status == "false"){
          
         return "false";

        }else{
        $user->client_ouro()->update([
          'login_auto' => $reposta->data->token,
          'expiration' => $expiration
        ]);
        return "true";
      }
      }
      return "true";
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
          exit();       
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

    public function user_course_delete(OuroCourse $ouro){
      //dd($ouro);
      
      $payload = ['token' => env('OURO_POST_TOKEN'),];
      
      $url = "https://ead.ouromoderno.com.br/ws/v2/alunos/removercurso/$ouro->ouro_id/$ouro->ouro_course_id?token=".env('OURO_TOKEN');
      //dd($url);
      $type = "POST";

      $request = OuroModerno::req($payload, $url, $type);
      dd($request);
      $return = $request->status;
      if($return == true){
        $status = "Cursos Excluído com Sucesso";
        return back()->with('status', __($status)); 
  
        exit();
        }else{
            $msg = "Erro! Por favor refaça a operação";
    
            return back()->withErrors(__($msg));
            exit();	
          }


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
      $status = "Lista atualizada com sucesso!";
      return back()->with('status', __($status));
      exit();
    }

    public function ouro_create_liberation(Request $request, $id){
       
      $user = (User::find($id));

      if($request->users_list_tags && $request->course_list){
        $combos = collect(json_decode($request->users_list_tags));
        $cb = (($combos->implode('courses', ',')));
        $de = array('[','"',"]");
        $para = array('','','');
        $cb = (str_replace($de, $para, $cb));

        $courses = collect(json_decode($request->course_list));
        $cs = json_encode((explode(",", $courses->implode('value', ','))));
        $de = array('[','"',"]");
        $para = array('','','');
        $cs = (str_replace($de, $para, $cs));

        $data = ($cb . "," . $cs);
        $liberation = (object)['course_code' => $data, 'course_name' => $combos->implode('name', ', ') . ", " . $courses->implode('name', ', ')];

        //dd($liberation->course_code);
      } else if($request->users_list_tags){
        $combos = collect(json_decode($request->users_list_tags));
        $cb = (($combos->implode('courses', ',')));
        $de = array('[','"',"]");
        $para = array('','','');
        $cb = (str_replace($de, $para, $cb));
        $liberation = (object)['course_code' => $cb, 'course_name' => $combos->implode('name', ', ')];

        //dd($liberation);
      } else if($request->course_list){
        $courses = collect(json_decode($request->course_list));
        $cs = json_encode((explode(",", $courses->implode('value', ','))));
        $de = array('[','"',"]");
        $para = array('','','');
        $cs = (str_replace($de, $para, $cs));
        $liberation = (object)['course_code' => $cs, 'course_name' => $courses->implode('name', ', ')];

        //dd($liberation);
      }
      
      
      
      /*$data = ($cs . $cb);

      $de = array('[','"',"]");
      $para = array('','','');
      $data = (str_replace($de, $para, $data));

      $liberation = ['course_code' => $data, 'name' => $combos->implode('name', ', ')];
      dd($liberation);*/

      if(!$user->client_ouro()->first()){
        $aluno = OuroModerno::criar_aluno($id);
      }else{
        $aluno = $user->client_ouro()->first();
      }

      //$aluno = $user->client_ouro()->delete();
      //$aluno->matricula_ouro->first()->delete();

      //dd($aluno);

      $return = OuroModerno::criar_matricula($liberation, $aluno);

      if($return == true){
      $status = "Cursos Liberados com Sucesso";
      return back()->with('status', __($status)); 

      exit();
      }else{
          $msg = "Por favor refaça a liberação";
  
          return back()->withErrors(__($msg));
          exit();	
        }
      }
       
    

    public function combo_create(Request $request){
      

      foreach($request->all() as $key => $r){
        if($r == null){
          $error = "Campo $key está vazio!!!";
          return back()
          ->withErrors([$key => __($error)]);
          exit();
        }
      }
      //dd((int)$request->combo_days);
      //dd('n');

      $comb = array();
      $combo = json_decode($request->course_list);
      $i = 0;
      //dd($combo);
      foreach($combo as $c){
        $comb[$i] = $c->value;
        $i++;
      }
      OuroCombo::create([
        'name' => $request->combo_name,
        'courses' => json_encode($comb),
        'days' => (int)$request->combo_days
      ]);

      $status = "Combo criado com sucesso";
      return back()->with('status', __($status));  
      exit(); 
    }

    public function combo_edit(Request $request, $id){
      foreach($request->all() as $key=>$r){
        //dd($key);
        if(str_contains($key, "course_list")){
          $course_list = $r;
        }
      }
      $comb = array();
      $combo = json_decode($course_list);
      $i = 0;
      foreach($combo as $c){
        $comb[$i] = $c->value;
        $i++;
      }
      $ouro = OuroCombo::find($id);
      $ouro->name = $request->combo_name;
      $ouro->courses = json_encode($comb);
      $ouro->days = (int)$request->combo_days;
      $ouro->update();
      
      $status = "Combo atualizado com sucesso";
      return back()->with('status', __($status));  
      exit(); 
    }

    public function combo_delete(Request $request, $id){
      $ouro = OuroCombo::find($id);
      $ouro->delete();
      
      $status = "Combo excluído com sucesso";
      return back()->with('status', __($status)); 
      exit();  
    }

    public function show_list_courses (){
      $products = OuroList::all();
      $combos = OuroCombo::all();

      return view('pages.app.ouro.list', ['title' => 'Ouro | Profissionaliza EAD', 'breadcrumb' => 'Lista Cursos Ouro'], compact('products', 'combos'));
    }

    public function img_up(Request $request, $id){

      $product = OuroList::find($id);
                    if($request->hasFile('image')){
                        $image = $request->file('image');
                        $file_name = $image->getClientOriginalName();
  
                        $image->storePubliclyAs("/ouro/$product->id" , $file_name, ['visibility'=>'public', 'disk'=>'product']);
                            $img = "/product/ouro/$product->id" . '/' .$file_name;
                            $product->img = $img;
                            $product->save();
                    }

                       return "$img";
    }

    public function img_rm(Request $request, $id){
      dd($request->all());
    }

    public function correct_img_course(){
      $lists = OuroList::all();

      foreach($lists as &$list){
        if($list->img == null || $list->img == "resources/images/Curso Liberado.jpg"){
          $list->update([
            "img" => "/product/ouro/Curso Liberado.jpg"
          ]);
        }
      }

    }

    public function show_list_alunos(){
      $users = OuroClient::paginate(20);
      //dd($ouro_list);
      return view('pages.app.ouro.listouro', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('users'));
    }

    public function search(Request $request)
    {
        //dd($request->input());
        $query  = OuroClient::query();
        if ($request->has('secretary')) {
            $query->where('secretary', 'LIKE', '%' . $request->secretary . '%');
        }
       
        $users = $query->paginate();
        //dd($users);
        return view('pages.app.user.list', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'secretary' => $request->secretary], compact('users'));
    }

}
