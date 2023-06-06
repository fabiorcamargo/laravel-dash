<div>
 
    <div class="col-auto">
        <label class="sr-only" for="inlineFormInputGroup">ID</label>
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text">ID:</div>
          </div>
          <input wire:model="search" type="search" placeholder="Insira o ID" class=" inline form-control" list="list-users"
                id="input-users">
            <datalist id="list-users">
                @foreach($users as $user)
                <option data-value="{{ $user->id }}" value="{{ $user->username }}" />
                @endforeach
            </datalist>
        </div>
        <button onclick="select_id()">Selecionar</button>
      </div>
        

    <br>
    <div class="avatar me-2 text-center">
        <img alt="avatar" src="{{ isset($user->image) ? asset($user->image) : asset('avatar/default.jpeg') }}" class="rounded-circle" width="60">
    </div>
    <div class="text-left p-4">
    <input type="text" id="id_select" value="{{ isset($user->id) ?  $user->id : "Vazio"}}" hidden>
    <input type="text" id="username_select" value="{{ isset($user->username) ?  $user->username : "Vazio"}}" hidden>
    ID: {{ isset($user->username) ?  $user->username : "Vazio"}}<br>
    Name: {{ isset($user->name) ?  $user->name : "Vazio"}} {{ isset($user->lastname) ? $user->lastname : "Vazio" }}<br>
    CPF: {{ isset($user->document) ? $user->document : "Vazio" }}<br>
    Email: {{ isset($user->email) ? $user->email : "Vazio" }}<br>
    Tel1: {{ isset($user->cellphone) ? $user->cellphone : "Vazio" }}<br>
    Tel2: {{ isset($user->cellphone2) ? $user->cellphone2 : "Vazio" }}<br>
    Cidade: {{ isset($user->city) ? $user->city : "Vazio" }} - {{ isset($user->uf) ? $user->uf : "Vazio" }}<br>
    Pagamento: {{ isset($user->payment) ? $user->payment : "Vazio" }}<br>
    Secretaria: {{ isset($user->secretary) ? $user->secretary : "Vazio" }}<br>
    Vendedor: {{ isset($user->seller) ? $user->seller : "Vazio" }}<br>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', e => {
                $('#input-users').autocomplete()
                $('select[id="nome"]').val("Glenn Quagmire")
            }, false);
          
    </script>
    <script>
        function select_id(){
            did = document.getElementById('id')
            
            console.log(document.getElementById('input-users').value)
            document.getElementById('id').value = document.getElementById('id_select').value
            document.getElementById('username').value = document.getElementById('username_select').value
        }
    </script>

</div>