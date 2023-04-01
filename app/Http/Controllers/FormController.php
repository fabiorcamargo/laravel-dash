<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ChatbotAsset as ControllersChatbotAsset;
use App\Models\ChatbotAsset;
use App\Models\City;
use App\Models\FormCampaignCode;
use App\Models\FormCampain;
use App\Models\FormLead;
use App\Models\State;
use App\Models\User;
use App\Models\Whatsapp_client;
use App\Models\WhatsappBulkStatus;
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

    public function add_show_course_create(){
        $campaign = FormCampain::all();

        $url = "https://ead.ouromoderno.com.br/ws/v2/unidades/cursos/" . env('OURO_UNIDADE');
        $ouro = new OuroModerno;
        $payload ="";
        $data = "";
        $courses = ($ouro->request($payload, $url, $data, "get")->object())->data;

        //dd($courses);
        
        return view('pages.app.campaign.add_course', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('campaign', 'courses'));
    }

    public function add_course_create(Request $request){
        dd($request->all());

        FormCampaignCode::create([
            'name' => $request->name,
            'form_campains_id' => $request->campaign,
            'course' => $request->campaign,
            'code' => $request->course,
            'end_date' => $request->date,
        ]);
        
        $campaign = FormCampain::all();

        $url = "https://ead.ouromoderno.com.br/ws/v2/unidades/cursos/" . env('OURO_UNIDADE');
        $ouro = new OuroModerno;
        $payload ="";
        $data = "";
        $courses = ($ouro->request($payload, $url, $data, "get")->object())->data;

        //dd($courses);
        
        return view('pages.app.campaign.add_course', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('campaign', 'courses'));
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
        Cookie::queue('fbid', $fbclid, 0);

        $form = FormCampain::find($id);
        Cookie::queue('fbcity', $form->city, 0);

        return view('pages.app.form.end', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('form'));
    }

    public function end_post(Request $request, $id){

        $faker = \Faker\Factory::create();
        $password = ($faker->randomNumber(5, false));
        $faker = \Faker\Factory::create();
        $username = "GRA" . $faker->randomNumber(5, false);

        $form = FormCampain::find($id);

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
        $user->email = $request->email !== "" ? $request->email : $username . "@profissionalizaead.com.br";
        $user->email2 = $username . "@profissionalizaead.com.br";
        $user->cellphone = preg_replace('/[^0-9]/', '',$request->cellphone);
        $user->cellphone2 = preg_replace('/[^0-9]/', '',$request->cellphone);
        $user->city = $form->city;
        $user->city2 = $form->city;
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
        
        $form->leads()->create([
            'user_id' => $user->id
        ]);

        $user->password = $password;

        $numero = preg_replace("/[^0-9]/", "", $request->cellphone);
        $nome = $request->name;
        $msg = "Parabéns seu cadastro foi realizado com sucesso, segue os dados para acesso:\n\nLogin: $user->username\n\nSenha: $user->password\n\nhttps://alunos.profissionalizaead.com.br/login\n\nPara confirmar o recebimento dos dados, salve o nosso contato e nos envie um *ok*.";

        $send = new ControllersChatbotAsset;
        $send->chatbot_send($form->chip, $numero, $msg);

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
        $send = collect(['total', 'error', 'success', 'confirm']);
        $send->total = (WhatsappBulkStatus::where('campaign', $id)
        ->get());
        $send->error = (WhatsappBulkStatus::where('wamid', 'Não enviado')
        ->where('campaign', $id)
        ->get());
        $send->success = (WhatsappBulkStatus::where('wamid',"!=", 'Não enviado')
        ->where('campaign', $id)
        ->get());

        $send->confirm = (Whatsapp_client::where('quality', '!=', '')->get());
        


        //$send->confirm = WhatsappBulkStatus::client_get();

        //$send->confirm = Whatsapp_client::where('quality', '!=', '')->get();
        


        //dd($send);



        $campaign = FormCampain::find($id);
        $users = User::leftJoin('form_leads', 'users.id', '=', 'form_leads.user_id')->where('form_campain_id', $id)
         ->select('users.*')
         ->where('active', 2)
         ->orderBy('updated_at', 'desc')
         ->get();

         //dd($users);
         

        $uss = User::leftJoin('form_leads', 'users.id', '=', 'form_leads.user_id')->where('form_campain_id', $id)
         ->select('users.*')
         ->where('active', 2)
         ->orderBy('updated_at', 'desc')
         ->get();
        
        $total = count($uss);
        
        $d =  collect(['h', 'o', 't']);
        $d->h = 0;
        $d->o = 0;
        $d->t = 0;
        foreach($uss as $us){
        $date = Carbon::parse($us->created_at);
        if ($date->isToday() == true){
            $d->h++;
            $hoje = $d->h;
        }
        if ($date->isYesterday() == true){
            $d->o++;
            $ontem = $d->o;
        }
        if ($date->format('d/m/y') == Carbon::parse('Now -2 days')->format('d/m/y')){
            $d->t++;
            $tres = $d->t;
        }
        
        }

        //dd($d);

        return view('pages.app.campaign.list_leads', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'campaign' => $campaign, 'total' => $total], compact('users', 'd', 'send'));

    }

    public function correct_campaign(){
        $bulks = WhatsappBulkStatus::all();
        foreach($bulks as $bulk){
            $bulk->campaign = 1;
            $bulk->save();
        }
    }

    
}

