<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>
@php
    $teste = 1;
@endphp
    

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->

        @vite(['resources/scss/light/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/dark/plugins/editors/quill/quill.snow.scss'])

        @vite(['resources/scss/light/assets/apps/ecommerce-create.scss'])
        @vite(['resources/scss/dark/assets/apps/ecommerce-create.scss'])

        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])

        <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/noUiSlider/nouislider.min.css')}}">
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])
        
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <div class="row mb-4 layout-spacing layout-top-spacing">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">

           <!-- Session Status -->
           <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

           <!-- Validation Errors -->
           <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />

            <div class="">
                <form action="{{ getRouterValue(); }}/app/campaign/add_course"  method="post" enctype="multipart/form-data" name="form1" class="was-validated">
                    @csrf
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="widget-content widget-content-area ecommerce-create-section">
                            <h4>Cadastrar Liberação</h4>
                            <br>
                            <div class="col-xxl-6 col-md-6 mb-2">
                                <label for="title">Nome da Liberação</label>
                                <input type="text" class="form-control mb-4" id="title" name="title" placeholder="Nome da Liberação" required>
                            </div>
        
                            <div class="col-xxl-6 col-md-6 mb-2">
                                <label for="title">Campanha</label>
                                <select name="campaign" id="campaign" class="form-control" required>
                                    <option value=""></option>
                                    @foreach ($campaign as $key => $value)
                                        <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                                    @endforeach-
                                </select>
                            </div>{{--}}
                                    <div class="col-xxl-10 col-md-10 mb-10">
                                        <label for="title">Selecione sua Cidade</label>
                                        
                                        <select name="city" id="city" class="form-control" aria-placeholder="Cidade" onchange = "myFn('city')" required>
                                            <option value="">Selecione sua Cidade</option>
                                        </select>
                                    </div>--}}
                           
                            <div class="col-xxl-6 col-md-6 mb-4">
                                <label for="course">Curso | Aulas | Horas</label>
                                <select name="course" id="course" class="form-control" required>
                                    <option value="">Selecione o Curso</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}|{{ $course->nome }}">{{ $course->id }} | {{ $course->nome }} | {{ $course->aulas }} | {{ $course->carga }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-4 col-md-4 mb-4">
                                <label for="code">Código</label>
                                <input type="text" class="form-control mb-4" id="code" name="code" placeholder="Código com 4 dígitos" required>
                            </div>
                            <div class="col-xxl-12 col-md-6 mb-3">
                                <label for="flow">Selecione o período de Matrícula</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Início</span>
                                    <input id="start" name="start"  class="form-control flatpickr flatpickr-input active" type="text" placeholder="Data inicial.." required>
                                    <span class="input-group-text">Fim</span>
                                    <input id="end" name='end' class="form-control flatpickr flatpickr-input active" type="text" placeholder="Data final.." required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <button id="adicionar" class="btn btn-success w-100">Criar campanha</button>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
        <script src="{{asset('plugins/editors/quill/quill.js')}}"></script>
        @vite(['resources/assets/js/apps/ecommerce-create.js'])

        <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
        <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr2.js')}}"></script>
        <script src="{{asset('plugins/autocomplete/autoComplete.min.js')}}"></script>
        <script src="{{asset('plugins/autocomplete/city_autoComplete.js')}}"></script>
            @vite(['resources/assets/js/apps/blog-create.js'])

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>