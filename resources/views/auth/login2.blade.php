<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/authentication/auth-cover.scss'])
        @vite(['resources/scss/dark/assets/authentication/auth-cover.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">
    
            <div class="row">
    
                <div class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
                    <div class="auth-cover-bg-image"></div>
                    <div class="auth-overlay"></div>
                        
                    <div class="auth-cover">
    
                        <div class="position-relative">
    
                            <img src="{{Vite::asset('resources/images/auth-cover.svg')}}" alt="auth-img">
    
                            <h2 class="mt-5 text-white font-weight-bolder px-2">Profissionaliza EAD</h2>
                            <p class="text-white px-2">Uma das maiores Plataformas de Estudo do Brasil</p>
                        </div>
                        
                    </div>

                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
                    <div class="card">
                        <div class="card-body">
    
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <h2 class="animate__animated animate__pulse animate__infinite text-center"><img src="{{Vite::asset('resources/images/logo.svg')}}" class="navbar-logo logo-dark  mb-3" style="width: 70px;" alt="logo"></h2>
                                    
                                    <h2 class="text-center">Entrar</h2>
                                    <div class="seperator-text text-center"> <span>Insira os dados de usuário para entrar na Plataforma</span></div>
                                    
                                    
                                </div>
                                
                                  <div class="col-12 mb-4">
                                    <div class="">
                                        <div class="seperator">
                                            
                                            
                                        </div>
                                    </div>
                                </div>



                                                    <!-- Session Status -->
                                                    <x-auth-session-status class="mb-4" :status="session('status')" />

                                                    <!-- Validation Errors -->
                                                    <x-auth-validation-errors class="mb-4" :errors="$errors" />





        
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <!-- Email Address -->
                                        <div>
                                            <x-label for="email" :value="__('Id do Aluno')" />

                                            <x-input id="login" class="form-control" type="text" name="login" :value="old('login')" required autofocus />
                                        </div>

                                        <!-- Password -->
                                        <div class="mt-4">
                                            <x-label for="password" :value="__('Senha')" />

                                            <x-input id="password" class="form-control"
                                                            type="password"
                                                            name="password"
                                                            required autocomplete="current-password" />
                                        </div>

                                        <!-- Remember Me -->
                                        <div class="block mt-4">
                                            <label for="remember_me" class="inline-flex items-center">
                                                <input id="remember_me" type="checkbox" class="form-check-input me-3" name="remember">
                                                <span class="ml-2 text-sm text-gray-600">{{ __('Lembrar') }}</span>
                                            </label>
                                        </div>

                                        <div class="flex items-center justify-end mt-4">
                                    

                                            <div class="col-12">
                                                <div class="mb-4">
                                                    <button class="btn btn-secondary w-100">Entrar</button>
                                                    
                                                </div>
                                            </div>

                                            

                                        </div>
                                        
                                    </form>

                                   
                                
                                <div class="col-12 mb-4">
                                    <div class="">
                                        <div class="seperator">
                                            <hr>
                                            <div class="seperator-text"> <span>Ou recupere sua senha</span></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!--
                                <div class="col-sm-4 col-12">
                                    <div class="mb-4">
                                        <a class="btn  btn-social-login w-100 " href="{{ route('password.request') }}">
                                            <img src="{{Vite::asset('resources/images/google-gmail.svg')}}" alt="" class="img-fluid">
                                            <span class="btn-text-inner">Email</span>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-sm-5 col-12">
                                    <div class="mb-4">
                                        <a class="btn  btn-social-login w-100" href="{{ route('password.request') }}">
                                            <img src="{{Vite::asset('resources/images/whatsapp.svg')}}" alt="" class="img-fluid">
                                            <span class="btn-text-inner">Whatsapp</span>
                                        </a>
                                    </div>
                                </div>-->
                                
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
        

    </div>

    
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>