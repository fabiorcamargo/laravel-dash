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
            <li class="breadcrumb-item"><a href="#">Eco</a></li>
            <li class="breadcrumb-item active" aria-current="page">Vendas</li>
            </ol>
            </nav>
    </div>
    <!-- /BREADCRUMB -->

    
    
    <div class="seperator-header layout-top-spacing">
        <h4 class="">Lista de Vendas</h4>
    </div>


    
    <div class="row layout-top-spacing">
            
        <form action="{{ getRouterValue(); }}/app/eco/list_sales/search" name="search" class="input-group mb-3" aria-label="Text input with dropdown button" method="post" role="search" >
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
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">Vendedor</th>
                                <th scope="col">Código</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Status</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($sales as $sale)
                            <tr>
                                <td>{{ $sale->name }}</td>
                                <td>{{ $sale->email }}</td>
                                <td>{{ $sale->cellphone }}</td>
                                <td>{{ $sale->seller }}</td>
                                <td>{{ $sale->codesale }}</td>
                                
                                
                                @if ($sale->venda->billingType == "CREDIT_CARD")
                                <td class="text-center"><span class="shadow-none badge badge-success">Cartão</span></td>
                                @elseif ($sale->venda->billingType == "BOLETO")
                                <td class="text-center"><span class="shadow-none badge badge-primary">Boleto</span></td>
                                @else
                                <td class="text-center"><span class="shadow-none badge badge-dark">Vazio</span></td>
                                @endif

                                @if ($sale->status == "CONFIRMED")
                                <td class="text-center"><span class="shadow-none badge badge-success">Confirmado</span></td>
                                @elseif ($sale->status == "PENDING")
                                <td class="text-center"><span class="shadow-none badge badge-warning">Pendente</span></td>
                                @elseif ($sale->status == "RECUSED")
                                <td class="text-center"><span class="shadow-none badge badge-danger">Recusado</span></td>
                                @endif

                                <td>R${{ $sale->installmentValue }} em {{ $sale->installmentCount }}x</td>
                                
                                <td class="text-center">
                                        <div class="action-btns">
                                            <a href="{{ getRouterValue(); }}/app/user/profile/{{ $sale->user_id }}" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Ver">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            </a>
                                            <a href="{{ getRouterValue(); }}/app/user/profile/{{ $sale->user_id }}/edit" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                            </a>
                                        </div>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    
                    <div class="row">
                        <div class="col-md-12">
                            {{ $sales->appends($_POST)->links('pagination::bootstrap-5') }}

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