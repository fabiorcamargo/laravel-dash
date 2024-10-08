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

            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])
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

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />

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
                                <textarea type="text" class="form-control" name="body" id="body" placeholder="Descrição"
                                    required></textarea>
                            </div>

                        </div>

                        <div class="widget-content widget-content-area blog-create-section mt-4">
                            <button type="send" class="btn btn-success w-100">Enviar Notificação</button>
                        </div>
                    </form>

                    <div class="widget-content widget-content-area blog-create-section mt-4">
                        <h5 class="mb-4">Notificações Enviadas</h5>

                        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing mt-2">
                            <div class="statbox widget box box-shadow">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Título</th>
                                                <th scope="col">Descrição</th>
                                                <th scope="col">Envio</th>
                                                <th scope="col">Sucesso</th>
                                                <th scope="col">Falha</th>
                                                <th scope="col">Data</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pushNotifications as $notify)


                                            <tr>
                                                <td class="py-2">
                                                    <div class="d-flex align-items-center">
                                                        <div >
                                                            <img style="height: 40px;" src="{{ $notify->image }}">
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 ps-2">{{ $notify->title }}</h6>
                                                        </div>
                                                    </div>
                                                    
                                                </td>
                                                <td>
                                                    <span>{{ $notify->body }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $notify->send }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $notify->successes }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $notify->failures }}</span>
                                                </td>
                                                <td>{{ $notify->created_at }}</td>

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

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>