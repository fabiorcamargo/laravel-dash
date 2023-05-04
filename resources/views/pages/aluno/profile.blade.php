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
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Alunos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Perfil</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-success" :status="session('status')" />
    
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
   

    <div class="row layout-spacing ">

        <!-- Content -->
        <div class="col-xl-5 col-md-5 col-sm-12 layout-top-spacing">
            <div class="user-profile">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between">
                        <h3 class="">Perfil do Usuário</h3>
                        <a href="{{getRouterValue();}}/aluno/profile/{{ $user->id }}/edit" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                    </div>
                    
                    <div class="text-center user-info">
                        
                        <img src="{{ asset($user->image) }}" alt="avatar">
                        <p class="">{{ $user->username }} | {{ $user->name }} {{ $user->lastname }}</p>
                        @if ((Auth::user()->role) >= 4)
                        <div id="OuroModal" class="modal animated fadeInDown" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <form action="{{ route('ouro-create-liberation', $user->id) }}" method="POST" id="liberation_form" class="py-12">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Liberação Ouro Moderno</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
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
                                            <button type="button" href="javascript:void(0);" onClick="document.getElementById('liberation_form').submit();" class="btn btn-success">Liberar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="bloquearModal" class="modal animated fadeInDown" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Bloqueio de Usuário</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                          <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </button>
                                    </div>
                
                                    <div class="modal-body">
                                          <p class="modal-text">Você tem certeza que deseja prosseguir com o bloqueio do usuário?<br><br>Para efetuar o desbloqueio siga o procedimento:<br>1º Ative as compras do usuário na Cademi;<br>2º Clique em desbloquear aqui no sistema;</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>
                                        <button type="button" href="javascript:void(0);" onClick="document.getElementById('delete_form').submit();" class="btn btn-danger">Bloquear</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <div id="desbloquearModal" class="modal animated fadeInDown" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Desbloquear Usuário</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                          <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </button>
                                    </div>
                
                                    <div class="modal-body">
                                        @isset($user->cademis->first()->user)  
                                        <p class="modal-text">Siga as etapas abaixo antes de prosseguir?<br><br>1º Ative as compras do usuário na Cademi <a class="btn btn-secondary  mb-2 me-4 btn-sm" target="_blank" href="https://profissionaliza.cademi.com.br/office/usuario/perfil/compras/{{ $user->cademis->first()->user }}">Compras</a></p><p>2º Clique em desbloquear</p>
                                        @endisset
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>
                                        <button type="button" href="javascript:void(0);" onClick="document.getElementById('active_form').submit();" class="btn btn-success">Desbloquear</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                                    @if($user->first == 2)
                                    <form action="{{ route('user-profile-delete', $user->id) }}" method="POST" id="delete_form" class="py-12">
                                        @method('DELETE')
                                        @csrf
                                    <div class="badge badge-success badge-dot"></div>
                                    <a data-bs-toggle="modal" data-bs-target="#bloquearModal"  class="btn btn-danger btn-lg mt-4" data-toggle="tooltip" data-placement="top" title="Bloquear"> Bloquear
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    </a>
                                    </form>
                                    @elseif($user->first == 3)
                                    <form action="{{ route('user-profile-active', $user->id) }}" method="POST" id="active_form" class="py-12">
                                        @method('POST')
                                        @csrf
                                    <div class="badge badge-danger badge-dot"></div>
                                    <a data-bs-toggle="modal" data-bs-target="#desbloquearModal" class="btn btn-success btn-lg mt-4" data-toggle="tooltip" data-placement="top" title="Desbloquear"> Desbloquear
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-unlock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg>
                                    </a>
                                    </form>
                                    @endif
                        @endif
                        @if ($seller == "não")        
                            @if ((Auth::user()->role) >= 6)
                            <div id="vendedorModal" class="modal animated fadeInDown" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Criar Vendedor</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                              <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <form action="{{getRouterValue();}}/app/user/profile/{{ $user->id }}/seller_create"  method="POST" id="create_seller_form" class="py-12">
                                            @csrf
                                        <div class="modal-body">
                                              <h6 class="modal-text mb-4">Se você realmente quer tornar esse usuário vendedor escolha o tipo de vendedor e clique em <b>Criar</b></h6>
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
                                            <button type="button" href="javascript:void(0);" onClick="document.getElementById('create_seller_form').submit();" class="btn btn-primary">Criar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a data-bs-toggle="modal" data-bs-target="#vendedorModal"  class="btn btn-primary btn-lg mt-4" data-toggle="tooltip" data-placement="top" title="Tornar Vendedor"> Tornar Vendedor
                                <x-widgets._w-svg svg="cash-banknote"/>
                            </a>
                            @endif
                        @elseif ($seller == "sim") 
                            @if ((Auth::user()->role) == 8)
                            <div id="vendedordModal" class="modal animated fadeInDown" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Criar Vendedor</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                              <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <form action="{{getRouterValue();}}/app/user/profile/{{ $user->id }}/seller_delete"  method="POST" id="delete_seller_form" class="py-12">
                                            @csrf
                                        <div class="modal-body">
                                              <h6 class="modal-text mb-4">Se você realmente deseja excluir esse vendedor, apenas a função vendedor será removida o acesso como usuário permanece normal.<br><br>Para prosseguir clique em <b>Excluir</b></h6>
                                        </div>
                                        </form>
                                        <div class="modal-footer">
                                            <button class="btn btn-light-dark" data-bs-dismiss="modal">Sair</button>
                                            <button type="button" href="javascript:void(0);" onClick="document.getElementById('delete_seller_form').submit();" class="btn btn-primary">Excluir</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a data-bs-toggle="modal" data-bs-target="#vendedordModal"  class="btn btn-warning btn-lg mt-4" data-toggle="tooltip" data-placement="top" title="Remover Vendedor"> Remover Vendedor
                                <x-widgets._w-svg svg="cash-banknote"/>
                            </a>
                            @endif
                        @endif
                    </div>
                    <div class="user-info-list">
                        

                        <div class="">
                            <ul class="contacts-block list-unstyled">
                               {{-- <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-coffee me-3"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg> Web Developer
                                </li> --}}
                                <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar me-3"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>{{ $user->created_at->format('d-m-Y H:i') }}
                                </li>
                                <li class="contacts-block__item">
                                    <a href="mailto:{{ $user->email }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail me-3"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>{{ $user->email }}</a>
                                </li>
                                <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone me-3"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> {{ $user->cellphone }}
                                </li>
                                @if ((Auth::user()->role) == 7 || (Auth::user()->role) == 8)
                                <li class="contacts-block__item">
                                    <a href="mailto:{{ $user->email2 }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail me-3"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>{{ $user->email2 }}</a>
                                </li>
                                <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone me-3"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> {{ $user->cellphone2 }}
                                </li>
                                @endif
                                <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin me-3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>{{ $user->city }} - {{ $user->uf }}
                                </li>
                                <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart me-3"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg> {{ $user->seller }}
                                </li>
                                <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users me-3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> {{ $user->secretary }}
                                </li>
                                <li class="contacts-block__item">
                                    <div class="form-group">
                                        <input class="form-check-input me-1" id="ouro" name="ouro" type="checkbox" @if ($user->ouro == 1 ) checked @endif disabled>
                                        Contratou 10 Cursos
                                    </div>
                                </li>

                                @isset($cademi->login_auto)
                                <li class="contacts-block__item">
                                   <a href="{{ $cademi->login_auto }}" target="blank"  class="btn btn-secondary  _effect--ripple waves-effect waves-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                                        <span class="btn-text-inner">Acesse seu Curso</span>
                                   </a>    
                                </li>

                                
                                
                                <li class="contacts-block__item">
                                    @if ((Auth::user()->role) == 4 || (Auth::user()->role) == 8)
                                    <div class="clipboard">
                                        
                                        <li class="contacts-block__item">
                                            <a href="https://profissionaliza.cademi.com.br/office/usuario/perfil/{{ $user->cademis->first()->user }}" target="blank" class="btn btn-danger  _effect--ripple waves-effect waves-light">
                                                <x-widgets._w-svg svg="user-search"/>
                                                 <span class="btn-text-inner">Perfil do Aluno na Cademi</span>
                                            </a>    
                                         </li>
                                        <form class="form-horizontal">
                                            <div class="clipboard-input">
                                                <input type="text" class="form-control inative" id="copy-basic-input" value="{{ $cademi->login_auto }}" readonly>
                                                <div class="copy-icon jsclipboard cbBasic" data-bs-trigger="click" title="Copied" data-clipboard-target="#copy-basic-input"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    
                                    @endif
                                </li>
                                @endisset
                            </ul>
                            
                            
                            {{--
                            <ul class="list-inline mt-4">
                                <li class="list-inline-item mb-0">
                                    <a class="btn btn-info btn-icon btn-rounded" href="javascript:void(0);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                                    </a>
                                </li>
                                <li class="list-inline-item mb-0">
                                    <a class="btn btn-danger btn-icon btn-rounded" href="javascript:void(0);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dribbble"><circle cx="12" cy="12" r="10"></circle><path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"></path></svg>
                                    </a>
                                </li>
                                <li class="list-inline-item mb-0">
                                    <a class="btn btn-dark btn-icon btn-rounded" href="javascript:void(0);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                                    </a>
                                </li>
                            </ul>
                            --}}
                                                           
                        </div>
                    </div>
                </div>
            </div>

        <div class="col-xl-7 col-md-7 col-sm-12 layout-top-spacing">

            <div class="user-profile">
                <div class="widget-content widget-content-area">

                    <div class="d-flex justify-content-between">
                        <h3 class="md-2">Cursos Liberados</h3>
                        {{--<a href="{{getRouterValue();}}/app/user/profile/{{ $user->id }}/courses" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="green" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>--}}
                    </div>

                    <div id="toggleAccordion" class="accordion mt-4">
                        @foreach ($courses as $course)
                            <div class="card">
                                <div class="card-header" id="...">
                                    <section class="mb-0 mt-0">
                                        <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#defaultAccordion{{ $course['row'] }}" aria-expanded="false" aria-controls="defaultAccordion{{ $course['row'] }}">
                                            <p class="text-success"> {{ $course['name'] }}   |  {{ $course['perc'] }} </p>  <div class="icons"><svg> ... </svg></div>
                                        </div>
                                    </section>
                                </div>
                                
                                        <div id="defaultAccordion{{ $course['row'] }}" class="collapse" aria-labelledby="..." data-bs-parent="#toggleAccordion">
                                            <div class="card-body">
                                            
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ $course['name'] }}</td>
                                                                <td>                                                    
                                                                    <div class="progress br-30">
                                                                        <div class="progress-bar br-30 bg-secondary" role="progressbar" style="width: {{ $course['perc'] }}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </td>
                                                                <td><p class="text-secondary">{{ $course['perc'] }}</p></td>
                                                               
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
                                                                    <td><p class="text-secondary">{{$aula['data']}}</p></td>
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
                            <a data-bs-toggle="modal" href="" data-bs-target="#OuroModal" class="mt-2 edit-profile" data-toggle="tooltip" data-placement="top" title="Adicionar Cursos">
                            <x-widgets._w-svg svg="apps-filled"/>
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
                                        <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#defaultAccordion{{ $course['row'] }}" aria-expanded="false" aria-controls="defaultAccordion{{ $course['row'] }}">
                                            <p class="text-success"> {{ $course['ouro_course_id'] }}   |  {{ $course['name'] }} </p>  <div class="icons"><svg> ... </svg></div>
                                        </div>
                                    </section>
                                </div>
                                {{--}}
                                        <div id="defaultAccordion{{ $course['row'] }}" class="collapse" aria-labelledby="..." data-bs-parent="#toggleAccordion">
                                            <div class="card-body">
                                            
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ $course['name'] }}</td>
                                                                <td>                                                    
                                                                    <div class="progress br-30">
                                                                        <div class="progress-bar br-30 bg-secondary" role="progressbar" style="width: {{ $course['perc'] }}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </td>
                                                                <td><p class="text-secondary">{{ $course['perc'] }}</p></td>
                                                               
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
                                                                    <td><p class="text-secondary">{{$aula['data']}}</p></td>
                                                                </tr>
                                                                @endforeach
                                                            @endisset

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>    --}}
                                
                            </div>
                                
                            
                        @endforeach
                    </div>
                </div>
               
            </div>
            @endif
            
            
            
        </div>
        @if ((Auth::user()->role) == 4 || (Auth::user()->role) == 8)
        <div class="summary layout-spacing pt-4">
            <div class="widget-content widget-content-area">
                <h3 class="">Observações</h3>
                <div class="order-summary">

                    <div class="summary-list summary-income">
                        <p>{!!$user->observation!!}</p>
                        {{--
                        <div class="summery-info">

                            <div class="w-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            </div>

                            <div class="w-summary-details">

                                <div class="w-summary-info">
                                    <h6>Income <span class="summary-count">$92,600 </span></h6>
                                    <p class="summary-average">90%</p>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="summary-list summary-profit">

                        <div class="summery-info">

                            <div class="w-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            </div>
                            
                            <div class="w-summary-details">

                                <div class="w-summary-info">
                                    <h6>Profit <span class="summary-count">$37,515</span></h6>
                                    <p class="summary-average">65%</p>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="summary-list summary-expenses">

                        <div class="summery-info">

                            <div class="w-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                            </div>
                            <div class="w-summary-details">

                                <div class="w-summary-info">
                                    <h6>Expenses <span class="summary-count">$55,085</span></h6>
                                    <p class="summary-average">42%</p>
                                </div>

                            </div>

                        </div>

                    </div>
                    --}}

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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                </div>

                                <div class="w-summary-details">

                                    <div class="w-summary-info">
                                        <h6>Income <span class="summary-count">$92,600 </span></h6>
                                        <p class="summary-average">90%</p>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="summary-list summary-profit">

                            <div class="summery-info">

                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                </div>
                                
                                <div class="w-summary-details">

                                    <div class="w-summary-info">
                                        <h6>Profit <span class="summary-count">$37,515</span></h6>
                                        <p class="summary-average">65%</p>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="summary-list summary-expenses">

                            <div class="summery-info">

                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                </div>
                                <div class="w-summary-details">

                                    <div class="w-summary-info">
                                        <h6>Expenses <span class="summary-count">$55,085</span></h6>
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
                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> 5 Days Left</p>
                                </div>
                                <div class="progress-stats"><p class="text-info">$25 / month</p></div>
                            </div>
                            
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 65%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
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
                                <a id="paymentHistory1" href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="paymentHistory1">
                                    <a class="dropdown-item" href="javascript:void(0);">View Invoice</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Download Invoice</a>
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
                                <a id="paymentHistory2" href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="paymentHistory2">
                                    <a class="dropdown-item" href="javascript:void(0);">View Invoice</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Download Invoice</a>
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
                                <a id="paymentHistory3" href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="paymentHistory3">
                                    <a class="dropdown-item" href="javascript:void(0);">View Invoice</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Download Invoice</a>
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
                            <img src="{{ Vite::asset('resources/images/card-americanexpress.svg') }}" class="align-self-center me-3" alt="americanexpress">
                            <div class="me-auto">
                                <div class="fw-bold title">American Express</div>
                                <p class="sub-title mb-0">Expires on 12/2025</p>
                            </div>
                            <span class="badge badge-success align-self-center me-3">Primary</span>
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-start">
                            <img src="{{Vite::asset('resources/images/card-mastercard.svg')}}" class="align-self-center me-3" alt="mastercard">
                            <div class="me-auto">
                                <div class="fw-bold title">Mastercard</div>
                                <p class="sub-title mb-0">Expires on 03/2025</p>
                            </div>
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-start">
                            <img src="{{Vite::asset('resources/images/card-visa.svg')}}" class="align-self-center me-3" alt="visa">
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

    
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/clipboard/clipboard.min.js')}}"></script>
        <script type="module" src="{{asset('plugins/clipboard/custom-clipboard.min.js')}}"></script>

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
                @foreach ($ouro_courses as $ouro_course)
                        {
                        "value": "{{$ouro_course->course_id}}",
                        "name": "{{$ouro_course->name}}",
                        "info": "Id: {{$ouro_course->course_id}} | M: {{$ouro_course->modulo}} | A: {{$ouro_course->aulas}} | hs: {{$ouro_course->carga}}"
                        },
                @endforeach
            ]
            })

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
})

        </script>
        
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>