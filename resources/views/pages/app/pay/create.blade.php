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
    @vite(['resources/scss/light/assets/elements/alert.scss'])
    @vite(['resources/scss/dark/assets/elements/alert.scss'])


    <style>
        body {
            font-family: Arial, Sans;
            margin: 0;
        }

        .wrapper {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300px;
            text-align: center;
            transform: translateX(-50%);
        }

        .spanner {
            position: absolute;
            top: 50%;
            left: 0;
            background: #2a2a2a55;
            width: 100%;
            display: block;
            text-align: center;
            height: 300px;
            color: #FFF;
            transform: translateY(-50%);
            z-index: 1000;
            visibility: hidden;
        }

        .overlay {
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            visibility: hidden;
        }

        .loader,
        .loader:before,
        .loader:after {
            border-radius: 50%;
            width: 2.5em;
            height: 2.5em;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
            -webkit-animation: load7 1.8s infinite ease-in-out;
            animation: load7 1.8s infinite ease-in-out;
        }

        .loader {
            color: #ffffff;
            font-size: 10px;
            margin: 80px auto;
            position: relative;
            text-indent: -9999em;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
            -webkit-animation-delay: -0.16s;
            animation-delay: -0.16s;
        }

        .loader:before,
        .loader:after {
            content: '';
            position: absolute;
            top: 0;
        }

        .loader:before {
            left: -3.5em;
            -webkit-animation-delay: -0.32s;
            animation-delay: -0.32s;
        }

        .loader:after {
            left: 3.5em;
        }

        @-webkit-keyframes load7 {

            0%,
            80%,
            100% {
                box-shadow: 0 2.5em 0 -1.3em;
            }

            40% {
                box-shadow: 0 2.5em 0 0;
            }
        }

        @keyframes load7 {

            0%,
            80%,
            100% {
                box-shadow: 0 2.5em 0 -1.3em;
            }

            40% {
                box-shadow: 0 2.5em 0 0;
            }
        }

        .show {
            visibility: visible;
        }

        .spanner,
        .overlay {
            opacity: 0;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            transition: all 0.3s;
        }

        .spanner.show,
        .overlay.show {
            opacity: 1
        }
    </style>

    @livewireStyles
</head>
    @if(request()->input('search'))
        <body onload="myFunction()">
    @endif
<ul class="nav justify-content-end p-4">
    <li class="nav-item">
        <a type="button" class="btn btn-danger" href="/modern-dark-menu/aluno/my">"Sair do Sistema"</a>
    </li>
</ul>

<div class="modal fade" id="overlay" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="spanner">
            <div class="loader"></div>
            <p>Enviando aguarde.</p>
        </div>
    </div>
</div>



<div id="myModal" class="modal animated fadeInDown" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content ">
            <div class="container mx-auto align-self-center">
                <div class="card mt-3 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div id="cliente"></div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="mb-4">
                                    <button type="send" onclick="ClientExist(2)" class="btn btn-primary w-100">Criar
                                        Cobrança</button>
                                    <button type="send" onclick="ClientExist(3)"
                                        class="my-2 btn btn-primary w-100">Trocar Responsável</button>
                                    <button data-dismiss="modal" aria-label="Close"
                                        class="btn btn-secondary w-100">Voltar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal1" class="modal animated fadeInDown" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content ">
            <div class="container mx-auto align-self-center">
                <div class="card mt-3 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div id="cliente1"></div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="mb-4">
                                    <button type="send" data-dismiss="modal"
                                        class="btn btn-primary w-100">Prosseguir</button>
                                    <a href="/modern-dark-menu/app/pay/create" aria-label="Close"
                                        class="mt-2 btn btn-secondary w-100">Voltar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<body class="bg-light pb-4">
    <div class="container">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4"
                src="https://ead.profissionalizaead.com.br/pluginfile.php/1/theme_edumy/headerlogo1/1651025660/Prancheta%203%20%28Personalizado%29.png"
                alt="" width="245" height="72">

            <h2>Sistema de Geração de Boletos</h2>

            <!-- Session Status -->
            <x-auth-session-status2 class="mb-4 text-success" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors2 class="mb-4 text-danger" :errors="$errors" />


        </div>
    </div>

    <div class="card-deck m-1">
        <div class="card col-3 p-2">
            <h4>Informações do Sistema</h4>
            <p class="">Insira o ID para localizar o aluno no Sistema.</p>

            <div class="pt-2">
                <livewire:getuser i={{true}} n={{1}} />
            </div>

        </div>




        <div class="card col-9 p-3">

            <h4>Insira os dados para gerar a Cobrança</h4>
            <p class="pb-2">Preencha todas as informações abaixo corretamente, a cobrança gerada é notificada
                automáticamente ao cliente via SMS</p>
            <form class="form-horizontal" method="post" action="{{route('pay-create-post')}}">
                @csrf
                <div class="container">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>ID</label>

                            <input type="text" id="username[1]" name="username[1]" class="form-control" required
                                readonly>
                            <input type="text" id="resp_exist" name="resp_exist" class="form-control" value="1"
                                readonly hidden>
                            <input type="text" id="id[1]" name="id[1]" class="form-control" required readonly hidden>
                        </div>
                        <div class="form-group col-md-6">
                            <label>CPF</label>
                            <input type="text" id="cpf" name="cpf" class="form-control"
                                onkeypress="$(this).mask('000.000.000-00');" required
                                onblur="return verificarCPF(this.value)" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nome Responsável</label>
                            <input type="text" id="responsavel" name="responsavel" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nome do Aluno</label>
                            <input type="text" id="aluno[1]" name="aluno[1]" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Telefone do Responsável<br></label>
                            <input type="text" id="telefone" name="telefone" class="form-control"
                                onkeypress="$(this).mask('(00) 90000-0000')" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email do Responsável<br></label>
                            <input type="email" id="email" name="email" class="form-control" />
                        </div>
                    </div>

                    <p class="text-danger">
                        <x-widgets._w-svg svg="alert-triangle" /> Atenção os boletos serão enviados no telefone
                        inserido
                    </p>



                    <div style="display: none" id="container2">

                        <hr>
                        <label>2º Aluno</label>
                        <livewire:getuser i={{false}} n={{2}}>
                            <div class="text-left  ">
                                <a href="javascript:void(0);" type="button" onclick="showadd(3)" id="btnshow3"
                                    class="btn btn-primary">
                                    + Alunos
                                </a>
                            </div>
                            <hr>

                    </div>
                    <div style="display: none" id="container3">
                        <label>3º Aluno</label>
                        <livewire:getuser i={{false}} n={{3}}>
                            <div class="text-left  ">
                                <a href="javascript:void(0);" type="button" onclick="showadd(4)" id="btnshow4"
                                    class="btn btn-primary">
                                    + Alunos
                                </a>
                            </div>
                            <hr>
                    </div>
                    <div style="display: none" id="container4">
                        <label>4º Aluno</label>
                        <livewire:getuser i={{false}} n={{4}}>
                            <div class="text-left  ">
                                <a href="javascript:void(0);" type="button" onclick="showadd(5)" id="btnshow5"
                                    class="btn btn-primary">
                                    + Alunos
                                </a>
                            </div>
                            <hr>
                    </div>
                    <div style="display: none" id="container5">
                        <label>5º Aluno</label>
                        <livewire:getuser i={{false}} n={{5}}>
                            <hr>
                    </div>

                    <div class="text-left  ">
                        <a href="javascript:void(0);" type="button" onclick="showadd(2)" id="btnshow2"
                            class="btn btn-primary">
                            + Alunos
                        </a>
                    </div>

                    <div class="form-row pt-4">
                        <div class="form-group col-md-3">
                            <label>CEP</label>
                            <input type="text" id="cep" name="cep" value="" size="8" maxlength="8" class="form-control"
                                onkeypress="$(this).mask('00000-000')" required>
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
                            <input type="date" id="data" name="data" class="form-control" onkeypress="">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Valor da Parcela</label>
                            <input type="text" id="valor" name="valor" class="form-control" placeholder="Valor 00,00"
                                onkeypress="$(this).mask('000.000.000.000.000,00', {reverse: true});"
                                onchange="adicionarRequired('data')">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Quantidade</label>
                            <input type="text" id="parcelas" name="parcelas" class="form-control"
                                onkeypress="$(this).mask('00x', {reverse: true});">
                        </div>
                    </div>
                    <p class="text-danger">
                        <x-widgets._w-svg svg="alert-triangle" /> Só digite Valor da Parcela e Quantidade de Parcela
                        se deseja gerar boleto.
                    </p>

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
                                <option>PREPARATÓRIO PM</option>
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
                                <input class="form-check-input" type="checkbox" id="taxa" name="taxa" value=" + Taxa"
                                    onclick="toggleInput(1)" style="scale:1.3">
                                <label class="form-check-label" for="inlineCheckbox1">Taxa Paga</label>
                                <div id="input-wrapper1" class="input-wrapper" hidden>
                                    <input type="text" id="taxa_valor" name="taxa_valor" placeholder="R$ Valor Total"
                                        class="mx-2  form-control"
                                        onkeypress="$(this).mask('R$ #######', {reverse: false});">
                                </div>
                            </div>
                            
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="cartaoi" name="cartaoi"
                                    value=" + Cartão Integral" onclick="toggleInput(3)" style="scale:1.3">
                                <label class="form-check-label" for="inlineCheckbox3">Cartão</label>
                                <div id="input-wrapper3" class="input-wrapper" hidden>
                                    <input type="text" id="cartaoi_valor" name="cartaoi_valor"
                                        placeholder="R$ Valor Total" class="mx-2 form-control"
                                        onkeypress="$(this).mask('R$ #######', {reverse: false});">
                                </div>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="link" name="link" value=" + Link"
                                    onclick="toggleInput(4)" style="scale:1.3">
                                <label class="form-check-label" for="inlineCheckbox4">Link de Pagamento</label>
                                <div id="input-wrapper4" class="input-wrapper" hidden>
                                    <input type="text" id="link_valor" name="link_valor" placeholder="R$ Valor Total"
                                        class="mx-2 form-control"
                                        onkeypress="$(this).mask('R$ #######', {reverse: false});">
                                </div>
                            </div><br>
                            <div class="form-check form-check-inline pt-2">
                                <input class="form-check-input" type="checkbox" id="taxa" name="taxa" value=" + Taxa"
                                    onclick="toggleInput(5)" style="scale:1.3">
                                <label class="form-check-label" for="inlineCheckbox5">Gerar Taxa(Junto com a 1ª Parcela)</label>
                                <div id="input-wrapper5" class="input-wrapper" hidden>
                                    <input type="text" id="gerartaxa" name="gerartaxa" placeholder="R$ Valor Total"
                                        class="mx-2  form-control"
                                        onkeypress="$(this).mask('000.000.000.000.000,00', {reverse: true});">
                                </div>
                            </div>
                            <br><br>
                            {{--<div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="taxa-gerar" name="taxa-gerar" value=" + Taxa"
                                    onclick="toggleInput(5)" style="scale:1.3">
                                <label class="form-check-label" for="inlineCheckbox1">Colocar taxa junto na 1ª parcela</label>
                                <div id="input-wrapper5" class="input-wrapper" hidden>
                                    <input type="text" id="taxa_valor" name="taxa_valor" placeholder="R$ Valor Total"
                                        class="mx-2  form-control"
                                        onkeypress="$(this).mask('R$ #######', {reverse: false});">
                                </div>
                            </div>--}}
                        </div>


                    </div>
                    <div class="form-group">
                        <label for="descricao">Observações:</label>
                        <textarea class="form-control" name="descricao" id="descricao" rows="3"></textarea>
                    </div>
                    <!-- Button trigger modal -->
                    <button type="submit" onclick="loading()" class="btn btn-primary btn-lg">CRIAR</button>
                </div>


        </div>



        </fieldset>
        </form>
        @livewireScripts
    </div>
</body>


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

    <script>
        function showadd(i) {
            
            //document.getElementById("container"+i).classList.add('active');
            document.getElementById("container"+i).style.display = 'block';
            document.getElementById("btnshow"+i).style.display = 'none';
            
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

function myFunction(){
    console.log('sim');
    window.location.href = "/modern-dark-menu/app/pay/create";
}


function loading(){

  $("div.spanner").addClass("show");
  $("#overlay").modal("show");

}
    
function ClientExist(n)    {
    document.getElementById("resp_exist").value = n;

    $('#myModal').modal('hide');
}
    
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
        
                var settings = {
                "url": "/modern-dark-menu/app/pay/asaas/"+d,
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json",
                    "access_token": "a8b9e454a84a17b7b592bb63f5717d75f44d593600b38d661af38c837ab132e8",
                },
                };

                $.ajax(settings).done(function (response) {
                    $('#cliente1').append("<h5>Responsável cadastrado no Asaas, para prosseguir você precisa escolher uma das opções abaixo:</h5><br><h6>Dados do Cliente</h6>");
                    $('#cliente1').append(response);
                    $('#myModal1').modal('show');
                //alert(response);
                });
    }	
	
}
    </script>


</html>