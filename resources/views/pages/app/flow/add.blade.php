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

        @vite(['resources/scss/light/plugins/editors/quill/quill.snow.scss'])

        <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/noUiSlider/nouislider.min.css')}}">
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])

        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])


        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">App</a></li>
                <li class="breadcrumb-item"><a href="#">Group</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>
    -->

    <div class="row mb-4 layout-spacing layout-top-spacing">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
        <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form action="{{ getRouterValue(); }}/app/flow/add" method="post" enctype="multipart/form-data" name="form1" class="was-validated">
                @csrf
            <div class="widget-content widget-content-area blog-create-section mb-4">
                <h5 class="mb-4">Criar novo Fluxo</h5>
                <div class="row mb-4">
                    <div class="col-xxl-8 col-md-8 mb-3">
                        <label>Nome do fluxo</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nome" required>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-xxl-4 col-md-4 mb-3">
                        <label for="context">Contexto</label>
                            <select class="form-select" name="context" id="context" required>
                                <option></option>
                                <option value="1">Ecommerce</option>
                                <option value="2">Campanhas</option>
                            </select>
                    </div>
                    <div class="col-xxl-4 col-md-4 mb-3">
                        <label for="steps">Etapas</label>
                            <select class="form-select" name="steps" id="steps" required>
                                <option></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                    </div>
               
                    <div class="col-xxl-4 col-md-4 mb-3">
                        <label for="item">Item</label>
                            <input class="form-control" name="item" id="item" required>
                    </div>
              
                </div>     
              
                </div>
                    <button type="send" class="btn btn-success w-100">Enviar</button>
            </form>
        </div>

    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    <script src="{{asset('plugins/editors/quill/quill.js')}}"></script>
    <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
    <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr2.js')}}"></script>
    <script src="{{asset('plugins/autocomplete/autoComplete.min.js')}}"></script>
    <script src="{{asset('plugins/autocomplete/city_autoComplete.js')}}"></script>
        @vite(['resources/assets/js/apps/blog-create.js'])

        <script>
            function submeter() {
        
                
                var inpname = document.querySelector('#autoComplete').value;
                document.cookie = "city=" + inpname + ";" + "path=/";
                
                console.log(inpname);
            }
        
        </script>

        <script>
                    
            var options = {
                placeholder: 'Coloque a descrição do produto',
                theme: 'snow'
                };

                var editor = new Quill('#quillEditor', options);
                var justHtmlContent = document.getElementById('comment');

                editor.on('text-change', function() {
                var delta = editor.getContents();
                var text = editor.getText();
                var justHtml = editor.root.innerHTML;
                justHtmlContent.value = justHtml;
                });

                
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>