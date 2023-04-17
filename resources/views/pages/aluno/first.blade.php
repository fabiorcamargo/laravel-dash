<x-base-layout :scrollspy="true">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/stepper/bsStepper.min.css')}}">
        @vite(['resources/scss/light/plugins/stepper/custom-bsStepper.scss'])
        @vite(['resources/scss/dark/plugins/stepper/custom-bsStepper.scss'])
        
        @vite(['resources/scss/light/assets/pages/knowledge_base.scss'])
        @vite(['resources/scss/dark/assets/pages/knowledge_base.scss'])

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>   
        
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="" data-bs-offset="100" 
    </x-slot>
    

    

        <div id="wizard_Default" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="bs-stepper stepper-form-one p-1">
                        <div class="bs-stepper-header" role="tablist">
                            <div class="step" data-target="#defaultStep-one">
                                <button type="button" class="step-trigger" role="tab" >

                                    <span class="bs-stepper-circle">1</span>
                                    
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#defaultStep-two">
                                <button type="button" class="step-trigger" role="tab"  >

                                    <span class="bs-stepper-circle">2</span>
                                    
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#defaultStep-three">
                                <button type="button" class="step-trigger" role="tab"  >

                                    <span class="bs-stepper-circle">3</span>

                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <div id="defaultStep-one" class="content" role="tabpanel">
                                <div class="faq-header-content">
                                    <div class="fq-header-wrapper">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12 align-self-center order-md-0 order-1">
                                                    <div class="faq-header-content">
                                                        <h2 class="animate__animated animate__pulse animate__infinite"><img src="{{Vite::asset('resources/images/logo.svg')}}" class="navbar-logo logo-dark  mb-3" style="width: 80px;" alt="logo"></h2   >
                                                        <h2 class="animate__animated animate__fadeIn animate__delay-1s">Seja bem Vindo</h2>
                                                        <div class="row">
                                                        
                                                        </div>
                                                        <p class="mt-4 mb-0 animate__animated animate__fadeIn animate__delay-2s">Siga os próximos passos para ativar seu acesso</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
        
                                        <a class="btn btn-primary btn-nxt mt-5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg></a>
                                    </div>
                                </div>

                            </div>
                            <div id="defaultStep-two" class="content" role="tabpanel">
                                <div class="faq-header-content">
                                    <div class="fq-header-wrapper">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12 align-self-center order-md-0 order-1">
                                                    <div class="faq-header-content">
                                                        <h2 class="animate__animated animate__fadeIn">Dados Pessoais</h2>
                                                        <div class="row">
                                                        
                                                        </div>
                                                        <p class="mt-4 mb-0 animate__animated animate__fadeIn">Insira as informações abaixo:</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ getRouterValue(); }}/aluno/post"  method="post" enctype="multipart/form-data" name="form1" class="was-validated">
                                    
                                    @csrf

                                    <div class="form-group mb-4">
                                        <label for="name">Primeiro Nome</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Maria Vitória" autocomplete="on" onchange="myFn('name')" required>
                                        
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="lastname">Sobrenome</label>
                                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Soares da Silva" autocomplete="on" required onchange="myFn('lastname')">

                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" placeholder="Para recuperação de senha" class="email white col-7 col-md-4 col-lg-7 ml-3 form-control" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" onchange="myFn('mail')" required>
                                                    <div class="valid-feedback feedback-pos">
                                                        Email Válido!
                                                    </div>
                                                    <div class="invalid-feedback feedback-pos">
                                                        Por favor coloque um email válido.
                                                    </div>

                                        </div>
                                    </div>     
                                    <div class="form-group mb-4">
                                        <label for="defaultEmailAddress">Celular com Whatsapp </label>
                                        <input type="text" class="ph-number form-control mb-4" placeholder="Telefone com DDD" name="cellphone" id="cellphone" pattern="(\([0-9]{2}\))\s([9]{1})\s?([0-9]{4})-([0-9]{4})" autocomplete="on" required onchange = "myFn('cellphone')">
                                        <div class="valid-feedback feedback-pos">
                                            Celular válido!
                                        </div>
                                        <div class="invalid-feedback feedback-pos">
                                            Por favor coloque um Telefone válido com DDD e 9º dígito.
                                        </div>
                                    </div>
                                    <div class="form-group">
  
                                        <div class="row">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="title">Selecione seu Estado</label>
                                                    <select name="state" class="form-control" onchange = "myFn('state')" required>
                                                        <option value="">Selecione seu Estado</option>
                                                        @foreach ($states as $key => $value)
                                                            <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="title">Selecione sua Cidade</label>
                                                    
                                                    <select name="city" id="city" class="form-control" aria-placeholder="Cidade" onchange = "myFn('city')" required>
                                                        <option value="">Selecione sua Cidade</option>
                                                    </select>
                                                </div>
                                        
 
                                            </div>
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-secondary btn-nxt mt-5 disabled" id="step"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg></a>
                                    </div>
                                
                             
                            </div>
                            <div id="defaultStep-three" class="content" role="tabpanel" >
                                <div class="faq-header-content">
                                    <div class="fq-header-wrapper">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12 align-self-center order-md-0 order-1">
                                                    <div class="faq-header-content">
                                                        <h2 class="animate__animated animate__fadeIn">Nova Senha</h2>
                                                        <div class="row">
                                                        
                                                        </div>
                                                        <p class="mt-4 mb-0 animate__animated animate__fadeIn">Recomendamos que seja utilizado uma senha fácil.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-12">
                                        <div id="fuMultipleFile" class="col-lg-12 layout-spacing">
                                            
                                            <label for="name">Nova Senha</label>
                                            <input class="invisible" id="login" type="text" name="login" value="{{Auth::user()->username}}" disabled>
                                            <input type="password" class="form-control invalid" name="password" id="password" placeholder="******" autocomplete="on">
                                            
                                            <label for="name">Repita a Senha</label>
                                            <input type="password" class="form-control mb-2" name="password2" id="password2" placeholder="******" autocomplete="on" oninput ="myPw()">
                                            <div class="text-warning invisible" name="feed" id="feed" >As Senhas não são iguais!</div>
                                            <div class="text-warning invisible" name="feed" id="feed" >Existem campos incompletos, favor voltar no passo anterior</div>
                                            <a id="customCheck1" class="mt-2" onclick="myFunction()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                                             
                                        </div>
                                        <button type="submit" id="submit" name="subimit" class="btn btn-primary mb-2 me-4 disabled">Enviar</button>
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

        

    
      
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
        <script src="{{asset('plugins/input-mask/jquery.inputmask.bundle.min.js')}}"></script>
        <script src="{{asset('plugins/input-mask/input-mask.js')}}"></script>

        <script src="{{asset('plugins/stepper/bsStepper.min.js')}}"></script>
        <script src="{{asset('plugins/stepper/custom-bsStepper.min.js')}}"></script>

        

        
   
        

        <script>
            function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            var x = document.getElementById("password2");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            }

        </script>
<script>

    function myPw(){
                let pw = document.getElementById('password').value;
                let pw2 = document.getElementById('password2').value;

                console.log(pw);
                console.log(pw2);

                if ( pw != pw2) {
                    document.getElementById('feed').classList.remove('invisible');
                    document.getElementById('submit').classList.add('disabled');
                }else if ( pw == pw2 ){
                    document.getElementById('feed').classList.add('invisible');
                    document.getElementById('submit').classList.remove('disabled');
                    
                }

            }


</script>

<script>
    function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    var x = document.getElementById("password2");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    }
</script>
<script>
    function myFn($data){
        console.log($data);
        if ( name.value != ""  && lastname.value != "" && email.value != "" && cellphone.value != "" && city.value != "") {
        let el = document.getElementById('step');
        el.classList.remove('disabled');
        }
    }
    </script>

    <script>
        (function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
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
})();
    </script>

<script type="text/javascript">
    $(document).ready(function() {
        
        $('select[name="state"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
                $.ajax({
                    url: '/city/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {   
                        console.log("teste");   
                        var city = "1";                
                        $('select[name="city"]').empty();
                        $.each(data, function(key, value) {
                        $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="city"]').empty();
            }
        });
    });
</script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>