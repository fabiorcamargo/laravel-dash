<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Erro
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/pages/error/error.scss'])
        @vite(['resources/scss/dark/assets/pages/error/error.scss'])
        <!--  END CUSTOM STYLE FILE  -->

        <style>
            body.layout-dark .theme-logo.dark-element {
                display: inline-block;
            }
            .theme-logo.dark-element {
                display: none;
            }
            body.layout-dark .theme-logo.light-element {
                display: none;
            }
            .theme-logo.light-element {
                display: inline-block;
            }
        </style>
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    <div>
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-md-4 mr-auto mt-5 text-md-left text-center">
                <div class="d-flex flex-row">
                    <div class="p-2">
                        <a href="/dashboard/analytics" class="ml-md-5">
                            <img alt="image-404" src="{{Vite::asset('resources/images/logo.svg')}}" class="dark-element theme-logo">
                            <img alt="image-404" src="{{Vite::asset('resources/images/logo2.svg')}}" class="light-element theme-logo">
                        </a>            
                    </div>
                    <h1 class="p-2 d-flex align-items-center">Code:404</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid error-content">
        <div class="">
            <h3 class="error-number mt-4">Oooops!</h3>
            <p class="error-text mb-5 mt-1">Parece que essa página não existe, caso esteja tentando acessar uma página necessária relate para o nosso suporte!</p>
            <img src="{{Vite::asset('resources/images/error.svg')}}" alt="cork-admin-404" class="error-img">
            
        </div>
        <a href="{{getRouterValue();}}/dashboard/analytics" class="btn btn-dark mt-5">Voltar</a>
    </div>  
</div>

    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>