<x-base-layout :scrollspy="true" :avatar="$avatar">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/apex/apexcharts.css')}}">
        <script src="https://core.cademi.com.br/assets/js/remote.js"></script>

        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/widgets/modules-widgets.scss'])

        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/widgets/modules-widgets.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- Analytics -->
    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>

    <div class="row layout-top-spacing">
        <form action="{{ getRouterValue(); }}/app/user/reset"  method="post" enctype="multipart/form-data" name="form1" class="was-validated">
                                    
            @csrf

     <div id="defaultStep-three" class="content" role="tabpanel" >
        <div class="faq-header-content">
            <div class="fq-header-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 align-self-center order-md-0 order-1">
                            <div class="faq-header-content">
                                <h2 class="animate__animated animate__fadeIn">Digite o Usuário que deseja trocar a senha</h2>
                                <div class="row">
                                
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-12">
                <div id="fuMultipleFile" class="col-lg-12 layout-spacing">
                    <label for="name">Id do Usuário</label>
                    <input type="text" class="form-control" name="username" id="username" autocomplete="off">
                    
                    <label for="name">Nova Senha</label>
                    <input type="text" class="form-control" name="password" id="password" placeholder="******" autocomplete="off">
                    
                    <label for="name">Repita a Senha</label>
                    <input type="text" class="form-control mb-2" name="password2" id="password2" placeholder="******" autocomplete="off" onblur="myPw()">
                    <div class="text-danger invisible" name="feed" id="feed" >As Senhas não são iguais, ou o campo Id está vazio</div>
                     
                </div>
                <button type="submit" id="submit" name="subimit" class="btn btn-primary mb-2 me-4 disabled">Enviar</button>
            </div>
        </div>
            </div>
        </div>
            </div>             
        
            
    </form>

    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        
        {{-- <script src="{{asset('plugins/apex/custom-apexcharts.js')}}"></script> --}}
        
<script>
        function myPw(){
            let pw = document.getElementById('password').value;
            let pw2 = document.getElementById('password2').value;
            let username = document.getElementById('username').value;

            console.log(pw);
            console.log(pw2);

            if ( pw != pw2 || username == "") {
                document.getElementById('feed').classList.remove('invisible');
                document.getElementById('submit').classList.add('disabled');
            }else if ( pw == pw2 || username !== "" ){
                document.getElementById('feed').classList.add('invisible');
                document.getElementById('submit').classList.remove('disabled');
                
            }

        }</script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>