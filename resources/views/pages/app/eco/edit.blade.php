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


            <div class="widget-content widget-content-area ecommerce-create-section">
                
                <form action="{{ getRouterValue(); }}/app/eco/product/{{ $product->id }}/edit"  method="post" enctype="multipart/form-data" name="form1" class="was-validated">
                    @csrf
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <h4>Nome do Produto: {{ $product->id }}</h4>
                        <br>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome do Produto" onblur="submeter()" value="{{ $product->name }}" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-12">
                        <h4>Descrição curta:</h4>
                        <div id="quillEditor"></div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-12">
                        <h4>Descrição longa:</h4>
                        <div id="quillEditor2"></div>
                    </div>
                </div>
                
                
                <input id="description" name="description" >
                <input id="specification" name="specification" >

                <div class="row">
                    <div class="col-md-8">
                        <label for="product-images">Carregar imagens</label>
                        <div class="multiple-file-upload ">
                            <input type="file" 
                                class="filepond"
                                name="image"
                                id="product-images" 
                                multiple 
                                data-allow-reorder="true"
                                data-max-file-size="3MB"
                                data-max-files="5"
                                accept="image/*" hidden>
                        </div>
                        
                    </div>

                    <div class="col-md-4 text-center">
                        <div class="switch form-switch-custom switch-inline form-switch-primary mt-4">
                            <input class="switch-input" type="checkbox" role="switch" id="public" name="public" checked>
                            <label class="switch-label" for="showPublicly">Exibição Pública</label>
                        </div>
                    </div>
                    
                </div>

            </div>
            
        </div>

        <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12">

            <div class="row">
                <div class="col-xxl-12 col-xl-8 col-lg-8 col-md-7 mt-xxl-0 mt-4">
                    <div class="widget-content widget-content-area ecommerce-create-section">
                        <div class="row">
                            {{--
                            <div class="col-xxl-12 mb-4">
                                <div class="switch form-switch-custom switch-inline form-switch-secondary">
                                    <input class="switch-input" type="checkbox" role="switch" id="in-stock" required>
                                    <label class="switch-label" for="in-stock">In Stock</label>
                                </div>
                            </div> --}}
                            <div class="col-xxl-12 col-md-6 mb-3">
                                <label for="flow">Código do Produto</label>
                                <select name="course_id" id="course_id" class="form-control mb-2" required>
                                    @foreach ($tags as $tag)
                                    <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                                <a href="{{ getRouterValue(); }}/app/eco/cademi/tag" class="btn btn-light-primary mb-2 me-4">Atualizar</a>
                            </div>

                            <div class="col-xxl-12 col-md-6 mb-3">
                                <label for="flow">Produto Base</label>
                                <select name="product_base" id="product_base" class="form-control mb-2" disabled>
                                    <option value="{{ $product->product_base }}">{{ $product->product_base }}</option>
                                </select>
                            </div>

                            <div class="col-xxl-12 col-md-6 mb-3">
                                <label for="flow">Fluxo RD</label>
                                <select name="flow" id="flow" class="form-control mb-2" required>
                                    <option value="{{ $product->flow }}" selected>{{ $product->flow }}</option>
                                    @foreach ($flows as $flow)
                                    <option value="{{ $flow->name }}">{{ $flow->name }}</option>
                                    @endforeach
                                </select>
                                <a href="{{ getRouterValue(); }}/app/eco/rd/fluxo" class="btn btn-light-primary mb-2 me-4">Atualizar</a>
                            </div>
                            {{--
                            <div class="col-xxl-12 col-md-6 mb-4">
                                <label for="proSKU">Product SKU</label>
                                <input type="text" class="form-control" id="proSKU" value="" required>
                            </div> 
                            <div class="col-xxl-12 col-md-6 mb-4">
                                <label for="gender">Gender</label>
                                <select class="form-select" id="gender">
                                    <option value="">Choose...</option>
                                    <option value="Informática">Informática</option>
                                    <option value="Profissionalizante">Profissionalizante</option>
                                    <option value="Inglês">Inglês</option>
                                    <option value="Especialidades">Especialidades</option>
                                    <option value="Administrativo">Administrativo</option>
                                    <option value="Kids">Kids</option>
                                    <option value="Programação">Programação</option>
                                </select>
                            </div>--}}
                            
                            <div class="col-xxl-12 col-md-6 mb-3">
                                <label for="category">Categoria</label>
                                <select name="category" id="category" class="form-control mb-2" required>
                                    @foreach ($categorys as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xxl-12 col-md-6 mb-3">
                                <label for="category">Vendedor</label>
                                <select name="seller" id="seller" class="form-control mb-2" required>
                                    <option value="{{ $seller->id }}" selected>{{ $seller->name }}</option>
                                    @foreach ($sellers as $seller)
                                    <option value="{{ $seller->user_id }}">{{ $seller->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                       
                            <div class="col-xxl-12 col-lg-6 col-md-12 mb-3">
                                <label for="tags">Tags (Separadas por vírgula)</label>
                                <input id="tag" name="tag" class="product-tags" value="{{ $product->tag }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-12 col-xl-4 col-lg-4 col-md-5 mt-4">
                    <div class="widget-content widget-content-area ecommerce-create-section">
                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <label for="regular-price">Preço</label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}">
                            </div>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="percent" name="percent" min="1" max="70" value="{{ $product->percent*100 }}">
                                <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-percent"><line x1="19" y1="5" x2="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg></span>
                                </div>
                                {{--
                            <div class="col-sm-12 mb-4">
                                <div class="switch form-switch-custom switch-inline form-switch-danger">
                                    <input class="switch-input" type="checkbox" role="switch" id="pricing-includes-texes">
                                    <label class="switch-label" for="pricing-includes-texes">Price includes taxes</label>
                                </div>
                            </div>--}}
                            <div class="col-sm-12">
                                <button class="btn btn-success w-100">Salvar</button>
                            </div>
                        </div>                                            
                    </div>
                </form>
                </div>
            </div>
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
            
            var options = {
                placeholder: 'Coloque a descrição do produto',
                theme: 'snow'
                };

                var editor = new Quill('#quillEditor', options);
                var justHtmlContent = document.getElementById('description');
                
                editor.clipboard.dangerouslyPasteHTML(0, <?php echo json_encode($product->description); ?>);

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

                editor2.clipboard.dangerouslyPasteHTML(0, <?php echo json_encode($product->description); ?>);

                editor2.insertText(0, 'test');

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
            // Multiple select boxes
            $("input[name='percent']").TouchSpin({
            verticalbuttons: true,
            });
        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>