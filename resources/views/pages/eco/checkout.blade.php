<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/apps/invoice-preview.scss'])
        @vite(['resources/scss/dark/assets/apps/invoice-preview.scss'])
        
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

                                            
                                            <form action="{{ getRouterValue(); }}/eco/checkout/end" method="post" enctype="multipart/form-data" name="form" id="form" class="needs-validation" novalidate>
                                                @csrf
                                                <div class="inv--detail-section">

                                                    <div class="row">

                                                        <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                                            <p class="inv-to">Formas de pagamento</p>
                                                        

                                                        <div class="form-check form-check-primary form-check-inline pt-4">
                                                            <input class="form-check-input" type="radio" name="radio-checked" id="pix" onchange="mypix()" checked>
                                                            <label class="form-check-label" for="pix">
                                                                <img class="company-logo" src="{{Vite::asset('resources/images/logo-pix.svg')}}" style="width: 58px;" alt="logo"> Pagamento via PIX R${{ $product->price *0.90 }} (10% de Desconto) <span class="badge badge-primary mb-2 me-4">Liberação Imediata</span>
                                                            </label>
                                                            </div>
                                                            
                                                            <div class="form-check form-check-primary form-check-inline">
                                                            <input class="form-check-input" type="radio" name="radio-checked" id="card" onchange="mycard()">
                                                            <label class="form-check-label" for="card">
                                                                <img class="company-logo" src="{{Vite::asset('resources/images/credit-card.svg')}}" style="width: 60px;" alt="logo"> Cartão de Crédito R${{ $product->price }} (Em até 10x R${{ $product->price/10 }}) <span class="badge badge-primary mb-2 me-4">Liberação Imediata</span>
                                                            </label>
                                                            </div>
                                                            
                                                            <div class="form-check form-check-primary form-check-inline">
                                                            <input class="form-check-input" type="radio" name="radio-checked" id="boleto" onchange="myboleto()">
                                                            <label class="form-check-label" for="boleto">
                                                                <img class="company-logo" src="{{Vite::asset('resources/images/boleto.svg')}}" style="width: 60px;" alt="logo"> Boleto Bancário R${{ $product->price }} (Valor à vista) <span class="badge badge-warning mb-2 me-4">Liberação após compensação</span>
                                                            </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="inv--head-section inv--detail-section"></div>
                                                    
                                                    <div class="row">
                                                        
                                                        <div class="col-md-6">
                                                            <h4 class="pb-4">Dados Pessoais</h4>
                                                            <label for="defaultEmailAddress">Nome Completo</label>
                                                            <input type="text" class="form-control mb-4" placeholder="Nome completo" name="nome" id="nome"  autocomplete="on" required >
                                                            <div class="valid-feedback feedback-pos">
                                                                Celular válido!
                                                            </div>
                                                            <div class="invalid-feedback feedback-pos">
                                                                Por favor coloque um Telefone válido com DDD e 9º dígito.
                                                            </div>
                                                    
                                                            <label for="defaultEmailAddress">CPF</label>
                                                            <input type="text" class="cpf-number form-control mb-4" placeholder="Digite apenas os números" name="cpfCnpj" id="cpfCnpj"  autocomplete="on" required >
                                                            <div class="valid-feedback feedback-pos">
                                                                Celular válido!
                                                            </div>
                                                            <div class="invalid-feedback feedback-pos">
                                                                Por favor coloque um Telefone válido com DDD e 9º dígito.
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

                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="email" name="email" placeholder="Para receber acesso ao portal" class="email white col-7 col-md-4 col-lg-7 ml-3 form-control" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" onchange="myFn('mail')" required>
                                                                        <div class="valid-feedback feedback-pos">
                                                                            Email Válido!
                                                                        </div>
                                                                        <div class="invalid-feedback feedback-pos">
                                                                            Por favor coloque um email válido.
                                                                        </div>
                    
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                            
                                                    
                                                    <div class="row" >
                                                        <div class="col-xl-6 col-lg-12 col-md-12 layout-spacing">
                                                            <div class="section general-info payment-info">
                                                                <div class="info">
                                                                                                                                     
                                                                    <div id='cards' name='cards' hidden>
                                                                    <x-widgets._w-cardcredit/>
                                                                    </div>

                                                                    <div id='pixs' name='pixs' hidden>
                                                                        <h3>Pix</h3>
                                                                    </div>

                                                                    <div id='boletos' name='boletos' hidden="true">
                                                                        <h3>Boleto</h3>
                                                                    </div>
                                                                    <button class="btn btn-primary mt-4" type="submit">Finalizar</button>
                                                                </div>
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




                                                
                                             
                                                
                                          

                                            
                                            

     

                    <div class="col-xl-3">

                        <div class="invoice-actions-btn">

                            <div class="invoice-action-btn">

                                <div class="row">
                                    <div class="inv--total-amounts">
                                            
                                        <div class="row mt-4">
                   
                                            <div class="">
                                                <div class="text-sm">
                                                    <div class="row">
                                                        <div class="col-sm-8 col-12">
                                                            <h4  class="">{{ $product->name }}</h4>
                                                        </div>
                        
                                                       
                                                        <div class="col-sm-8 col-7 grand-total-title mt-3">
                                                            <h4 class="">Valor Total: </h4>
                                                        </div>
                                                        <div class="col-sm-4 col-5 grand-total-amount mt-3">
                                                            <h4 class="" id="prec">R${{ $product->price * 0.90 }}</h4>
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
        <script src="{{asset('plugins/input-mask/input-mask.js')}}"></script>
        <script src="{{asset('plugins/card/dist/card.js')}}"></script>
        <script>
            var c = new Card({
                form: document.querySelector('#form'),
                container: '.card-wrapper'
            });
        </script>

        <script>
            

            function mycard(){
                    prec.innerText = "R${!! $product->price !!}" ;
                    document.getElementById("cards").hidden = false;
                    document.getElementById("pixs").hidden = true;
                    document.getElementById("boletos").hidden = true;
                    document.getElementById("number").required = true;
                    document.getElementById("holderName").required = true;
                    document.getElementById("expiry").required = true;
                    document.getElementById("cvc").required = true;
                    
            }
            function mypix(){
                    prec.innerText = "R${!! $product->price * 0.90 !!}" ;
                    document.getElementById("pixs").hidden = false;
                    document.getElementById("cards").hidden = true;
                    document.getElementById("boletos").hidden = true;
                    document.getElementById("number").required = false;
                    document.getElementById("holderName").required = false;
                    document.getElementById("expiry").required = false;
                    document.getElementById("cvc").required = false;
            }
            function myboleto(){
                    prec.innerText = "R${!! $product->price !!}" ;
                    document.getElementById("boletos").hidden = false;
                    document.getElementById("cards").hidden = true;
                    document.getElementById("pixs").hidden = true;
                    document.getElementById("number").required = false;
                    document.getElementById("holderName").required = false;
                    document.getElementById("expiry").required = false;
                    document.getElementById("cvc").required = false;
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