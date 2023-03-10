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

        <link rel="stylesheet" href="{{asset('plugins/apex/apexcharts.css')}}">

        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/widgets/modules-widgets.scss'])

        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/widgets/modules-widgets.scss'])
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
            <li class="breadcrumb-item"><a href="#">Campaign</a></li>
            <li class="breadcrumb-item"><a href="#">Leads</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lista</li>
            </ol>
            </nav>
    </div>
    <!-- /BREADCRUMB -->

    
    
    <div class="seperator-header layout-top-spacing">
        <h4 class="">{{$campaign->name}} {{$campaign->city}}</h4>
    </div>
<div class="row">

    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-8 col-8 layout-spacing">
        <x-widgets._w-total-leads value="{{ $total }}" title="Total" svg="trending-up" cla="text-success"/>
    </div>

    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-8 col-8 layout-spacing">
        <x-widgets._w-total-leads value="{{ $d->t }}" title="- 3 Dias" svg="trending-up" cla="text-success"/>
    </div>
    
    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-8 col-8 layout-spacing">
        @if($d->o > $d->t)
        <x-widgets._w-total-leads value="{{ $d->o }}" title="Ontem" svg="trending-up" cla="text-success"/>
        @else
        <x-widgets._w-total-leads value="{{ $d->o }}" title="Ontem" svg="trending-down" cla="text-danger"/>
        @endif
    </div>

    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-8 col-8 layout-spacing">
        @if($d->h > $d->o)
            <x-widgets._w-total-leads value="{{ $d->h }}" title="Hoje" svg="trending-up" cla="text-success"/>
        @else
            <x-widgets._w-total-leads value="{{ $d->h }}" title="Hoje" svg="trending-down" cla="text-danger"/>
        @endif
    </div>
</div>
    

    
    <div class="row layout-top-spacing">

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
                                <th scope="col">Data</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Username</th>
                                {{--<th scope="col">Email</th>--}}
                                <th scope="col">Telefone</th>
                                <th class="text-center">Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->created_at->format('d/m/y H:m') }}</td>
                                <td>{{ $user->name }} {{ $user->lastname }}</td>
                                <td>{{ $user->username }} 
                                    @if($user->first == 2)
                                    <div class="badge badge-success badge-dot"></div>
                                    @elseif($user->first == 3)
                                    <div class="badge badge-danger badge-dot"></div>
                                    @endif
                                </td>
                                {{--<td>{{ $user->email }}</td>--}}
                                <td>{{ $user->cellphone }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="usr-img-frame mr-2 rounded-circle">
                                            <span><img src="{{ asset($user->image) }}" class="rounded-circle profile-img" alt="avatar"></span>
                                        </div>
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