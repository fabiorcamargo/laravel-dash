<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class RedirCademiController extends Controller
{
    public function redir_get(Request $request){
        if(Auth::user()){
            if(Auth::user()->cademis()->exists()){
                $new_url = (str_replace("https://profissionaliza.cademi.com.br/auth/login", "https://profissionaliza.cademi.com.br/" . request()->input('url'), Auth::user()->cademis()->first()->login_auto));
                return Redirect::to($new_url);
            } else {
                $msg = "Token inválido por favor entre em contato com o suporte";
                return Redirect::to('modern-dark-menu/aluno/my')->withErrors(__($msg));;
            }
        }else{
            return Redirect::to('modern-dark-menu/redir_login');
        }

        

        
    }
    public function redir_get_show(){

        
        return view('auth.login4', ['title' => 'Profissionaliza EAD - Seu melhor sistema de ensino', 'breadcrumb' => 'Login']);
    }

    public function redir_post(Request $request){

        //dd($request->all());

        //$url = "https://ead.profissionalizaead.com.br/local/cademi/login.php";
        $url = "ead.profissionalizaead.com.br/login/token.php?username=$request->login&password=$request->password&service=moodle_mobile_app";
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->get($url);

            
            if(!isset(json_decode($response->body())->error)){
                //dd($response->body());
            if($response->body() !== ""){
                $token = (json_decode($response->body())->token);
                //echo $token;
                $url = "ead.profissionalizaead.com.br/webservice/rest/server.php?wstoken=$token&wsfunction=core_user_get_users_by_field&field=username&values[0]=fabiotb&moodlewsrestformat=json";
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->get($url);
                $redir = (strip_tags(json_decode($response->body())[0]->customfields[22]->value));
                
                $new_url = (str_replace("https://profissionaliza.cademi.com.br/auth/login", "https://profissionaliza.cademi.com.br/" . $request->url, $redir));

                //dd($new_url);

                return Redirect::to($redir . request()->input('url'));
            }else{
                if(Auth::user()){
                    if(Auth::user()->cademis()->exists()){
                        $new_url = (str_replace("https://profissionaliza.cademi.com.br/auth/login", "https://profissionaliza.cademi.com.br/" . request()->input('url'), Auth::user()->cademis()->first()->login_auto));
                        return Redirect::to($new_url);
                    } else {
                        $msg = "Token inválido por favor entre em contato com o suporte";
                        return Redirect::to('modern-dark-menu/aluno/my')->withErrors(__($msg));;
                    }
                }else{
                    return route('login');
                }
            }

    }
    
        if (Auth::attempt(['email' => $request->login, 'password' => $request->password, 'active' => 1])) {
            // Authentication was successful...
            if(Auth::user()){
                if(Auth::user()->cademis()->exists()){
                    $new_url = (str_replace("https://profissionaliza.cademi.com.br/auth/login", "https://profissionaliza.cademi.com.br/" . request()->input('url'), Auth::user()->cademis()->first()->login_auto));
                    return Redirect::to($new_url);
                } else {
                    $msg = "Token inválido por favor entre em contato com o suporte";
                    return Redirect::to('modern-dark-menu/aluno/my')->withErrors(__($msg));;
                }
            }
        }
        
    }
}

