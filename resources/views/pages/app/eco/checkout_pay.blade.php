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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        
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
            <style>
                .callout {
                    position: fixed;
                    top: 10px;
                    right: 10px;
                    margin-left: 20px;

                    animation: pulse infinite; /* referring directly to the animation's @keyframe declaration */
                    animation-duration: 2s; /* don't forget to set a duration! */
                }
                .cupom {
                    width: 100px; 

                }
                .cupom-text{
                    position: fixed;
                    top: 58px;
                    right: 48px;
                    color: black;
                }
                .footer {
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
                height: 40px;
                background-color: rgb(49, 49, 49);
                color: white;
                text-align: center;
                }
                #overlay {
                position: fixed; /* Sit on top of the page content */
                display: none; /* Hidden by default */
                width: 100%; /* Full width (cover the whole page) */
                height: 100%; /* Full height (cover the whole page) */
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.5); /* Black background with opacity */
                z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
                cursor: pointer; /* Add a pointer on hover */
                }
                #text{
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%,-50%);
                -ms-transform: translate(-5%,-5%);
                }
                .text{
                font-size: 50px;
                color: white;
                }
                </style>     
                
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
        @php $price = $product->price @endphp
        @if(App\Models\EcoCoupon::where('token', request()->input('t'))->exists())
            @php $cupom = App\Models\EcoCoupon::where('token', request()->input('t'))->first() @endphp
            @php $cupom_discount = 1 - $cupom->discount /100 @endphp
            @php $seller = App\Models\User::find(App\Models\EcoSeller::find(App\Models\EcoCoupon::where('token', request()->input('t'))->first()->seller)->user_id)  @endphp
            @php $wp_text = urlencode("Olá preciso de um novo cupom para o curso de $product->name eu estava utilizando o Cupom: $cupom->name") @endphp
        @else
            @php $cupom_discount = 1 - $product->percent @endphp
        @endif
        <div class="row invoice layout-top-spacing layout-spacing" style="margin: -10px 0px">
            <div class="doc-container">
                <div class="row">
                    <div class="col-xl-10">
                        <div class="invoice-container">
                            <div class="content-section">
                                <div class="row">
                                    <div class="widget-content widget-content-area br-8">
                                        <div class="d-flex">    
                                        <h4 class=""><img src="{{Vite::asset('resources/images/logo2.svg')}}" class="navbar-logo logo-light pe-3" width="80" alt="logo">Profissionaliza EAD</h4>
                                        

                                        

                                    </div>
                                        <p class="inv-street-addr mt-3">CNPJ: 41.769.690/0001-25</p>
                                        <p class="inv-street-addr mt-3">Endereço: Av. Advogado Horácio Raccanello Filho, 5410 Sala 01, Maringá/PR, 87020-035</p>
                                    </div> 
                                    
                                </div>
                            </div>
                            <div class="content-section pt-4">
                                <div class="widget-content widget-content-area br-8 ">
                                    @php
                                    $images = json_decode($product->image);
                                    @endphp
                                    <div class="d-flex product">
                                        <h4 class=""><img src="{{asset("/product/$images[0]")}}" class="navbar-logo logo-light pe-3" width="80" alt="logo">{{ $product->name }}</h4>
                                        
                                    </div>
                                </div>
                            </div>
                           
                                        
                            <div class="content-section pt-4">
                                <form action="{{ getRouterValue(); }}/app/eco/checkout/{{ $product->id }}/end/{{ $user->id }}" method="post" enctype="multipart/form-data" name="form" id="form" class="needs-validation" novalidate>
                                    @csrf  
                                    <div class="row">
                                        <div class="widget-content widget-content-area br-8 ">
                                            @if (\Session::has('erro'))
                                                <div class="alert alert-light-danger alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> {!! \Session::get('erro') !!} </div>
                                            @endif
                                            @if (\Session::has('success'))
                                                <div class="alert alert-light-sucess alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> {!! \Session::get('success') !!} </div>
                                            @endif

                                            <h5 class="pt-4">Escolha uma forma de pagamento</h5>
                                           
                                            
                                            <ul class="list-group list-group-media col-xxl-8 col-xl-10 col-lg-12 col-md-12 col-12">
                                                <li class="list-group-item"  onchange="mypix()">
                                                
                                                    <div class="form-check form-check-primary form-check-inline pt-4 col-12">
                                                        <input class="form-check-input" type="radio" name="radio-checked" id="PIX">
                                                        <label class="form-check-label" for="PIX">
                                                            <img src="{{Vite::asset('resources/images/logo-pix.svg')}}" style="width: 40px;">
                                                            <span class="badge badge-primary">Liberação Imediata</span>
                                                            <h4 class="form-check-inline col-12 mt-2">Pix (10% desconto adicional)</h4>
                                                        </label>
                                                        
                                                    </div>
                                                    <div class="col-md-12">
                                                        <select name="pgpix" id="pgpix" class="form-control mb-4" hidden>
                                                            <option value="1">1x R${{ round($product->price*$cupom_discount*0.9, 0) }}</option>
                                                        </select>
                                                        </div>

                                                </li>
                                                <li class="list-group-item" onchange="mycard({{$cupom_discount}})">
                                                    
                                                    <div class="form-check form-check-primary form-check-inline">
                                                        <input class="form-check-input" type="radio" name="radio-checked" id="CREDIT_CARD">
                                                        <label class="form-check-label" for="CREDIT_CARD">
                                                            <img class="company-logo" src="{{Vite::asset('resources/images/credit-card.svg')}}" style="width: 60px;" alt="logo"> 
                                                            <span class="badge badge-primary mb-2 me-4">Liberação Imediata</span>
                                                            <h4 class="form-check-inline col-12 mt-2">Cartão de Crédito</h4>
                                                            <img class="company-logo col-12" src="{{asset('/product/badeira-cartoes.png')}}" alt="logo"> 
                                                            
                                                             {{--R${{ $product->price * $cupom_discount }} Em até 10x R${{ $product->price*$cupom_discount/10 }} --}}
                                                             
                                                            
                                                        </label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <select name="parcelac" id="parcelac" class="form-control mb-4" hidden>
                                                            @for ($i = 1; $i < 13; $i++)
                                                                <option value="{{$i}}">{{$i}}x R${{ round($product->price*$cupom_discount / $i, 0) }} com desconto</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="list-group-item"  onchange="myboleto()">
                                                    <div class="form-check form-check-primary form-check-inline pt-4 col-12">
                                                        <input class="form-check-input" type="radio" name="radio-checked" id="BOLETO">
                                                        <label class="form-check-label" for="BOLETO">
                                                            <img class="company-logo" src="{{Vite::asset('resources/images/boleto.svg')}}" style="width: 60px;" alt="logo">
                                                            <span class="badge badge-warning mb-2">Libera após compensação</span>
                                                            <h4 class="form-check-inline col-12 mt-2"> Boleto </h4>
                                                            {{--}} de R${{ $product->price*$cupom_discount }} Valor à vista ou em até 10x de R${{$product->price}} --}}
                                                        </label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <select name="parcelab" id="parcelab" class="form-control mb-4" onchange="select_boleto()" hidden>
                                                            <option value="">Escolha</option>
                                                            <option value="1">1x R${{ round($product->price*$cupom_discount, 0) }} com desconto </option>
                                                            @for ($i = 2; $i < 13; $i++)
                                                                <option value="{{ $i }}" >{{$i}}x R${{ round(($product->price + $i*$product->price*0.05)/$i, 0) }} sem desconto</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </li>
                                                <input type="text" name="payment" id="payment" value="PIX" hidden>
                                                @if (App\Models\EcoCoupon::where('token', request()->input('t'))->exists())
                                                    <input type="text" id="checkou_value" name="checkou_value" hidden>
                                                @endif
                                            </ul>
                                        </div>
                                                    
                                    </div>
                               
                                
                                                
                                                    
                                    <div class="content-section pt-4">
                                        <div class="row">
                                            <div class="widget-content widget-content-area br-8 ">
                                                <div class="col-md-6">
                                                    <h4>Informações de Pagamento</h4>
                                                    <div class="form-group col-md-6 mt-4">    
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
                                                
                                                
                                                <div class="row" >
                                                    <div class="col-xl-10 col-lg-12 col-md-12 layout-spacing">
                                                        <div class="section general-info payment-info">
                                                            <div class="info">                                                           
                                                                <div id='cards' name='cards' hidden>
                                                              
                                                                    <x-widgets._w-cardcredit/>
                                                                    
                                                                </div>
                                                                <div id='pixs' name='pixs' hidden>
                                                                    <h3>Pix</h3>
                                                                </div>
                                                                <div id='boletos' name='boletos' hidden>
                                                                   
                                                                        <h4>Informações de Pagamento</h4>
                                                                       
                                                                </div>

                                                                <div class="col-md-3" id="show_cep">
                                                                        
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Cep:</label>
                                                                        <input name="cep" type="text" id="cep" class="cep-number form-control" maxlength="9" onchange="pesquisacep(this.value);"/><span class="badge badge-light-success mt-2 me-4">Buscar</span>
                                                                    </div>
                                                                </div>

                                                                <div id='end' name='end' hidden>
                                                                 
                                                                    <x-widgets._w-end/>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-section pt-4">
                                        <div class="row">
                                            <div class="widget-content widget-content-area br-8 ">
                                                <div class="">
                                                    <div class="text-sm">
                                                        <div class="row">
                                                            <div class="col-sm-8 col-12">
                                                                <h4  class="">{{ $product->name }}</h4>
                                                                <p>{!! $product->description !!}</p>
                                                            </div>
                                                            <div class="col-sm-8 col-7 grand-total-title mt-3">
                                                                <h4 class="" id="prec">Escolha uma forma de pagamento</h4>
                                                            </div>
                                                            <div class="col-sm-4 col-5 grand-total-amount mt-3">   
                                                            </div>
                                                            <div class="d-grid gap-2 col-12 mx-auto">
                                                            <button class="btn btn-primary btn-lg mt-4" id="button_finalizar" type="submit">Finalizar</button>
                                                            </div>
                                                        </div>
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

        @if(App\Models\EcoCoupon::where('token', request()->input('t'))->exists())
            <div class="footer">
                <h4 class="mt-2" style="color: #FFBA00">Cupom expira em: <span class="btn-text-inner" id="demo"></span></h4>
            </div>
            <div class="callout">
                <span class="closebtn" {{--onclick="this.parentElement.style.display='none';"--}}><img class="cupom" src="{{Vite::asset('resources/images/Cupom.svg')}}"  alt="logo"><h4 class="cupom-text">{{App\Models\EcoCoupon::where('token', request()->input('t'))->first()->discount}}</h4></span>
            </div>
            <div id="overlay">
                <div id="text" class="col-xxl-6 col-xl-8 col-lg-10 col-md-12 col-12" >
                    <div class="card style-4 mx-4 mt-5">
                        <div class="card-body pt-3">
                            <div class="media mt-0 mb-3">
                                <div class="">
                                <div class="avatar avatar-md avatar-indicators avatar-online me-3">
                                    <img alt="avatar" src="{{asset($seller->image)}}" class="rounded-circle">
                                </div>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading mb-0">{{($seller->name)}} {{($seller->lastname)}}</h4>
                                    <p class="media-text">Representante Comercial</p>
                                </div>
                            </div>
                            <p class="card-text mt-4 mb-0">Olá! Vejo que seu cupom explirou, fale comigo através do Whatsapp que tenho uma ótima proposta para você!</p>
                        </div>
                        <div class="card-footer pt-0 border-0 text-center">
                            
                            <a href="https://api.whatsapp.com/send?phone={{$seller->cellphone}}&text={{$wp_text}}" class="btn btn-success w-100"><x-widgets._w-svg svg="brand-whatsapp"/>  <span class="btn-text-inner ms-3">Enviar Mensagem</span></a>
                        </div>
                        </div>
                </div>
            </div>
        @endif
        
        {{!$flow = new App\Http\Controllers\Flow}}
        {{$flow->new_entry(1, 1, request()->input('s') !== null ? request()->input('s') : 1)}}
        {{--<x-flow-event id="1" step="1" seller="{{request()->input('s') !== null ? "?seller=".request()->input('s') : 1}}"/>--}}
            
 
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
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
    function on() {
      document.getElementById("overlay").style.display = "block";
    }
    
    function off() {
      document.getElementById("overlay").style.display = "none";
    }
    </script>

        <script>
            

            function mycard(){
                
                if({{$cupom_discount}} > 0){
                   discount = {{$cupom_discount}};
                   price = {{$product->price}} * discount;
                }
            
                    prec.innerText = "Total: R$"+price;
                    
                    document.getElementById("cards").hidden = false;
                    document.getElementById("pixs").hidden = true;
                    document.getElementById("boletos").hidden = true;
                    document.getElementById("number").required = true;
                    document.getElementById("holderName").required = true;
                    document.getElementById("expiry").required = true;
                    document.getElementById("cvc").required = true;
                    document.getElementById("parcelac").hidden = false;
                    document.getElementById("pgpix").hidden = true;
                    document.getElementById("parcelab").hidden = true;
                    document.getElementById("payment").value = "CREDIT_CARD";
                    document.getElementById("checkou_value").value = price;
                    
            }
            function mypix(){
                if({{$cupom_discount}} > 0){
                   discount = {{$cupom_discount}};
                   price = {{$product->price}} * discount;
                }
             
                    prec.innerText = "Total: R$" + price * 0.9;

                    document.getElementById("pixs").hidden = false;
                    document.getElementById("cards").hidden = true;
                    document.getElementById("boletos").hidden = true;
                    document.getElementById("number").required = false;
                    document.getElementById("holderName").required = false;
                    document.getElementById("expiry").required = false;
                    document.getElementById("cvc").required = false;
                    document.getElementById("parcelac").hidden = true;
                    document.getElementById("pgpix").hidden = false;
                    document.getElementById("payment").value = "PIX";
                    document.getElementById("checkou_value").value = price;
            }
            function myboleto(){
                if({{$cupom_discount}} > 0){
                   discount = {{$cupom_discount}};
                   price = {{$product->price}} * discount;
                }
                    

                    document.getElementById("boletos").hidden = false;
                    document.getElementById("cards").hidden = true;
                    document.getElementById("pixs").hidden = true;
                    document.getElementById("number").required = false;
                    document.getElementById("holderName").required = false;
                    document.getElementById("expiry").required = false;
                    document.getElementById("cvc").required = false;
                    document.getElementById("parcelac").hidden = true;
                    document.getElementById("parcelab").hidden = false;
                    document.getElementById("pgpix").hidden = true;
                    document.getElementById("payment").value = "BOLETO";

            }
            function select_boleto(){
                
                var value = document.getElementById("parcelab").value;
                console.log(value);
                document.getElementById("checkou_value").value = value;
                var total_value = {!!($product->price)!!} * value;

                {!!round($product->price + $i*$product->price*0.05, 0)!!}

                prec.innerText = "Total: R$"+total_value;
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

        <script>
            Date.prototype.addMinutes= function(h){
                this.setMinutes(this.getMinutes()+h);
                return this;
            }

           function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            }
           
        // Set the date we're counting down to
            
        
        if(getCookie('countDownDate')){
            var countDownDate = getCookie('countDownDate');    
        }else{
            var countDownDate = new Date().addMinutes(10).getTime();
            document.cookie = 'countDownDate=' + countDownDate  + '; max-age=' + 3600 + '; path=/';
        }
        
        
        // Update the count down every 1 second
        var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();
        
        // Find the distance between now and the count down date
        
        var distance = countDownDate - now;
            
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
        // Output the result in an element with id="demo"
        document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";

        document.cookie = 'countdown-m=' + minutes + '; max-age=' + minutes*60+seconds + '; path=/';
        document.cookie = 'countdown-s=' + seconds + '; max-age=' + minutes*60+seconds + '; path=/';

        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRADO";
            document.getElementById("button_finalizar").hidden = true;
            on();
        }
        }, 1000);

        
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
