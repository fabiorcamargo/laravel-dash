@php $id = $_GET["id"]; @endphp
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

        <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form action="{{ getRouterValue(); }}/app/eco/post_comment/add/{{$id}}" method="post" enctype="multipart/form-data" name="form1" class="was-validated">
                @csrf
            <div class="widget-content widget-content-area blog-create-section mb-4">
                <h5 class="mb-4">Editar Comentário</h5>
                <div class="row mb-4">
                    <div class="col-xxl-8 col-md-8 mb-3">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nome" required>
                    </div>
                </div>

                <div class="row mb-2">
                   
                    <div class="col-xxl-6 col-md-6 mb-3">
                        <label for="flow">Gênero</label>
                        <label for="gender">Example select</label>
                            <select class="form-select" name="gender" id="gender" required>
                                <option></option>
                                <option>male</option>
                                <option>female</option>
                            </select>
                    </div>
               
                    <div class="col-xxl-6 col-md-6 mb-3">
                        <label for="flow">Estrelas</label>
                        <label for="star">Example select</label>
                            <select class="form-select" name="star" id="star" required>
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <h4>Comentário:</h4>
                            <div id="quillEditor"></div>
                            <input id="comment" name="comment" hidden>
                        </div>
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