<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>
    
    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-four  mb-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg><span class="inner-text">Home</span></a></li>
            <li class="breadcrumb-item"><a href="#">Aluno</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lista</li>
            </ol>
            </nav>
    </div>
    <!-- /BREADCRUMB -->

    
    
    <div class="seperator-header layout-top-spacing">
        <h4 class="">Lista de Usuários Ativos</h4>
    </div>


    
    <div class="row layout-top-spacing">
            
        <form action="{{ getRouterValue(); }}/app/user/search" name="search" class="input-group mb-3" aria-label="Text input with dropdown button" method="post" role="search" >
            @csrf
            <input type="text" placeholder="Pesquisar..." name="search" class="form-control" aria-label="Text input with dropdown button">
            <button type="submit" class="btn btn-primary" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
        </form>

        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Lista de Alunos</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">Cidade - UF</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Pagamento</th>
                                <th class="text-center dt-no-sorting">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->username }} 
                                    @if($user->first == 2)
                                    <div class="badge badge-success badge-dot"></div>
                                    @elseif($user->first == 3)
                                    <div class="badge badge-danger badge-dot"></div>
                                    @endif
                                </td>
                                <td>{{ $user->name }} {{ $user->lastname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->cellphone }}</td>
                                <td>{{ $user->city }} - {{ $user->uf }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="usr-img-frame mr-2 rounded-circle">
                                            <span><img src="{{ asset($user->image) }}" class="rounded-circle profile-img" alt="avatar"></span>
                                        </div>
                                    </div>
                                </td>

                                @if ($user->payment == "CARTÃO")
                                <td class="text-center"><span class="shadow-none badge badge-success">Cartão</span></td>
                                @elseif ($user->payment == "BOLETO")
                                <td class="text-center"><span class="shadow-none badge badge-primary">Boleto</span></td>
                                @else
                                <td class="text-center"><span class="shadow-none badge badge-dark">Vazio</span></td>
                                @endif

                                <td class="text-center">
                                        <div class="action-btns">
                                            <a href="{{ getRouterValue(); }}/app/user/profile/{{ $user->id }}" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Ver">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="green"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            </a>
                                            <a href="{{ getRouterValue(); }}/app/user/profile/{{ $user->id }}/edit" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="orange"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                            </a>
                                        </div>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    
                    <div class="row">
                        <div class="col-md-12">
                            {{ $users->appends($_POST)->links('pagination::bootstrap-5') }}

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