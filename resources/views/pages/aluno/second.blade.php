<x-base-layout :scrollspy="true">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->

        @vite(['resources/scss/light/assets/pages/knowledge_base.scss'])
        @vite(['resources/scss/dark/assets/pages/knowledge_base.scss'])

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        <link rel="stylesheet" href="{{asset('plugins/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">
        @vite(['resources/scss/light/plugins/filepond/custom-filepond.scss'])
        @vite(['resources/scss/dark/plugins/filepond/custom-filepond.scss'])
        
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>
    




        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing" style="    margin-top: -40px;">
            
            <div class="statbox widget box box-shadow">
                
                <div class="widget-header">
                    <div class="faq-header-content">
                        <div class="fq-header-wrapper">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 align-self-center order-md-0">
                                        <div class="faq-header-content">
                                            <h2 class="animate__animated animate__pulse animate__infinite"><img src="{{Vite::asset('resources/images/logo.svg')}}" class="navbar-logo logo-dark  mb-3" style="width: 80px;" alt="logo"></h2   >
                                            <h2 class="animate__animated animate__fadeIn animate__delay-1s">Última Etapa</h2>
                                            <div class="row">
                                            
                                            </div>
                                            <p class="mt-4 mb-2 animate__animated animate__fadeIn animate__delay-2s">Carregue uma foto da sua preferência para o seu perfil.</p>
                                            <div class="">
                                                <input type="file" id="image" name="image" class="filepond col-md-2 ">
                                            </div>
                                            <div class="row">
                                                <a type="submit" href="{{getRouterValue();}}/aluno/my" class="btn btn-primary mb-2 me-4 mt-5">Enviar</a>
                                            </div>
                                        </div>

                                            
                                            
                                            
                                            
                                            
                                  
                                    </div>
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
                process: '{{ getRouterValue(); }}/avatar-upload',
                revert: '{{ getRouterValue(); }}/avatar-delete',
                         
                headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
                
            }
            
            });



        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>