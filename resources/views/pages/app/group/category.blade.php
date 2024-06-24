<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title = "Cademi Lista"}}
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

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-top-spacing">

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />


                    <div class="user-profile">
                        <div class="widget-content widget-content-area">
                            <form action="{{ getRouterValue(); }}/app/group/category" method="post"
                                enctype="multipart/form-data" name="form1" class="was-validated">
                                @csrf
                                <div class="input-group mb-3">
                                    <input name="name" id="name" type="text" class="form-control"
                                        placeholder="Nome da Categoria" aria-label="Nome da Categoria"
                                        aria-label="Text input with dropdown button">
                                    <button class="btn btn-success dropdown-toggle" type="send"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-settings">
                                            <circle cx="12" cy="12" r="3"></circle>
                                            <path
                                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                            </path>
                                        </svg></button>

                                </div>
                            </form>

                            <div id="tableSimple" class="col-lg-12 col-12 layout-spacing mt-2">
                                <div class="statbox widget box box-shadow">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nome</th>
                                                    <th class="text-center dt-no-sorting">Imagem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categories as $category)
                                                <!-- MODAL SEÇÃO -->
                                                <div id="CademiImgModal{{$category->id}}"
                                                    class="modal animated fadeInDown" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Inserir imagem</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <svg aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-x">
                                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">


                                                                <div class="">
                                                                    <label for="category-images">Carregue a imagem para
                                                                        essa categoria</label>
                                                                    <div class="multiple-file-upload">
                                                                        <input type="file" class="filepond" name="image"
                                                                            id="category-images{{$category->id}}"
                                                                            data-max-file-size="1MB" data-max-files="1"
                                                                            accept="image/*">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                {{--<button class="btn btn-light-dark"
                                                                    data-bs-dismiss="modal">Sair</button>--}}
                                                                <a href="{{ getRouterValue(); }}/app/group/category"
                                                                    class="btn btn-success">Atualizar</a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- MODAL SEÇÃO -->

                                                <tr>
                                                    <td>
                                                        <div class="media">
                                                            <div class="avatar me-2">
                                                                <img alt="avatar"
                                                                    src="{{$category->img == null ? Vite::asset('resources/images/Curso Liberado.jpg') : $category->img}}"
                                                                    class="rounded-circle">
                                                            </div>
                                                            <div class="media-body align-self-center">
                                                                <h6 class="mb-0">{{ $category->tag_id }} | {{
                                                                    $category->name }}</h6>
                                                                <span>{{$category->title}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="action-btns">
                                                            <a data-bs-toggle="modal" href=""
                                                                onclick="mypond({{$category->id}})"
                                                                data-bs-target="#CademiImgModal{{$category->id}}"
                                                                class="action-btn btn-edit bs-tooltip me-2"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Inserir Imagem">
                                                                <x-widgets._w-svg svg="photo-plus" />
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
                        const inputElement = document.getElementById('category-images'+$data);
                        const pond = FilePond.create(inputElement);
                
                        FilePond.setOptions({
                        server: {
                            process: '{{ getRouterValue(); }}/app/group/img/up/'+$data,
                            revert: '{{ getRouterValue(); }}//app/group/img/rm/'+$data,
                                    
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
            @foreach ($categories as $category)
                {
                    "value": "{{$category->course_id}}",
                    "name": "{{$category->name}}",
                    "info": "Id: {{$category->course_id}} | M: {{$category->modulo}} | A: {{$category->aulas}} | hs: {{$category->carga}}"
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
            @foreach ($categories as $category)
                {
                    "value": "{{$category->course_id}}",
                    "name": "{{$category->name}}",
                    "info": "Id: {{$category->course_id}} | M: {{$category->modulo}} | A: {{$category->aulas}} | hs: {{$category->carga}}"
                },
            @endforeach
            ]
        })
    }
                </script>

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>