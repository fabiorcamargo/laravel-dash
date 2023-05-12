<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->



            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])

            <link rel="stylesheet" href="{{asset('plugins/apex/apexcharts.css')}}">

            @vite(['resources/scss/light/assets/components/list-group.scss'])
            @vite(['resources/scss/light/assets/widgets/modules-widgets.scss'])

            @vite(['resources/scss/dark/assets/components/list-group.scss'])
            @vite(['resources/scss/dark/assets/widgets/modules-widgets.scss'])

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

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
                    //alert("CEP não encontrado.");
                    document.getElementById('cep').classList.add('is-invalid');
                    document.getElementById('cep').classList.remove('is-valid');
                    document.getElementById('cepResponse').innerHTML = '<span class"pt-0" style="color:red">CEP não encontrado</span>';
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

                        document.getElementById('cep').classList.add('is-valid');
                        document.getElementById('cep').classList.remove('is-invalid');
                        document.getElementById('cepResponse').innerHTML = '<span class"pt-0" style="color:success"></span>';
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();

                        document.getElementById('cep').classList.add('is-invalid');
                        document.getElementById('cep').classList.remove('is-valid');
                        document.getElementById('cepResponse').innerHTML = '<span class"pt-0" style="color:red">Formato de CEP inválido</span>';
                        
                        //alert("Formato de CEP inválido.");
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

                    animation: pulse infinite;
                    /* referring directly to the animation's @keyframe declaration */
                    animation-duration: 2s;
                    /* don't forget to set a duration! */
                    z-index: 4;
                }

                .cupom {
                    position: fixed;
                    top: 10px;
                    right: 10px;
                    width: 100px;
                    z-index: 4;

                }

                .cupom-text {
                    position: fixed;
                    top: 60px;
                    right: 53px;
                    color: black;
                    z-index: 4;
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
                    z-index: 4;
                }

                #overlay {
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
                    z-index: 4;
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

                .list-group-item.active {
                    background-color: #0d6efd00;
                }

                .list-group-item.active:hover,
                .list-group-item.active:focus {
                    background-color: #0d6efd00;
                    box-shadow: 0 1px 15px 1px rgba(52, 40, 104, 0.15);
                }

                .form-control:disabled:not(.flatpickr-input),
                .form-control[readonly]:not(.flatpickr-input) {
                    background-color: #0d6efd00;
                    color: rgb(49, 49, 49)
                }
                .widget-card-two .card-bottom-section .button_card{
                    display: block;
                    margin-top: 18px;
                    background: #4361ee;
                    color: #fff;
                    padding: 10px 10px;
                    transform: none;
                    margin-right: 15px;
                    margin-left: 15px;
                    font-size: 15px;
                    font-weight: 500;
                    letter-spacing: 1px;
                    border: none;
                    background-image: linear-gradient(315deg, #1e9afe 0%, #3d38e1 74%);
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


            <div class="row invoice layout-top-spacing layout-spacing">
                <div class="doc-container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="invoice-container">
                                <div class="content-section header">
                                    <div class="row">
                                        <div class="widget-content widget-content-area br-8">
                                            <div class="d-flex">
                                                <h4 class=""><img src="{{Vite::asset('resources/images/logo2.svg')}}"
                                                        class="navbar-logo logo-light pe-3" width="80"
                                                        alt="logo">Profissionaliza EAD</h4>




                                            </div>
                                            <p class="inv-street-addr mt-3">CNPJ: 41.769.690/0001-25</p>
                                            <p class="inv-street-addr mt-3">Endereço: Av. Advogado Horácio Raccanello
                                                Filho, 5410 Sala 01, Maringá/PR, 87020-035</p>
                                        </div>

                                    </div>
                                </div>



                                <div class="content-section pt-4">
                                    <form
                                        action="{{ getRouterValue(); }}/app/eco/checkout/{{ $product->id }}/end/{{ $user->id }}"
                                        method="post" enctype="multipart/form-data" name="form" id="form"
                                        class="needs-validation" novalidate>
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-8">

                                                @if (\Session::has('erro'))
                                                <div class="alert alert-light-danger alert-dismissible fade show border-0 mb-4"
                                                    role="alert"> <button type="button" class="btn-close"
                                                        data-bs-dismiss="alert" aria-label="Close"> <svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-x close"
                                                            data-bs-dismiss="alert">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg></button> {!! \Session::get('erro') !!} </div>
                                                @endif
                                                @if (\Session::has('success'))
                                                <div class="alert alert-light-sucess alert-dismissible fade show border-0 mb-4"
                                                    role="alert"> <button type="button" class="btn-close"
                                                        data-bs-dismiss="alert" aria-label="Close"> <svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-x close"
                                                            data-bs-dismiss="alert">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg></button> {!! \Session::get('success') !!} </div>
                                                @endif

                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
                                                    <div class="widget-content widget-content-area br-8">
                                                        <h5 class="p-4 text-center">Como você prefere pagar?</h5>
                                                        <input type="text" id="parcelab_x" hidden readonly>
                                                        <input type="text" id="parcelab_v" hidden readonly>

                                                        <ul class="list-group list-group-media col-12">
                                                            <label class="form-check-label" for="PIX">
                                                                <li class="list-group-item" id="pix_li"
                                                                    onchange="mypay('pix')">

                                                                    <div
                                                                        class="form-check form-check-primary form-check-inline pt-4 col-12">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="radio-checked" id="PIX">

                                                                        <div class="d-flex">
                                                                            <div
                                                                                class="usr-img-frame me-2 rounded-circle">
                                                                                <img alt="avatar"
                                                                                    class="img-fluid rounded-circle"
                                                                                    src="{{Vite::asset('resources/images/logo-pix.svg')}}"
                                                                                    style="width: 30px;">
                                                                            </div>
                                                                            <p class="align-self-center admin-name"> Pix
                                                                                (+{{(1-env('ECO_PIX_DISCOUNT'))*100}}%
                                                                                Desconto)<br>Liberação Imediata</p>
                                                                        </div>


                                                                    </div>
                                                                    <select name="pix_dados" id="pix_dados"
                                                                        class="form-control mt-4 mb-4" hidden>
                                                                                <option
                                                                                value='{"x":"1", "v":"{{ round($product->price*$cupom_discount*env('ECO_PIX_DISCOUNT')  , 1) }}"}'>
                                                                                {{1}}x R${{
                                                                                round($product->price*$cupom_discount*env('ECO_PIX_DISCOUNT')
                                                                                , 1) }} com desconto</option>
                                                                                
                                                                    </select>
                                                                    <input type="text" id="pixs" name="pixs" hidden
                                                                        readonly>

                                                                </li>
                                                            </label>
                                                            <label class="form-check-label" for="CREDIT_CARD">
                                                                <li class="list-group-item" id="card_li"
                                                                    onchange="mypay('card')">
                                                                    <div
                                                                        class="form-check form-check-primary form-check-inline pt-4 col-12">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="radio-checked" id="CREDIT_CARD">

                                                                        <div class="d-flex">
                                                                            <div
                                                                                class="usr-img-frame me-2 rounded-circle">
                                                                                <img alt="avatar"
                                                                                    class="img-fluid rounded-circle"
                                                                                    src="{{Vite::asset('resources/images/credit-card.svg')}}"
                                                                                    style="width: 30px;">
                                                                            </div>
                                                                            <p class="align-self-center admin-name">
                                                                                Cartão de Crédito (Em até 12x)<br></p>


                                                                        </div>
                                                                        <img class="company-logo col-xl-6 col-lg-5  col-md-6 col-sm-8 col-12 pt-2"
                                                                            src="{{asset('/product/badeira-cartoes.png')}}"
                                                                            alt="logo">


                                                                        {{--R${{ $product->price * $cupom_discount }} Em
                                                                        até 10x R${{ $product->price*$cupom_discount/10
                                                                        }} --}}

                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <select name="card_dados" id="card_dados"
                                                                            class="form-control mb-4" hidden>
                                                                            @for ($i = 1; $i < 13; $i++) <option
                                                                                value='{"x":"{{$i}}", "v":"{{ round($product->price*$cupom_discount / $i, 1) }}"}'>
                                                                                {{$i}}x R${{
                                                                                round($product->price*$cupom_discount /
                                                                                $i, 1) }} com desconto</option>
                                                                                @endfor
                                                                        </select>
                                                                    </div>
                                                                    <div id='cards' name='cards' hidden>

                                                                        <x-widgets._w-cardcredit />

                                                                    </div>
                                                                </li>
                                                            </label>
                                                            <label class="form-check-label" for="BOLETO">
                                                                <li class="list-group-item" id="boleto_li"
                                                                    onchange="mypay('boleto')">
                                                                    <div
                                                                        class="form-check form-check-primary form-check-inline pt-4 col-12">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="radio-checked" id="BOLETO">

                                                                        <div class="d-flex">
                                                                            <div
                                                                                class="usr-img-frame me-2 rounded-circle">
                                                                                <img alt="avatar"
                                                                                    class="img-fluid rounded-circle"
                                                                                    src="{{Vite::asset('resources/images/boleto.svg')}}"
                                                                                    style="width: 30px;">
                                                                            </div>
                                                                            <p class="align-self-center admin-name">
                                                                                Boleto (Em até 6x)<br>Libera após
                                                                                compensação</p>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <select name="boleto_dados" id="boleto_dados"
                                                                            class="form-control mb-4" hidden>

                                                                            <option
                                                                                value='{"x":"1", "v":"{{round($product->price*$cupom_discount, 0)}}"}'>
                                                                                1x R${{
                                                                                round($product->price*$cupom_discount,
                                                                                0) }} com desconto </option>
                                                                            @for ($i = 2; $i < 13; $i++) <option
                                                                                value='{"x":"{{$i}}", "v":"{{round(($product->price + $i*$product->price*0.05)/$i, 2)}}"}'>
                                                                                {{$i}}x R${{ round(($product->price +
                                                                                $i*$product->price*0.05)/$i, 0) }} sem
                                                                                desconto</option>
                                                                                @endfor
                                                                        </select>

                                                                    </div>
                                                                </li>
                                                            </label>
                                                            <input type="text" name="payment" id="payment" value="PIX"
                                                                hidden>

                                                            <input type="text" id="checkou_value" name="checkou_value"
                                                                hidden readonly>

                                                        </ul>

                                                    </div>
                                                </div>
                                                <div class=" col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">

                                                    <div class="widget-content widget-content-area br-8">
                                                        <h5 class="p-4 text-center">Informações Pessoais</h5>
                                                        <div class="row">

                                                            <div
                                                                class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 pt-2">
                                                                <label for="defaultEmailAddress">CPF do Pagador:</label>
                                                                <input type="text" class="cpf-number form-control mb-4"
                                                                    onchange="cpfCheck(this)" maxlength="17"
                                                                    onkeydown="javascript: fMasc( this, mCPF );"
                                                                    placeholder="Apenas os números" name="cpfCnpj"
                                                                    id="cpfCnpj" autocomplete="on" required>
                                                                <p><span id="cpfResponse"></span></p>
                                                            </div>

                                                            <div
                                                                class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 pt-2">
                                                                <div class="col-12 layout-spacing">
                                                                    <div class="section general-info payment-info">
                                                                        <div class="info">


                                                                            <div class="mb-3">
                                                                                <label class="form-label">Cep:</label>
                                                                                <input name="cep" type="text" id="cep"
                                                                                    class="cep-number form-control"
                                                                                    maxlength="9"
                                                                                    onchange="pesquisacep(this.value);" required/>
                                                                                <p><span id="cepResponse"></span></p>
                                                                                {{--<span
                                                                                    class="badge badge-light-success mt-2 me-4">Buscar</span>--}}
                                                                            </div>
                                                                        </div>



                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div id='end' name='end' hidden>
                                                                    <h5 class="p-4 text-center">Meu Endereço</h5>
                                                                    <x-widgets._w-end />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            @php
                                            $images = "/product/".json_decode($product->image)[0];

                                            @endphp


                                            <div
                                                class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing pt-2">
                                                <x-widgets._w-card-checkout-end title="{{$product->name}}"
                                                    img="{{$images}}"
                                                    desc="Este é um produto digital, você receberá todas as informações nos contatos inseridos no seu perfil."
                                                    price="R$1000" />
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
                <h4 class="mt-2" style="color: #FFBA00">Cupom expira em: <span class="btn-text-inner" id="demo"></span>
                </h4>
            </div>
            <div class="callout">
                <div class="d-flex">
                    <img class="cupom" src="{{Vite::asset('resources/images/Cupom.svg')}}" alt="logo">
                    <h4 class="cupom-text">{{App\Models\EcoCoupon::where('token',
                        request()->input('t'))->first()->discount}}</h4>
                </div>
            </div>
            <div id="overlay">
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

            {{!$flow = new App\Http\Controllers\Flow}}
            {{$flow->new_entry(1, 1, request()->input('s') !== null ? request()->input('s') : 1, $product)}}
            {{--
            <x-flow-event id="1" step="1" seller="{{request()->input('s') !== null ? "
                ?seller=".request()->input('s') : 1}}" />--}}


            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                <script src="{{asset('plugins/global/vendors.min.js')}}"></script>


                <script src="{{asset('plugins/card/dist/card.js')}}"></script>
                <script>
                    var c = new Card({
                form: document.querySelector('#form'),
                container: '.card-wrapper'
            });
                </script>

                <script>
                    function is_cpf (c) {

                if((c = c.replace(/[^\d]/g,"")).length != 11)
                return false

                if (c == "00000000000")
                return false;

                var r;
                var s = 0;

                for (i=1; i<=9; i++)
                s = s + parseInt(c[i-1]) * (11 - i);

                r = (s * 10) % 11;

                if ((r == 10) || (r == 11))
                r = 0;

                if (r != parseInt(c[9]))
                return false;

                s = 0;

                for (i = 1; i <= 10; i++)
                s = s + parseInt(c[i-1]) * (12 - i);

                r = (s * 10) % 11;

                if ((r == 10) || (r == 11))
                r = 0;

                if (r != parseInt(c[10]))
                return false;

                return true;
                }


                function fMasc(objeto,mascara) {
                obj=objeto
                masc=mascara
                setTimeout("fMascEx()",1)
                }

                function fMascEx() {
                obj.value=masc(obj.value)
                }

                function mCPF(cpf){
                cpf=cpf.replace(/\D/g,"")
                cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
                cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
                cpf=cpf.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
                return cpf
                }

                cpfCheck = function (el) {
                document.getElementById('cpfResponse').innerHTML = is_cpf(el.value)? '' : '<span class"pt-0" style="color:red">Inválido insira novamente</span>';
                document.getElementById('cpfCnpj').classList = is_cpf(el.value)? 'cpf-number form-control mb-1 is-valid' : 'cpf-number form-control mb-1 is-invalid';

                if(el.value=='') document.getElementById('cpfResponse').innerHTML = '';
                }
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
                    function mypay(pay){
               
               json = document.getElementById(pay+"_dados").value;
               price = JSON.parse(json);
               const price_c = price.x * price.v;
               console.log(price);

               document.getElementById(pay+"_dados").hidden = false;
          
               if(price.x == 0){
                   prec.innerText = "Escolha uma forma de pagamento";
               } else {
               prec.innerHTML = "<del class='text-warning'>R${{$product->price}}</del><br> R$" + price_c.toFixed(0);
               }
       
               pay === "card" ? document.getElementById("cards").hidden = false : document.getElementById("cards").hidden = true;
               pay === "card" ? document.getElementById("card_dados").hidden = false : document.getElementById("card_dados").hidden = true;
               pay === "card" ? document.getElementById("card_li").classList.add('active') : document.getElementById("card_li").classList.remove('active');
               if(pay ==="card"){
                document.getElementById("number").required = true;
               document.getElementById("holderName").required = true;
               document.getElementById("expiry").required = true;
               document.getElementById("cvc").required = true;
               }else{
                document.getElementById("number").required = false;
               document.getElementById("holderName").required = false;
               document.getElementById("expiry").required = false;
               document.getElementById("cvc").required = false;
               }

               pay === "boleto" ? document.getElementById("boleto_dados").hidden = false : document.getElementById("boleto_dados").hidden = true;
               pay === "boleto" ? document.getElementById("boleto_li").classList.add('active') : document.getElementById("boleto_li").classList.remove('active');
               pay === "pix" ? document.getElementById("pix_dados").hidden = false : document.getElementById("pix_dados").hidden = true;
               pay === "pix" ? document.getElementById("pix_li").classList.add('active') : document.getElementById("pix_li").classList.remove('active');

               
               
               //document.getElementById("pixs").hidden = true;
               
               
               //document.getElementById("parcelac").hidden = false;
               //document.getElementById("pgpix").hidden = true;
               //document.getElementById("parcelab").hidden = false;
               document.getElementById("parcelab_x").value = price.x;
               document.getElementById("parcelab_v").value = price.v;
               document.getElementById("payment").value = "CREDIT_CARD";
               document.getElementById("checkou_value").value = price;
               
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
        //document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";

        document.cookie = 'countdown-m=' + minutes + '; max-age=' + minutes*60+seconds + '; path=/';
        document.cookie = 'countdown-s=' + seconds + '; max-age=' + minutes*60+seconds + '; path=/';

        // If the count down is over, write some text 
       if (distance < 0) {
            clearInterval(x);
            //document.getElementById("demo").innerHTML = "EXPIRADO";
            //document.getElementById("button_finalizar").hidden = true;
            //on();
        }
        }, 1000);

        
                </script>
                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>