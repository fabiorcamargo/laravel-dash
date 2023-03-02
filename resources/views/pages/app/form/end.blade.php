<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/apps/invoice-preview.scss'])
        @vite(['resources/scss/dark/assets/apps/invoice-preview.scss'])

        
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        
        <script>
    
            function limpa_formulário_cep() {
                    //Limpa valores do formulário de cep.
                    document.getElementById('rua').value=("");
                    document.getElementById('bairro').value=("");
                    document.getElementById('cidade').value=("");
                    document.getElementById('uf').value=("");

                    

            }
        
            function meu_callback(conteudo) {
                if (!("erro" in conteudo)) {
                    //Atualiza os campos com os valores.


                    document.getElementById('end').hidden=false;

                    document.getElementById('rua').value=(conteudo.logradouro);
                    document.getElementById('bairro').value=(conteudo.bairro);
                    document.getElementById('cidade').value=(conteudo.localidade);
                    document.getElementById('uf').value=(conteudo.uf);



                } //end if.
                else {
                    //CEP não Encontrado.
                    limpa_formulário_cep();
                    alert("CEP não encontrado.");
                }
            }
                
            function pesquisacep(valor) {
        
                //Nova variável "cep" somente com dígitos.
                var cep = valor.replace(/\D/g, '');
        
                //Verifica se campo cep possui valor informado.
                if (cep != "") {
        
                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;
        
                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {
        
                        //Preenche os campos com "..." enquanto consulta webservice.
                        document.getElementById('rua').value="...";
                        document.getElementById('bairro').value="...";
                        document.getElementById('cidade').value="...";
                        document.getElementById('uf').value="...";
        
                        //Cria um elemento javascript.
                        var script = document.createElement('script');
        
                        //Sincroniza com o callback.
                        script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
        
                        //Insere script no documento e carrega o conteúdo.
                        document.body.appendChild(script);
        
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
            };
        
            </script>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <div class="row invoice layout-top-spacing layout-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            
            <div class="doc-container">

                <div class="row">

                    <div class="col-xl-9">

                        <div class="invoice-container">
                            <div class="invoice-inbox">
                                
                                <div id="ct" class="">
                                    
                                    <div class="invoice-00001">
                                        <div class="content-section">

                                            <div class="inv--head-section inv--detail-section">
                                            
                                                <div class="row">

                                                    <div class="col-sm-6 col-12 mr-auto">
                                                        <div class="d-flex">
                                                        <h4 class=""><img src="{{Vite::asset('resources/images/logo2.svg')}}" class="navbar-logo logo-light pe-3" width="80" alt="logo">Profissionaliza EAD</h4>
                                                        </div>
                                                        <p class="inv-street-addr mt-3">Endereço: Av. Advogado Horácio Raccanello Filho, 5410 Sala 01, Maringá/PR, 87020-035</p>
                                                        
                                                    </div>
                                                             
                                                </div>
                                                
                                            </div>

                                            
                                            <form action="{{ getRouterValue(); }}/app/form/end/{{$form->id}}" method="post" enctype="multipart/form-data" name="form" id="form" class="needs-validation" novalidate>
                                                @csrf
                                                <div class="inv--detail-section">

                                                    <div class="row">
                                                        @if (\Session::has('erro'))
                                                            <div class="alert alert-light-danger alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Atenção:</strong> {!! \Session::get('erro') !!} </div>
                                                
                                                        @endif
                                                        @if (\Session::has('success'))
                                                            <div class="alert alert-light-sucess alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Atenção:</strong> {!! \Session::get('success') !!} </div>
                                                
                                                        @endif
                                                        
                                                    </div>
                                                 
                                                    <div class="row pb-4">
                                                        <h4>{{ $form->name }}</h4>
                                                        {!! $form->description !!}
                                                    </div>
                                                    
                                                    <div class="row">
                                                        
                                                        <div class="col-md-6">
                                                            <h4 class="pb-4">Dados Pessoais</h4>
                                                            <label for="defaultEmailAddress">Nome Completo</label>
                                                            <input type="text" class="form-control mb-4" placeholder="Nome completo" name="nome" id="nome"  autocomplete="on" required >
                                                            <div class="valid-feedback feedback-pos">
                                                                Celular válido!
                                                            </div>
                                                            <div class="invalid-feedback feedback-pos">
                                                                Por favor preencha com seu nome completo.
                                                            </div>
                                                
                                                            <div class="form-group">
                                                            <label for="defaultEmailAddress">Telefone com Whatsapp</label>
                                                            <input type="text" class="ph-number form-control mb-4" placeholder="Digite apenas os números" name="cellphone" id="cellphone"  autocomplete="on" required >
                                                            <div class="valid-feedback feedback-pos">
                                                                Celular válido!
                                                            </div>
                                                            <div class="invalid-feedback feedback-pos">
                                                                Por favor coloque um Telefone válido com DDD e 9º dígito.
                                                            </div>
                                                            </div>
                                                            <label for="defaultEmailAddress">Cidade</label>
                                                            <input type="text" class="form-control mb-4" placeholder="Cidade" name="city" id="city"  autocomplete="on" required >

                                                            <input type="text" class="form-control mb-4" placeholder="Cidade" name="fbclid" id="fbclid" value="{{ $fbclid }}"  hidden>
                                                            

                                                            {{--<div class="form-group">
                                                                <label for="email">Email (Opcional se preferir deixe em branco)</label>
                                                                <input type="email" name="email" placeholder="Para receber acesso ao portal" class="email white col-7 col-md-4 col-lg-7 ml-3 form-control" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" onchange="myFn('mail')">
                                                                        <div class="valid-feedback feedback-pos">
                                                                            Email Válido!
                                                                        </div>
                                                                        <div class="invalid-feedback feedback-pos">
                                                                            Por favor coloque um email válido.
                                                                        </div>
                                                            </div>--}}
                                                        </div>
                                                        
                                                        <div class="col-sm-12 pt-4">
                                                            <button id="adicionar" class="btn btn-success w-100">Efetuar Cadastro</button>
                                                        </div>  
                                                    </div>
                                                    
                                                    
                                            
                                            
                                                   

                                                    
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>

        </div>
    </div>
    <body>
        <style>
            .demo-container {
                width: 100%;
                max-width: 350px;
                margin: 50px auto;
            }
    
            form {
                margin: 30px;
            }
    
            input {
                width: 200px;
                margin: 10px auto;
                display: block;
            }
        </style>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('node_modules/card/lib/card.js')}}"></script>
        @vite(['resources/assets/js/apps/invoice-preview.js'])

        <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
        

        <script src="{{asset('plugins/input-mask/jquery.inputmask.bundle.min.js')}}"></script>
        <script src="{{asset('plugins/input-mask/input-mask2.js')}}"></script>
        <script src="{{asset('plugins/card/dist/card.js')}}"></script>
        <script>
            var c = new Card({
                form: document.querySelector('#form'),
                container: '.card-wrapper'
            });
        </script>

            

        <script>
            window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            }
            form.classList.add('was-validated');
            }, false);
            });
            }, false);
        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>