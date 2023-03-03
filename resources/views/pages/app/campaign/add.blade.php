<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>
@php
    $teste = 1;
@endphp
    

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->

        @vite(['resources/scss/light/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/dark/plugins/editors/quill/quill.snow.scss'])

        @vite(['resources/scss/light/assets/apps/ecommerce-create.scss'])
        @vite(['resources/scss/dark/assets/apps/ecommerce-create.scss'])

        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <div class="row mb-4 layout-spacing layout-top-spacing">
        <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            @if (isset($success))
            @endif
            @if (\Session::has('success'))
            <div class="alert alert-light-danger alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Erro:</strong> {!! \Session::get('success') !!} </div>
        @endif
            <div class="">
                <form action="{{ getRouterValue(); }}/app/campaign/add"  method="post" enctype="multipart/form-data" name="form1" class="was-validated">
                    @csrf
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="widget-content widget-content-area ecommerce-create-section">
                            <h4>Nome da Campanha:</h4>
                            <br>
                            <input type="text" class="form-control mb-4" id="form_name" name="form_name" placeholder="Nome do Produto" required>
                            <div class="row mb-4">
                                    <div class="col-xxl-2 col-md-2 mb-2">
                                        <label for="title">Estado</label>
                                        <select name="state" class="form-control" required>
                                            <option value="">UF</option>
                                            @foreach ($states as $key => $value)
                                                <option value="{{ $value['id'] }}">{{ $value['abbr'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xxl-10 col-md-10 mb-10">
                                        <label for="title">Selecione sua Cidade</label>
                                        
                                        <select name="city" id="city" class="form-control" aria-placeholder="Cidade" onchange = "myFn('city')" required>
                                            <option value="">Selecione sua Cidade</option>
                                        </select>
                                    </div>
                                <input type="text" class="form-control" id="redirect" name="redirect" placeholder="https://..." value="https://alunos.profissionalizaead.com.br/modern-dark-menu/aluno/my" required hidden>
                            </div>
                            <div class="col-xxl-4 col-md-4 mb-4">
                                <label for="title">Chip</label>
                                <select name="chip" id="chip" class="form-control" required>
                                    <option value="">Selecione o Chip</option>
                                    @foreach ($assets as $asset)
                                        <option value="{{ $asset->id }}">{{ $asset->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="widget-content widget-content-area ecommerce-create-section">
                        <h4>Descrição:</h4>
                        <p>É o texto que aparece no corpo da página de captura.</p>
                        <div id="quillEditor"></div>
                        </div>
                    </div>
                </div>
                <input id="description" name="description" hidden>
            </div>
            <div class="col-sm-12">
                <button id="adicionar" class="btn btn-success w-100">Criar campanha</button>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
        <script src="{{asset('plugins/editors/quill/quill.js')}}"></script>
        @vite(['resources/assets/js/apps/ecommerce-create.js'])


        <script type="text/javascript">
            $(document).ready(function() {
                
                $('select[name="state"]').on('change', function() {
                    var stateID = $(this).val();
                    if(stateID) {
                        $.ajax({
                            url: '/city/'+stateID,
                            type: "GET",
                            dataType: "json",
                            success:function(data) {   
                                console.log("teste");   
                                var city = "1";                
                                $('select[name="city"]').empty();
                                $.each(data, function(key, value) {
                                $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');
                                });
                            }
                        });
                    }else{
                        $('select[name="city"]').empty();
                    }
                });
            });
        </script>

        <script>
            var options = {
                placeholder: 'Coloque a descrição do produto',
                theme: 'snow'
                };

                var editor = new Quill('#quillEditor', options);
                var justHtmlContent = document.getElementById('description');

                editor.on('text-change', function() {
                var delta = editor.getContents();
                var text = editor.getText();
                var justHtml = editor.root.innerHTML;
                justHtmlContent.value = justHtml;
                });

                
        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>