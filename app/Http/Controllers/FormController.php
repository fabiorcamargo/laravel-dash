<?php

namespace App\Http\Controllers;


use App\Models\FormCampain;
use App\Models\FormLead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    public function add_show(){
        return view('pages.app.form.add', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb']);
    }

    public function create(Request $request){

        //dd($request->all());
        FormCampain::create([
            'name' => $request->form_name,
            'city' => $request->form_city,
            'description' => $request->description,
            'redirect' => $request->redirect,
            'chip' => $request->chip,
        ]);
        //dd($request->all());
        return back();
        
    }

    public function end_show(Request $request, $id){

        //dd($request->all());

        $fbclid = $request->fbclid;
        $form = FormCampain::find($id);

        $event = new ConversionApiFB;
        $eventid = $event->ViewContent($request->fbclid);

        return view('pages.app.form.end', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'fbclid' => $fbclid], compact('form'));
    }

    public function end_post(Request $request, $id){

        //dd($request->all());
        $fbclid = $request->$request;

        $faker = \Faker\Factory::create();
        $password = ($faker->randomNumber(5, false));
        $faker = \Faker\Factory::create();
        $username = "GRA" . $faker->randomNumber(5, false);

        if(User::where('username', $username)->first()){
            $faker = \Faker\Factory::create();
            $password = ($faker->randomNumber(5, false));
            $faker = \Faker\Factory::create();
            $username = "GRA" . $faker->randomNumber(5, false);
        }else{
            //dd('n');
        }
        

        $nome = explode(" ", $request->nome, 2);

        $user = new User;
        $user->username = $username;
        $user->name =$nome[0];
        $user->lastname =  (isset($nome[1])) ? $nome[1] : "";
        $user->email = $username . "@profissionalizaead.com.br";
        $user->email2 = $username . "@profissionalizaead.com.br";
        $user->cellphone = preg_replace('/[^0-9]/', '',$request->cellphone);
        $user->cellphone2 = preg_replace('/[^0-9]/', '',$request->cellphone);
        $user->secretary = "TB";
        $user->seller = "Internet";
        $user->password = bcrypt($password);
        $user->role = "1";
        $user->active = "2";
        $user->first = "1";
        $user->courses = "GRATUITO-AUX";
        $user->document = 99999999999;
        $user->save();

        //Auth::loginUsingId($user->id, TRUE);

        Auth::login($user);

        $event = new ConversionApiFB;
        $eventid = $event->Lead($fbclid);

        //dd($eventid);

        $form = FormCampain::find($id);
        $form->leads()->create([
            'user_id' => $user->id
        ]);

        $user->password = $password;

        $numero = preg_replace("/[^0-9]/", "", $request->cellphone);
        $nome = $request->name;
        $msg = "Parabéns seu cadastro foi realizado com sucesso, segue os dados para acesso:\n\nLogin: $user->username\n\nSenha: $user->password\n\nhttps://alunos.profissionalizaead.com.br/login\n\nPara confirmar o recebimento dos dados, salve o nosso contato e nos envie um *ok*.";
        
        //dd($form);
        $send = new ChatbotAsset;
        $send->chatbot_send($form->chip, $numero, $msg);

        
        

        //dd('teste');
        
        return Redirect('/modern-dark-menu/aluno/my');
    }

    public function code_verify(Request $request){
        //dd($request->all());
        $status = "error";
        $msg = "Código de ativação inválido";

        return back()->with($status, $msg);
    }

    public function redir(Request $request, $id){
        //dd('test');
        //dd($request);
        if(!empty($request->fbclid)){
            $fbclid = $request->fbclid;
        }else{
            $fbclid = null;
        }
        
        //dd($fbclid);
        return redirect("/modern-light-menu/app/form/end/$id?fbclid=$fbclid");
        //return redirect()->route('form-end-show', ['id' => $id]);
    }


    public function list(User $user){
              
        
      $users = ($user->where('active', 2)->orderBy('updated_at', 'desc')->paginate(20));
    //dd($user->lead());

    
//            User::first()->where('active', 1)->orderBy('updated_at', 'desc')->paginate(20);

            return view('pages.app.form.list', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('users'));

    }
}

