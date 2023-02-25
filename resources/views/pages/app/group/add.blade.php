<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->

        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/assets/apps/blog-create.scss'])

        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/assets/apps/blog-create.scss'])

        <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/noUiSlider/nouislider.min.css')}}">
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])




        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">App</a></li>
                <li class="breadcrumb-item"><a href="#">Group</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->

    <div class="row mb-4 layout-spacing layout-top-spacing">

        <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form action="{{ getRouterValue(); }}/app/group/add"  method="post" enctype="multipart/form-data" name="form1" class="was-validated">
                @csrf
            <div class="widget-content widget-content-area blog-create-section mb-4">
                <h5 class="mb-4">Criação de Grupos</h5>
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <label>Coloque o nome do grupo com base no nome do curso.</label>
                        <input type="text" class="form-control" name="course_name" id="course_name" placeholder="Nome" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="col-xxl-12 col-md-6 mb-3">
                            <label for="flow">Código do Curso (Código cadastrado na Cademi)</label>
                            <select name="course_id" id="course_id" class="form-control mb-2" required>
                                @foreach ($tags as $tag)
                                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            <a href="{{ getRouterValue(); }}/app/eco/cademi/tag" class="btn btn-light-primary me-4">Atualizar</a>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="col-xxl-12 col-md-6 mb-3">
                            <label for="flow">Selecione o período de Matrícula</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Início</span>
                                <input id="inicio" name="inicio"  class="form-control flatpickr flatpickr-input active" type="text" placeholder="Data inicial.." required>
                                <span class="input-group-text">Fim</span>
                                <input id="fim" name='fim' class="form-control flatpickr flatpickr-input active" type="text" placeholder="Data final.." required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
              
            <div class="widget-content widget-content-area blog-create-section">
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="col-xxl-12 col-md-6 mb-3">
                            <label for="flow">Responsável</label>
                            <select name="responsavel" id="responsavel" class="form-control mb-2" required>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <label>Link para entrar no grupo</label>
                        <input type="text" class="form-control" name="group_link" id="group_link" placeholder="https://whats.....">
                    </div>
                </div>
            </div>

            <div class="widget-content widget-content-area blog-create-section mt-4">
                <h5 class="mb-4">Integração do Chatbot</h5>
                <div class="row mb-4">
                    <div class="col-xxl-12 mb-4">
                        <label>Identificação para integração (Caso não possua deixar em branco)</label>
                        <input type="text" class="form-control" name="group_id" id="group_id" placeholder="">
                    </div>
                </div>
                <button type="send" class="btn btn-success w-100">Criar Grupo</button>
            </div>
            </form>
        </div>

    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
    <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr2.js')}}"></script>
        @vite(['resources/assets/js/apps/blog-create.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>