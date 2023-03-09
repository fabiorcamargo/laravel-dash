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
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        
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
                        <h4>Identificação: #{{ $product->id }} </h4>
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
                
                
                <input id="description" name="description" hidden>
                <input id="specification" name="specification" hidden>

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
                            data-max-file-size="1MB"
                            data-max-files="5"
                            accept="image/*">
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
                                    <option value="{{ $product->category }}">{{ $product->category }}</option>
                                    @foreach ($categorys as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xxl-12 col-md-6 mb-3">
                                <label for="category">Vendedor</label>
                                <select name="seller" id="seller" class="form-control mb-2" required>
                                    <option value="{{ $product->seller }}" selected>{{ $seller->name }}</option>
                                    @foreach ($sellers as $seller)
                                    <option value="{{ $seller->user_id }}">{{ $seller->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                       
                            <div class="col-xxl-12 col-lg-6 col-md-12 mb-3">
                                <label for="tags">Tags (Separadas por vírgula)</label>
                                <input id="tag" name="tag" class="product-tags" value="{{ $product->tag }}">
                            </div>
                            <div class="col-xxl-12 col-lg-6 col-md-12 md-3 mt-4">
                                <div class="switch form-switch-custom switch-inline form-switch-primary">
                                    <input class="switch-input" type="checkbox" role="switch" id="public" name="public" @if($product->public == 1) @checked(true) @else @checked(false) @endif>
                                    <label class="switch-label" for="showPublicly">Público</label>
                                </div>
                                </div>
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
        
        
   
    


    
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="table-responsive">
                    <div class="col-sm-12">
                        <div class="switch form-switch-custom switch-inline form-switch-primary">
                            <h4 class="switch-label inline" for="showPublicly">Público</h4>
                        </div>
                            <a href="{{ getRouterValue(); }}/app/eco/comment/add?id={{$product->id}}" class="btn btn-success btn-icon mb-2 me-4 btn-rounded">
                                <x-widgets._w-svg svg="message-plus"/>
                            </a>
                    </div>

                    @isset($comments)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Genero</th>
                            <th scope="col">Comentário</th>
                            <th scope="col">Estrelas</th>
                            <th class="text-center dt-no-sorting">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach ($comments as $comment)
                        <tr>
                            <td>
                                <div class="d-flex justify-content-left align-items-center">
                                    <div class="avatar--group">
                                        
                                        <a href="{{ getRouterValue(); }}/app/eco/comment/{{ $product->id }}/{{$i}}" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                        </a>
                                            <div class="avatar avatar-sm">
                                                <img alt="avatar" src="{{asset("$comment->img")}}" class="rounded-circle">
                                            </div>
                                        <div class="d-flex flex-column ps-2">
                                            <span class="text-truncate fw-bold">{{ $comment->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $comment->gender }}</td>
                            <td>{{ $comment->comment }}</td>
                            <td>{{ $comment->star }}</td>

                            <td class="text-center">
                                
                                <div class="action-btns">
                                    <a href="{{ getRouterValue(); }}/app/eco/product/{{ $product->id }}" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>
                                    <a href="{{ getRouterValue(); }}/app/eco/product/{{ $product->id }}/edit" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                    </a>

                                    <a href="javascript:void(0);" onClick="document.getElementById('delete_form').submit();" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </a>
                                </div>
                                </form>
                            </td>
                        </tr>
                        @php $i++; @endphp
                        @endforeach
                        
                    </tbody>
                </table>
                @endisset
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

            
            const inputElement = document.getElementById('product-images');
            const pond = FilePond.create(inputElement);
     
            FilePond.setOptions({
            server: {
                process: '{{ getRouterValue(); }}/img_product_upload/{{$product->id}}',
                revert: '{{ getRouterValue(); }}/img_product_delete/{{$product->id}}',
                         
                headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
            
            });

        </script>

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

                editor2.clipboard.dangerouslyPasteHTML(0, <?php echo json_encode($product->specification); ?>);

                editor2.on('text-change', function() {
                var delta = editor2.getContents();
                var text = editor2.getText();
                var justHtml = editor2.root.innerHTML;
                justHtmlContent2.value = justHtml;
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