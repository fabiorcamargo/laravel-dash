<x-base-layout :scrollspy="true">

    <x-slot:pageTitle>
        {{$title = "Certificados"}}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/users/user-profile.scss'])
        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/users/user-profile.scss'])

        @vite(['resources/scss/dark/assets/components/modal.scss'])
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @livewireStyles
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot:scrollspyConfig>



    <div class="row layout-spacing">

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
                    <div class="table-responsive ps" id="table1">
                        <div class="statbox widget box box-shadow">
                            @foreach ($certificates as $cert)
                            <div id="EditCertModal{{$cert->id}}" class="modal animated fadeInDown" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <form action="{{ route('post-cert-edit', ['id' => $cert->id]) }}" method="POST"
                                            id="cert_edit{{$cert->id}}" class="py-12">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Editar Certificado</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-x">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="col-xxl-12 col-md-12 mb-4">
                                                    <p for="combo_name">Nome do Certificado</p>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        value="{{$cert->cert_certificates_model_id}}" required>
                                                </div>
                                                <div class="col-xxl-12 col-md-12 mb-4">
                                                    <p for="combo_name">Tipo</p>
                                                    <select class="form-control form-control" id="type" name="type"
                                                        required>

                                                    </select>
                                                </div>
                                                <div class="col-xxl-12 col-md-12 mb-4">
                                                    <p for="combo_name">Carga horária</p>
                                                    <input type="number" class="form-control" id="hours" name="hours"
                                                        value="{{$cert->percent}}" required>
                                                </div>
                                                <div class="col-xxl-12 col-md-12 mb-4">
                                                    <p for="combo_name">Carga horária</p>
                                                    <div class="col-sm-12">
                                                        <textarea class="form-control" name="conteudo" id="conteudo"
                                                            rows="5" required>{!! $cert->velidity !!}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                {{--<button class="btn btn-light-dark"
                                                    data-bs-dismiss="modal">Sair</button>--}}
                                                <button type="button" href="javascript:void(0);"
                                                    onClick="document.getElementById('cert_edit{{$cert->id}}').submit();"
                                                    class="btn btn-success">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <tr>
                                <td>
                                    <div class="card style-5 bg-dark mt-4 mb-md-0 mb-4">
                                        <div class="card-top-content">
                                            <div class="avatar avatar-md">
                                                <img alt="avatar" src="{{asset(($cert->getuser())->image)}}"
                                                    class="rounded-circle">
                                            </div>


                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <h5 class="card-title mb-2">{{$cert->getuser()->name}}
                                                    {{$cert->getuser()->lastname}}
                                                </h5>
                                                <h6 class="">Código: {{ $cert->code }}</h6>
                                                <h6 class="">Aproveitamento: {{ $cert->percent }}%</h6>
                                                <h6 class="">Certificado: {{ $cert->getCertModel()->name }}</h6>
                                                <p class="card-text">{!!
                                                    str_replace(['\r','\n'], [""," <br> "],
                                                    $cert->content) !!}</p>
                                                <form action="{{route('cert-del-emit', ['id' => $cert->id])}}"
                                                    id="msg_del[{{$cert->id}}]" method="POST">
                                                    @csrf

                                                    <p class="d-flex justify-content-start">
                                                        {!!$cert->created_at->format('d/m/y
                                                        H:i:s')!!}</p>

                                                    <a href="{{route('cert-check', ['code' => $cert->code])}}"
                                                        target="_blank" type="button"
                                                        class="badge badge-primary mb-2 bs-tooltip" title="Ver">
                                                        <x-widgets._w-svg class="text-white" svg="arrow-up-right" />
                                                    </a>

                                                    <a href="{{route('cert-down', ['code' => $cert->code])}}"
                                                        target="_blank" type="button"
                                                        class="badge badge-success mb-2 bs-tooltip" title="Baixar">
                                                        <x-widgets._w-svg class="text-white" svg="file-download" />
                                                    </a>

                                                    <!-- Modal content-->
                                                    <div class="modal fade" id="exampleModal{{$cert->id}}" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">

                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Você
                                                                        deseja
                                                                        excluir?</h5>
                                                                    <a type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <svg> ... </svg>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p class="text-danger p-4">⚠ Essa ação
                                                                        não pode ser revertida, confira os
                                                                        dados!</p>

                                                                    <div class="card-body">
                                                                        {{--$cert->id--}}
                                                                        <h5 class="card-title mb-2">{{
                                                                            $cert->name }}
                                                                        </h5>
                                                                        <p class="card-text">{!!
                                                                            str_replace(['\r','\n'], ["","
                                                                            <br> "],
                                                                            $cert->msg) !!}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a class="btn btn btn-success"
                                                                        data-bs-dismiss="modal"><i
                                                                            class="flaticon-cancel-12"></i>
                                                                        Não</a>
                                                                    <a type="button" class="btn btn-danger"
                                                                        onClick="document.getElementById('msg_del[{{$cert->id}}]').submit();">Sim</a>
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

    @livewireScripts
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>

        <script>
            $(function () {
                                $('[data-toggle="tooltip"]').tooltip()
                                })
        </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>