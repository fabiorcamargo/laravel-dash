<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
            <link rel="stylesheet" type="text/css" href="{{asset('plugins/tagify/tagify.css')}}">
            @vite(['resources/scss/light/plugins/tagify/custom-tagify.scss'])
            @vite(['resources/scss/dark/plugins/tagify/custom-tagify.scss'])

            @vite(['resources/scss/light/assets/components/list-group.scss'])
            @vite(['resources/scss/light/assets/users/user-profile.scss'])
            @vite(['resources/scss/dark/assets/components/list-group.scss'])
            @vite(['resources/scss/dark/assets/users/user-profile.scss'])
            @vite(['resources/scss/light/plugins/clipboard/custom-clipboard.scss'])
            @vite(['resources/scss/dark/plugins/clipboard/custom-clipboard.scss'])

            @vite(['resources/scss/dark/assets/components/modal.scss'])
            @vite(['resources/scss/light/assets/components/modal.scss'])

            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])

            @vite(['resources/scss/light/assets/components/accordions.scss'])
            @vite(['resources/scss/dark/assets/components/accordions.scss'])

            @vite(['resources/scss/light/assets/apps/chat.scss'])
            @vite(['resources/scss/dark/assets/apps/chat.scss'])


            <style>
                .ps {
                    position: relative;
                    height: 300px;
                }
            </style>
            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->



            <div class="col-xl-12 col-md-12 col-sm-12 layout-top-spacing">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
            </div>



            <!-- Content -->
            <div class="body row layout-spacing">
                @if ((Auth::user()->role) == 4 || (Auth::user()->role) == 5 || (Auth::user()->role) == 8)
                <div class="ms-4 col-xl-12 col-md-12 col-sm-12 layout-top-spacing">
                        <h3 >Dados do Contrato</h3>
                        <div class="">
                            <p>{!!$user->observation!!}</p>

                        </div>
                </div>
                @endif
                <div class="col-xl-5 col-md-5 col-sm-12 layout-top-spacing">
                    <div class="user-profile">
                        <div class="widget-content widget-content-area">
                            <div class="d-flex justify-content-between">
                                <h3 class="">Perfil do Usuário</h3>
                                @if (Auth::user()->id == $user->id || Auth::user()->role >= 4)
                                <a href="{{getRouterValue();}}/aluno/profile/{{ $user->id }}/edit"
                                    class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-edit-3">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg></a>
                                @endif

                            </div>



                            <div class="text-center user-info">


                                <img src="{{ asset($user->image) }}" alt="avatar">
                                <p class="">{{ $user->username }} | {{ $user->name }} {{ $user->lastname }}</p>
                                <div class="media-body align-self-center">
                                    @if ((Auth::user()->role) >= 4)
                                    @if($user->first == 2)
                                    <div class="badge badge-success badge-dot">{{$user->secretary}}</div>
                                    @elseif($user->first == 3)
                                    <div class="badge badge-danger badge-dot">{{$user->secretary}}</div>
                                    @else
                                    <div class="badge badge-warning badge-dot">{{$user->secretary}}</div>
                                    @endif
                                    @if ($user->payment == "CARTÃO")
                                    <div class="shadow-none badge badge-success">Cartão</div>
                                    @elseif ($user->payment == "BOLETO")
                                    <div class="shadow-none badge badge-primary">Boleto</div>
                                    @else
                                    <div class="shadow-none badge badge-dark">Vazio</div>
                                    @endif
                                    @if($user->ouro == 1)
                                    <span class="badge badge-light-info mb-2">10 Cursos</span>
                                    @endif

                                    @if($user->cademis()->first())
                                    @if($user->first < 3) <a href="javascript():void" data-bs-toggle="modal"
                                        data-bs-target="#bloquearCademiModal" class="badge badge-success mb-2">
                                        Cademi</a>
                                        @elseif($user->first == 4)
                                        <a href="javascript():void" data-bs-toggle="modal"
                                            data-bs-target="#bloquearCademiModal"
                                            class="badge badge-success mb-2">Cademi</a>
                                        @else
                                        <a href="javascript():void" data-bs-toggle="modal"
                                            data-bs-target="#desbloquearCademiModal"
                                            class="badge badge-danger mb-2">Cademi</a>
                                        @endif
                                        @endif
                                        @if ($user->client_ouro()->first() || $user->ouro_id !== null)
                                        @if($user->first < 4) <a href="javascript():void" data-bs-toggle="modal"
                                            data-bs-target="#bloquearOuroModal"
                                            class="badge badge-success position-relative btn-icon mb-2 me-4">
                                            Ouro
                                            @else
                                            <a href="javascript():void" data-bs-toggle="modal"
                                                data-bs-target="#desbloquearOuroModal"
                                                class="badge badge-danger position-relative btn-icon mb-2 me-4">
                                                Ouro
                                                @endif
                                                <span
                                                    class="badge badge-dark counter">{{$user->client_ouro()->first()->matricula_ouro()->count()}}</span>
                                            </a>
                                            @endif
                                            @endif




                                </div>
                                @if ((Auth::user()->role) >= 4)
                                @if($user->first == 2)



                                @elseif($user->first >= 3)
                                <form action="{{ route('user-profile-active', $user->id) }}" method="POST"
                                    id="active_form" class="py-12">
                                    @method('POST')
                                    @csrf

                                </form>
                                @endif
                                @endif
                                @if ((Auth::user()->role) >= 8)
                                @if ($seller == "não")
                                <a data-bs-toggle="modal" data-bs-target="#vendedorModal"
                                    class="btn btn-primary btn-lg mt-4" data-toggle="tooltip" data-placement="top"
                                    title="Tornar Vendedor"> Tornar Vendedor
                                    <x-widgets._w-svg svg="cash-banknote" />
                                </a>
                                @endif
                                @if ($seller == "sim")
                                <a data-bs-toggle="modal" data-bs-target="#vendedordModal"
                                    class="btn btn-warning btn-lg mt-4" data-toggle="tooltip" data-placement="top"
                                    title="Remover Vendedor"> Remover Vendedor
                                    <x-widgets._w-svg svg="cash-banknote" />
                                </a>
                                @endif
                                @endif
                            </div>
                            <div class="user-info-list">

                                <ul class="contacts-block list-unstyled">
                                    {{-- <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-coffee me-3">
                                            <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                                            <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                                            <line x1="6" y1="1" x2="6" y2="4"></line>
                                            <line x1="10" y1="1" x2="10" y2="4"></line>
                                            <line x1="14" y1="1" x2="14" y2="4"></line>
                                        </svg> Web Developer
                                    </li> --}}
                                    <div class="card p-2" id="create">
                                        <li class="contacts-block__item">

                                            <label for="create">Data de Liberação:</label>
                                            <p>{{ $user->created_at->format('d-m-Y H:i') }}</p>
                                            @if($user->contract_date != null)
                                            <label for="create">Data do Contrato:</label>
                                            <p>{{ $user->contract_date->format('d-m-Y') }}</p>
                                            @endif

                                        </li>
                                    </div>
                                    <div class="card p-2 mt-4" id="create">

                                        <label for="create">Responsável Financeiro:</label>
                                        <li class="contacts-block__item">
                                            <a href="{{getRouterValue();}}/aluno/pay/list/{{$user->id}}" target="blank"
                                                class="btn btn-secondary  _effect--ripple waves-effect waves-light">
                                                <x-widgets._w-svg svg="cash" />
                                                <span class="btn-text-inner">Ver Pagamentos</span>
                                            </a>
                                        </li>
                                        @foreach ($user->accountable()->get() as $responsavel)
                                        <li class="contacts-block__item">
                                            <div class="media-body align-self-center">
                                                <p class="mb-0">{{ $responsavel->name }}</p>
                                                <p class="mb-0">{{ $responsavel->document }}</p>
                                                <p class="mb-0">{{ $responsavel->cellphone }}</p>
                                            </div>
                                        </li>
                                        @endforeach
                                    </div>
                                    <div class="card p-2 mt-4" id="create">
                                        <li class="contacts-block__item">
                                            <a href="mailto:{{ $user->email }}"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-mail me-3">
                                                    <path
                                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                    </path>
                                                    <polyline points="22,6 12,13 2,6"></polyline>
                                                </svg>{{ $user->email }}</a>
                                        </li>
                                        <li class="contacts-block__item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-phone me-3">
                                                <path
                                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                </path>
                                            </svg> {{ $user->cellphone }}
                                        </li>
                                        @if ((Auth::user()->role) == 7 || (Auth::user()->role) == 8 ||
                                        (Auth::user()->role) == 4)
                                        <li class="contacts-block__item">
                                            <a href="mailto:{{ $user->email2 }}"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-mail me-3">
                                                    <path
                                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                    </path>
                                                    <polyline points="22,6 12,13 2,6"></polyline>
                                                </svg>{{ $user->email2 }}</a>
                                        </li>
                                        <li class="contacts-block__item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-phone me-3">
                                                <path
                                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                </path>
                                            </svg> {{ $user->cellphone2 }}
                                        </li>
                                        @endif
                                        <li class="contacts-block__item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-map-pin me-3">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg>{{ $user->city }} - {{ $user->uf }}
                                        </li>
                                        <li class="contacts-block__item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-shopping-cart me-3">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path
                                                    d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                                </path>
                                            </svg> {{ $user->seller }}
                                        </li>
                                        <li class="contacts-block__item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-users me-3">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg> {{ $user->secretary }}
                                        </li>
                                        <li class="contacts-block__item">
                                            <div class="form-group">
                                                <input class="form-check-input me-1" id="ouro" name="ouro"
                                                    type="checkbox" @if ($user->ouro == 1 ) checked @endif disabled>
                                                Contratou 10 Cursos
                                            </div>
                                        </li>

                                        @if ((Auth::user()->role) >= 4)
                                        <li class="contacts-block__item">
                                            <a href="/login/{{ $user->id }}" target="blank"
                                                class="btn btn-dark  _effect--ripple waves-effect waves-light">
                                                <x-widgets._w-svg svg="login" />
                                                <span class="btn-text-inner">Acessar como {{$user->name}}</span>
                                            </a>
                                        </li>
                                        @endif

                                        @isset($cademi->login_auto)
                                        {{--<li class="contacts-block__item">
                                            <a href="{{ $cademi->login_auto }}" target="blank"
                                                class="btn btn-secondary  _effect--ripple waves-effect waves-light">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-log-in">
                                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                                    <polyline points="10 17 15 12 10 7"></polyline>
                                                    <line x1="15" y1="12" x2="3" y2="12"></line>
                                                </svg>
                                                <span class="btn-text-inner">Acesse seu Curso</span>
                                            </a>
                                        </li>--}}


                                        @if ((Auth::user()->role) == 4 || (Auth::user()->role) == 8)
                                        <li class="contacts-block__item">
                                            <div class="clipboard">

                                                <a href="https://profissionaliza.cademi.com.br/office/usuario/perfil/{{ $user->cademis->first()->user }}"
                                                    target="blank"
                                                    class="btn btn-danger  _effect--ripple waves-effect waves-light">
                                                    <x-widgets._w-svg svg="user-search" />
                                                    <span class="btn-text-inner">Perfil do Aluno na Cademi</span>
                                                </a>
                                        </li>


                                        {{--<li class="contacts-block__item">
                                            <form class="form-horizontal">
                                                <div class="clipboard-input">
                                                    <input type="text" class="form-control inative"
                                                        id="copy-basic-input" value="{{ $cademi->login_auto }}"
                                                        readonly>
                                                    <div class="copy-icon jsclipboard cbBasic" data-bs-trigger="click"
                                                        title="Copied" data-clipboard-target="#copy-basic-input"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-copy">
                                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2">
                                                            </rect>
                                                            <path
                                                                d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1">
                                                            </path>
                                                        </svg></div>
                                                </div>
                                            </form>


                                        </li>--}}
                                        @endif

                                        @endisset
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-md-7 col-sm-12 layout-top-spacing">


                    <div class="user-profile">
                        <div class="widget-content widget-content-area">

                            <div class="d-flex justify-content-between">
                                <h3 class="md-2">Cursos Liberados</h3>
                                {{--<a href="{{getRouterValue();}}/app/user/profile/{{ $user->id }}/courses"
                                    class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="green" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-edit-3">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z">
                                        </path>
                                    </svg></a>--}}
                            </div>

                            <div id="toggleAccordion" class="accordion mt-4">
                                @foreach ($courses as $course)
                                <div class="card">
                                    <div class="card-header" id="...">
                                        <section class="mb-0 mt-0">
                                            <div role="menu" class="collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#defaultAccordion{{ $course['row'] }}"
                                                aria-expanded="false"
                                                aria-controls="defaultAccordion{{ $course['row'] }}">
                                                <p class="text-success"> {{ $course['name'] }} | {{
                                                    $course['perc'] }} </p>
                                                <div class="icons"><svg> ... </svg></div>
                                            </div>
                                        </section>
                                    </div>

                                    <div id="defaultAccordion{{ $course['row'] }}" class="collapse"
                                        aria-labelledby="..." data-bs-parent="#toggleAccordion">
                                        <div class="card-body">

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $course['name'] }}</td>
                                                            <td>
                                                                <div class="progress br-30">
                                                                    <div class="progress-bar br-30 bg-secondary"
                                                                        role="progressbar"
                                                                        style="width: {{ $course['perc'] }}"
                                                                        aria-valuenow="25" aria-valuemin="0"
                                                                        aria-valuemax="100"></div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p class="text-secondary">{{
                                                                    $course['perc'] }}</p>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Aula</th>
                                                            <th>Finalizada em</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @isset($course['aula'])
                                                        @foreach ($course['aula'] as $aula)
                                                        <tr>
                                                            <td>{{$aula['nome']}}</td>
                                                            <td>
                                                                <p class="text-secondary">
                                                                    {{$aula['data']}}</p>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endisset

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="user-profile mt-4">
                        <div class="widget-content widget-content-area">

                            <div class="d-flex justify-content-between">
                                <h3 class="md-2">Cursos Ouro Moderno</h3>
                                @if ((Auth::user()->role) >= 4)
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a data-bs-toggle="modal" href="" data-bs-target="#OuroModal"
                                        class="mt-2 edit-profile" data-toggle="tooltip" data-placement="top"
                                        title="Adicionar Cursos">
                                        <x-widgets._w-svg svg="apps-filled" />
                                    </a>
                                </div>
                                @endif

                            </div>
                            @if($client_ouro)
                            <div id="toggleAccordion" class="accordion mt-4">
                                @foreach ($course_ouro as $course)
                                <div class="card">

                                    <div class="card-header" id="...">

                                        <section class="mb-0 mt-0">
                                            <div class="d-flex justify-content-between">

                                                <div role="menu" class="collapsed" data-bs-toggle="collapse"
                                                    data-bs-target="#defaultAccordion{{ $course['row'] }}"
                                                    aria-expanded="false"
                                                    aria-controls="defaultAccordion{{ $course['row'] }}">
                                                    <p class="text-success"> {{ $course['ouro_course_id'] }}
                                                        | {{
                                                        $course['name'] }} </p>
                                                    <div class="icons"><svg> ... </svg></div>
                                                </div>
                                                @if ((Auth::user()->id) == 4 || (Auth::user()->id) == 1)


                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#delOuroModal{{$course['id']}}"
                                                        class="text-danger" data-toggle="tooltip" data-placement="top"
                                                        title="Adicionar Cursos">
                                                        <x-widgets._w-svg svg="trash" />
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </section>
                                    </div>
                                    {{--}}
                                    <div id="defaultAccordion{{ $course['row'] }}" class="collapse"
                                        aria-labelledby="..." data-bs-parent="#toggleAccordion">
                                        <div class="card-body">

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $course['name'] }}</td>
                                                            <td>
                                                                <div class="progress br-30">
                                                                    <div class="progress-bar br-30 bg-secondary"
                                                                        role="progressbar"
                                                                        style="width: {{ $course['perc'] }}"
                                                                        aria-valuenow="25" aria-valuemin="0"
                                                                        aria-valuemax="100"></div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p class="text-secondary">{{
                                                                    $course['perc'] }}</p>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Aula</th>
                                                            <th>Finalizada em</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @isset($course['aula'])
                                                        @foreach ($course['aula'] as $aula)
                                                        <tr>
                                                            <td>{{$aula['nome']}}</td>
                                                            <td>
                                                                <p class="text-secondary">
                                                                    {{$aula['data']}}</p>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endisset

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> --}}

                                </div>

                                <div id="delOuroModal{{$course['id']}}" class="modal animated fadeInDown" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Excluir Curso</h5>
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
                                                <p class="modal-text">Você tem certeza que deseja prosseguir com
                                                    exclusão?</p>
                                                <p class="text-danger">Essa ação é destrutiva não pode revertida, todos
                                                    os registros desse curso serão apagados.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>
                                                <button type="button" href="javascript:void(0);"
                                                    onClick="document.getElementById('delOuroCourse{{$course->id}}').submit();"
                                                    class="btn btn-danger">Excluir</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{getRouterValue();}}/app/user/ouro/delete/{{ $course->id }}"
                                    method="POST" id="delOuroCourse{{$course->id}}" class="py-12">
                                    {{ method_field('DELETE') }}
                                    @csrf

                                </form>

                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if ((Auth::user()->role) == 4 || (Auth::user()->role) == 5 || (Auth::user()->role) == 8)

                <div class="modal" style="height: 788px; overflow:auto;" id="modal-send" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form class="chat-form" method="POST" id="msg_send"
                                action="{{ route('mkt-send_profile_msg', ['id' => $user->id]) }}">
                                @csrf
                                <div class="card style-4">
                                    <div class="card-body pt-3">
                                        <div class="media mt-0 mb-3">
                                            <div class="">
                                                <div class="avatar avatar-md avatar-indicators avatar-online me-3">
                                                    <img alt="avatar" src="{{Vite::asset('resources/images/logo.svg')}}"
                                                        class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading mb-0">{{$user->name}}</h4>
                                                <p class="media-text">Aluno</p>
                                            </div>
                                        </div>
                                        <div class="form-group row px-4">
                                            <label for="cellphone"
                                                class="col-sm-3 col-form-label col-form-label-sm">Telefone:</label>
                                            <div class="col-sm-9">
                                                <select class="form-control form-control-sm" id="cellphone"
                                                    name="cellphone" required>
                                                    <option value="">Escolha</option>
                                                    <option value="{{$user->name}}, {{$user->cellphone}}">
                                                        Aluno - {{$user->cellphone}}
                                                    </option>
                                                    <option value="{{$user->name}}, {{$user->cellphone2}}">
                                                        Aluno - {{$user->cellphone2}}
                                                    </option>
                                                    @isset($user->accountable->name)
                                                    <option
                                                        value="{{$user->accountable->name}}, {{$user->accountable->cellphone}}">
                                                        Responsável -
                                                        {{$user->accountable->cellphone}}
                                                    </option>
                                                    @endisset
                                                </select>
                                            </div>
                                        </div>

                                        <p class="card-text py-2">Selecione para qual telefone, escolha se deseja abrir
                                            chamado no MKT e digite a mensagem que deseja enviar.</p>
                                    </div>
                                    <div class="card-footer pt-0 border-0 text-center">
                                        <div class="col-xxl-12 col-md-12">
                                            <label for="users_list_tags">Mensagem:</label>
                                            <textarea class="form-control" name="obs" id="obs" rows="3"
                                                required></textarea>
                                        </div>

                                        <button type="send" class="btn btn-secondary w-100 mt-4">
                                            <span class="btn-text-inner ms-3">Enviar</span></button>

                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" value="" name="chamadoativo"
                                            id="customCheck1">
                                        <label class="form-check-label bs-tooltip" for="customCheck1"
                                            title="Nessa opção será aberto um chamado no MKT">Abrir
                                            Protocolo</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            @foreach ($user->usermsg()->orderby('created_at','desc')->get() as $obs)
            <div class="modal" style="height: 788px; overflow:auto;" id="exampleModal{{$obs->id}}" tabindex="-1"
                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="chat-form" method="POST" id="msg_send"
                            action="{{ route('mkt-send_profile_msg', ['id' => $user->id]) }}">
                            @csrf
                            <div class="chat-system" style="height: 488px;" id="chat[{{$obs->id}}]">
                                <div class="chat-box m-1"
                                    style="background-image: url({{Vite::asset('resources/images/bg.png')}}); height: 488px;">

                                    <div class="chat-not-selected" style="display: none;">
                                        <p> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-message-square">
                                                <path
                                                    d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                                </path>
                                            </svg> Click User To Chat</p>
                                    </div>

                                    <div class="row">
                                        <div class="card-top-content">
                                            <div class="chat-box-inner" style="height: 100%;">
                                                <div class="chat-meta-user chat-active">

                                                    <div class="current-chat-user-name">
                                                        <form class="chat-form" method="POST" id="msg_send"
                                                            action="{{ route('mkt-send_profile_msg', ['id' => $user->id]) }}">
                                                            @csrf
                                                            <span>
                                                                <img src="{{Vite::asset('resources/images/logo.svg')}}"
                                                                    alt="dynamic-image">
                                                                <span class="name">Enviar Mensagem

                                                                </span>
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="form-group">
                                                                        <select class="form-select mt-2"
                                                                            id="cellphone" name="cellphone"
                                                                            required>
                                                                            <option value="">Escolha</option>
                                                                            <option
                                                                                value="{{$user->name}}, {{$user->cellphone}}">
                                                                                Aluno - {{$user->cellphone}}
                                                                            </option>
                                                                            <option
                                                                                value="{{$user->name}}, {{$user->cellphone2}}">
                                                                                Aluno - {{$user->cellphone2}}
                                                                            </option>
                                                                            @isset($user->accountable->name)
                                                                            <option
                                                                                value="{{$user->accountable->name}}, {{$user->accountable->cellphone}}">
                                                                                Responsável -
                                                                                {{$user->accountable->cellphone}}
                                                                            </option>
                                                                            @endisset
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group ms-4 pt-2">
                                                                        <input class="form-check-input me-1"
                                                                            id="chamadoativo" name="chamadoativo"
                                                                            type="checkbox">
                                                                        <label for="chamadoativo" class="bs-tooltip"
                                                                            title="Nessa opção será aberto um chamado no MKT">Abrir
                                                                            Protocolo</label>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="chat-conversation-box pt-4">
                                            <div id="chat-conversation-box-scroll"
                                                class="chat-conversation-box-scroll ms-2">
                                                <div class="chat" data-chat="{{$obs->id}}">
                                                    <div class="conversation-start">
                                                        <span>{!!$obs->created_at->format('d/m/y
                                                            H:i:s')!!}</span>
                                                    </div>
                                                    <div class="bubble you">
                                                        {!! str_replace(['\r','\n'], [""," <br> "],
                                                        $obs->msg) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btn-toolbar" role="toolbar"
                                                aria-label="Toolbar with button groups">
                                                @if($obs->status == 201)

                                                <div class="btn-group ms-2" role="group" aria-label="First group">
                                                    <a type="button" class="btn btn-success bs-tooltip"
                                                        title="Eviada com sucesso">
                                                        <x-widgets._w-svg class="text-white" svg="checks" />
                                                    </a>
                                                    @isset($obs->cellphone)
                                                    <a href="{{getRouterValue();}}/app/mkt/resend_not_active/{{$obs->id}}"
                                                        type="button" class="btn btn-warning bs-tooltip"
                                                        title="Reenviar">
                                                        <x-widgets._w-svg class="text-white" svg="reload" />
                                                    </a>
                                                    @endisset
                                                </div>
                                                @else
                                                <div class="btn-toolbar" role="toolbar"
                                                    aria-label="Toolbar with button groups">
                                                    <div class="btn-group ms-2" role="group"
                                                        aria-label="First group">
                                                        <a type="button" class="btn btn-danger bs-tooltip"
                                                            title="Não Enviada">
                                                            <x-widgets._w-svg class="text-white"
                                                                svg="alert-triangle" />
                                                        </a>
                                                        @isset($obs->cellphone)
                                                        <a href="{{getRouterValue();}}/app/mkt/resend_not_active/{{$obs->id}}"
                                                            type="button" class="btn btn-warning bs-tooltip"
                                                            title="Reenviar">
                                                            <x-widgets._w-svg class="text-white" svg="reload" />
                                                        </a>
                                                        @endisset
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="d-flex justify-content-between p-4">
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="obs" id="obs" rows="3" required></textarea>
                                </div>
                                <div class="col-sm-2 mx-2">
                                    <button type="send" class="btn">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        @endforeach
            <div class="row layout-spacing ">
                <div class="summary layout-spacing col-md-6">
                    <div class="widget-content widget-content-area">

                        <div class="d-flex justify-content-between">
                            <h3 class="">Observações</h3>
                            <div>
                                <a data-bs-toggle="modal" href="" data-bs-target="#ObsModal" class="btn"
                                    data-toggle="tooltip" data-placement="top" title="Adicionar Observação">
                                    Nova Observação
                                </a>
                            </div>

                        </div>

                        <div class="table-responsive ps" id="table1" style="height: 350px;
                            overflow:auto;
                        ">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Dados</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->observation()->orderby('created_at','desc')->get() as $obs)
                                    <tr>
                                        <td>
                                            <p class="contacts-block__item mb-0">{!!$obs->created_at->format('d/m/y
                                                H:i:s')!!} </p>
                                            <small class="form-group">{!!str_ireplace("\r\n", "<br>",
                                                $obs->obs)!!}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="summary layout-spacing col-md-6">
                    <div class="widget-content widget-content-area">
                            <form class="chat-form" method="POST" id="msg_send"
                                action="{{ route('mkt-send_profile_msg', ['id' => $user->id]) }}">
                                @csrf
                                    <div class="pt-3">
                                        <div class="media mt-0 mb-3">
                                            <div class="">
                                                <div class="avatar avatar-md avatar-indicators avatar-online me-3">
                                                    <img alt="avatar" src="{{Vite::asset('resources/images/logo.svg')}}"
                                                        class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <h3 class="mb-0">{{$user->name}}</h3>
                                                <p class="media-text">Aluno</p>
                                            </div>
                                        </div>
                                        <div class="form-group row px-4">
                                            <label for="cellphone"
                                                class="col-sm-3 col-form-label col-form-label-sm">Telefone:</label>
                                            <div class="col-sm-9">
                                                <select class="form-control form-control-sm" id="cellphone"
                                                    name="cellphone" required>
                                                    <option value="">Escolha</option>
                                                    <option value="{{$user->name}}, {{$user->cellphone}}">
                                                        Aluno - {{$user->cellphone}}
                                                    </option>
                                                    <option value="{{$user->name}}, {{$user->cellphone2}}">
                                                        Aluno - {{$user->cellphone2}}
                                                    </option>
                                                    @isset($user->accountable->name)
                                                    <option
                                                        value="{{$user->accountable->name}}, {{$user->accountable->cellphone}}">
                                                        Responsável -
                                                        {{$user->accountable->cellphone}}
                                                    </option>
                                                    @endisset
                                                </select>
                                            </div>
                                        </div>

                                        <p class="card-text py-2">Selecione para qual telefone, escolha se deseja abrir
                                            chamado no MKT e digite a mensagem que deseja enviar.</p>
                                            <div class=" rounded p-4 ps bg-light-dark" id="messages" style="height: 350px;
                                            overflow:auto;
                                        ">
                                            <p class="py-2 text-center">Mensagens enviadas do sistema</p>
                                            @foreach ($user->usermsg()->orderby('created_at','desc')->get() as $obs)
                                            
                                                <div class="card my-3">
                                                    <p class="text-muted p-2">{{$obs->cellphone}}</p><br>
                                                    <div class="card-body">
                                                        
                                                        <p class="mb-0">{!! str_replace(['\r','\n'], [""," <br> "],
                                                            $obs->msg) !!}</p><br>
                                                    
                                                    </div>
                                                    <div> 
                                                        @if($obs->status == 201)
                                                            <p class="d-flex justify-content-end p-2">{!!$obs->created_at->format('d/m/y
                                                                H:i:s')!!}<x-widgets._w-svg class="mx-2 text-success" svg="checks" /></p>
                                                        @else
                                                            @isset($obs->cellphone)
                                                                <p class="d-flex justify-content-end p-2">{!!$obs->created_at->format('d/m/y
                                                                    H:i:s')!!} <p class="text-danger d-flex justify-content-end ps-2">Não enviada<a href="{{getRouterValue();}}/app/mkt/resend_not_active/{{$obs->id}}"
                                                                type="button" class="btn btn-warning bs-tooltip"
                                                                title="Reenviar">
                                                                <x-widgets._w-svg class="text-white" svg="reload" />
                                                                </a></small></p>
                                                            @else
                                                                <p class="d-flex justify-content-end p-2">{!!$obs->created_at->format('d/m/y
                                                                    H:i:s')!!} <p class="text-danger d-flex justify-content-end ps-2">Não enviada</p></p>
                                                            @endisset
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="card-footer pt-4 border-0 text-center">
                                        
                                        <div class="col-xxl-12 col-md-12">
                                            <label for="users_list_tags">Mensagem:</label>
                                            <textarea class="form-control" name="obs" id="obs" rows="3"
                                                required></textarea>
                                        </div>

                                        <button type="send" class="btn btn-secondary w-100 mt-4">
                                            <span class="btn-text-inner ms-3">Enviar</span></button>

                                    </div>
                                    <div class="form-check m-2">
                                        <input class="form-check-input" type="checkbox" value="" name="chamadoativo"
                                            id="chamadoativo">
                                        <label class="form-check-label bs-tooltip" for="chamadoativo"
                                            title="Nessa opção será aberto um chamado no MKT">Abrir
                                            Protocolo</label>
                                    </div>
                            </form>
                    </div>
                </div>
            </div>

            </div>
            @endif
            </div>







            {{--
            <div class="row">

                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                    <div class="summary layout-spacing ">
                        <div class="widget-content widget-content-area">
                            <h3 class="">Summary</h3>
                            <div class="order-summary">

                                <div class="summary-list summary-income">

                                    <div class="summery-info">

                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-shopping-bag">
                                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z">
                                                </path>
                                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                                            </svg>
                                        </div>

                                        <div class="w-summary-details">

                                            <div class="w-summary-info">
                                                <h6>Income <span class="summary-count">$92,600 </span>
                                                </h6>
                                                <p class="summary-average">90%</p>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="summary-list summary-profit">

                                    <div class="summery-info">

                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-dollar-sign">
                                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6">
                                                </path>
                                            </svg>
                                        </div>

                                        <div class="w-summary-details">

                                            <div class="w-summary-info">
                                                <h6>Profit <span class="summary-count">$37,515</span>
                                                </h6>
                                                <p class="summary-average">65%</p>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="summary-list summary-expenses">

                                    <div class="summery-info">

                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-credit-card">
                                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2">
                                                </rect>
                                                <line x1="1" y1="10" x2="23" y2="10"></line>
                                            </svg>
                                        </div>
                                        <div class="w-summary-details">

                                            <div class="w-summary-info">
                                                <h6>Expenses <span class="summary-count">$55,085</span>
                                                </h6>
                                                <p class="summary-average">42%</p>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">

                    <div class="pro-plan layout-spacing">
                        <div class="widget">

                            <div class="widget-heading">

                                <div class="task-info">
                                    <div class="w-title">
                                        <h5>Pro Plan</h5>
                                        <span>$25/month</span>
                                    </div>
                                </div>

                                <div class="task-action">
                                    <button class="btn btn-secondary">Renew Now</button>
                                </div>
                            </div>

                            <div class="widget-content">

                                <ul class="p-2 ps-3 mb-4">
                                    <li class="mb-1"><strong>10,000 Monthly Visitors</strong></li>
                                    <li class="mb-1"><strong>Unlimited Reports</strong></li>
                                    <li class=""><strong>2 Years Data Storage</strong></li>
                                </ul>

                                <div class="progress-data">
                                    <div class="progress-info">
                                        <div class="due-time">
                                            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-clock">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <polyline points="12 6 12 12 16 14"></polyline>
                                                </svg> 5 Days Left</p>
                                        </div>
                                        <div class="progress-stats">
                                            <p class="text-info">$25 / month</p>
                                        </div>
                                    </div>

                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 65%"
                                            aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                    <div class="payment-history layout-spacing ">
                        <div class="widget-content widget-content-area">
                            <h3 class="">Payment History</h3>

                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <div class="fw-bold title">March</div>
                                        <p class="sub-title mb-0">Pro Membership</p>
                                    </div>
                                    <span class="pay-pricing align-self-center me-3">$45</span>
                                    <div class="btn-group dropstart align-self-center" role="group">
                                        <a id="paymentHistory1" href="javascript:void(0);" class="dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-horizontal">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="paymentHistory1">
                                            <a class="dropdown-item" href="javascript:void(0);">View
                                                Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Download
                                                Invoice</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <div class="fw-bold title">February</div>
                                        <p class="sub-title mb-0">Pro Membership</p>
                                    </div>
                                    <span class="pay-pricing align-self-center me-3">$45</span>
                                    <div class="btn-group dropstart align-self-center" role="group">
                                        <a id="paymentHistory2" href="javascript:void(0);" class="dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-horizontal">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="paymentHistory2">
                                            <a class="dropdown-item" href="javascript:void(0);">View
                                                Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Download
                                                Invoice</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <div class="fw-bold title">January</div>
                                        <p class="sub-title mb-0">Pro Membership</p>
                                    </div>
                                    <span class="pay-pricing align-self-center me-3">$45</span>
                                    <div class="btn-group dropstart align-self-center" role="group">
                                        <a id="paymentHistory3" href="javascript:void(0);" class="dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-horizontal">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="paymentHistory3">
                                            <a class="dropdown-item" href="javascript:void(0);">View
                                                Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Download
                                                Invoice</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                    <div class="payment-methods layout-spacing ">
                        <div class="widget-content widget-content-area">
                            <h3 class="">Payment Methods</h3>

                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <img src="{{ Vite::asset('resources/images/card-americanexpress.svg') }}"
                                        class="align-self-center me-3" alt="americanexpress">
                                    <div class="me-auto">
                                        <div class="fw-bold title">American Express</div>
                                        <p class="sub-title mb-0">Expires on 12/2025</p>
                                    </div>
                                    <span class="badge badge-success align-self-center me-3">Primary</span>
                                </div>

                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <img src="{{Vite::asset('resources/images/card-mastercard.svg')}}"
                                        class="align-self-center me-3" alt="mastercard">
                                    <div class="me-auto">
                                        <div class="fw-bold title">Mastercard</div>
                                        <p class="sub-title mb-0">Expires on 03/2025</p>
                                    </div>
                                </div>

                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <img src="{{Vite::asset('resources/images/card-visa.svg')}}"
                                        class="align-self-center me-3" alt="visa">
                                    <div class="me-auto">
                                        <div class="fw-bold title">Visa</div>
                                        <p class="sub-title mb-0">Expires on 10/2025</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div> --}}

            @if ((Auth::user()->role) >= 4)
            <div id="OuroModal" class="modal animated fadeInDown" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <form action="{{ route('ouro-create-liberation', $user->id) }}" method="POST"
                            id="liberation_form" class="py-12">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Liberação Ouro Moderno</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>


                            <div class="modal-body">
                                <div class="col-xxl-12 col-md-12 mb-4 mt-4">
                                    <div class="col-xxl-12 col-md-12 mb-4 mt-4">
                                        <label for="users_list_tags mt-4">Liberação de Combos</label>
                                        <input name='users_list_tags'>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-12 mb-4 mt-4">
                                    <div class="col-xxl-12 col-md-12 mb-4 mt-4">
                                        <label for="course_list mt-4">Liberação de Cursos</label>
                                        <input name='course_list'>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                {{--<button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>--}}
                                <button type="button" href="javascript:void(0);"
                                    onClick="document.getElementById('liberation_form').submit();"
                                    class="btn btn-success">Liberar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="desbloquearOuroModal" class="modal animated fadeInDown" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form action="{{ route('ouro-desblock', $user->id) }}" method="POST" id="ouro_desblock"
                        class="py-12">
                        @csrf

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Desbloquear Ouro</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>

                            </div>

                            <div class="modal-body">
                                <p class="modal-text">Você tem certeza que deseja prosseguir com o desbloqueio
                                    do usuário?<br><br>
                                    Preencha as informações para prosseguir.
                            </div>
                            <div class="modal-body mt-0 pt-0">
                                <label for="users_list_tags mt-4">Motivo do Desbloqueio:</label>
                                <textarea class="form-control" name="obs" id="obs" rows="3" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>
                                <button type="send" class="btn btn-danger">Desbloquear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="bloquearOuroModal" class="modal animated fadeInDown" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form action="{{ route('ouro-block', $user->id) }}" method="POST" id="ouro_block" class="py-12">
                        @csrf

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Bloqueio Ouro</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>

                            </div>

                            <div class="modal-body">
                                <p class="modal-text">Você tem certeza que deseja prosseguir com o bloqueio
                                    do usuário?<br><br>
                                    Preencha as informações para prosseguir.
                            </div>
                            <div class="modal-body mt-0 pt-0">
                                <label for="type"> Motivo do Bloqueio:</label>
                                <select name="motivo" id="motivo" class="form-control mb-4" required>
                                    <option value="">Escolha uma Opção</option>
                                    <option value="Pagamento atrasado">Pagamento atrasado</option>
                                    <option value="Cancelamento">Cancelamento</option>
                                </select>
                                <label for="users_list_tags mt-4">Observações:</label>
                                <textarea class="form-control" name="obs" id="obs" rows="3" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>
                                <button type="send" class="btn btn-danger">Bloquear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="desbloquearCademiModal" class="modal animated fadeInDown" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form action="{{ route('cademi-desblock', $user->id) }}" method="POST" id="cademi_desblock"
                        class="py-12">
                        @csrf

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Desbloquear Cademi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>

                            </div>

                            <div class="modal-body">
                                <p class="modal-text">Você tem certeza que deseja prosseguir com o desbloqueio
                                    do usuário?<br><br>
                                    Preencha as informações para prosseguir.
                            </div>
                            <div class="modal-body mt-0 pt-0">
                                <label for="users_list_tags mt-4">Motivo do Desbloqueio:</label>
                                <textarea class="form-control" name="obs" id="obs" rows="3" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>
                                <button type="send" class="btn btn-danger">Desbloquear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="bloquearCademiModal" class="modal animated fadeInDown" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form action="{{ route('cademi-block', $user->id) }}" method="POST" id="ouro_block" class="py-12">
                        @csrf

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Bloqueio Cademi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>

                            </div>

                            <div class="modal-body">
                                <p class="modal-text">Você tem certeza que deseja prosseguir com o bloqueio
                                    do usuário?<br><br>
                                    Preencha as informações para prosseguir.
                            </div>
                            <div class="modal-body mt-0 pt-0">
                                <label for="type"> Motivo do Bloqueio:</label>
                                <select name="motivo" id="motivo" class="form-control mb-4" required>
                                    <option value="">Escolha uma Opção</option>
                                    <option value="Pagamento atrasado">Pagamento atrasado</option>
                                    <option value="Cancelamento">Cancelamento</option>
                                </select>
                                <label for="users_list_tags mt-4">Observações:</label>
                                <textarea class="form-control" name="obs" id="obs" rows="3" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>
                                <button type="send" class="btn btn-danger">Bloquear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div id="desbloquearModal" class="modal animated fadeInDown" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Desbloquear Usuário</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>

                        <div class="modal-body">
                            @isset($user->cademis->first()->user)
                            <p class="modal-text">Siga as etapas abaixo antes de prosseguir?<br><br>1º
                                Ative as compras
                                do usuário na Cademi <a class="btn btn-secondary  mb-2 me-4 btn-sm" target="_blank"
                                    href="https://profissionaliza.cademi.com.br/office/usuario/perfil/compras/{{ $user->cademis->first()->user }}">Compras</a>
                            </p>
                            <p>2º Clique em desbloquear</p>
                            @endisset
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>
                            <button type="button" href="javascript:void(0);"
                                onClick="document.getElementById('active_form').submit();"
                                class="btn btn-success">Desbloquear</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="ObsModal" class="modal animated fadeInDown" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <form action="{{ route('user.obs.create', $user->id) }}" method="POST" id="obs_create"
                            class="py-12">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Cadastro de Observações</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>


                            <div class="modal-body">
                                <div class="col-xxl-12 col-md-12">
                                    <div class="col-xxl-12 col-md-12">
                                        <label for="users_list_tags mt-4">Observações:</label>
                                        <textarea class="form-control" name="descricao" id="descricao"
                                            rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                {{--<button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>--}}
                                <button type="button" href="javascript:void(0);"
                                    onClick="document.getElementById('obs_create').submit();"
                                    class="btn btn-success">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @endif
            @if ((Auth::user()->role) >= 6)
            <div id="vendedorModal" class="modal animated fadeInDown" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Criar Vendedor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <form action="{{getRouterValue();}}/app/user/profile/{{ $user->id }}/seller_create"
                            method="POST" id="create_seller_form" class="py-12">
                            @csrf
                            <div class="modal-body">
                                <h6 class="modal-text mb-4">Se você realmente quer tornar esse usuário
                                    vendedor escolha
                                    o tipo de vendedor e clique em <b>Criar</b></h6>
                                <label for="type"> Tipo de Vendedor:</label>
                                <select name="type" id="type" class="form-control mb-4">
                                    @foreach ($seller_types as $types)
                                    <option value={{ $types->id }}>{{ $types->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>
                            <button type="button" href="javascript:void(0);"
                                onClick="document.getElementById('create_seller_form').submit();"
                                class="btn btn-primary">Criar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="vendedordModal" class="modal animated fadeInDown" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Criar Vendedor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <form action="{{getRouterValue();}}/app/user/profile/{{ $user->id }}/seller_delete"
                            method="POST" id="delete_seller_form" class="py-12">
                            @csrf
                            <div class="modal-body">
                                <h6 class="modal-text mb-4">Se você realmente deseja excluir esse
                                    vendedor, apenas a
                                    função vendedor será removida o acesso como usuário permanece
                                    normal.<br><br>Para
                                    prosseguir clique em <b>Excluir</b></h6>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>
                            <button type="button" href="javascript:void(0);"
                                onClick="document.getElementById('delete_seller_form').submit();"
                                class="btn btn-primary">Excluir</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif


            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>

                <script src="{{asset('plugins/clipboard/clipboard.min.js')}}"></script>
                <script type="module" src="{{asset('plugins/clipboard/custom-clipboard.min.js')}}">
                </script>

                <script src="{{asset('plugins/tagify/tagify.min.js')}}"></script>



                <script>
                    const ps1 = new
                    PerfectScrollbar('#table1');
                    const ps2 = new
                    PerfectScrollbar('#messages');
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
                @foreach ($ouro_courses as $ouro_course)
                        {
                        "value": "{{$ouro_course->course_id}}",
                        "name": "{{$ouro_course->name}}",
                        "info": "Id: {{$ouro_course->course_id}} | M: {{$ouro_course->modulo}} | A: {{$ouro_course->aulas}} | hs: {{$ouro_course->carga}}"
                        },
                @endforeach
            ]
            });
                </script>

                <script>
                    /**
        * 
        * Users List
        *  
        **/ 


        // https://www.mockaroo.com/


        var inputElm = document.querySelector('input[name=users_list_tags]');

function tagTemplate(tagData){
    return `
        <tag title="${tagData.email}"
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
            <span>${tagData.courses}</span>
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
        searchKeys: ['name', 'courses']  // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: tagTemplate,
        dropdownItem: suggestionItemTemplate
    },
    whitelist: [
        @foreach($ouro_combos as $ouro_combo)
        {
            "value": "{{$ouro_combo->id}}",
            "name": "{{$ouro_combo->name}}",
            "courses": @json($ouro_combo->courses, JSON_PRETTY_PRINT)
        },
        @endforeach
    ]
});

                </script>



                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>