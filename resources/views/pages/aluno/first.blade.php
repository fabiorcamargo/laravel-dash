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
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
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
                                <form action="{{ getRouterValue(); }}/aluno/post"  method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group mb-4">
                                        <label for="name">Primeiro Nome</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Maria Vitória">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="lastname">Nome do Meio e Sobrenome</label>
                                        <input type="lastname" class="form-control" name="lastname" id="lastname" placeholder="Soares da Silva">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control mb-3" name="email" id="email" placeholder="Email" value="">
                                        </div>
                                    </div>     
                                    <div class="form-group mb-4">
                                        <label for="defaultEmailAddress">Telefone (Whatsapp) </label>
                                        <input type="text" class="ph-number form-control mb-4" placeholder="Telefone com DDD" name="ph" id="ph">
                                    </div>
                                    <div class="form-group">
                                        <label for="city">Cidade - Estado</label>
                                        <div class="row">
                                            <div class="mb-3">
                                                <input id="autoComplete" name="city" class="form-control">
                                                
                                            </div>
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-secondary btn-nxt mt-5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg></a>
                                    </div>
                                
                             
                            </div>
                            <div id="defaultStep-three" class="content" role="tabpanel" >
                                
                                    <div class="col-12">
                                        <label for="defaultInputAddress" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="defaultInputAddress" placeholder="1234 Main St">
                                    </div>
                                    <div class="col-12">
                                        <label for="defaultInputAddress2" class="form-label">Address 2</label>
                                        <input type="text" class="form-control" id="defaultInputAddress2" placeholder="Apartment, studio, or floor">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="defaultInputCity" class="form-label">City</label>
                                        <input type="text" class="form-control" id="defaultInputCity">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="defaultInputState" class="form-label">State</label>
                                        <select id="defaultInputState" class="form-select">
                                            <option selected="">Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="defaultInputZip" class="form-label">Zip</label>
                                        <input type="text" class="form-control" id="defaultInputZip">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="defaultGridCheck">
                                            <label class="form-check-label" for="defaultGridCheck">
                                                Check me out
                                            </label>
                                        </div>
                                    </div>
                                
                                    <div class="d-grid gap-2 mt-5">
                                        <button class="btn btn-primary" type="submit">Enviar</button>
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

        @vite(['resources/assets/js/pages/knowledge-base.js'])

        <script src="{{asset('plugins/stepper/bsStepper.min.js')}}"></script>
        <script src="{{asset('plugins/stepper/custom-bsStepper.min.js')}}"></script>

        <script src="{{asset('plugins/autocomplete/autoComplete.min.js')}}"></script>
        <script src="{{asset('plugins/autocomplete/city_autoComplete.js')}}"></script>
        <script src="{{asset('plugins/input-mask/jquery.inputmask.bundle.min.js')}}"></script>
        <script src="{{asset('plugins/input-mask/input-mask-custom.js')}}"></script>
   
   

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>