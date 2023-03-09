<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ChatbotAsset as ControllersChatbotAsset;
use App\Models\ChatbotAsset;
use App\Models\City;
use App\Models\FormCampain;
use App\Models\FormLead;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function add_show(){
        $states = State::all('abbr', 'id');
        $assets = ChatbotAsset::all();
        return view('pages.app.campaign.add', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('states', 'assets'));
    }

    public function create(Request $request){

        //dd($request->all());
        $city = City::find($request->city);
        $uf = State::find($request->state);
        //dd($uf);
        FormCampain::create([
            'name' => $request->form_name,
            'city' => $city->name . " - " . $uf->abbr,
            'description' => $request->description,
            'redirect' => $request->redirect,
            'chip' => $request->chip,
        ]);
        //dd($request->all());
        return back();
        
    }

    public function end_show($id){

        $fbclid = ((string) Str::uuid());
        //dd($fbclid);
        Cookie::queue('fbid', $fbclid, 0);

        $form = FormCampain::find($id);

        return view('pages.app.form.end', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('form'));
    }

    public function end_post(Request $request, $id){

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
        $user->email = $request->email;
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
        //dd($user);
        $user->save();

        Auth::login($user);

        

        $form = FormCampain::find($id);
        $form->leads()->create([
            'user_id' => $user->id
        ]);

        $user->password = $password;

        $numero = preg_replace("/[^0-9]/", "", $request->cellphone);
        $nome = $request->name;
        $msg = "Parabéns seu cadastro foi realizado com sucesso, segue os dados para acesso:\n\nLogin: $user->username\n\nSenha: $user->password\n\nhttps://alunos.profissionalizaead.com.br/login\n\nPara confirmar o recebimento dos dados, salve o nosso contato e nos envie um *ok*.";

        $send = new ControllersChatbotAsset;
        //$send->chatbot_send($form->chip, $numero, $msg);

        $event = new ConversionApiFB;
        $event->Lead();
        
        return Redirect('/modern-dark-menu/aluno/my');
    }

    public function code_verify(Request $request){
        //dd($request->all());
        $status = "error";
        $msg = "Código de ativação inválido";

        return back()->with($status, $msg);
    }

    public function redir(Request $request, $id){

        //$fbclid = ((string) Str::uuid());
        //dd($fbclid);
        //Cookie::queue('fbclid', $fbclid, 60);

        return redirect("/modern-light-menu/app/form/end/$id");
        //return redirect()->route('form-end-show', ['id' => $id]);
    }


    public function show(User $user){
              
      /* Verificar !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $forms = FormCampain::all();
       
        $leads = User::leftJoin('form_leads', 'users.id', '=', 'form_leads.user_id')->where('form_campain_id', 2)
         ->select('users.*')
         ->where('active', 2)
         ->get();
  
        dd($leads); !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/ 
          
      $users = ($user->where('active', 2)->orderBy('updated_at', 'desc')->paginate(20));
    //dd($user->lead());

    
//            User::first()->where('active', 1)->orderBy('updated_at', 'desc')->paginate(20);

            return view('pages.app.campaign.list', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('users'));

    }

    public function list_campaigns(){
              
          $forms = FormCampain::paginate(20);   
          
          foreach ($forms as &$form){
            
            $leads = User::leftJoin('form_leads', 'users.id', '=', 'form_leads.user_id')->where('form_campain_id', $form->id)
            ->select('users.*')
            ->where('active', 2)
            ->orderBy('updated_at', 'desc')
            ->count();
            $form->leads = $leads;
            //dd($leads);
          }

          //dd($forms);
      
  //            User::first()->where('active', 1)->orderBy('updated_at', 'desc')->paginate(20);
  
              return view('pages.app.campaign.list_campaigns', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('forms'));
  
      }

      public function list_leads($id){
              
        $campaign = FormCampain::find($id);
        $users = User::leftJoin('form_leads', 'users.id', '=', 'form_leads.user_id')->where('form_campain_id', $id)
         ->select('users.*')
         ->where('active', 2)
         ->orderBy('updated_at', 'desc')
         ->paginate(20);
        
        $d =  collect(['h', 'o']);
        $d->h = 0;
        $d->o = 0;
        foreach($users as $user){
        $date = Carbon::parse($user->created_at);
        if ($date->isToday() == true){
        $d->h++;
        $hoje = $d->h;
        }
        if ($date->isYesterday() == true){
            $d->o++;
            $ontem = $d->o;
        }
        }

        //dd($ontem);

        return view('pages.app.campaign.list_leads', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'campaign' => $campaign], compact('users', 'd'));

    }
}

