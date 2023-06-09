<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon"
        href="https://ead.profissionalizaead.com.br/pluginfile.php/1/theme_edumy/favicon/1651025660/bitmap.png">

    <title>Boletos</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    
        @livewireStyles
</head>

<ul class="nav justify-content-end">
    <li class="nav-item">
        <a type="button" class="btn btn-danger" href="/modern-dark-menu/aluno/my">"Sair do Sistema"</a>
    </li>
</ul>

<body class="bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4"
                src="https://ead.profissionalizaead.com.br/pluginfile.php/1/theme_edumy/headerlogo1/1651025660/Prancheta%203%20%28Personalizado%29.png"
                alt="" width="245" height="72">

            <h2>Sistema de Geração de Boletos</h2>

            <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />


        </div>
    </div>

    <div class="card-deck m-4">
        <div class="card col-3 p-4">
            <h4>Informações do Sistema</h4>
            <p class="">Insira o ID para localizar o aluno no Sistema, caso não exista ou as informações estejam
                erradas por favor avise a Secretaria antes de Prosseguir.</p>

            <div class="">
                <livewire:getuser />
            </div>

        </div>


        


        <div class="card col-9 p-4">
            <h4>Insira os dados para gerar a Cobrança</h4>
            <p class="pb-2">Preencha todas as informações abaixo corretamente, a cobrança gerada é notificada
                automáticamente ao cliente via SMS</p>
            <form class="form-horizontal" method="post" action="{{route('pay-create-post')}}">
                @csrf
                <fieldset>
                    <div class="container">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>ID</label>
                                <input type="text" id="username" name="username" class="form-control"
                                     required readonly>
                                <input type="text" id="id" name="id" class="form-control"
                                     required readonly hidden>
                            </div>
                            <div class="form-group col-md-3">
                                <label>CPF</label>
                                <input type="text" id="cpf" name="cpf" class="form-control"
                                    onkeypress="$(this).mask('000.000.000-00');" required
                                    onblur="return verificarCPF(this.value)" />
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>Nome Responsável</label>
                                <input type="text" id="responsavel" name="responsavel" class="form-control" required>
                            </div>
                            <div class="form-group col-md-5">
                                <label>Nome Aluno</label>
                                <input type="text" id="aluno" name="aluno" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Telefone do Responsável<br></label>
                                <input type="text" id="telefone" name="telefone" class="form-control"
                                    onkeypress="$(this).mask('(00) 90000-0000')" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email (Opcional)<br></label>
                                <input type="email" id="email" name="email" class="form-control" />
                            </div>
                        </div>
                        <p class="text-danger"><x-widgets._w-svg svg="alert-triangle"/> Atenção os boletos serão enviados no telefone inserido</p>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>CEP</label>
                                <input type="text" id="cep" name="cep" value="" size="8" maxlength="8"
                                    class="form-control" onkeypress="$(this).mask('00000-000')" required>
                            </div>

                            <div class="form-group col-md-3">
                                <fieldset disabled>
                                    <label>Cidade:</label>
                                    <input name="cidade" type="text" class="form-control" id="cidade" size="40" />
                                </fieldset>
                            </div>
                            <div class="form-group col-md-3">
                                <fieldset disabled>
                                    <label>Estado:</label>
                                    <input name="uf" type="text" class="form-control" id="uf" size="2" /></ </fieldset>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Data</label>
                                <input type="date" id="data" name="data" class="form-control"
                                    onkeypress="$(this).mask('00/00/0000')">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Valor da Parcela</label>
                                <input type="text" id="valor" name="valor" class="form-control"
                                    onkeypress="$(this).mask('R$ #######', {reverse: false});" onchange="adicionarRequired('data')">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Quantidade de Parcelas</label>
                                <input type="text" id="parcelas" name="parcelas" class="form-control"
                                    onkeypress="$(this).mask('00x', {reverse: true});">
                            </div>
                        </div>
                        <p class="text-danger"><x-widgets._w-svg svg="alert-triangle"/> Só digite Valor da Parcela e Quantidade de Parcela se deseja gerar boleto.</p>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputState">Divulgador</label>
                                <select id="grupo" name="grupo" class="form-control" required>
                                    <option selected></option>
                                    @foreach ($sellers as $seller)
                                    <option>{{$seller->name}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputState">Curso</label>
                                <select id="curso" name="curso" class="form-control" required>
                                    <option selected></option>
                                    <option>BANCÁRIO</option>
                                    <option>BANCÁRIO + INGLÊS</option>
                                    <option>BANCÁRIO + 10 CURSOS</option>
                                    <option>BANCÁRIO + 10 CURSOS + INGLÊS</option>
                                    <option>BANCÁRIO + CPA 10 + 10 CURSOS</option>
                                    <option>BANCÁRIO + PRÉ MILITAR + 10 CURSOS</option>
                                    <option>BANCÁRIO + PRÉ MILITAR</option>
                                    <option>PRÉ MILITAR</option>
                                    <option>PRÉ MILITAR + INGLÊS</option>
                                    <option>PRÉ MILITAR + 10 CURSOS</option>
                                    <option>CPA 10</option>
                                    <option>CPA10 + INGLÊS</option>
                                    <option>CPA10 + MILITAR</option>
                                    <option>CPA 10 + 10 CURSOS</option>
                                    <option>CPA 10 + 10 CURSOS + INGLES</option>
                                    <option>CPA10 + BANCÁRIO</option>
                                    <option>INGLÊS</option>
                                    <option>INGLÊS + 10 CURSOS</option>
                                    <option>10 CURSOS</option>
                                    <option>AUXILIAR DE CRECHE</option>
                                    <option>PREPARATÓRIO ENCCEJA</option>
                                    <option>CURSOS PROFISSIONALIZANTES</option>
                                </select>

                            </div>

                            <div class="form-group col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="taxa" name="taxa"
                                value=" + Taxa" onclick="toggleInput(1)" style="scale:1.3">
                                <label class="form-check-label" for="inlineCheckbox1">Taxa</label>
                                <div id="input-wrapper1" class="input-wrapper" hidden>
                                    <input type="text" id="taxa_valor" name="taxa_valor" placeholder="R$ Valor Total" class="mx-2  form-control" onkeypress="$(this).mask('R$ #######', {reverse: false});">
                                </div>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="cartaoi" name="cartaoi"
                                    value=" + Cartão Integral" onclick="toggleInput(3)" style="scale:1.3">
                                <label class="form-check-label" for="inlineCheckbox3">Cartão</label>
                                <div id="input-wrapper3" class="input-wrapper" hidden>
                                    <input type="text" id="cartaoi_valor" name="cartaoi_valor" placeholder="R$ Valor Total" class="mx-2 form-control" onkeypress="$(this).mask('R$ #######', {reverse: false});">
                                </div>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="link" name="link"
                                    value=" + Link" onclick="toggleInput(4)" style="scale:1.3">
                                <label class="form-check-label" for="inlineCheckbox4">Link de Pagamento</label>
                                <div id="input-wrapper4" class="input-wrapper" hidden>
                                    <input type="text" id="link_valor" name="link_valor" placeholder="R$ Valor Total" class="mx-2 form-control" onkeypress="$(this).mask('R$ #######', {reverse: false});">
                                </div>
                            </div>
                            </div>
                            

                        </div>
                        <div class="form-group">
                            <label for="descricao">Observações:</label>
                            <textarea class="form-control" name="descricao" id="descricao" rows="3"></textarea>
                          </div>
                        <!-- Button trigger modal -->
                        <button type="submit" class="btn btn-primary btn-lg">CRIAR</button>
                    </div>


        </div>



        </fieldset>
        </form>
        @livewireScripts
    </div>

    <script>
        function adicionarRequired(elementId) {
        var inputElement = document.getElementById(elementId);
        if (inputElement) {
            inputElement.required = true;
        }
        }
    </script>

    <script>
        function toggleInput(i) {
            var inputWrapper = document.getElementById("input-wrapper"+i);
            inputWrapper.hidden = inputWrapper.hidden == false ? true : false;
        }
    </script>


<!-- Adicionando Javascript -->
<script>
    $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });

</script>
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
        alert("CPF Inválido")
        v = true;
        return false;
    }
    d1 = 11 - (d1 % 11);
    if (d1 > 9) d1 = 0;
    if (dv.charAt(0) != d1){
        alert("CPF Inválido")
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
        alert("CPF Inválido")
        v = true;
        return false;
    }
    if (!v) {
    }	
	
}
</script>

</html>