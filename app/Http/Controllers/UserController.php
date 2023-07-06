<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserFormRequest;
use App\Models\Avatar;
use App\Models\Cademi;
use App\Models\CademiCourse;
use App\Models\CademiImport;
use App\Models\CademiTag;
use App\Models\ChatbotGroup;
use App\Models\City;
use App\Models\EcoSallerType;
use App\Models\EcoSeller;
use App\Models\OuroClient;
use App\Models\OuroCombo;
use App\Models\OuroList;
use App\Models\Role;
use App\Models\State;
use App\Models\TemporaryFile;
use App\Models\User;
use App\Models\UserMessage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Nette\Utils\Arrays;
use PhpParser\Node\Expr\Cast\Object_;
use stdClass;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $user, State $state, City $cities, TemporaryFile $file, Avatar $avatar)
    {
        $this->user = $user;
        $this->state = $state;
        $this->cities = $cities;
        $this->file = $file;
        $this->avatar = $avatar;
        
    }

    public function index(Request $request)
    {
        $users = $this->user
                        ->getUsers(
                            search: $request->search ?? ''
                        );

        return view('users.index', compact('users'));
        
    }

    public function show($id)
    {
        // $user = $this->model->where('id', $id)->first();
        if (!$user = $this->user->find($id))
            return redirect()->route('users.index');

        return view('users.show', compact('user'));
    }

    public function store(StoreUpdateUserFormRequest $request)
    {
        $data = $request->all();
        $user = auth()->user();
        
        $data['password'] = bcrypt($request->password);
        $de = array('.','-');
        $para = array('','');
        $data['document'] = str_replace($de, $para, $request->document);
        $de = array('(',')',' ','-');
        $para = array('','','','');
        $data['cellphone'] = str_replace($de, $para, $request->cellphone);
        if ($request->image) {
            $data['image'] = $request->image->store('users');
            // $extension = $request->image->getClientOriginalExtension();
            // $data['image'] = $request->image->storeAs('users', now() . ".{$extension}");
        }
        
        $response = json_decode(($this->model->create($data)), true);

        $id = ($response['id']);
        //return redirect()->route('users.show', $id);
        
        return redirect()->route('cademi.create', $id);
        

        //return redirect()->route("/users/$id/cademi/create")->$response;

        // $user = new User;
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password = $request->password;
        // $user->save();
    }

    public function edit($id)
    {
        if (!$user = $this->user->find($id))
            return redirect()->route('users.index');

        return view('users.edit', compact('user'));
    }

    public function update(StoreUpdateUserFormRequest $request, $id)
    {
        if (!$user = $this->user->find($id))
            return redirect()->route('users.index');

        $data = $request->only('name', 'email');
        if ($request->password)
            $data['password'] = bcrypt($request->password);

        if ($request->image) {
            if ($user->image && Storage::exists($user->image)) {
                Storage::delete($user->image);
            }

            $data['image'] = $request->image->store('users');
        }

        $user->update($data);

        return redirect()->route('users.index');
    }

    public function block_cademi($id, Request $request) {
        $user = $this->user->find($id);
        if($user->first < 3){
            $obs = "Motivo: $request->motivo\r\nTipo: Cademi\r\nObs: $request->obs\r\nBloqueado por: ".Auth::user()->name;
            $user->first = 3;
        }elseif($user->first == 4){
            $obs = "Motivo: $request->motivo\r\nTipo: Cademi\r\nObs: $request->obs\r\nBloqueado por: ".Auth::user()->name;
            $user->first = 5;
        }
        $user->observation()->create([
            'obs' => $obs
        ]);
        $user->save();        
        return back()->with([
            'status' => "Cursos Cademi bloqueados com sucesso!"
        ]);
    }

    public function desblock_cademi($id, Request $request) {
        $user = $this->user->find($id);
        if($user->first == 3){
            $obs = "Motivo: $request->motivo\r\nTipo: Cademi\r\nObs: $request->obs\r\nBloqueado por: ".Auth::user()->name;
            $user->first = 2;
        }elseif($user->first == 5){
            $obs = "Motivo: $request->motivo\r\nTipo: Cademi\r\nObs: $request->obs\r\nBloqueado por: ".Auth::user()->name;
            $user->first = 4;
        }
        $user->observation()->create([
            'obs' => $obs
        ]);
        //dd($user);
        $user->save();        
        return back()->with([
            'status' => "Cursos Cademi desbloqueados com sucesso!"
        ]);
    }
    public function desblock_ouro($id, Request $request) {
        $user = $this->user->find($id);
        if($user->first == 4){
            $obs = "Motivo: $request->motivo\r\nTipo: Ouro\r\nObs: $request->obs\r\nBloqueado por: ".Auth::user()->name;
            $user->first = 2;
        }elseif($user->first == 5){
            $obs = "Motivo: $request->motivo\r\nTipo: Ouro\r\nObs: $request->obs\r\nBloqueado por: ".Auth::user()->name;
            $user->first = 3;
        }
        $user->observation()->create([
            'obs' => $obs
        ]);
        $user->save();        
        return back()->with([
            'status' => "Cursos Ouro desbloqueados com sucesso!"
        ]);
    }

    public function block_ouro($id, Request $request) {
        $user = $this->user->find($id);
        if($user->first < 3){
            $obs = "Motivo: $request->motivo\r\nTipo: Ouro\r\nObs: $request->obs\r\nBloqueado por: ".Auth::user()->name;
            $user->first = 4;
        }elseif($user->first == 3){
            $obs = "Motivo: $request->motivo\r\nTipo: Ouro\r\nObs: $request->obs\r\nBloqueado por: ".Auth::user()->name;
            $user->first = 5;
        }
        $user->observation()->create([
            'obs' => $obs
        ]);
        $user->save();        
        return back()->with([
            'status' => "Cursos Ouro bloqueados com sucesso!"
        ]);
        /*
        $user = $this->user->find($id);
        //dd($user);
        $r = str_replace(" ", "", $user->courses);
        $courses = explode(",",  $r);
        //dd($courses);

        foreach($courses as $course){
         $payload = [
             "token" => env('CADEMI_TOKEN_GATEWAY'),
             "codigo"=> "CODD-$course-$user->username",
             "status"=> "disputa",
             "recorrencia_status" => "em-atraso",
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

         if (env('APP_DEBUG') == true){
            $data = Storage::get('file1.txt', "$user->username, $user->email2, $user->name, $user->document, $user->cellphone, $course, CODD-$course-$user->username, Debug" . PHP_EOL);
            Storage::put('file1.txt', $data . "$user->username, $user->email2, $user->name, $user->document, $user->cellphone, $course, CODD-$course-$user->username, Debug" . PHP_EOL);
            
            $url = "https://profissionaliza.cademi.com.br/api/v1/entrega/enviar";
            $cademi = json_decode(Http::withHeaders([
                'Authorization' => env('CADEMI_TOKEN_API')
            ])->post("$url", $payload));

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
         
            if (isset($cademi->data[0]->erro)){
                //dd($cademi);
                $import = new CademiImport();
                $import->username = $user->username;
                $import->status = "error";
                $import->msg = $cademi->data[0]->erro;
                $import->body = json_encode($cademi);
                $import->save();

            }else{

                $import = new CademiImport();
                $import->username = $user->username;
                $import->status = "success";
                $import->course = $course;
                $import->code = "CODD-$course-$user->username";
                $import->msg = $cademi->data[0]->status . "Bloqueado Acesso";
                $import->body = json_encode($cademi);
                $import->save();
            }

    }*/
                
        
            
    }

    public function active($id) {
        
        
        $user = $this->user->find($id);
        $r = str_replace(" ", "", $user->courses);
        $courses = explode(",",  $r);

        /*foreach($courses as $course){
         $payload = [
             "token" => env('CADEMI_TOKEN_GATEWAY'),
             "codigo"=> "CODD-$course-$user->username",
             "status"=> "aprovado",
             "recorrencia_status" => "ativo",
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

         if (env('APP_DEBUG') == true){
            $data = Storage::get('file1.txt', "$user->username, $user->email2, $user->name, $user->document, $user->cellphone, $course, CODD-$course-$user->username, Debug" . PHP_EOL);
            Storage::put('file1.txt', $data . "$user->username, $user->email2, $user->name, $user->document, $user->cellphone, $course, CODD-$course-$user->username, Debug" . PHP_EOL);
            
            $url = "https://profissionaliza.cademi.com.br/api/v1/entrega/enviar";
            $cademi = json_decode(Http::withHeaders([
                'Authorization' => env('CADEMI_TOKEN_API')
            ])->post("$url", $payload));

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
         
            if (isset($cademi->data[0]->erro)){
                //dd($cademi);
                $import = new CademiImport();
                $import->username = $user->username;
                $import->status = "error";
                $import->msg = $cademi->data[0]->erro;
                $import->body = json_encode($cademi);
                $import->save();

            }else{

                $import = new CademiImport();
                $import->username = $user->username;
                $import->status = "success";
                $import->course = $course;
                $import->code = "CODD-$course-$user->username";
                $import->msg = $cademi->data[0]->status . "Desbloqueado Acesso";
                $import->body = json_encode($cademi);
                $import->save();
            }

    }*/
                $user->first = 2;
                $user->save();        
        
                return back();
        
            
    }

    public function getUsers() {
        $students = User::get()->toJson(JSON_PRETTY_PRINT);
        return response($students, 200);
      }

    public function list(Request $request)
    {
        $users = User::first()->where('active', 1)->orderBy('updated_at', 'desc')->paginate(20);
        return view('pages.app.user.list', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('users'));
    }

    public function listschool(Request $request)
    {

        $users = User::first()->orderBy('updated_at', 'desc')->paginate(20);
        $fillable = (app(User::class)->getFillable());
        //dd($fillable);
        return view('pages.app.user.listschool', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'fillable' => $fillable], compact('users'));
    }

    public function search(Request $request)
    {
        //dd($request->input('ouro'));
        $query  = User::query();
        if ($request->has('secretary')) {
            $query->where('secretary', 'LIKE', '%' . $request->secretary . '%');
        }
        if ($request->has('search')) {
            $query->where('username', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->has('ouro')) {
            if($request->input('ouro') == "Sim"){
                    $query->join('ouro_clients', function (JoinClause $join) {
                        $join->on('users.id', '=', 'ouro_clients.user_id');
                    })
                    ->get();
                }else if($request->input('ouro') == 10){
                    $query->where('ouro', '=', 1);
            }
        }
        
        foreach ($request->input() as $nome => $valor) {
            if($nome != "_token" && $nome != "page" && $nome != "ouro"){
                if ($valor) { 
                    $query->where($nome, 'LIKE', '%' . $valor . '%');
                }
            }
        }
        $users = $query->orderBy('users.updated_at', 'desc')->paginate();
        //dd($users);
        return view('pages.app.user.list', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'secretary' => $request->secretary], compact('users'));
    }

    public function resp(Request $request)
    {
        $users = $this->user
                        ->getUsers(
                            search: $request->search ?? ''
                        );

        return view('pages.app.user.list', ['title' => 'Alunos | teste', 'breadcrumb' => 'This Breadcrumb'], compact('users'));
    }

    public function create(Request $request)
    {

        
        return view('pages.app.user.create', ['title' => 'Profissionaliza EAD Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
    }

    public function lote(Request $request)
    {
        $cademis = CademiImport::first()->orderBy('updated_at', 'desc')->paginate(20);
        
        return view('pages.app.user.lote', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('cademis'));
    }

    public function username()
    {
        $field = [['name'=> Auth::user()->name],
        ['email'=> Auth::user()->email]
    ];
        return compact($field);
    }

    public function post(Request $request)
    {
        //$observation = ($_POST['observation']);
        //dd($request->all());
        if (str_contains(url()->previous(), "profile")){
            $user = $this->user->find($request->id);

            if($request->password == null){
                $user->password = $user->password;
            } else {
                $user->password = bcrypt($request->password);
            }
            if(Auth::user()->role == 4 || Auth::user()->role == 6 || Auth::user()->role == 7 || Auth::user()->role == 8){
            $user->email2 = $request->email2;
            $de = array('(',')',' ','-');
            $para = array('','','','');
            $user->cellphone2 = str_replace($de, $para, $request->cellphone2);
            $user->payment = $request->payment;
            $user->secretary = $request->secretary;
            $de = array('.','-');
            $para = array('','');
            $user->document = str_replace($de, $para, $request->document);
            //dd($user);
            if( $request->ouro == "on"){
                $user->ouro = 1;
                }else{
                $user->ouro = 0;   
                }
                /*
            if( $request->first == "on"){
                $user->first = 0;
                } else {
                $user->first = 1;   
                }*/
            
        }
           // return redirect("/modern-dark-menu/app/user/profile/$user->id")->with('sucess', 'Verdade');
        }else{
            //dd('n');
            $user = $this->user->find(Auth::user()->id);
            $user->first = 1;
        }

        
        //$user->first = 1;
        if($request->password == null){
            $user->password = $user->password;
        } else {
            $user->password = bcrypt($request->password);
        }
        
        
        $de = array('(',')',' ','-');
        $para = array('','','','');
        $user->cellphone = str_replace($de, $para, $request->cellphone);
        if ($request->image) {
            $user->image = $request->image->store('users');
            // $extension = $request->image->getClientOriginalExtension();
            // $data['image'] = $request->image->storeAs('users', now() . ".{$extension}");
        }
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        if (is_numeric($request->city)){
            //dd('s');
        $city = City::where('id', $request->city)->first();
        //]dd($city);
        $user->city = $city->name;
        $state = State::where('id', $city->state_id)->first();
        $user->uf = $state->abbr;
            //dd($user);
        } else {
            //dd('n');
            $request->city != "" ? $user->city = $request->city : "";
            $request->state != "" ? $user->uf = $request->state : "";
        }

        if (is_numeric($request->city2)){
            //dd('s');
        $city2 = City::where('id', $request->city2)->first();
        $user->city2 = $city2->name;
        $state2 = State::where('id', $city2->state_id)->first();
        $user->uf2 = $state2->abbr;
        } else {
            $request->city2 != "" ? $user->city2 = $request->city2 : "";
            $request->state2 != "" ? $user->uf2 = $request->state2 : "";
        }
        //dd($user);
        if (isset($request->role)){
        $user->role = (integer)$request->role;
        }
        //dd($user);
        $request->pw_change == "on" ? $user->active = 4 : "";

        //dd($user);
        //$city = preg_replace('/[^0-9]/', '', $data['city']);
        //$city2 = City::where('id', $city)->first();
        //$uf = State::where('id', $city2->state_id)->first();
        

       // $user->city = $city2->name;
        //$user->uf = $uf->abbr;
        $request->observation != null ? $user->observation = $request->observation : "";
        //dd($user);
        $user->update();
        $status = "Usuário atualizado com sucesso!";
        
        if (str_contains(url()->previous(), "profile")){
            return redirect("/modern-dark-menu/aluno/profile/$user->id")->with('status', __($status));
        }
        
        
        return view('pages.aluno.second', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'Ativação']);
    }


    public function my(){

        //$cards = new stdClass;
        $data = $this->avatar->where('user_id', Auth::user()->id)->first();
        if ( $data != null ){
            $avatar =  $data->folder . "/" . $data->file;
        } else {
            $avatar = "/default.jpeg";
        }

        $cards[0] = array(
            'img' => "product/cademi/em-breve.jpg",
            'title' => "Em Breve"
            );
        //$cards[0]->img = "resources/images/em-breve.jpg";
        //$cards[0]->title = "Em Breve";

        if(Auth::user()->first == 3){
            $cards[0] = array(
            'img' => "resources/images/Curso Bloqueado.jpg",
            'title' => "Seu curso está bloqueado"
            );
        }else{

            if (Cademi::where('user_id', Auth::user()->id)->first()){
            if((Auth::user()->courses != "")){
                $courses = explode(",", Auth::user()->courses);
                
                $i = 0;
                foreach($courses as $course){
                    if(CademiTag::where('name', $course)->first()){
                        $cards[$i] = array(
                        "id" => CademiTag::where('name', $course)->first()->tag_id,
                        'tag' => CademiTag::where('name', $course)->first()->name,
                        'img' => CademiTag::where('name', $course)->first()->img == null ? "product/cademi/Curso Liberado.jpg" : CademiTag::where('name', $course)->first()->img,
                        'title' => CademiTag::where('name', $course)->first()->title == null ? "Seu curso está liberado" : CademiTag::where('name', $course)->first()->title
                        );
                    }else{
                        $cards[$i] = array(
                            'id' => ""
                        );
                    }
                    $i++;
                }
                
            }
            
            }else{
                $cards[0] = array(
                    'img' => "product/cademi/em-breve.jpg",
                    'title' => "Em Breve"
                    );
            }
        }
        if ( $data != null ){
            $avatar =  $data->folder . "/" . $data->file;
        } else {
            $avatar = "/default.jpeg";
        }

//        dd(Auth::user()->client_ouro()->first()->login_auto);
/*
        $user = User::find(Auth::user()->id);
        if ($user->uf2 != ""){
        $state = State::where("abbr", $user->uf2)->first();
        $city = City::where([["name", $user->city2],["state_id", $state->id]])->first();

        $r = str_replace(" ", "", $user->courses);
        $courses = explode(",",  $r);
        $i=0;
        foreach($courses as $course){
            $groups[$i] = ChatbotGroup::where([["city", $city->id],["group_code", $course]])->first();
            $i++;
        }
    }else{
        $groups = null;
    }*/

        //$event = new ConversionApiFB;
        //$event->Lead();

        //dd(Auth::user()->courses);
        
        if(Auth::user()->client_ouro->first()){
            //dd('s');
            $ouro = new OuroModerno;
            $ouro_status = $ouro->check_user_token();
            //dd($ouro_status);
            $msg = "Usuário inválido favor contatar suporte!!!";
        }else{
            $ouro_status = "true";
        }

        if (Auth::user()->courses == "GRATUITO-AUX" && Auth::user()->active == 2){
            $card = "resources/images/GRATUITO-AUX.jpg";
            if($ouro_status == "false"){
                return view('pages.aluno.my', ['title' => 'Profissionaliza EAD | Início', 'breadcrumb' => 'Início', 'avatar' => $avatar], compact('cards'))->withErrors(__($msg));
            }else{
                return view('pages.aluno.my', ['title' => 'Profissionaliza EAD | Início', 'breadcrumb' => 'Início', 'avatar' => $avatar], compact('cards'));
            }
            
        }else{  
            $ouro = "resources/images/Curso Liberado.jpg";
            if($ouro_status == "false"){
                return view('pages.aluno.my', ['title' => 'Profissionaliza EAD | Início', 'breadcrumb' => 'Início', 'avatar' => $avatar, 'ouro' => $ouro], compact('cards'))->withErrors(__($msg));    
            }else{
                return view('pages.aluno.my', ['title' => 'Profissionaliza EAD | Início', 'breadcrumb' => 'Início', 'avatar' => $avatar, 'ouro' => $ouro], compact('cards'));    
            }
        }
        if($ouro_status == "false"){
                return view('pages.aluno.my', ['title' => 'Profissionaliza EAD | Início', 'breadcrumb' => 'Início', 'avatar' => $avatar], compact('cards'))->withErrors(__($msg));
        }else{
                return view('pages.aluno.my', ['title' => 'Profissionaliza EAD | Início', 'breadcrumb' => 'Início', 'avatar' => $avatar], compact('cards'));
        }

    }

    public function newids(Request $request){

        $users = User::factory()
                ->count(10)
                ->state(new Sequence(
                    ['admin' => 'Y'],
                    ['admin' => 'N'],
                ))
                ->create();
        
        $data = $request->all();
        //dd($data);
        $data['password'] = bcrypt($request->password);
        $de = array('.','-');
        $para = array('','');
        $data['document'] = str_replace($de, $para, $request->document);
        $de = array('(',')',' ','-');
        $para = array('','','','');
        $data['cellphone'] = str_replace($de, $para, $request->cellphone);
        if ($request->image) {
            $data['image'] = $request->image->store('users');
            // $extension = $request->image->getClientOriginalExtension();
            // $data['image'] = $request->image->storeAs('users', now() . ".{$extension}");
        }
            
        
        $response = json_decode(($this->model->create($data)), true);

        $id = ($response['id']);
        
               
                
                
        
        
                return view('pages.aluno.my', ['title' => 'Profissionaliza EAD | Início', 'breadcrumb' => 'Início']);
        
            }


        public function charge(Request $request)
    {
        $user = $this->user->find(Auth::user()->id);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['image'] = 'avatar/default.jpeg';
        //dd($data);
        $user->update($data);
        
        
        return view('pages.aluno.charge', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'Charge']);
    }

    public function reset(Request $request)
    {
        
        $data = $request->all();
        //dd($request->first);
        $user = $this->user->where('username', $data['username'])->first();
        
        $data['password'] = bcrypt($request->password);
        if($request->first = "on" ){
            $data['first'] = null;
        } else if($request->first = "off" ){
            $data['first'] = "1";
        }
   
        $user->password = $data['password'];
        $user->first = $data['first'];
        //dd($user);
        $user->update();
        //dd(Cademi::where('user_id', Auth::user()->id)->first());


        if (Cademi::where('user_id', Auth::user()->id)->first()){
            if(str_contains(Auth::user()->courses, "PRE")){
             $card = "resources/images/Militar.jpg";
             //dd($card);
            }else if(str_contains(Auth::user()->courses, "AG")){
             $card = "resources/images/Bancario.jpg";
            }else if(str_contains(Auth::user()->courses, "CPA")){
                $card = "resources/images/cpa10.jpg";
            }else{
                $card = "resources/images/em-breve.jpg";
            }
         
         }else{
             $card = "resources/images/em-breve.jpg";
         }
        //dd($card);
        
        return view('pages.aluno.my', ['title' => 'Profissionaliza EAD | Início', 'breadcrumb' => 'Início', 'avatar' => "Auth::user()->id", 'card' => $card]);
    }

    public function first(){
    
    
        $states = State::all('name', 'id');

    
    return view('pages.aluno.first', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'Início', 'file' => 'teste', 'states' => $states]);
    }


    public function city($id)
    {
        $cities = City::where("state_id",$id)
                    ->pluck('name','id');
                   //dd($cities);
        return json_encode($cities);
    }


    public function profile($id)
    {
        if((Auth::user()->role) == 1 ){
            //dd("1");
            if(Auth::user()->id != $id){
                return back();
            }
        }
        //dd("ok");
        //dd(UserController::getIp());
        
        if(!(User::find($id))){
            $msg = "Não foi possível localiza usuário.";
            return redirect('/modern-dark-menu/aluno/my')->withErrors(__($msg));
        }
        $user = User::find($id);
        
        
        $cademi = Cademi::where('user_id', $user->id)->first();
        //dd($cademi);
        $i = 0;
        $n = 0;
        if(!empty($cademi)){
        $cademicourses = CademiCourse::where('user_id', $user->id)->get();
        //dd($cademi);
        //dd($cademicourses);
        //dd($user);
        $response = Http::withToken(env('CADEMI_TOKEN_API'))->get("https://profissionaliza.cademi.com.br/api/v1/usuario/acesso/$cademi->user");    
       //dd($response);
       //dd($response->status()); 
        $profiler = json_decode($response->body(), true);

        //dd($profiler);

        if ($response->status() !== 200){
            $courses[$i] = ["name" => "Vazio", "perc" => "0%"];
        }
        //dd($profiler);
        if ($response->status() == 200){
        $produtos = ($profiler['data']['acesso']);

        //dd($produtos);
        
        foreach ($produtos as $produto){
            //dd($produto);
            $response = Http::withToken(env('CADEMI_TOKEN_API'))->get('https://profissionaliza.cademi.com.br/api/v1/usuario/progresso_por_produto/' . $cademi->user . '/' . $produto['produto']['id']);
            $data = (json_decode($response->body(), true));

            //dd($data);
			
			if($response->status() !== 200){
				$courses[$i] = ["row" => "$i",  "name" => $produto['produto']['nome'], "perc" => "0%"];
			}
			//dd($courses);
            
            if (isset($data['data']['progresso'])){
                $courses[$i] = ["row" => "$i", "name" => $produto['produto']['nome'], "perc" => $data['data']['progresso']['total']];
            }
            
            
                if (isset($data['data']['progresso']['aulas'])){
                    //dd('s');
                        $aulas = $data['data']['progresso']['aulas'];
                        //dd($aulas);
                        foreach($aulas as $aula){
                            $courses[$i]['aula'][$n] = ["nome" => $aula['aula']['nome'], "data" => date('d-m-Y H:i:s', strtotime($aula['acesso_em']))];
                            $n++;
                        }
                        $n = 0;
                        //dd($courses);
                    }
                    //dd('n');
        
            
            

            
        $i++;    
    }
    
    }else{
        $courses[0] = ["row" => "$i", "name" => "Vazio", "perc" => "0%"];
        
    }
    }else{
        $courses[0] = ["row" => "$i","name" => "Vazio", "perc" => "0%"];

        //dd($courses);
    }

    if(  EcoSeller::where([['user_id', '=', $user->id],['type', '<>', 0]])->first() ){
                            //dd("sim");
        $seller = "sim";
    }else{
        $seller = "não";
    }
        $seller_types = EcoSallerType::all();


        if($user->client_ouro()->first()){
            $client_ouro = $user->client_ouro()->first();
            $course_ouro = ($client_ouro->matricula_ouro()->get());

            //dd($course_ouro);
        }else{
            $client_ouro = "";
            $course_ouro = "";
        }

        $ouro_courses = OuroList::all();
        $ouro_combos = OuroCombo::all();
        $messages = UserMessage::all();
        $ultimo_acesso = Carbon::parse(isset($profiler['data']['usuario']['ultimo_acesso_em']) ? $profiler['data']['usuario']['ultimo_acesso_em'] : "");
        //dd($ultimo_acesso);

           if(str_contains(url()->previous(), "aluno")){
            return view('pages.aluno.profile', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'ultimo_acesso' => $ultimo_acesso], compact('user', 'cademi', 'courses', 'seller_types', 'seller', 'client_ouro', 'course_ouro', 'ouro_courses', 'ouro_combos','messages'));
        } else {
            return view('pages.aluno.profile', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'ultimo_acesso' => $ultimo_acesso], compact('user', 'cademi', 'courses', 'seller_types', 'seller', 'client_ouro', 'course_ouro', 'ouro_courses', 'ouro_combos','messages'));
        }
           
       
        }

        public function profile_edit($id)
    {

        if((Auth::user()->role) < 4 ){
            //dd("1");
            if(Auth::user()->id != $id){
                return back();
            }

        }
        //dd($id);
        $user = $this->user->find($id);
        //dd($user);
        $cademi = Cademi::where('user_id', $user->id)->first();

        $roles = Role::all('id', 'name');
        //dd($role);
/*
        if(!empty($cademi)){
        $cademicourses = CademiCourse::where('user_id', $user->id)->get();
        //dd($cademi);
        //dd($cademicourses);
        //dd($user);
        
        $response = Http::withToken(env('CADEMI_TOKEN_API'))->get("https://profissionaliza.cademi.com.br/api/v1/usuario/acesso/$cademi->user");    
//        dd($response);
        $profiler = json_decode($response->body(), true);
        //dd($profiler);
        if ($response['code'] == 200){
        $produtos = ($profiler['data']['acesso']);
        $i = 0;
        foreach ($produtos as $produto){
            //dd($course['produto']['id']);
            $response = Http::withToken(env('CADEMI_TOKEN_API'))->get('https://profissionaliza.cademi.com.br/api/v1/usuario/progresso_por_produto/' . $cademi->user . '/' . $produto['produto']['id']);
            $data = (json_decode($response->body(), true));
            if($data['code'] !== 200){
				$courses[$i] = ["name" => $produto['produto']['nome'], "perc" => "0%"];
			}
            
            if ($i == 2){
           // dd($data);
        }
        if (isset($data['data']['progresso'])){
            $courses[$i] = ["name" => $produto['produto']['nome'], "perc" => $data['data']['progresso']['total']];

            //dd($courses);
           
        }
         $i++;   
    }
			
    }else{
        $courses[0] = ["row" => 0, "name" => "Vazio", "perc" => "0%"];
        
    }
    }else{
        $courses[0] = ["row" => 0, "name" => "Vazio", "perc" => "0%"];

        //dd($courses);
    }*/

    $states = State::all('name', 'id');
    
    //dd($courses);
        
           //dd($response->body()); 

           if(str_contains(url()->previous(), "aluno")){
            return view('pages.aluno.profile-edit', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('user', 'cademi', 'states', 'roles'));
           }else{
            return view('pages.aluno.profile-edit', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('user', 'cademi', 'states', 'roles'));
           }
           
       
        }

        public function courses_profile($id){
        $user = User::find($id);
        $cademi = Cademi::where('user_id', $user->id)->first();
        $cademicourses = CademiCourse::where('user_id', $user->id)->get();
            $i=0;
        foreach($cademicourses as $course){
            
            $courses[$i] = ["user" => $course->user, "course_id" => $course->course_id, "doc" => $course->doc, "created_at" => $course->created_at, "updated_at" => $course->updated_at];
            $i++;
        }
        //dd($courses);

        

        //dd($user);
        //dd($cademi);
        //dd($courses);



        return view('pages.app.user.listcourses', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('user', 'cademi', 'courses'));

       
        }

        public function usercademi(Request $request)
        {

           $users = User::all();
           foreach($users as $user){
                if(Cademi::where('user_id', $user->id)->first()){
                    $user->first = 2;
                    $user->save();
                    //dd($user);
                }
               // dd("n");
           }
           //dd($user[0]);
           echo("Fim");
        }
        
        public function corr_email(){
            $users = User::all();
            foreach($users as $user){
                $user->email = strtolower($user->email);
                $user->email2 = strtolower($user->email2);
                $user->save();
            }

        }

        public function cpf_send(Request $request){
            
            $de = array('.','-');
            $para = array('','');
            $cpf = str_replace($de, $para, $request->cpf);
            
            $this->validate($request, [
                'cpf' => 'required|cpf',
            ]);

            $user = Auth::user();
            $user->document = $cpf;
            $user->save();

            $status = "success";
            $msg = "CPF atualizado com sucesso";

            $status = "CPF atualizado com sucesso";
            return back()->with('status', __($status));;

        }
        public function pw_change(Request $request){
            $user = Auth::user();
            $user->password = bcrypt($request->password);
            $user->active = 1;
            $user->save();

            //dd($user);
            //dd('/modern-dark-menu/aluno/my');
            $status = "Nova senha salva com sucesso";
            return(redirect('/modern-dark-menu/aluno/my')->with('status', __($status)));
            
        }

        public function getIp(){
            foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
                if (array_key_exists($key, $_SERVER) === true){
                    foreach (explode(',', $_SERVER[$key]) as $ip){
                        $ip = trim($ip); // just to be safe
                        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                            return $ip;
                        }
                    }
                }
            }
            return request()->ip(); // it will return the server IP if the client IP is not found using this method.
        }
       
    }