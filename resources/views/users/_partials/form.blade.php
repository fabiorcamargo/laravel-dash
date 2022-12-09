<div class="w-full bg-white shadow-md rounded px-8 py-12">
    @csrf
    <input type="text" name="name" placeholder="Nome:" value="{{ $user->name ?? old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline my-2">
    <input type="email" name="email" placeholder="E-mail:" value="{{ $user->email ?? old('email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline my-2">
    


    <input type="text" name="cellphone" placeholder="Celular:" value="{{ $user->cellphone ?? old('cellphone') }}" class="cellphone shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline my-2">
    <input type="text" name="city" placeholder="Cidade:" value="{{ $user->city ?? old('city') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline my-2">
    <input type="text" name="uf" placeholder="UF:" value="{{ $user->uf ?? old('uf') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline my-2">
    <input type="text" name="payment" placeholder="Pagamento:" value="{{ $user->payment ?? old('payment') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline my-2">
    
    <fieldset>
              
        <input id="10courses" class="peer/sim" type="radio" name="10courses" value='1' checked />
        <label for="sim" class="peer-checked/sim:text-sky-500">Sim</label>
      
        <input id="10courses" class="peer/nao" type="radio" name="10courses" value='0' />
        <label for="nao" class="peer-checked/nao:text-sky-500">Não</label>
      
        <div class="hidden peer-checked/sim:block">Aluno <b>Contratou</b> os 10 Cursos</div>
        <div class="hidden peer-checked/nao:block">Aluno <b>não Contratou</b> os 10 Cursos</div>
      </fieldset>


    <input type="text" name="secretary" placeholder="Secretaria:" value="{{ $user->secretary ?? old('secretary') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline my-2">
    <input type="text" name="document" placeholder="CPF:" value="{{ $user->document ?? old('document') }}" class="cpf shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline my-2 required" onblur="return verificarCPF(this.value)">
    
    <input type="text" name="seller" placeholder="Divulgador:" value="{{ $user->seller ?? old('seller') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline my-2">
    <input type="text" name="courses" placeholder="Cursos:" value="{{ $user->courses ?? old('courses') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline my-2">



    <fieldset>
              
        <input id="role" class="peer/admin" type="radio" name="role" value="1" checked />
        <label for="admin" class="peer-checked/admin:text-sky-500">admin</label>
      
        <input id="role" class="peer/aluno" type="radio" name="role" value="7" />
        <label for="aluno" class="peer-checked/aluno:text-sky-500">Alunos</label>
      
        <div class="hidden peer-checked/admin:block">Usuários administradores da plataforma</div>
        <div class="hidden peer-checked/aluno:block">Alunos da Plataforma</div>
      </fieldset>


    

    <input type="password" name="password" placeholder="Senha:" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline my-2">
    <input type="file" name="image" class="block w-full text-sm text-slate-500
    file:mr-4 file:py-2 file:px-4
    file:rounded-full file:border-0
    file:text-sm file:font-semibold
    file:bg-violet-50 file:text-violet-700
    hover:file:bg-violet-100
    py-5
  ">
    <button type="submit" class="w-full shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
        Enviar
    </button>
</div>





@extends('layouts.modal')
@section('title-modal', 'CPF Inválido')
@section('desc-modal', 'O formato do CPF é inválido, favor verificar!')



  





<script>$(document).ready(function($){
    $('.cpf').mask('000.000.000-00', {reverse: false});
    $('.cellphone').mask('(00) 0 0000-0000', {reverse: false});
}
)    </script>

<script>
    //arquivo funcoes_cpf.js
// validador CPF
    
    
    
function verificarCPF(d){
    c = d.replace(/[^0-9]/g,'');
    var i;
    s = c;
    var c = s.substr(0,9);
    var dv = s.substr(9,2);
    var d1 = 0;
    var v = false;
 
    for (i = 0; i < 9; i++){
        d1 += c.charAt(i)*(10-i);
    }
    if (d1 == 0){
        openModal('modal')
        v = true;
        return false;
    }
    d1 = 11 - (d1 % 11);
    if (d1 > 9) d1 = 0;
    if (dv.charAt(0) != d1){
        openModal('modal')
        v = true;
        return false;
    }
 
    d1 *= 2;
    for (i = 0; i < 9; i++){
        d1 += c.charAt(i)*(11-i);
    }
    d1 = 11 - (d1 % 11);
    if (d1 > 9) d1 = 0;
    if (dv.charAt(1) != d1){
        openModal('modal')
        v = true;
        return false;
    }
    if (!v) {
    }	
	
}
</script>