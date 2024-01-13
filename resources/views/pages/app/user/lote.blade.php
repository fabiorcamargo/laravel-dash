<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">
        @vite(['resources/scss/light/plugins/filepond/custom-filepond.scss'])
        @vite(['resources/scss/dark/plugins/filepond/custom-filepond.scss'])

        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])

        <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-four  mb-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg><span class="inner-text">Home</span></a></li>
            <li class="breadcrumb-item"><a href="#">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cademi</li>
            </ol>
            </nav>
    </div>
    <!-- /BREADCRUMB -->
    @if(env('APP_DEBUG'))
    <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><svg> ... </svg></button>
        <strong>Atenção!</strong> Modo depuração ativado, as requisições não serão enviadas!!!</button>
    </div>
    @endif
   
    <div class="row">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-success" :status="session('status')"/>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors"/>
        
    </div>
       
        @if (@isset($users))


        

        <div class="row layout-top-spacing">
            
            <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Importação Cidade de {{ $city }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
    
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                            
                                        <th>Contrato</th>
                                        <th>Nome</th>
                                        <th>Sobrenome</th>
                                        <th>Email</th>
                                        <th>Telefone</th>
                                        <th>Curso</th>
                                        <th class="text-center">Pagamento</th>
                                        <th class="text-center dt-no-sorting">Existe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users[0] as $user)


                                    


                                    <tr>
                                        
                                        <td>{{ $user["username"] }} 
                                            @if($user['first'] == 2)
                                            <div class="badge badge-success badge-dot"></div>
                                            @endif
                                        </td>
                                        <td>{{ $user["name"]}}</td>
                                        <td>{{ $user["lastname"]}}</td>
                                        <td>{{ $user["email2"] }}</td>
                                        <td>{{ $user["cellphone2"] }}</td>
                                        <td>{{ $user["courses"] }}</td>

                                        @if ($user["payment"] == "CARTÃO")
                                        <td class="text-center"><span class="shadow-none badge badge-success">Cartão</span></td>
                                        @elseif ($user["payment"] == "BOLETO")
                                        <td class="text-center"><span class="shadow-none badge badge-primary">Boleto</span></td>
                                        @else
                                        <td class="text-center"><span class="shadow-none badge badge-dark">Vazio</span></td>
                                        @endif
                                        <td>{{ $user["exist"] }}</td>
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
    
    
    
                    </div>
                </div>
            </div>
            <form action="{{ getRouterValue(); }}/csv"  method="post" enctype="multipart/form-data">
                @csrf
            <input type="text" name="file" value="{{ $file }}" hidden>
            <input type="text" name="folder" value="{{ $folder }}" hidden>
            <input type="text" name="folder" value="{{ $city }}" hidden>
            <div class="d-flex justify-content-end">
                <p>Total de Usuários da lista:  {{ count($users[0]) }} <button type="submit" class="btn btn-primary mb-2 me-4">Enviar</button></p>
            </div>
            </form>

        </div>


        

    @endif
        
    @if (@empty($users))
    <div class="row layout-top-spacing">

        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12 mt-2">
                            <h4>Lista de Usuários</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

        <form action="{{ getRouterValue(); }}/store"  method="post" enctype="multipart/form-data">
            @csrf
            <div id="fuMultipleFile" class="col-lg-12 layout-spacing">
                
                        <div class="row">
                            <div class="col-md-6 mx-auto pt-4 pb-4">  
                            <input class="form-check-input me-1" id="observation" name="observation" type="checkbox">
                            <label for="city">Somente Observações</label>
                            </div>
                        </div>
                        <div class="row"></div>
                            <div class="col-md-6 mx-auto">
                                <label for="city">Cidade - Estado</label>
                                        <div class="row">
                                            <div class="mb-3">
                                                <input id="autoComplete" name="city" name="city" class="form-control" required onblur="submeter()">
 
                                            </div>
                                        </div>
                                <div class="multiple-file-upload">
                                    <input type="file" id="image" name="image" class="file-upload-multiple">
                                    
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 me-4">Enviar</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
        <div class="row layout-top-spacing">

            <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Importação Cademi</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
    
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-md-2">Atualização</th>   
                                        <th class="col-md-1">Username</th>
                                        <th class="col-md-1">Status</th>
                                        <th class="col-md-2">Code</th>
                                        <th class="col-md-1">Msg</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cademis as $cademi)
                                    <tr>
                                        <td class="col-md-1">{{ $cademi['updated_at'] }}</td>
                                        <td >{{ $cademi['username'] }}</td>
                                        @if($cademi['status'] == "success")
                                        <td class=""><span class="shadow-none badge badge-success">Success</span></td>
                                        @elseif ($cademi['status'] == "error")
                                        <td class=""><span class="shadow-none badge badge-danger">Error</span></td>
                                        @endif
                                        <td>{{ $cademi['code'] }}</td>
                                        <td>{{ $cademi['msg'] }}</td>
                                        
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-12">
                                    {{ $cademis->appends($_POST)->links('pagination::bootstrap-5') }}
        
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

        
    

    @endif

    
    
   
    
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/filepond/filepond.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImagePreview.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageCrop.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageResize.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageTransform.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/filepondPluginFileValidateSize.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/custom-filepond.js')}}"></script>
        <script src="{{asset('plugins/autocomplete/autoComplete.min.js')}}"></script>
        <script src="{{asset('plugins/autocomplete/city_autoComplete.js')}}"></script>
        <script>

            const inputElement = document.querySelector('input[type="file"]');

            const pond = FilePond.create(inputElement);

            FilePond.setOptions({
            server: {
                process: '{{ getRouterValue(); }}/tmp-upload',
                revert: '{{ getRouterValue(); }}/tmp-delete',
                         
                headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
                
            }
            
            });



        </script>

<script>
    function submeter() {

        
        var inpname = document.querySelector('#autoComplete').value;
        document.cookie = "city=" + inpname + ";" + "path=/";
        
        console.log(inpname);
    }

</script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>