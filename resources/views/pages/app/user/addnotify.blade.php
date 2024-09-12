<x-base-layout :scrollspy="false">

    <style>
        .flatpickr-calendar {
            z-index: 9999 !important;
        }
    </style>
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

            <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/noUiSlider/nouislider.min.css')}}">
            @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
            @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])
            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Alunos</a></li>
                        <li class="breadcrumb-item"><a href="#">Notificação</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nova</li>
                    </ol>
                </nav>
            </div>
            <!-- /BREADCRUMB -->

            <div class="row mb-4 layout-spacing layout-top-spacing">

                <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ getRouterValue(); }}/app/user/notify" method="post" enctype="multipart/form-data"
                        name="form1" class="was-validated">
                        @csrf
                        <div class="widget-content widget-content-area blog-create-section mb-4">
                            <h5 class="mb-4">Criar Notificação</h5>
                            <div class="row mb-4">
                                <div class="col-xxl-4 col-md-4 mb-3">
                                    <label for="flow">Selecione a Turma</label>
                                    <select name="cademi_code" id="cademi_code" class="form-control mb-2" required>
                                        <option value="">Selecione</option>
                                        @foreach ($tags as $tag)
                                        <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="{{ getRouterValue(); }}/app/eco/cademi/tag"
                                        class="btn btn-light-primary me-4">Atualizar</a>
                                </div>
    
                                <div class="col-xxl-8 col-md-8 mb-3">
                                    <label>Título da Notificação.</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Nome"
                                        required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Texto da Notificação.</label>
                                <textarea type="text" class="form-control" name="body" id="body"
                                    placeholder="Descrição" required></textarea>
                            </div>
                            
                        </div>

                        <div class="widget-content widget-content-area blog-create-section mt-4">
                            <button type="send" class="btn btn-success w-100">Enviar Notificação</button>
                        </div>
                    </form>

                    {{-- <div class="widget-content widget-content-area blog-create-section mt-4">
                        <h5 class="mb-4">Grupos</h5>

                        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing mt-2">
                            <div class="statbox widget box box-shadow">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Categoria</th>
                                                <th scope="col">Período</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($groups as $group)
                                            <!-- MODAL SEÇÃO -->
                                            <div id="CademiImgModal{{$group->id}}" class="modal animated fadeInDown"
                                                role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <form action="{{route('group-update')}}" method="post">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Editar Grupo</h5>
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
                                                                <div>


                                                                    <div class="col-xxl-12 col-md-12 mb-2 mt-2">
                                                                        <p for="combo_name">Nome</p>
                                                                        <input type="text" class="form-control"
                                                                            id="name" name="name"
                                                                            value="{{$group->name}}">
                                                                        <input type="text" class="form-control" id="id"
                                                                            name="id" value="{{ $group->id }}" hidden>
                                                                    </div>
                                                                    <p for="combo_name">Descrição</p>
                                                                    <textarea class="form-control" id="description"
                                                                        name="description">{{ old('description', $group->description) }}</textarea>

                                                                    <div class="input-group my-3">
                                                                        <span class="input-group-text">Início</span>
                                                                        <input id="inicio1" name="inicio1"
                                                                            class="form-control flatpickr flatpickr-input"
                                                                            type="text" placeholder="Data inicial.."
                                                                            
                                                                            required>
                                                                        <span class="input-group-text">Fim</span>
                                                                        <input id="fim1" name='fim1'
                                                                            class="form-control flatpickr flatpickr-input"
                                                                            type="text" placeholder="Data final.."
                                                                            
                                                                            required>
                                                                    </div>
                                                                </div>


                                                                <div class="row mb-4">
                                                                    <div class="col-sm-12">
                                                                        <p for="combo_name">Link para entrar no grupo
                                                                        </p>

                                                                        <input type="text" class="form-control"
                                                                            name="link" id="link"
                                                                            placeholder="https://whats....."
                                                                            value="{{ $group->link }}" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-success btn-lg">Atualizar</a>
                                                                    </form>
                                                                    <form id="deleteForm{{$group->id}}" action="{{ route('group-delete', ['id' => $group->id]) }}" method="POST">
                                                                        @csrf
                                                                        <button type="button" class="btn btn-danger" onclick="confirmDeletion({{ $group->id }}, event)">Excluir</button>
                                                                    </form>

                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- MODAL SEÇÃO -->

                                            <tr>
                                                <td>
                                                    <div class="media">
                                                        <div class="avatar me-2">
                                                            <img alt="avatar" src="{{ $group->wpGroupCategory->img }}"
                                                                class="rounded-circle">
                                                        </div>
                                                        <div class="media-body align-self-center">
                                                            <a data-bs-toggle="modal" href="#"
                                                                onclick="mydata('{{ $group->inicio }}', '{{ $group->fim }}')"
                                                                data-bs-target="#CademiImgModal{{$group->id}}"
                                                                class="action-btn btn-edit bs-tooltip me-2"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Editar">
                                                                <h6 class="mb-0">{{ $group->name }}</h6>
                                                                <div class="row">
                                                                    
                                                                    <span>{{ $group->description }}</span>
                                                                    <span>{{ $group->link }}</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>{{ $group->wpGroupCategory->name }}</span>
                                                </td>
                                                <td>{{ $group->inicio }} -> {{ $group->fim }}</td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
                <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr2.js')}}"></script>
                <script src="{{asset('plugins/autocomplete/autoComplete.min.js')}}"></script>
                <script src="{{asset('plugins/autocomplete/city_autoComplete.js')}}"></script>
                @vite(['resources/assets/js/apps/blog-create.js'])

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>