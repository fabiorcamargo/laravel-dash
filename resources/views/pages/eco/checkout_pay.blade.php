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
    @php $price = $product->price @endphp
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
                                                            
                                                        <h3 class="">Profissionaliza EAD</h3>
                                                        </div>
                                                        <p class="inv-street-addr mt-3">CNPJ: 41.769.690/0001-25</p>
                                                        <p class="inv-street-addr mt-3">Endereço: Av. Advogado Horácio Raccanello Filho, 5410 Sala 01, Maringá/PR, 87020-035</p>
                                                        
                                                    </div>

                                                    

                                                    
                                                    <div class="col-sm-6 text-sm-end">
                                                        <p class="inv-list-number mt-sm-3 pb-sm-2 mt-4"><span class="inv-title">Identificação : </span> <span class="inv-number">#0001</span></p>
                                                    </div>                                                                
                                                </div>
                                                
                                            </div>

                                            
                                            <form action="{{ getRouterValue(); }}/eco/checkout/{{ $product->id }}/end/{{ $user->id }}" method="post" enctype="multipart/form-data" name="form" id="form" class="needs-validation" novalidate>
                                                @csrf
                                                <div class="inv--detail-section">

                                                        <div class="row">
                                                                @if (\Session::has('erro'))
                                                                    <div class="alert alert-light-danger alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Atenção:</strong> {!! \Session::get('erro') !!} </div>
                                                        
                                                                @endif
                                                                @if (\Session::has('success'))
                                                                    <div class="alert alert-light-sucess alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Atenção:</strong> {!! \Session::get('success') !!} </div>
                                                        
                                                                @endif
                                                                


                                                            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                                                
                                                                <h4>Escolha uma forma de pagamento</h4>
                                                            

                                                                    <div class="form-check form-check-primary form-check-inline pt-4">
                                                                        <input class="form-check-input" type="radio" name="radio-checked" id="PIX" onchange="mypix()" checked>
                                                                        <label class="form-check-label" for="PIX">
                                                                            <img class="company-logo" src="{{Vite::asset('resources/images/logo-pix.svg')}}" style="width: 58px;" alt="logo"> Pagamento via PIX R${{ $product->price *0.90 }} (10% de Desconto) <span class="badge badge-primary mb-2 me-4">Liberação Imediata</span>
                                                                        </label>
                                                                    </div>
                                                                        
                                                                    <div class="form-check form-check-primary form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="radio-checked" id="CREDIT_CARD" onchange="mycard()">
                                                                        <label class="form-check-label" for="CREDIT_CARD">
                                                                            <img class="company-logo" src="{{Vite::asset('resources/images/credit-card.svg')}}" style="width: 60px;" alt="logo"> Cartão de Crédito R${{ $product->price }} (Em até 10x R${{ $product->price/10 }}) <span class="badge badge-primary mb-2 me-4">Liberação Imediata</span>
                                                                        </label>
                                                                    </div>
                                                                        
                                                                    <div class="form-check form-check-primary form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="radio-checked" id="BOLETO" onchange="myboleto()">
                                                                        <label class="form-check-label" for="BOLETO">
                                                                            <img class="company-logo" src="{{Vite::asset('resources/images/boleto.svg')}}" style="width: 60px;" alt="logo"> Boleto Bancário R${{ $product->price }} (Valor à vista) <span class="badge badge-warning mb-2 me-4">Liberação após compensação</span>
                                                                        </label>
                                                                    </div>
                                                                        <input type="text" name="payment" id="payment" value="PIX">
                                                            </div>
                                                        </div>
                                                </div>
                                                    <div class="inv--head-section inv--detail-section">
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group col-md-6 mt-4">
                                                                <div class="form-control mb-4">
                                                                    <label for="defaultEmailAddress">CPF do Pagador:</label>
                                                                    <input type="text" class="cpf-number form-control mb-4" placeholder="Apenas os números" name="cpfCnpj" id="cpfCnpj"  autocomplete="on" required>
                                                                    <div class="valid-feedback feedback-pos">
                                                                        CPF válido!
                                                                    </div>
                                                                    <div class="invalid-feedback feedback-pos">
                                                                        Por favor insira um CPF Válido.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row" >
                                                        <div class="col-xl-10 col-lg-12 col-md-12 layout-spacing">
                                                            <div class="section general-info payment-info">
                                                                <div class="info">
                                                                                                                                     
                                                                    <div id='cards' name='cards' hidden>
                                                                        <h4 class="form-control mb-4">
                                                                        <x-widgets._w-cardcredit/>
                                                                    </div>

                                                                    <div id='pixs' name='pixs' hidden>
                                                                        <h4 class="form-control mb-4">
                                                                        <h3>Pix</h3>
                                                                    </div>

                                                                    <div id='boletos' name='boletos' hidden="true">
                                                                        <h4 class="form-control mb-4">
                                                                        <h3>Boleto</h3>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="">
                                                        <div class="text-sm">
                                                            <div class="row">
                                                                
                                                                <h4 class="form-control mb-4">
                                                                <div class="col-sm-8 col-12">
                                                                    <h4  class="">{{ $product->name }}</h4>
                                                                </div>
                                
                                                               
                                                                <div class="col-sm-8 col-7 grand-total-title mt-3">
                                                                    <h4 class="" id="prec">Total: R${!! $product->price * 0.90 !!}</h4>
                                                                </div>
                                                                <div class="col-sm-4 col-5 grand-total-amount mt-3">
                                                                    
                                                                </div>
                                                                <div class="d-grid gap-2 col-12 mx-auto">
                                                                <button class="btn btn-primary btn-lg mt-4" type="submit">Finalizar</button>
                                                                </div>
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
            

            function mycard(){
                    prec.innerText = "Total: R${!! $product->price !!}" ;
                    document.getElementById("cards").hidden = false;
                    document.getElementById("pixs").hidden = true;
                    document.getElementById("boletos").hidden = true;
                    document.getElementById("number").required = true;
                    document.getElementById("holderName").required = true;
                    document.getElementById("expiry").required = true;
                    document.getElementById("cvc").required = true;
                    document.getElementById("payment").value = "CREDIT_CARD";
                    
            }
            function mypix(){
                    prec.innerText = "Total: R${!! $product->price * 0.90 !!}" ;
                    document.getElementById("pixs").hidden = false;
                    document.getElementById("cards").hidden = true;
                    document.getElementById("boletos").hidden = true;
                    document.getElementById("number").required = false;
                    document.getElementById("holderName").required = false;
                    document.getElementById("expiry").required = false;
                    document.getElementById("cvc").required = false;
                    document.getElementById("payment").value = "PIX";
            }
            function myboleto(){
                    prec.innerText = "Total: R${!! $product->price !!}" ;
                    document.getElementById("boletos").hidden = false;
                    document.getElementById("cards").hidden = true;
                    document.getElementById("pixs").hidden = true;
                    document.getElementById("number").required = false;
                    document.getElementById("holderName").required = false;
                    document.getElementById("expiry").required = false;
                    document.getElementById("cvc").required = false;
                    document.getElementById("payment").value = "BOLETO";
            }
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