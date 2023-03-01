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
        <link rel="stylesheet" href="{{asset('plugins/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/tagify/tagify.css')}}">

        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/light/plugins/tagify/custom-tagify.scss'])
        @vite(['resources/scss/light/plugins/filepond/custom-filepond.scss'])
        
        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/dark/plugins/tagify/custom-tagify.scss'])
        @vite(['resources/scss/dark/plugins/filepond/custom-filepond.scss'])

        @vite(['resources/scss/light/assets/apps/ecommerce-create.scss'])
        @vite(['resources/scss/dark/assets/apps/ecommerce-create.scss'])

        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <div class="row mb-4 layout-spacing layout-top-spacing">

        <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            @if (isset($success))
           
            @endif

            @if (\Session::has('success'))
            <div class="alert alert-light-danger alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Erro:</strong> {!! \Session::get('success') !!} </div>
  
        @endif

            <div class="">
                <form action="{{ getRouterValue(); }}/app/form/add"  method="post" enctype="multipart/form-data" name="form1" class="was-validated">
                    @csrf
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="widget-content widget-content-area ecommerce-create-section">
                        <h4>Nome da Campanha:</h4>
                        <br>
                        <input type="text" class="form-control" id="form_name" name="form_name" placeholder="Nome do Produto" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="widget-content widget-content-area ecommerce-create-section">
                        <h4>Nome da Cidade:</h4>
                        <br>
                        <input type="text" class="form-control" id="form_city" name="form_city" placeholder="Nome do Produto" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="widget-content widget-content-area ecommerce-create-section">
                        <h4>URL de Redirecionamento:</h4>
                        <br>
                        <input type="text" class="form-control" id="redirect" name="redirect" placeholder="Nome do Produto" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="widget-content widget-content-area ecommerce-create-section">
                        <h4>Chip:</h4>
                        <br>
                        <input type="text" class="form-control" id="chip" name="chip" placeholder="Chip confirmação" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="widget-content widget-content-area ecommerce-create-section">
                        <h4>Descrição curta:</h4>
                        <p>Deve ser uma descrição resumida fica ao lado da imagem do produto</p>
                        <div id="quillEditor"></div>
                        </div>
                    </div>
                </div>

                <input id="description" name="description" hidden>

            </div>
            <div class="col-sm-12">
                <button id="adicionar" class="btn btn-success w-100">Adicionar Produto</button>
            </div>
        </div>

        <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12">

           
           
        </div>
        
        
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/editors/quill/quill.js')}}"></script>
        <script src="{{asset('plugins/filepond/filepond.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImagePreview.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageCrop.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageResize.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageTransform.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/filepondPluginFileValidateSize.min.js')}}"></script>
        <script src="{{asset('plugins/tagify/tagify.min.js')}}"></script>
        @vite(['resources/assets/js/apps/ecommerce-create.js'])

        <script>

            



        </script>

        <script>
            var options = {
                placeholder: 'Coloque a descrição do produto',
                theme: 'snow'
                };

                var editor = new Quill('#quillEditor', options);
                var justHtmlContent = document.getElementById('description');

                editor.on('text-change', function() {
                var delta = editor.getContents();
                var text = editor.getText();
                var justHtml = editor.root.innerHTML;
                justHtmlContent.value = justHtml;
                });

                
        </script>

        <script>
            var options = {
                placeholder: 'Coloque a descrição do produto',
                theme: 'snow'
                };

                var editor2 = new Quill('#quillEditor2', options);
                var justHtmlContent2 = document.getElementById('specification');

                editor2.on('text-change', function() {
                var delta = editor2.getContents();
                var text = editor2.getText();
                var justHtml = editor2.root.innerHTML;
                justHtmlContent2.value = justHtml;
                });

                
        </script>

        <script>
        function submeter() {

            
            var inpname = document.getElementById('name').value;
            document.cookie = "name=" + inpname + ";" + "path=/";
            console.log(inpname);
            const inputElement = document.querySelector('input[type="file"]');
            const pond = FilePond.create(inputElement);
     
            FilePond.setOptions({
            server: {
                process: '{{ getRouterValue(); }}/img_product_upload',
                revert: '{{ getRouterValue(); }}/img_product_delete',
                         
                headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
                
            }
            
            });

            }
        </script>

        <script>
             $(document).ready(function() {
            console.log(document.getElementByName("image").value);
            document.getElementById("adicionar").disabled = false;
            });
        </script>
        <script>
            // Multiple select boxes
            $("input[name='percent']").TouchSpin({
            verticalbuttons: true,
            });
        </script>


    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>