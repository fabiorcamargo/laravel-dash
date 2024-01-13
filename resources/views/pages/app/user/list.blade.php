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

            @vite(['resources/scss/light/assets/components/modal.scss'])
            @vite(['resources/scss/dark/assets/components/modal.scss'])

            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])

            @vite(['resources/scss/light/assets/components/list-group.scss'])
            @vite(['resources/scss/light/assets/users/user-profile.scss'])
            @vite(['resources/scss/dark/assets/components/list-group.scss'])
            @vite(['resources/scss/dark/assets/users/user-profile.scss'])

            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <div class="row layout-spacing">
                <!-- Content -->
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-top-spacing">
                    <div class="user-profile">
                        <div class="widget-content widget-content-area">
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-4">Lista de Alunos</h3>
                                {{--<a data-bs-toggle="modal" href="" data-bs-target="#OuroComboCreateModal"
                                    class="mt-2 edit-profile" data-toggle="tooltip" data-placement="top"
                                    title="Criar Combo">
                                    <x-widgets._w-svg svg="text-plus" />
                                </a>--}}
                            </div>
                            <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
                                <div class="widget-header">
                                    <div class="row dt--top-section">
                                        <div
                                            class="col-12 col-lg-8 col-sm-12 d-flex justify-content-sm-start justify-content-center">
                                            <div class="col-12 col-sm-12">
                                                <div class="btn-group mb-4 mr-2">
                                                    @if (app('request')->input('secretary') == "")
                                                    <button class="btn btn-outline-dark btn-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Secretaria<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </button>
                                                    @else
                                                    <button class="btn btn-outline-dark btn-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        {{app('request')->input('secretary')}}<svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </button>
                                                    @endif
                                                    <div class="dropdown-menu">
                                                        <a href="{{ getRouterValue(); }}/app/user/search?secretary=MGA @foreach(app('request')->input() as $key =>$value) @if($key != "
                                                            _token" && $key !="secretary" ){{"&$key=$value"}}@endif
                                                            @endforeach" class="dropdown-item">MGA</a>
                                                        <a href="{{ getRouterValue(); }}/app/user/search?secretary=TB @foreach(app('request')->input() as $key =>$value) @if($key != "
                                                            _token" && $key !="secretary" ){{"&$key=$value"}}@endif
                                                            @endforeach" class="dropdown-item">TB</a>
                                                        <a href="{{ getRouterValue(); }}/app/user/search?secretary=UMU @foreach(app('request')->input() as $key =>$value) @if($key != "
                                                            _token" && $key !="secretary" ){{"&$key=$value"}}@endif
                                                            @endforeach" class="dropdown-item">UMU</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="{{Request::url()}}?{{app('request')->input('payment') != null ? "
                                                            &payment=" . app('request')->input('payment') : ""}}"
                                                            class="dropdown-item">Limpar</a>
                                                    </div>
                                                </div>
                                                <div class="btn-group mb-4 mr-2">
                                                    @if (app('request')->input('payment') == "")
                                                    <button class="btn btn-outline-dark btn-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Pagamento<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </button>
                                                    @else
                                                    <button class="btn btn-outline-dark btn-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        {{app('request')->input('payment')}}<svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </button>
                                                    @endif
                                                    <div class="dropdown-menu">
                                                        <a href="{{ getRouterValue(); }}/app/user/search?payment=CARTÃO @foreach(app('request')->input() as $key =>$value) @if($key != "
                                                            _token" && $key !="payment" ){{"&$key=$value"}}@endif
                                                            @endforeach" class="dropdown-item">CARTÃO</a>
                                                        <a href="{{ getRouterValue(); }}/app/user/search?payment=BOLETO @foreach(app('request')->input() as $key =>$value) @if($key != "
                                                            _token" && $key !="payment" ){{"&$key=$value"}}@endif
                                                            @endforeach" class="dropdown-item">BOLETO</a>
                                                        <a href="{{ getRouterValue(); }}/app/user/search?payment=PIX @foreach(app('request')->input() as $key =>$value) @if($key != "
                                                            _token" && $key !="payment" ){{"&$key=$value"}}@endif
                                                            @endforeach" class="dropdown-item">PIX</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="{{Request::url()}}?{{app('request')->input('secretary') != null ? "
                                                            &secretary=" . app('request')->input('secretary') : ""}}"
                                                            class="dropdown-item">Limpar</a>
                                                    </div>
                                                </div>
                                                {{--<div class="btn-group mb-4 mr-2">
                                                    @if (app('request')->input('ouro') == "")
                                                    <button class="btn btn-outline-dark btn-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Ouro<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </button>
                                                    @else
                                                    <button class="btn btn-outline-dark btn-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        {{app('request')->input('ouro')}}<svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </button>
                                                    @endif
                                                    <div class="dropdown-menu">
                                                        <a href="{{ getRouterValue(); }}/app/user/search?ouro=Sim @foreach(app('request')->input() as $key =>$value) @if($key != "
                                                            _token" && $key !="ouro" ){{"&$key=$value"}}@endif
                                                            @endforeach" class="dropdown-item">SIM</a>
                                                        <a href="{{ getRouterValue(); }}/app/user/search?ouro=10 @foreach(app('request')->input() as $key =>$value) @if($key != "
                                                            _token" && $key !="ouro" ){{"&$key=$value"}}@endif
                                                            @endforeach" class="dropdown-item">10 Cursos</a>
                                                        {{--<a
                                                            href="{{Request::url()}}?{{app('request')->input('secretary') != null ? "
                                                            &secretary=" . app('request')->input('secretary') : ""}}"
                                                            class="dropdown-item">NÃO</a>

                                                        <div class="dropdown-divider"></div>
                                                        <a href="{{Request::url()}}?{{app('request')->input('secretary') != null ? "
                                                            &secretary=" . app('request')->input('secretary') : ""}}"
                                                            class="dropdown-item">Limpar</a>
                                                    </div>

                                                </div>--}}
                                                <div class="btn-group mx-2 mb-4 mr-2">
                                                    <a href="{{Request::url()}}" class="dropdown-item">Limpar</a>
                                                </div>


                                            </div>
                                        </div>
                                        <div
                                            class="col-12 col-lg-4 col-sm-12 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3">
                                            <form action="{{ getRouterValue(); }}/app/user/search" name="search"
                                                class="input-group mb-3" aria-label="Text input with dropdown button"
                                                method="GET" role="search">
                                                <div class="input-group mb-3 ms-auto">
                                                    <input type="text" class="form-control" name="username"
                                                        placeholder="Id do Aluno" aria-label="Id do Aluno"
                                                        aria-describedby="button-addon2">
                                                    <button type="submit" class="btn btn-primary" type="button"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-search">
                                                            <circle cx="11" cy="11" r="8"></circle>
                                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                                        </svg></button>
                                                    <button class="btn btn-outline-dark btn-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <x-widgets._w-svg svg="filter" />
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <div class="widget-content widget-content-area">

                                                            <div role="menu" class="collapsed" data-bs-toggle="collapse"
                                                                data-bs-target="#defaultAccordion" aria-expanded="false"
                                                                aria-controls="defaultAccordion">
                                                                <div class="input-group mb-3 ms-auto">
                                                                    <input type="text" class="form-control" name="name"
                                                                        placeholder="Nome" aria-label="Nome"
                                                                        aria-describedby="button-addon2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        type="button"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="feather feather-search">
                                                                            <circle cx="11" cy="11" r="8"></circle>
                                                                            <line x1="21" y1="21" x2="16.65" y2="16.65">
                                                                            </line>
                                                                        </svg></button>
                                                                </div>
                                                                <div class="input-group mb-3 ms-auto">
                                                                    <input type="text" class="form-control"
                                                                        name="lastname" placeholder="Sobrenome"
                                                                        aria-label="Sobrenome"
                                                                        aria-describedby="button-addon2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        type="button"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="feather feather-search">
                                                                            <circle cx="11" cy="11" r="8"></circle>
                                                                            <line x1="21" y1="21" x2="16.65" y2="16.65">
                                                                            </line>
                                                                        </svg></button>
                                                                </div>
                                                                <div class="input-group mb-3 ms-auto">
                                                                    <input type="text" class="form-control" name="city"
                                                                        placeholder="Cidade" aria-label="Cidade"
                                                                        aria-describedby="button-addon2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        type="button"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="feather feather-search">
                                                                            <circle cx="11" cy="11" r="8"></circle>
                                                                            <line x1="21" y1="21" x2="16.65" y2="16.65">
                                                                            </line>
                                                                        </svg></button>
                                                                </div>
                                                                <div class="input-group mb-3 ms-auto">
                                                                    <input type="text" class="form-control" name="uf"
                                                                        placeholder="UF" aria-label="UF"
                                                                        aria-describedby="button-addon2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        type="button"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="feather feather-search">
                                                                            <circle cx="11" cy="11" r="8"></circle>
                                                                            <line x1="21" y1="21" x2="16.65" y2="16.65">
                                                                            </line>
                                                                        </svg></button>
                                                                </div>
                                                            </div>
                                                            <a href="{{Request::url()}}?{{app('request')->input('payment') != null ? "
                                                                &payment=" . app('request')->input('payment') : ""}}"
                                                                class="dropdown-item">Limpar</a>

                                                        </div>


                                                    </div>
                                                </div>
                                                {{--}}
                                                @foreach (app('request')->input() as $key => $filter)
                                                @if($key == $filter)
                                                <input type="text" name="{{$key}}" id="{{$key}}" value="{{$filter}}">
                                                @endif
                                                @endforeach--}}
                                            </form>
                                        </div>

                                    </div>
                                </div>

                                <div class="widget-content widget-content-area">
                                    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing mt-2">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Aluno</th>
                                                        {{--<th scope="col">Nome</th>--}}
                                                        {{--<th scope="col">Email</th>--}}
                                                        {{--<th scope="col">Telefone</th>--}}
                                                        <th scope="col">Cidade - UF</th>
                                                        {{--<th class="text-center">Image</th>--}}
                                                        {{--<th class="text-center">Pagamento</th>--}}
                                                        <th class="text-center dt-no-sorting">Ação</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($users as $user)
                                                    <tr>
                                                        <td>
                                                            <a class="media"
                                                                href="{{ getRouterValue(); }}/app/user/profile/{{ app('request')->input('ouro') != "" ? $user->user_id : $user->id }}"
                                                                class="action-btn btn-view bs-tooltip me-2"
                                                                data-toggle="tooltip" data-placement="top" title="Ver">
                                                                <div class="media">
                                                                    <div class="avatar me-2">
                                                                        <img alt="avatar"
                                                                            src="{{ asset($user->image) }}"
                                                                            class="rounded-circle">
                                                                    </div>
                                                                    <div class="media-body align-self-center">
                                                                        <h6 class="mb-0">{{ $user->name }} {{
                                                                            $user->lastname }}</h6>
                                                                        <h6 class="mb-0">{{ $user->username }}</h6>
                                                                        <h6 class="mb-0">{{ $user->email }}</h6>
                                                                        <h6 class="mb-2">{{ $user->city }} - {{
                                                                            $user->uf }}</h6>
                                                                        @if($user->first == 2)
                                                                        <div class="badge badge-success badge-dot">
                                                                            {{$user->secretary}}</div>
                                                                        @elseif($user->first == 3)
                                                                        <div class="badge badge-danger badge-dot">
                                                                            {{$user->secretary}}</div>
                                                                        @else
                                                                        <div class="badge badge-warning badge-dot">
                                                                            {{$user->secretary}}</div>
                                                                        @endif
                                                                        @if ($user->payment == "CARTÃO")
                                                                        <div class="shadow-none badge badge-success">
                                                                            Cartão</div>
                                                                        @elseif ($user->payment == "BOLETO")
                                                                        <div class="shadow-none badge badge-primary">
                                                                            Boleto</div>
                                                                        @else
                                                                        <div class="shadow-none badge badge-dark">Vazio
                                                                        </div>
                                                                        @endif
                                                                        @if($user->ouro == 1)
                                                                        <span class="badge badge-light-info mb-2">10
                                                                            Cursos</span>
                                                                        @endif
                                                                        @if($user->cademis()->first())
                                                                        @if($user->first < 3) <span
                                                                            class="badge badge-success mb-2">
                                                                            Cademi</span>
                                                                            @elseif($user->first == 4)
                                                                            <span
                                                                                class="badge badge-success mb-2">Cademi</span>
                                                                            @else
                                                                            <span
                                                                                class="badge badge-danger mb-2">Cademi</span>
                                                                            @endif
                                                                            @endif
                                                                            @if ($user->client_ouro()->first() ||
                                                                            $user->ouro_id !== null)
                                                                            @if($user->first < 4) <span
                                                                                class="badge badge-success position-relative btn-icon mb-2">
                                                                                Ouro
                                                                                @else
                                                                                <span
                                                                                    class="badge badge-danger position-relative btn-icon mb-2">Ouro
                                                                                    @endif
                                                                                    <span
                                                                                        class="badge badge-dark counter">{{$user->client_ouro()->first()->matricula_ouro()->count()}}</span>
                                                                                </span>
                                                                                @endif
                                                                                @if($user->accountable()->first())
                                                                                <span class="badge badge-success mb-2">
                                                                                    <x-widgets._w-svg class="text-white"
                                                                                        svg="currency-real" />
                                                                                </span>
                                                                                @endif

                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        {{--<td>{{ $user->name }} {{ $user->lastname }}</td>--}}
                                                        {{--<td>{{ $user->email }}</td>--}}
                                                        {{--<td>{{ $user->cellphone }}</td>--}}
                                                        <td>
                                                            {{ $user->city2 }} - {{ $user->uf2 }} <br>
                                                        </td>
                                                        {{--}}
                                                        <td>
                                                            <div class="d-flex">
                                                                <div class="usr-img-frame mr-2 rounded-circle">
                                                                    <span><img src="{{ asset($user->image) }}"
                                                                            class="rounded-circle profile-img"
                                                                            alt="avatar"></span>
                                                                </div>
                                                            </div>
                                                        </td>--}}
                                                        {{--}}
                                                        @if ($user->payment == "CARTÃO")
                                                        <td class="text-center"><span
                                                                class="shadow-none badge badge-success">Cartão</span>
                                                        </td>
                                                        @elseif ($user->payment == "BOLETO")
                                                        <td class="text-center"><span
                                                                class="shadow-none badge badge-primary">Boleto</span>
                                                        </td>
                                                        @else
                                                        <td class="text-center"><span
                                                                class="shadow-none badge badge-dark">Vazio</span></td>
                                                        @endif--}}

                                                        <td class="text-center">
                                                            <div class="action-btns">
                                                                {{--<a
                                                                    href="{{ getRouterValue(); }}/app/user/profile/{{ $user->id }}"
                                                                    class="action-btn btn-view bs-tooltip me-2"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Ver">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-eye">
                                                                        <path
                                                                            d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                                        </path>
                                                                        <circle cx="12" cy="12" r="3"></circle>
                                                                    </svg>
                                                                </a>--}}
                                                                {{--<a
                                                                    href="{{ getRouterValue(); }}/app/user/ouro/show/{{ $user->id }}"
                                                                    class="action-btn btn-view bs-tooltip me-2"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Ouro">
                                                                    <x-widgets._w-svg svg="apps-filled" />
                                                                </a>--}}
                                                                <a href="{{ getRouterValue(); }}/app/user/profile/{{ $user->id }}/edit"
                                                                    class="action-btn btn-edit bs-tooltip me-2"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Editar">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-edit-2">
                                                                        <path
                                                                            d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                                        </path>
                                                                    </svg>
                                                                </a>
                                                                {{--<a
                                                                    href="{{ getRouterValue(); }}/app/user/profile/{{ $user->id }}/edit"
                                                                    class="action-btn btn-edit bs-tooltip me-2"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Pagamentos">
                                                                    <x-widgets._w-svg svg="cash-banknote" />
                                                                </a>--}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    {{ $users->appends($_GET)->links('pagination::bootstrap-5') }}

                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--  BEGIN CUSTOM SCRIPTS FILE  -->
                        <x-slot:footerFiles>
                            <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
                            <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>

                            </x-slot>
                            <script>

                            </script>
                            <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>