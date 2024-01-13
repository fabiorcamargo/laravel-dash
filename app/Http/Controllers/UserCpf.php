<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\stringContains;

class UserCpf extends Controller
{
    public function cpf_send(Request $request){
            //dd($cpf);
        if (str_contains($request->cpf,".")){
            $de = array('.');
            $para = array('');
            $cpf = str_replace($de, $para, $request->cpf);
        }
        if (str_contains($cpf,"-")){
            $de = array('-');
            $para = array('','');
            $cpf = str_replace($de, $para, $cpf);
        }
        
        $this->validate($request, [
            'cpf' => 'required|cpf',
        ]);

        $user = Auth::user();
        $user->document = $cpf;
        $user->save();

        $status = "success";
        $msg = "CPF atualizado com sucesso";

        $status = "CPF atualizado com sucesso";
        return back()->with('status', __($status));

    }
}
