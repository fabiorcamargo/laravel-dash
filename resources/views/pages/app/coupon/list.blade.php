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
        <!-- Content -->
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-top-spacing">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
            <div class="user-profile">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between">
                        <h3 class="">Lista de Cupons</h3>
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
                                            <th class="col">Criado por</th>
                                            <th class="col">Ação</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coupons as $coupon)
                                            <!-- MODAL SEÇÃO -->
                                            <div id="DivOuroComboModal{{$coupon->id}}" class="modal animated fadeInDown" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        {{--<form action="{{ route('user-ouro-coupon-edit', $coupon->id) }}" method="POST" id="OuroComboModal{{$coupon->id}}" class="py-12">
                                                            @csrf--}}
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Lista de Cupons</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                </button>
                                                            </div>
                                    
                                        
                                                            <div class="modal-body">
                                                                <div class="col-xxl-12 col-md-12 mb-4">
                                                                    <p for="coupon_name">Nome do Cupom</p>
                                                                    <input type="text" class="form-control" id="coupon_name" name="coupon_name" value="{{$coupon->name}}">
                                                                </div>
                                                                <div class="col-xxl-12 col-md-12 mb-4">
                                                                    <p for="coupon_name">Dias de Contrato</p>
                                                                    <input type="number" class="form-control" id="coupon_days" name="coupon_days" value="{{$coupon->days}}">
                                                                </div>
                                                                <div class="col-xxl-12 col-md-12 mb-4 mt-4">
                                                                    <label for="course_list mt-4">Lista de Cursos</label>
                                                                    <input name="course_list{{$coupon->id}}" id="course_list{{$coupon->id}}" value="{{$coupon->courses}}">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="modal-footer">
                                                                {{--<button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>--}}
                                                                <a type="button" href="javascript:void(0);" onClick='document.getElementById("OuroComboModal{{$coupon->id}}").submit();' class="btn btn-success">Liberar</a>
                                                            </div>
                                                        {{--</form>--}}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- MODAL SEÇÃO -->

                                            <!-- MODAL SEÇÃO -->
                                            <div id="DivOuroComboDelete{{$coupon->id}}" class="modal animated fadeInDown" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        {{--<form action="{{ route('user-ouro-coupon-delete', $coupon->id) }}" method="POST" id="delete_form{{$coupon->id}}" class="py-12">
                                                            @method('DELETE')
                                                            @csrf--}}
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Combo Ouro Moderno</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                </button>
                                                            </div>
                                    
                                        
                                                            <div class="modal-body">
                                                                <div class="col-xxl-12 col-md-12 mb-4">
                                                                    <p for="coupon_name">Nome do Combo</p>
                                                                    <input type="text" class="form-control" id="coupon_name" name="coupon_name" value="{{$coupon->name}}" readonly>
                                                                </div>
                                                                <div class="col-xxl-12 col-md-12 mb-4">
                                                                    <p for="coupon_name">Dias de Contrato</p>
                                                                    <input type="text" class="form-control" id="coupon_days" name="coupon_days" value="{{$coupon->days}}" readonly>
                                                                </div>
                                                                <div class="col-xxl-12 col-md-12 mb-4 mt-4">
                                                                    <label for="course_list mt-4">Lista de Cursos</label>
                                                                    <input type="text" class="form-control" name="course_list{{$coupon->id}}" id="course_list{{$coupon->id}}" value="{{$coupon->courses}}" readonly>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="modal-footer">
                                                                <div class="col-xxl-12 col-md-12 mb-4 mt-4">

                                                                </div>
                                                                <button class="btn btn-light-success" data-bs-dismiss="modal">Sair</button>
                                                                <a type="button" href="javascript:void(0);" onClick='document.getElementById("delete_form{{$coupon->id}}").submit();' class="btn btn-danger">Excluir</a>
                                                            </div>
                                                        {{--</form>--}}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- MODAL SEÇÃO -->
                                            <tr>
                                                <td>
                                                    <a class="media" href="{{getRouterValue();}}/app/eco/product/{{App\Models\EcoProduct::find($coupon->eco_product_id)->id}}?s={{$coupon->seller}}&t={{$coupon->token}}">
                                                        <div class="avatar me-2">
                                                            <img alt="avatar"  src="{{asset("product/" . json_decode(App\Models\EcoProduct::find($coupon->eco_product_id)->image)[0])}}" class="rounded-circle">
                                                        </div>
                                                        <div class="media-body align-self-center">
                                                            <h6 class="mb-0">{{ $coupon->name }}</h6>
                                                            <span> Curso: {{App\Models\EcoProduct::find($coupon->eco_product_id)->id}} {{App\Models\EcoProduct::find($coupon->eco_product_id)->name}} <br> Desconto: {{$coupon->discount}}% <br> Token: {{$coupon->token}}</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="media" href="{{ getRouterValue(); }}/app/user/profile/{{ App\Models\User::find(App\Models\EcoSeller::find($coupon->seller)->user_id)->id }}">
                                                        <div class="avatar me-2">
                                                            <img alt="avatar"  src="{{asset(App\Models\User::find(App\Models\EcoSeller::find($coupon->seller)->user_id)->image)}}" class="rounded-circle">
                                                        </div>
                                                        <div class="media-body align-self-center">
                                                            <h6 class="mb-0">{{App\Models\User::find(App\Models\EcoSeller::find($coupon->seller)->user_id)->name}} {{App\Models\User::find(App\Models\EcoSeller::find($coupon->seller)->user_id)->lastname}}</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <div class="action-btns">
                                                        <a data-bs-toggle="modal" href="" onclick="mycoupon({{$coupon->id}})" data-bs-target="#DivOuroComboModal{{$coupon->id}}" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Editar Combo">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                        </a>
                                                        <a href="" data-bs-toggle="modal" data-bs-target="#DivOuroComboDelete{{$coupon->id}}" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Excluir Combo">
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
                const inputElement = document.getElementById('coupon-images'+$data);
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
            @foreach ($coupons as $coupon)
                {
                    "value": "{{$coupon->course_id}}",
                    "name": "{{$coupon->name}}",
                    "info": "Id: {{$coupon->course_id}} | M: {{$coupon->modulo}} | A: {{$coupon->aulas}} | hs: {{$coupon->carga}}"
                },
            @endforeach
            ]
        })

        </script>

        <script>
            function mycoupon($data){
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
            @foreach ($coupons as $coupon)
                {
                    "value": "{{$coupon->course_id}}",
                    "name": "{{$coupon->name}}",
                    "info": "Id: {{$coupon->course_id}} | M: {{$coupon->modulo}} | A: {{$coupon->aulas}} | hs: {{$coupon->carga}}"
                },
            @endforeach
            ]
        })
    }
        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>