<x-base-layout :scrollspy="true">

    <x-slot:pageTitle>
        {{$title = "Condição Certificados"}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            <link rel="stylesheet" href="{{asset('plugins/tagify/tagify.css')}}">

            @vite(['resources/scss/light/plugins/tagify/custom-tagify.scss'])
            @vite(['resources/scss/dark/plugins/tagify/custom-tagify.scss'])

            @vite(['resources/scss/light/assets/components/modal.scss'])
            @vite(['resources/scss/dark/assets/components/modal.scss'])

            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])

            @vite(['resources/scss/light/assets/components/list-group.scss'])
            @vite(['resources/scss/dark/assets/components/list-group.scss'])

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <x-slot:scrollspyConfig>
                data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
                </x-slot>



                <div class="row layout-spacing">

                    <div id="OuroCreateModal" class="modal animated fadeInDown" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <form action="{{ route('post-condition-create') }}" method="POST" id="combo_create"
                                    class="py-12">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Nova Condição Ouro</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-x">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="col-xxl-12 col-md-12 mb-4">
                                            <p for="combo_name">Nome da Condição</p>
                                            <input type="text" class="form-control" id="name" name="name" value=""
                                                required>
                                        </div>
                                        <div class="col-xxl-12 col-md-12 mb-4">
                                            <p for="combo_name">Tipo</p>
                                            <select class="form-control form-control" id="type" name="type" required>
                                                <option value="">Escolha</option>
                                                <option value="cademi">Cademi</option>
                                                <option value="cademi">Ouro Moderno</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-xxl-12 col-md-12 mb-4">
                                            <p for="combo_name">Carga horária</p>
                                            <input type="number" class="form-control" id="hours" name="hours" value=""
                                                required>
                                        </div>
                                        <div class="col-xxl-12 col-md-12 mb-4">
                                            <p for="combo_name">Conteúdo</p>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" name="conteudo" id="conteudo" rows="3"
                                                    required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        {{--<button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>--}}
                                        <button type="button" href="javascript:void(0);"
                                            onClick="document.getElementById('combo_create').submit();"
                                            class="btn btn-success">Criar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="CademiCreateModal" class="modal animated fadeInDown" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <form action="{{ route('post-condition-create') }}" method="POST" id="condition_cademi_create"
                                    class="py-12">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Nova Condição Cademi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-x">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="col-xxl-12 col-md-12 mb-4">

                                            <p for="combo_name">Nome da Condição</p>
                                            <input type="text" class="form-control" id="name" name="name" value=""
                                                required>
                                        </div>

                                        <div class="col-xxl-12 col-md-12 mb-4">
                                            <p for="combo_name">Tipo</p>

                                            <input type="text" class="form-control" id="type" name="type" value="cademi"
                                                readonly>
                                        </div>

                                        <div class="col-xxl-12 col-md-12 mb-4">
                                            <p for="combo_name">Modelo</p>
                                            <select class="form-control form-control" id="model" name="model" required>
                                                <option value="">Escolha</option>
                                                @foreach ($cademi_certificates as $cert)
                                                <option value="{{$cert->id}}">{{$cert->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="col-xxl-12 col-md-12 mb-4 mt-4">
                                            <label for="course_list mt-4">Lista de Cursos</label>
                                            <input class="form-control" name='course_list'>
                                            <a class="btn mt-4" href="cademi/get_courses">
                                                <x-widgets._w-svg class="text-gray" svg="refresh" /> Atualizar Lista
                                            </a>
                                        </div>


                                        <div class="col-xxl-12 col-md-12 mb-4">
                                            <p for="combo_name">Percentual de Conclusão</p>
                                            <input type="text" class="form-control" onkeypress="$(this).mask('00%', {reverse: true});" id="percent" name="percent" value=""
                                                required>
                                        </div>
                                        
                                    </div>

                                    <div class="modal-footer">
                                        {{--<button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>--}}
                                        <button type="button" href="javascript:void(0);"
                                            onClick="document.getElementById('condition_cademi_create').submit();"
                                            class="btn btn-success">Criar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="navSection" data-bs-spy="affix" class="nav sidenav">
                        <div class="sidenav-content">

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
                                    <h3 class="">Lista de Condições</h3>
                                    <div class=>
                                        {{--<a data-bs-toggle="modal" href="" data-bs-target="#OuroCreateModal"
                                            class="bg-dark rounded p-2" data-toggle="tooltip" data-placement="top"
                                            title="Criar Condição Ouro">
                                            <img src="{{Vite::asset('resources/images/ouro.svg')}}" width="20px">
                                        </a>--}}
                                        <a data-bs-toggle="modal" href="" data-bs-target="#CademiCreateModal"
                                            class="mx-2 bg-dark rounded p-2" data-toggle="tooltip" data-placement="top"
                                            title="Criar Condição Cademi">
                                            <img src="{{Vite::asset('resources/images/cademi.png')}}" width="20px">
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive ps" id="table1">
                                    <div class="statbox widget box box-shadow">
                                        @foreach ($conditions as $condition)
                                        {{--$condition->id--}}
                                        
                                        <tr>
                                            <td>
                                                <div class="card style-5 bg-dark mt-4 mb-md-0 mb-4">
                                                    <div class="card-top-content">
                                                        <div class="avatar avatar-md">
                                                            <img alt="avatar"
                                                                src="{{-- asset(($condition->getuser())->image) --}}"
                                                                class="rounded-circle">
                                                        </div>


                                                    </div>
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-2">{{ $condition->id }} | {{ $condition->name }}
                                                            </h5>
                                                            <h6 class="">Percentual: {{ $condition->percent }}%</h6>
                                                            
                                                            @foreach (json_decode($condition->body) as $key => $value)
                                                            <li>
                                                                {{$value->name}} | {{$value->info}}
                                                            </li>
                                                            @endforeach

                                                            <form
                                                                action="{{route('post-condition-del', ['id' => $condition->id])}}"
                                                                id="msg_del[{{$condition->id}}]" method="POST">
                                                                @csrf

                                                                <p class="d-flex justify-content-start mt-2">
                                                                    {!!$condition->created_at->format('d/m/y
                                                                    H:i:s')!!}</p>

                                                                <span class="badge badge-primary mb-2 bs-tooltip"
                                                                    title="">{{$condition->type}}</span>
                                                                </a>

                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal{{$condition->id}}"
                                                                    type="button"
                                                                    class="badge badge-danger mb-2 bs-tooltip"
                                                                    title="Excluir">
                                                                    <x-widgets._w-svg class="text-white" svg="trash" />
                                                                </a>

                                                                <!-- Modal content-->
                                                                <div class="modal fade"
                                                                    id="exampleModal{{$condition->id}}" tabindex="-1"
                                                                    role="dialog" aria-labelledby="exampleModalLabel"
                                                                    aria-hidden="true">

                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">Você deseja
                                                                                    excluir?</h5>
                                                                                <a type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <svg> ... </svg>
                                                                                </a>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p class="text-danger p-4">⚠ Essa ação
                                                                                    não pode ser revertida, confira os
                                                                                    dados!</p>

                                                                                <div class="card-body">
                                                                                    {{--$condition->id--}}
                                                                                    <h5 class="card-title mb-2">{{
                                                                                        $condition->name }}
                                                                                    </h5>
                                                                                    <p class="card-text">{!!
                                                                                        str_replace(['\r','\n'], ["","
                                                                                        <br> "],
                                                                                        $condition->msg) !!}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a class="btn btn btn-success"
                                                                                    data-bs-dismiss="modal"><i
                                                                                        class="flaticon-cancel-12"></i>
                                                                                    Não</a>
                                                                                <a type="button" class="btn btn-danger"
                                                                                    onClick="document.getElementById('msg_del[{{$condition->id}}]').submit();">Sim</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  BEGIN CUSTOM SCRIPTS FILE  -->
                <x-slot:footerFiles>
                    <script src="{{asset('plugins/tagify/tagify.min.js')}}"></script>
                
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
                        @foreach ($courses as $course)
                            {
                                "value": "{{$course->course_id}}",
                                "name": "{{$course->course_id}} | {{$course->nome}}",
                                "info": "{{$course->nome_completo}}"
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
                        @foreach ($courses as $course)
                            {
                                "value": "{{$course->course_id}}",
                                "name": "{{$course->course_id}} | {{$course->nome}}",
                                "info": "{{$course->nome_completo}}"
                            },
                        @endforeach
                        ]
                    })
                }
                    </script>



                    </x-slot>
                    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>