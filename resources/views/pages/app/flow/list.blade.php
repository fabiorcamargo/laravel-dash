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
       
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-top-spacing">
            <div class="user-profile">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between">
                        <h3 class="">Lista de Cursos</h3>
                        
                    </div>
                    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing mt-2">
                        <div class="statbox widget box box-shadow">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Contexto</th>
                                            <th scope="col">Passos</th>
                                            <th scope="col">Itens</th>
                                            <th class="text-center dt-no-sorting">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($flows as $flow)
                                    

                                            <tr>
                                                <td>
                                                    <div class="media">
                                                        <div class="avatar me-2">
                                                            {{--<img alt="avatar" src="{{$flow->img == null ? Vite::asset('resources/images/Curso Liberado.jpg') : $flow->img}}" class="rounded-circle">--}}
                                                        </div>
                                                        <div class="media-body align-self-center">
                                                            <a href="{{getRouterValue();}}/app/flow/show/{{$flow->id}}">
                                                                <h6 class="mb-0">{{ $flow->name }}</h6>
                                                            </a>
                                                            {{--<span>M: {{ $flow->modulo }} | A: {{ $flow->aulas}} | C: {{ $flow->carga}}hs</span>--}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $flow->context }}</td>
                                                <td>{{ $flow->steps }}</td>
                                                <td>{{ $flow->item }}</td>
                                                <td class="text-center">
                                                    <div class="action-btns">
                                                        {{--<a href="{{ getRouterValue(); }}/app/eco/ouro/{{ $flow->id }}" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="View">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                        </a>
                                                        <a href="{{ getRouterValue(); }}/app/eco/ouro/{{ $flow->id }}/edit" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                        </a>--}}
                                                        <a data-bs-toggle="modal" href="" onclick="mypond({{$flow->id}})" data-bs-target="#OuroImgModal{{$flow->id}}" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Inserir Imagem">
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
                const inputElement = document.getElementById('flow-images'+$data);
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
            @foreach ($flows as $flow)
                {
                    "value": "{{$flow->course_id}}",
                    "name": "{{$flow->name}}",
                    "info": "Id: {{$flow->course_id}} | M: {{$flow->modulo}} | A: {{$flow->aulas}} | hs: {{$flow->carga}}"
                },
            @endforeach
            ]
        })

        </script>

        <script>
            function myflow($data){
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
            @foreach ($flows as $flow)
                {
                    "value": "{{$flow->course_id}}",
                    "name": "{{$flow->name}}",
                    "info": "Id: {{$flow->course_id}} | M: {{$flow->modulo}} | A: {{$flow->aulas}} | hs: {{$flow->carga}}"
                },
            @endforeach
            ]
        })
    }
        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>