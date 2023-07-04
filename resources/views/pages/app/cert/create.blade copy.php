<x-base-layout :scrollspy="true">

    <x-slot:pageTitle>
        {{$title = "Falhas Mensagens"}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            @vite(['resources/scss/light/assets/components/list-group.scss'])
            @vite(['resources/scss/light/assets/users/user-profile.scss'])
            @vite(['resources/scss/dark/assets/components/list-group.scss'])
            @vite(['resources/scss/dark/assets/users/user-profile.scss'])

            @vite(['resources/scss/dark/assets/components/modal.scss'])
            @vite(['resources/scss/light/assets/components/modal.scss'])
            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <x-slot:scrollspyConfig>
                data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
                </x-slot>



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
                                <div class="d-flex justify-content-between">
                                    <h3 class="">Criar novo certificado</h3>
                                </div>
                                <div class="table-responsive ps" id="table1">
                                    <div class="statbox widget box box-shadow">
                                        @foreach ($failed as $fail)
                                        {{--$fail->id--}}
                                        <tr>
                                            <td>
                                                <div class="card style-5 bg-dark mt-4 mb-md-0 mb-4">
                                                    <div class="card-top-content">
                                                        <div class="avatar avatar-md">
                                                            <img alt="avatar"
                                                                src="{{ asset(($fail->getuser())->image) }}"
                                                                class="rounded-circle">
                                                        </div>


                                                    </div>
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-2">{{ $fail->name }}
                                                            </h5>
                                                            <p class="card-text">{!!
                                                                str_replace(['\r','\n'], [""," <br> "],
                                                                $fail->msg) !!}</p>
                                                            <form
                                                                action="{{route('msg-del_list', ['id' => $fail->id])}}"
                                                                id="msg_del[{{$fail->id}}]" method="POST">
                                                                @csrf
                                                               

                                                                <!-- Modal content-->
                                                                <div class="modal fade" id="exampleModal{{$fail->id}}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="exampleModalLabel"
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
                                                                                <p class="text-danger p-4">⚠ Essa ação não pode ser revertida, confira os dados!</p>
                                                                                
                                                                                <div class="card-body">
                                                                                    {{--$fail->id--}}
                                                                                    <h5 class="card-title mb-2">{{
                                                                                        $fail->name }}
                                                                                    </h5>
                                                                                    <p class="card-text">{!!
                                                                                        str_replace(['\r','\n'], ["","
                                                                                        <br> "],
                                                                                        $fail->msg) !!}</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a class="btn btn btn-success"
                                                                                    data-bs-dismiss="modal"><i
                                                                                        class="flaticon-cancel-12"></i>
                                                                                    Não</a>
                                                                                <a type="button"
                                                                                    class="btn btn-danger" onClick="document.getElementById('msg_del[{{$fail->id}}]').submit();">Sim</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @if($fail->status == 409)
                                                                <p class="d-flex justify-content-start">
                                                                    {!!$fail->created_at->format('d/m/y
                                                                    H:i:s')!!}</p>

                                                                <div class="badge badge-light-dark badge-dot">{{
                                                                    ($fail->getuser())->secretary }}</div>
                                                                <span class="badge badge-warning mb-2 bs-tooltip"
                                                                    title="Mensagen não enviada devido chamado ativo no MKT">Chamado
                                                                    Ativo</span>
                                                                <a href="{{getRouterValue();}}/app/mkt/resend_not_active/{{$fail->id}}"
                                                                    type="button"
                                                                    class="badge badge-warning mb-2 bs-tooltip"
                                                                    title="Reenviar">
                                                                    <x-widgets._w-svg class="text-white" svg="reload" />
                                                                </a>

                                                                @else
                                                                <div class="badge badge-light-dark badge-dot">{{
                                                                    ($fail->getuser())->secretary }}</div>
                                                                <span class="badge badge-danger mb-2">Falha
                                                                    no Envio</span>
                                                                @endif

                                                                <a href="{{getRouterValue();}}/aluno/profile/{{$fail->user_id}}"
                                                                    type="button"
                                                                    class="badge badge-success mb-2 bs-tooltip"
                                                                    title="Abrir Perfil" target="_blank">
                                                                    <x-widgets._w-svg class="text-white"
                                                                        svg="user-search" />
                                                                </a>


                                                                <a data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal{{$fail->id}}"
                                                                    type="button"
                                                                    class="badge badge-danger mb-2 bs-tooltip"
                                                                    title="Abrir Perfil">
                                                                    <x-widgets._w-svg class="text-white" svg="trash" />
                                                                </a>

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
                    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                        crossorigin="anonymous"></script>

                    <script>
                        $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        })
                    </script>
                    </x-slot>
                    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>