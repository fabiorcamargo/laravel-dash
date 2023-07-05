<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->


            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])
            @vite(['resources/scss/light/plugins/loaders/custom-loader.scss', 'resources/scss/dark/plugins/loaders/custom-loader.scss'])

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

            <script>
                function mostrar(){
                    $('#continuar').show();
                    $(".enviando").hide();
                }
                $(document).ready(function() {
                    $(".enviando").hide();
                $('#form').submit(function(event) {
                    // Sua função a ser executada quando o formulário for enviado
                    $('#continuar').hide();
                    $(".enviando").show();
                    
                });
                });

            </script>

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

            <x-fb-microdata object={!!$product!!} />

            <style>
                .callout {
                    position: fixed;
                    top: 10px;
                    right: 10px;
                    margin-left: 20px;

                    animation: pulse infinite;
                    /* referring directly to the animation's @keyframe declaration */
                    animation-duration: 2s;
                    /* don't forget to set a duration! */
                }

                .cupom {
                    width: 100px;

                }

                .cupom-text {
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

                #overlay_cel {
                    position: fixed;
                    /* Sit on top of the page content */
                    display: none;
                    /* Hidden by default */
                    width: 100%;
                    /* Full width (cover the whole page) */
                    height: 100%;
                    /* Full height (cover the whole page) */
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: rgba(0, 0, 0, 0.5);
                    /* Black background with opacity */
                    z-index: 2;
                    /* Specify a stack order in case you're using a different order for other elements */
                    cursor: pointer;
                    /* Add a pointer on hover */
                }

                #text {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    -ms-transform: translate(-5%, -5%);
                }

                .text {
                    font-size: 50px;
                    color: white;
                }
            </style>

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

            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            @php $price = $product->price @endphp
            @if(App\Models\EcoCoupon::where('token', request()->input('t'))->exists())
            @php $cupom = App\Models\EcoCoupon::where('token', request()->input('t'))->first() @endphp
            @php $cupom_discount = 1 - $cupom->discount /100 @endphp
            @php $seller = App\Models\User::find(App\Models\EcoSeller::find(App\Models\EcoCoupon::where('token',
            request()->input('t'))->first()->seller)->user_id) @endphp
            @php $wp_text = urlencode("Olá preciso de um novo cupom para o curso de $product->name eu estava utilizando
            o Cupom: $cupom->name") @endphp
            @else
            @php $cupom_discount = 1 - $product->percent @endphp
            @endif

            <div class="modal fade" id="overlay" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="spanner">
                        <div class="loader"></div>
                        <p class="text-white">Aguarde</p>
                    </div>
                </div>
            </div>

            <div class="auth-container d-flex">

                <div class="container mx-auto align-self-center">
                    <div class="row">
                        @if (\Session::has('erro'))
                        <div class="alert alert-light-danger alert-dismissible fade show border-0 mb-4" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg></button> <strong>Atenção:</strong> {!!
                            \Session::get('erro') !!}
                        </div>

                        @endif
                        @if (\Session::has('success'))
                        <div class="alert alert-light-sucess alert-dismissible fade show border-0 mb-4" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg></button> <strong>Atenção:</strong> {!!
                            \Session::get('success') !!}
                        </div>

                        @endif

                    </div>

                    <div class="row">
                        <form action="{{ getRouterValue(); }}/app/eco/checkout/{{ $product->id }}/client" method="post"
                            enctype="multipart/form-data" name="form" id="form" class="needs-validation m-0 p-0"
                            onsubmit="enviando()"
                            novalidate>
                            @csrf
                            <div
                                class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto p-0 m-0">
                                <div class="card mt-3 mb-3">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="text-center">
                                                    <img src="{{Vite::asset('resources/images/Logo-Vetorial.png')}}"
                                                        class="navbar-logo logo-light pe-3" width="200"
                                                        alt="Profissionaliza EAD">
                                                </div>
                                                <h2 class="pt-4 text-center">Bem vindo</h2>
                                                <p class="pt-2 text-center">Você está a um passo de ingressar em uma das
                                                    maiores plataformas profissionalizantes do Brasil</p>

                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Nome</label>
                                                    <input type="text" class="form-control add-billing-address-input"
                                                        placeholder="Nome completo" name="nome" id="nome"
                                                        autocomplete="on" onblur="mostrar()" required>
                                                    <div class="valid-feedback feedback-pos">
                                                        Celular válido!
                                                    </div>
                                                    <div class="invalid-feedback feedback-pos">
                                                        Por favor preencha com seu nome completo.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="email form-control"
                                                        placeholder="Para receber acesso ao portal"
                                                        class="email white col-7 col-md-4 col-lg-7 ml-3 form-control"
                                                        id="email" name="email"
                                                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                                        onchange="myFn('mail')" 
                                                        onblur="mostrar()"
                                                        required>
                                                    <div class="valid-feedback feedback-pos">
                                                        Email Válido!
                                                    </div>
                                                    <div class="invalid-feedback feedback-pos">
                                                        Por favor coloque um email válido.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Telefone</label>
                                                    <input type="text" class="ph-number form-control"
                                                        placeholder="Digite apenas os números" name="cellphone"
                                                        id="cellphone" autocomplete="on"
                                                        onblur="mostrar()"
                                                        required>
                                                    <div class="valid-feedback feedback-pos">
                                                        Celular válido!
                                                    </div>
                                                    <div class="invalid-feedback feedback-pos">
                                                        Por favor coloque um Telefone válido com DDD e 9º
                                                        dígito.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-3">
                                                <div class="mb-3">
                                                    <div class="form-check form-check-primary form-check-inline">
                                                        <input class="form-check-input  " type="checkbox"
                                                            id="form-check-default" 
                                                            onchange="mostrar()"
                                                            required>
                                                        <label class="form-check-label" for="form-check-default">
                                                            Eu concordo com <a href="javascript:void(0);"
                                                                class="text-primary">Termos e Política de
                                                                Privacidade</a>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="mb-4">
                                                    @foreach (request()->input() as $key => $value)
                                                    <input type="text" id="{{$key}}" name="{{$key}}" value="{{$value}}"
                                                        readonly hidden>
                                                    @endforeach
                                                    <button id="enviando" class="btn btn-secondary w-100 enviando" disabled>
                                                        <div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Enviando
                                                    </button>
                                                    <button id="continuar" type="submit" class="btn btn-secondary w-100">Continuar</button>
                                                </div>
                                            </div>

                                            <div class="col-12 mb-2">
                                                <div class="">
                                                    <div class="seperator">
                                                        <hr>
                                                        <div class="seperator-text"> <span></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--}}
                                            <div class="col-sm-4 col-12">
                                                <div class="mb-4">
                                                    <button class="btn  btn-social-login w-100 ">
                                                        <img src="{{Vite::asset('resources/images/google-gmail.svg')}}"
                                                            alt="" class="img-fluid">
                                                        <span class="btn-text-inner">Google</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 col-12">
                                                <div class="mb-4">
                                                    <button class="btn  btn-social-login w-100">
                                                        <img src="{{Vite::asset('resources/images/github-icon.svg')}}"
                                                            alt="" class="img-fluid">
                                                        <span class="btn-text-inner">Github</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 col-12">
                                                <div class="mb-4">
                                                    <button class="btn  btn-social-login w-100">
                                                        <img src="{{Vite::asset('resources/images/twitter.svg')}}"
                                                            alt="" class="img-fluid">
                                                        <span class="btn-text-inner">Twitter</span>
                                                    </button>
                                                </div>
                                            </div>--}}

                                            <div class="col-12">
                                                <div class="text-center">
                                                    <p class="mb-0">Já possui uma conta? <a href="/login"
                                                            class="text-warning">Clique aqui para entrar</a></p>
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

            @if(App\Models\EcoCoupon::where('token', request()->input('t'))->exists())
            <div class="footer">
                <h4 class="mt-2" style="color: #FFBA00">Cupom expira em: <span class="btn-text-inner" id="demo"></span>
                </h4>
            </div>
            <div class="callout">
                <span class="closebtn" {{--onclick="this.parentElement.style.display='none';" --}}><img class="cupom"
                        src="{{Vite::asset('resources/images/Cupom.svg')}}" alt="logo">
                    <h4 class="cupom-text">{{App\Models\EcoCoupon::where('token',
                        request()->input('t'))->first()->discount}}</h4>
                </span>
            </div>
            <div id="overlay_cel">
                <div id="text" class="col-xxl-6 col-xl-8 col-lg-10 col-md-12 col-12">
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
                            <p class="card-text mt-4 mb-0">Olá! Vejo que seu cupom explirou, fale comigo através do
                                Whatsapp que tenho uma ótima proposta para você!</p>
                        </div>
                        <div class="card-footer pt-0 border-0 text-center">

                            <a href="https://api.whatsapp.com/send?phone={{$seller->cellphone}}&text={{$wp_text}}"
                                class="btn btn-success w-100">
                                <x-widgets._w-svg svg="brand-whatsapp" /> <span class="btn-text-inner ms-3">Enviar
                                    Mensagem</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif



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
                    <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
                    <script src="{{asset('plugins/input-mask/jquery.inputmask.bundle.min.js')}}"></script>
                    <script src="{{asset('plugins/input-mask/input-mask2.js')}}"></script>
                   

                    

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
            
            on();
        }
        }, 1000);


                    </script>

                    <script>
                        function on() {
            document.getElementById("overlay_cel").style.display = "block";
            }
            
            function off() {
            document.getElementById("overlay_cel").style.display = "none";
            }
                    </script>

                    <script>
                        fbq("track", "AddToWishlist",
            {
                "event_name": "AddToWishlist",
                "event_time": "{{ time() }}",
                "action_source": "website",
                "event_source_url": "{{ url()->current() }}",
                "eventID": "{{ Cookie::get('fbid') }}",
                "user_data": {
                    "client_ip_address": "{{$_SERVER['REMOTE_ADDR']}}",
                    "client_user_agent": "{{$_SERVER['HTTP_USER_AGENT']}}"
                    @isset($_COOKIE['_fbp'])
                    ,"fbp": "{{$_COOKIE['_fbp']}}",
                    "fbc": "{{$_COOKIE['_fbp']}}.{{ Cookie::get('fbid') }}"
                    @endisset
                },
                "custom_data": {
                    "content_ids": "product_{{$product->id}}",
                    "content_category": "{{json_decode($product->tag)[0]->value}}",
                    "content_name": "{{$product->name}}"
                }
            }
            )
                    </script>
                    </x-slot>
                    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
<x-fb-event event="AddToWishlist" object={!!$product!!} />