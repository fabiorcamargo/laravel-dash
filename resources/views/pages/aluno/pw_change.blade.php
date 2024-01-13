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

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <x-slot:scrollspyConfig>
                data-bs-spy="scroll" data-bs-target="" data-bs-offset="100"
                </x-slot>
                <div id="wizard_Default" class="col-lg-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <form action="{{route('user.pw_change-save')}}" method="post">
                            @csrf
                        <div class="widget-content widget-content-area">
                            <div class="bs-stepper stepper-form-one p-1">
                                <div class="bs-stepper-header" role="tablist">
                                    <div class="step" data-target="#defaultStep-one">
                                        <button type="button" class="step-trigger" role="tab">

                                            

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
                                                                <h2 class="animate__animated animate__fadeIn">Nova Senha
                                                                </h2>
                                                                <p class="mt-4 mb-0 animate__animated animate__fadeIn">
                                                                    Recomendamos que seja utilizado uma senha fácil.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div id="fuMultipleFile" class="col-lg-12 layout-spacing">

                                                <label for="name">Nova Senha</label>
                                                <input class="invisible" id="login" type="text" name="login"
                                                    value="{{Auth::user()->username}}" disabled>
                                                <input type="password" class="form-control invalid" name="password"
                                                    id="password" placeholder="******" autocomplete="on">

                                                <label for="name">Repita a Senha</label>
                                                <input type="password" class="form-control mb-2" name="password2"
                                                    id="password2" placeholder="******" autocomplete="on"
                                                    oninput="myPw()">
                                                <div class="text-warning invisible" name="feed" id="feed">As Senhas não
                                                    são iguais!</div>
                                                <div class="text-warning invisible" name="feed" id="feed">Existem campos
                                                    incompletos, favor voltar no passo anterior</div>
                                                <a id="customCheck1" class="mt-2" onclick="myFunction()"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-eye">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg></a>

                                            </div>
                                            <button type="submit" id="submit" name="subimit"
                                                class="btn btn-primary mb-2 me-4 disabled">Enviar</button>
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