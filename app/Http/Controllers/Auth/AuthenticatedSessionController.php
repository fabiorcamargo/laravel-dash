<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login2', ['title' => 'Profissionaliza EAD - Seu melhor sistema de ensino', 'breadcrumb' => 'Login']);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        //dd(Auth::user());
        $request->session()->regenerate();

        if(empty(Auth::user()->first)){
        $home = '/modern-dark-menu/aluno/first';
        }else if(Auth::user()->first == 4){    
        $home = '/modern-dark-menu/aluno/pw_change';  
        }else{ 
        if ((Auth::check())){
        $home = '/modern-dark-menu/aluno/my';    
        }}
        
        return redirect()->intended($home);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::to('https://alunos.profissionalizaead.com.br/login');;
    }
}
