<x-base-layout :scrollspy="true">

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

    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>

    <div class="row mb-4 layout-spacing layout-top-spacing">
        


        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-success" :status="session('status')" />
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />

            <form action="{{ getRouterValue(); }}/app/coupon/add" method="post" enctype="multipart/form-data" name="form1" class="was-validated">
                @csrf
            <div class="widget-content widget-content-area blog-create-section mb-4">
                <h5 class="mb-4">Criar novo Cupom</h5>
                <div class="row mb-4">
                    <div class="col-xxl-12 col-md-12 mb-3">
                        <label>Nome do Cupom</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nome" required>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-xxl-6 col-md-6 mb-3">
                        <label for="discount">Desconto</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="discount" name="discount" min="1" max="70" required>
                                <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-percent"><line x1="19" y1="5" x2="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg></span>
                            </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 mb-3">
                        <label for="product">Produto</label>
                            <select class="form-select" name="eco_product_id" id="eco_product_id" required>
                                <option></option>
                                @foreach ($products as $product)
                                <option value="{{$product->id}}">{{$product->id}} | {{$product->name}}</option>    
                                @endforeach
                            </select>
                    </div>
                    
                    <div class="col-xxl-4 col-md-4 mb-3">
                            <input class="form-control" name="seller" id="seller" value="1" hidden>
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