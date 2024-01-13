<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/tagify/tagify.css')}}">

        <link rel="stylesheet" href="{{asset('plugins/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">

        @vite(['resources/scss/light/plugins/tagify/custom-tagify.scss'])
        @vite(['resources/scss/dark/plugins/tagify/custom-tagify.scss'])

        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])

        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])

        @vite(['resources/scss/light/plugins/filepond/custom-filepond.scss'])
        @vite(['resources/scss/dark/plugins/filepond/custom-filepond.scss'])

        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/users/user-profile.scss'])
        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/users/user-profile.scss'])
        <!--  END CUSTOM STYLE FILE  -->
        
        <style>
            #ecommerce-list img {
                border-radius: 18px;
            }
        </style>
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->


    <div class="row layout-spacing">
        
        <div id="OuroComboCreateModal" class="modal animated fadeInDown" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <form action="{{ route('user-ouro-combo-create') }}" method="POST" id="combo_create" class="py-12">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Liberação Ouro Moderno</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="col-xxl-12 col-md-12 mb-4">
                                <p for="combo_name">Nome do Combo</p>
                                <input type="text" class="form-control" id="combo_name" name="combo_name" value="">
                            </div>
                            <div class="col-xxl-12 col-md-12 mb-4">
                                <p for="combo_name">Dias de Contrato</p>
                                <input type="number" class="form-control" id="combo_days" name="combo_days" value="">
                            </div>
                            <div class="col-xxl-12 col-md-12 mb-4 mt-4">
                                <label for="course_list mt-4">Lista de Cursos</label>
                                <input name='course_list'>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            {{--<button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>--}}
                            <button type="button" href="javascript:void(0);" onClick="document.getElementById('combo_create').submit();" class="btn btn-success">Liberar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-top-spacing">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
            <div class="user-profile">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between">
                        <h3 class="">Lista de Combos</h3>
                        <a data-bs-toggle="modal" href="" data-bs-target="#OuroComboCreateModal" class="mt-2 edit-profile" data-toggle="tooltip" data-placement="top" title="Criar Combo">
                            <x-widgets._w-svg svg="text-plus"/>
                        </a>
                    </div>
                    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing mt-2">
                        <div class="statbox widget box box-shadow">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nome</th>
                                            <th class="text-center dt-no-sorting">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($combos as $combo)
                                        <!-- MODAL SEÇÃO -->
                                        <div id="DivOuroComboModal{{$combo->id}}" class="modal animated fadeInDown" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <form action="{{ route('user-ouro-combo-edit', $combo->id) }}" method="POST" id="OuroComboModal{{$combo->id}}" class="py-12">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Liberação Ouro Moderno</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                            </button>
                                                        </div>
                                
                                    
                                                        <div class="modal-body">
                                                            <div class="col-xxl-12 col-md-12 mb-4">
                                                                <p for="combo_name">Nome do Combo</p>
                                                                <input type="text" class="form-control" id="combo_name" name="combo_name" value="{{$combo->name}}">
                                                            </div>
                                                            <div class="col-xxl-12 col-md-12 mb-4">
                                                                <p for="combo_name">Dias de Contrato</p>
                                                                <input type="number" class="form-control" id="combo_days" name="combo_days" value="{{$combo->days}}">
                                                            </div>
                                                            <div class="col-xxl-12 col-md-12 mb-4 mt-4">
                                                                <label for="course_list mt-4">Lista de Cursos</label>
                                                                <input name="course_list{{$combo->id}}" id="course_list{{$combo->id}}" value="{{$combo->courses}}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="modal-footer">
                                                            {{--<button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>--}}
                                                            <a type="button" href="javascript:void(0);" onClick='document.getElementById("OuroComboModal{{$combo->id}}").submit();' class="btn btn-success">Liberar</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- MODAL SEÇÃO -->

                                        <!-- MODAL SEÇÃO -->
                                        <div id="DivOuroComboDelete{{$combo->id}}" class="modal animated fadeInDown" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <form action="{{ route('user-ouro-combo-delete', $combo->id) }}" method="POST" id="delete_form{{$combo->id}}" class="py-12">
                                                        @method('DELETE')
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Combo Ouro Moderno</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                            </button>
                                                        </div>
                                
                                    
                                                        <div class="modal-body">
                                                            <div class="col-xxl-12 col-md-12 mb-4">
                                                                <p for="combo_name">Nome do Combo</p>
                                                                <input type="text" class="form-control" id="combo_name" name="combo_name" value="{{$combo->name}}" readonly>
                                                            </div>
                                                            <div class="col-xxl-12 col-md-12 mb-4">
                                                                <p for="combo_name">Dias de Contrato</p>
                                                                <input type="text" class="form-control" id="combo_days" name="combo_days" value="{{$combo->days}}" readonly>
                                                            </div>
                                                            <div class="col-xxl-12 col-md-12 mb-4 mt-4">
                                                                <label for="course_list mt-4">Lista de Cursos</label>
                                                                <input type="text" class="form-control" name="course_list{{$combo->id}}" id="course_list{{$combo->id}}" value="{{$combo->courses}}" readonly>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="modal-footer">
                                                            <div class="col-xxl-12 col-md-12 mb-4 mt-4">

                                                            </div>
                                                            <button class="btn btn-light-success" data-bs-dismiss="modal">Sair</button>
                                                            <a type="button" href="javascript:void(0);" onClick='document.getElementById("delete_form{{$combo->id}}").submit();' class="btn btn-danger">Excluir</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- MODAL SEÇÃO -->

                                            <tr>
                                                <td>
                                                    <div class="media">
                                                        <div class="avatar me-2">
                                                            <img alt="avatar" src="{{Vite::asset('resources/images/Curso Liberado.jpg')}}" class="rounded-circle">
                                                        </div>
                                                        <div class="media-body align-self-center">
                                                            <h6 class="mb-0">{{ $combo->name }}</h6>
                                                            <span>M: {{ $combo->courses }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="action-btns">
                                                        
                                                        <a data-bs-toggle="modal" href="" onclick="mycombo({{$combo->id}})" data-bs-target="#DivOuroComboModal{{$combo->id}}" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Editar Combo">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                        </a>
                                                        <a href="" data-bs-toggle="modal" data-bs-target="#DivOuroComboDelete{{$combo->id}}" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Excluir Combo">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-top-spacing">
            <div class="user-profile">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between">
                        <h3 class="">Lista de Cursos</h3>
                        <a href="{{route('user-ouro-get-courses')}}" class="mt-2 edit-profile" data-toggle="tooltip" data-placement="top" title="Atualiza Lista">
                            <x-widgets._w-svg svg="refresh"/>
                        </a>
                    </div>
                    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing mt-2">
                        <div class="statbox widget box box-shadow">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Categoria</th>
                                            <th class="text-center dt-no-sorting">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <!-- MODAL SEÇÃO -->
                                            <div id="OuroImgModal{{$product->id}}" class="modal animated fadeInDown" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Inserir imagem</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div>
                                                                <div class="col-xxl-12 col-md-12 mb-2 mt-2">
                                                                <p for="combo_name">Nome do Curso</p>
                                                                <input type="text" class="form-control" id="combo_name" name="combo_name" value="{{$product->course_id}} | {{$product->name}}" readonly>
                                                                </div>
                                                                <div class="col-xxl-12 col-md-12 mb-2 mt-2">
                                                                    <p for="combo_name">Detalhes</p>
                                                                    <li class="ms-4" type="text">Módulos: {{$product->modulo}};</li>
                                                                    <li class="ms-4" type="text">Aulas: {{$product->aulas}};</li>
                                                                    <li class="ms-4" type="text">Carga: {{$product->carga}}hs;</li>
                                                                </div>
                                                                
                                                            <div class="mt-4">
                                                                <label for="product-images">Carregar imagem</label>
                                                                <div class="multiple-file-upload">
                                                                    <input type="file" 
                                                                    class="filepond"
                                                                    name="image"
                                                                    id="product-images{{$product->id}}"
                                                                    data-max-file-size="1MB"
                                                                    data-max-files="1"
                                                                    accept="image/*">
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                {{--<button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>--}}
                                                                <a type="button" href="{{getRouterValue();}}/app/ouro/show" class="btn btn-success">Atualizar</a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- MODAL SEÇÃO -->

                                            <tr>
                                                <td>
                                                    <div class="media">
                                                        <div class="avatar me-2">
                                                            <img alt="avatar" src="{{$product->img == null ? Vite::asset('resources/images/Curso Liberado.jpg') : $product->img}}" class="rounded-circle">
                                                        </div>
                                                        <div class="media-body align-self-center">
                                                            <h6 class="mb-0">{{ $product->course_id }} | {{ $product->name }}</h6>
                                                            <span>M: {{ $product->modulo }} | A: {{ $product->aulas}} | C: {{ $product->carga}}hs</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $product->category }}</td>
                                                <td class="text-center">
                                                    <div class="action-btns">
                                                        {{--<a href="{{ getRouterValue(); }}/app/eco/ouro/{{ $product->id }}" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="View">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                        </a>
                                                        <a href="{{ getRouterValue(); }}/app/eco/ouro/{{ $product->id }}/edit" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                        </a>--}}
                                                        <a data-bs-toggle="modal" href="" onclick="mypond({{$product->id}})" data-bs-target="#OuroImgModal{{$product->id}}" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Inserir Imagem">
                                                            <x-widgets._w-svg svg="photo-plus"/>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script type="module" src="{{asset('plugins/global/vendors.min.js')}}"></script>
        <script src="{{asset('plugins/tagify/tagify.min.js')}}"></script>
        @vite(['resources/assets/js/custom.js'])
        <script src="{{asset('plugins/filepond/filepond.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImagePreview.min.js')}}"></script>

        <script type="module" src="{{asset('plugins/table/datatable/datatables.js')}}"></script>

        <script>
            function mypond($data){
                console.log($data);
                const inputElement = document.getElementById('product-images'+$data);
                const pond = FilePond.create(inputElement);
        
                FilePond.setOptions({
                server: {
                    process: '{{ getRouterValue(); }}/app/ouro/img/up/'+$data,
                    revert: '{{ getRouterValue(); }}//app/ouro/img/rm/'+$data,
                            
                    headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }
                });
            }
        </script>

        <script type="module">
            let ecommerceList = $('#ecommerce-list').DataTable({
                headerCallback:function(e, a, t, n, s) {
                    e.getElementsByTagName("th")[0].innerHTML=`
                    <div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input chk-parent" type="checkbox" id="form-check-default">
                    </div>`
                },
                columnDefs:[ {
                    targets:0, width:"30px", className:"", orderable:!1, render:function(e, a, t, n) {
                        return `
                        <div class="form-check form-check-primary d-block new-control">
                            <input class="form-check-input child-chk" type="checkbox" id="form-check-default">
                        </div>`
                    }
                }],
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                   "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [7, 10, 20, 50],
                "pageLength": 10 
            });
            multiCheck(ecommerceList);
        </script>

        <script>
            /**
        * 
        * Users List
        *  
        **/ 


        // https://www.mockaroo.com/


        var inputElm = document.querySelector('input[name=course_list]');

        function tagTemplate(tagData){
        return `
            <tag title="${tagData.info}"
            contenteditable='false'
            spellcheck='false'
            tabIndex="-1"
            class="tagify__tag ${tagData.class ? tagData.class : ""}"
            ${this.getAttributes(tagData)}>
            <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div>
            <div class='tagify__tag__avatar-wrap'>
            <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
            </div>
            <span class='tagify__tag-text'>${tagData.name}</span>
            </div>
            </tag>
        `
        }


        function suggestionItemTemplate(tagData){
        return `
            <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">
            ${ tagData.avatar ? `
                <div class='tagify__dropdown__item__avatar-wrap'>
                <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                </div>` : ''
            }
            <strong>${tagData.name}</strong>
            <span>${tagData.info}</span>
            </div>
        `
        }

        // initialize Tagify on the above input node reference
        var usrList = new Tagify(inputElm, {
            tagTextProp: 'name', // very important since a custom template is used with this property as text
            enforceWhitelist: true,
            skipInvalid: true, // do not remporarily add invalid tags
            dropdown: {
            closeOnSelect: false,
            enabled: 0,
            classname: 'users-list',
            searchKeys: ['value', 'name', 'info']  // very important to set by which keys to search for suggesttions when typing
            },
            templates: {
            tag: tagTemplate,
            dropdownItem: suggestionItemTemplate
            },
            whitelist: [
            @foreach ($products as $product)
                {
                    "value": "{{$product->course_id}}",
                    "name": "{{$product->name}}",
                    "info": "Id: {{$product->course_id}} | M: {{$product->modulo}} | A: {{$product->aulas}} | hs: {{$product->carga}}"
                },
            @endforeach
            ]
        })

        </script>

        <script>
            function mycombo($data){
            /**
        * 
        * Users List
        *  
        **/ 


        // https://www.mockaroo.com/


        var inputElm = document.getElementById('course_list'+$data);

        function tagTemplate(tagData){
        return `
            <tag title="${tagData.info}"
            contenteditable='false'
            spellcheck='false'
            tabIndex="-1"
            class="tagify__tag ${tagData.class ? tagData.class : ""}"
            ${this.getAttributes(tagData)}>
            <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div>
            <div class='tagify__tag__avatar-wrap'>
            <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
            </div>
            <span class='tagify__tag-text'>${tagData.name}</span>
            </div>
            </tag>
        `
        }


        function suggestionItemTemplate(tagData){
        return `
            <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">
            ${ tagData.avatar ? `
                <div class='tagify__dropdown__item__avatar-wrap'>
                <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                </div>` : ''
            }
            <strong>${tagData.name}</strong>
            <span>${tagData.info}</span>
            </div>
        `
        }

        // initialize Tagify on the above input node reference
        var usrList = new Tagify(inputElm, {
            tagTextProp: 'name', // very important since a custom template is used with this property as text
            enforceWhitelist: true,
            skipInvalid: true, // do not remporarily add invalid tags
            dropdown: {
            closeOnSelect: false,
            enabled: 0,
            classname: 'users-list',
            searchKeys: ['value', 'name', 'info']  // very important to set by which keys to search for suggesttions when typing
            },
            templates: {
            tag: tagTemplate,
            dropdownItem: suggestionItemTemplate
            },
            whitelist: [
            @foreach ($products as $product)
                {
                    "value": "{{$product->course_id}}",
                    "name": "{{$product->name}}",
                    "info": "Id: {{$product->course_id}} | M: {{$product->modulo}} | A: {{$product->aulas}} | hs: {{$product->carga}}"
                },
            @endforeach
            ]
        })
    }
        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>