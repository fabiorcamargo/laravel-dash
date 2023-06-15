<div>
    <div class="">
        <label class="sr-only" for="inlineFormInputGroup">ID</label>
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text">ID:</div>
          </div>
          <input wire:model="search" type="search" placeholder="Insira o ID" class=" inline form-control" list="list-users{{$n}}"
                id="input-users[{{$n}}]">
            <datalist id="list-users[{{$n}}]">
                @foreach($users as $user)
                <option data-value="{{ $user->username }}" value="{{ $user->username }}">
                @endforeach
            </datalist>
        </div>
        @if($i == true)
        <a href="javascript:void(0);" class="btn btn-sm btn-primary" onclick='select_id{{$n}}()'>Escolher</a>
        <a href="/modern-dark-menu/app/pay/create" class="btn btn-sm btn-secondary">Limpar</a>
        @endif
      </div>
        
@if($i == false)
<section id="sec'+x+'">
    <div class="form-row">
        <div class="form-group col-md-5"> <label>ID do Aluno</label> 
            <input type="text" id="username[{{$n}}]" name="username[{{$n}}]" class="form-control" value="{{ isset($user->username) ?  $user->username : ""}}" readonly>
            <input type="text" id="id[{{$n}}]" name="id[{{$n}}]" class="form-control" value="{{ isset($user->id) ?  $user->id : ""}}" readonly hidden></div>
        <div class="form-group col-md-7"> <label>Nome Aluno</label> 
            <input type="text"
                id="aluno[{{$n}}]" name="aluno[{{$n}}]" class="form-control" value="{{ isset($user->name) ?  $user->name : ""}} {{ isset($user->lastname) ? $user->lastname : "" }}"></div>
    </div>
</section>
    <input type="text" id="id_select[{{$n}}]" value="{{ isset($user->id) ?  $user->id : ""}}" hidden>
    <input type="text" id="username_select[{{$n}}]" value="{{ isset($user->username) ?  $user->username : ""}}" hidden>
@else
    
    <br>
    {{--<div class="avatar me-2 text-center">
        <img alt="avatar" src="{{ isset($user->image) ? asset($user->image) : asset('avatar/default.jpeg') }}" class="rounded-circle" width="60">
    </div>--}}
    <div class="text-left p-1">
    <input type="text" id="id_select[{{$n}}]" value="{{ isset($user->id) ?  $user->id : ""}}" hidden>
    <input type="text" id="username_select[{{$n}}]" value="{{ isset($user->username) ?  $user->username : ""}}" hidden>
    <p id="id_user">ID: {{ isset($user->username) ?  $user->username : ""}}<br></p>
    Name: {{ isset($user->name) ?  $user->name : ""}} {{ isset($user->lastname) ? $user->lastname : "" }}<br>
    CPF: {{ isset($user->document) ? $user->document : "" }}<br>
    Cidade: {{ isset($user->city) ? $user->city : "" }} - {{ isset($user->uf) ? $user->uf : "" }}<br>
    Pagamento: {{ isset($user->payment) ? $user->payment : "" }}<br>
    Secretaria: {{ isset($user->secretary) ? $user->secretary : "" }}<br>
    Vendedor: {{ isset($user->seller) ? $user->seller : "" }}<br><br>

    
    @if(isset($user))
    
    @if($accountable = $user->accountable)
    <input type="text" id="resp_name[{{$n}}]" value="{{ isset($accountable->name) ?  $accountable->name : ""}}" hidden>
    <input type="text" id="resp_tel[{{$n}}]" value="{{ isset($accountable->cellphone) ?  $accountable->cellphone : ""}}" hidden>
    <input type="text" id="resp_doc[{{$n}}]" value="{{ isset($accountable->document) ?  $accountable->document : ""}}" hidden>
    <input type="text" id="resp_sec[{{$n}}]" value="{{ isset($accountable->secretary) ?  $accountable->secretary : ""}}" hidden>
    Resposável: {{$accountable->name}}<br>
    Telefone: {{$accountable->cellphone}}<br>
    CPF: {{$accountable->document}}<br>
    Secretaria: {{$accountable->secretary}}<br>
    Alunos Vinculados: 
    @foreach($accountable->getuser->all() as $aluno)
        {{($aluno->username)}}/
    @endforeach
    @endif
    @endisset
    </div>
@endif
    <script>
        function select_id{{$n}}(){
            
            
            did = document.getElementById('id[{{$n}}]')
            console.log(document.getElementById('input-users[{{$n}}]').value)
            document.getElementById('id[{{$n}}]').value = document.getElementById('id_select[{{$n}}]').value
            document.getElementById('username[{{$n}}]').value = document.getElementById('username_select[{{$n}}]').value
            document.getElementById('cpf').value = document.getElementById('resp_doc[{{$n}}]').value
            document.getElementById('responsavel').value = document.getElementById('resp_name[{{$n}}]').value
            document.getElementById('telefone').value = document.getElementById('resp_tel[{{$n}}]').value

            $('#cliente').append("<h5>Aluno já possuí um responsável vinculado, para prosseguir você precisa escolher uma das opções abaixo:</h5><br><h6>Dados do Cliente</h6>");
            $('#cliente').append("Nome: "+document.getElementById('resp_name[{{$n}}]').value+"<br>");
            $('#cliente').append("Telefone: "+document.getElementById('resp_tel[{{$n}}]').value+"<br>");
            $('#cliente').append("CPF: "+document.getElementById('resp_doc[{{$n}}]').value+"<br>");
            $('#cliente').append("Secretaria: "+document.getElementById('resp_sec[{{$n}}]').value+"<br>");
            $('#myModal').modal('show');

            document.getElementById('cpf').focus();
        }
    </script>

</div>