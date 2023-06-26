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
            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <x-slot:scrollspyConfig>
                data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
                </x-slot>



                <div class="row layout-spacing">

                    <div id="navSection" data-bs-spy="affix" class="nav sidenav">
                        <div class="sidenav-content">
                            <a href="#tooltipDefault" class="active nav-link">Default</a>
                            <a href="#tooltipDirections" class="nav-link">Directions</a>
                            <a href="#tooltipDismissible" class="nav-link">HTML</a>
                            <a href="#tooltipOptions" class="nav-link">Options</a>
                            <a href="#tooltipColors" class="nav-link">Colors</a>
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
                                    <h3 class="">Mensagens com falha</h3>
                                </div>
                                <div class="table-responsive ps" id="table1">
                                    <div class="statbox widget box box-shadow">
                                        @foreach ($failed as $fail)
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
                                                            <form action="{{route('msg-del_list', ['id' => $fail->id])}}" id="msg_del" method="POST">
                                                                @csrf
                                                                @if($fail->status == 409)
                                                                    <p class="d-flex justify-content-start">
                                                                        {!!$fail->created_at->format('d/m/y
                                                                        H:i:s')!!}</p>

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
                                                                

                                                                <a href="javascript:void(0);"
                                                                onClick="document.getElementById('msg_del').submit();"
                                                                    type="button"
                                                                    class="badge badge-danger mb-2 bs-tooltip"
                                                                    title="Abrir Perfil">
                                                                    <x-widgets._w-svg class="text-white"
                                                                        svg="trash" />
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