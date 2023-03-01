<?php

namespace App\Http\Controllers;


use App\Models\FormCampain;
use App\Models\User;
use Illuminate\Http\Request;


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
        ]);
        //dd($request->all());
        return back();
        
    }

    public function end_show($id){

        $form = FormCampain::find($id);

        return view('pages.app.form.end', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('form'));
    }

    public function end_post(Request $request, $id){

        //dd($request->all());

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
        $user->email2 = $request->email;
        $user->cellphone = preg_replace('/[^0-9]/', '',$request->cellphone);
        $user->cellphone2 = preg_replace('/[^0-9]/', '',$request->cellphone);
        $user->secretary = "TB";
        $user->seller = "Internet";
        $user->password = bcrypt($password);
        $user->role = "1";
        $user->active = "1";
        $user->courses = "GRATUITO-AUX";
        $user->document = 99999999999;
        $user->save();

        Auth::login($user);
        
        $user->password = $password;

        $numero = preg_replace("/[^0-9]/", "", $request->cellphone);
        $nome = $request->name;
        $msg = "Parabéns seu cadastro foi realizado com sucesso, segue os dados para acesso:\n\nLogin: $user->username\n\nSenha: $user->password\n\nhttps://alunos.profissionalizaead.com.br/login\n\nPara confirmar o recebimento dos dados, salve o nosso contato e nos envie um *ok*.";
        $form = FormCampain::find($id);
        //dd($form);
        $send = new ChatbotAsset;
        $send->chatbot_send($form->chip, $numero, $msg);

        

        //dd('teste');
        
        return Redirect('https://alunos.profissionalizaead.com.br/modern-dark-menu/aluno/my');
    }
}

