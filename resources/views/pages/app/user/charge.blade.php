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
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
    </div>
    <!-- /BREADCRUMB -->
   
    
    
    @if (@isset($success))
    <div class="alert alert-light-success alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Sucesso!</strong> Todos os usuários foram atualizados. </div>
    @endif
    @if (count($errors) > 0)
                <div class="row">
                    <div class="col-md-8 col-md-offset-1">
                      <div class="alert alert-light-danger alert-dismissible fade show border-0 mb-4">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <h4><i class="icon fa fa-ban"></i> Error!</h4>
                          @foreach($errors->all() as $error)
                          {{ $error }} <br>
                          @endforeach      
                      </div>
                    </div>
                </div>
                @endif
        
        
    @if (@empty($users))
    <div class="row layout-top-spacing">

        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Lista de Usuários</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

        <form action="{{ getRouterValue(); }}/app/user/charge"  method="post" enctype="multipart/form-data">
            @csrf
            <div id="fuMultipleFile" class="col-lg-12 layout-spacing">
                        <div class="row">
                            
                            <div class="col-md-6 mx-auto">
                                <div class="multiple-file-upload">
                                    <input type="file" id="image"  accept=".xlsx, .xls"  name="image" class="file-upload-multiple">
                                    
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 me-4">Enviar</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
    

    @endif

    @if (@isset($fails))

        <div class="row layout-top-spacing">

            <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Lista de Falhas</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
    
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                            
                                        <th>Data</th>
                                        <th>Falha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fails as $fail)


                                    


                                    <tr>
                                        
                                        <td >{{ $fail['date'] }}</td>
                                        <td>{{ $fail['fail'] }}</td>
                                        
                                    @endforeach
                                </tbody>
                            </table>
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
        <script>
            
        </script>
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
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>