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
                        <li class="breadcrumb-item"><a href="#">App</a></li>
                        <li class="breadcrumb-item"><a href="#">Group</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add</li>
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

                    <form action="{{ getRouterValue(); }}/app/group/add" method="post" enctype="multipart/form-data"
                        name="form1" class="was-validated">
                        @csrf
                        <div class="widget-content widget-content-area blog-create-section mb-4">
                            <h5 class="mb-4">Criação de Grupos</h5>
                            <div class="row mb-4">
                                <div class="col-xxl-4 col-md-4 mb-3">
                                    <label for="flow">Código Cademi</label>
                                    <select name="cademi_code" id="cademi_code" class="form-control mb-2" required>
                                        <option value="">Selecione</option>
                                        @foreach ($tags as $tag)
                                        <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="{{ getRouterValue(); }}/app/eco/cademi/tag"
                                        class="btn btn-light-primary me-4">Atualizar</a>
                                </div>
                                <div class="col-xxl-4 col-md-4 mb-3">
                                    <label for="flow">Categoria</label>
                                    <select name="category" id="category" class="form-control mb-2" required>
                                        <option value="">Selecione</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="{{ getRouterValue(); }}/app/group/category"
                                        class="btn btn-light-primary me-4">Ver Categorias</a>
                                </div>
                                <div class="col-xxl-8 col-md-8 mb-3">
                                    <label>Coloque o nome do grupo com base no nome do curso.</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nome"
                                        required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Descrição.</label>
                                <textarea type="text" class="form-control" name="description" id="description"
                                    placeholder="Descrição"></textarea>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <div class="col-xxl-12 col-md-6 mb-3">
                                        <label for="flow">Selecione o período de Matrícula</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Início</span>
                                            <input id="inicio" name="inicio"
                                                class="form-control flatpickr flatpickr-input" type="text"
                                                placeholder="Data inicial.." required>
                                            <span class="input-group-text">Fim</span>
                                            <input id="fim" name='fim' class="form-control flatpickr flatpickr-input"
                                                type="text" placeholder="Data final.." required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-area blog-create-section mt-4">
                            <h5 class="mb-4">Informações do Grupo</h5>
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label>Link para entrar no grupo</label>
                                    <input type="text" class="form-control" name="link" id="link"
                                        placeholder="https://whats....." required>
                                </div>
                            </div>
                            <button type="send" class="btn btn-success w-100">Criar Grupo</button>
                        </div>
                    </form>

                    <div class="widget-content widget-content-area blog-create-section mt-4">
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
                                                                            onload="dataIni({{$group->inicio}})"
                                                                            required>
                                                                        <span class="input-group-text">Fim</span>
                                                                        <input id="fim1" name='fim1'
                                                                            class="form-control flatpickr flatpickr-input"
                                                                            type="text" placeholder="Data final.."
                                                                            onload="dataIni({{$group->inicio}})"
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
                    </div>
                </div>
            </div>

            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
                <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr2.js')}}"></script>
                <script src="{{asset('plugins/autocomplete/autoComplete.min.js')}}"></script>
                <script src="{{asset('plugins/autocomplete/city_autoComplete.js')}}"></script>
                @vite(['resources/assets/js/apps/blog-create.js'])
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                flatpickr("#inicio", {
                    dateFormat: "Y-m-d",
                    onChange: function(selectedDates, dateStr, instance) {
                        const endDatePicker = document.getElementById('fim')._flatpickr;
                        endDatePicker.set('minDate', dateStr);
                    }
                });
                flatpickr("#fim", {
                    dateFormat: "Y-m-d",
                    onChange: function(selectedDates, dateStr, instance) {
                        const startDatePicker = document.getElementById('inicio')._flatpickr;
                        startDatePicker.set('maxDate', dateStr);
                    }
                });
            });

            function submeter() {
                var inpname = document.querySelector('#autoComplete').value;
                document.cookie = "city=" + inpname + ";" + "path=/";
                console.log(inpname);
            }
                </script>


                <script>
                    function mydata(dataIni, dataFim) {
                        console.log(dataIni, dataFim);

                        // Initialize flatpickr for #inicio1 with default date and onChange event
                        flatpickr("#inicio1", {
                            dateFormat: "Y-m-d",
                            defaultDate: dataIni,
                            onChange: function(selectedDates, dateStr, instance) {
                                const endDatePicker = document.getElementById('fim1')._flatpickr;
                                endDatePicker.set('minDate', dateStr);
                            }
                        });

                        // Initialize flatpickr for #fim1 with default date and onChange event
                        flatpickr("#fim1", {
                            dateFormat: "Y-m-d",
                            defaultDate: dataFim,
                            onChange: function(selectedDates, dateStr, instance) {
                                const startDatePicker = document.getElementById('inicio1')._flatpickr;
                                startDatePicker.set('maxDate', dateStr);
                            }
                        });
                    }
                </script>

                <script>
                    function confirmDeletion(id, event) {
                        event.preventDefault(); // Previne o comportamento padrão do botão (enviar o formulário)

                        const form = document.getElementById('deleteForm' + id);
                        const userConfirmed = confirm("Você tem certeza que deseja excluir este grupo?");

                        if (userConfirmed) {
                            // Se o usuário confirmou, envie o formulário
                            form.submit();
                        } else {
                            // Se o usuário cancelou, não faça nada
                            console.log("Exclusão cancelada.");
                        }
                    }
                </script>

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>