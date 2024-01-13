<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->

        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/assets/apps/blog-create.scss'])

        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/assets/apps/blog-create.scss'])

        <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/noUiSlider/nouislider.min.css')}}">
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])

        @vite(['resources/scss/light/plugins/clipboard/custom-clipboard.scss'])
        @vite(['resources/scss/dark/plugins/clipboard/custom-clipboard.scss'])




        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">App</a></li>
                <li class="breadcrumb-item"><a href="#">Group</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->


    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
    
    <div class="row mb-4 layout-spacing layout-top-spacing">
        <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="widget-content widget-content-area blog-create-section mb-4">
            <h4>Variáveis</h4>

            <div class="clipboard">
                <form class="form-horizontal">
                    <div class="clipboard-input">
                        <input type="text" class="form-control inative" id="copy-basic-input-city" value="{{$form->city}}" readonly>
                        <div class="copy-icon jsclipboard cbBasic" data-bs-trigger="click" title="Copied" data-clipboard-target="#copy-basic-input-city"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></div>
                    </div>
                </form>
            </div>
            <div class="clipboard">
                <form class="form-horizontal">
                    <div class="clipboard-input">
                        <input type="text" class="form-control inative" id="copy-basic-input-name" value="{{$form->name}}" readonly>
                        <div class="copy-icon jsclipboard cbBasic" data-bs-trigger="click" title="Copied" data-clipboard-target="#copy-basic-input-name"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></div>
                    </div>
                </form>
            </div>
            @foreach ($fillable as $var)
            <div class="clipboard">
                <form class="form-horizontal">
                    <div class="clipboard-input">
                        <input type="text" class="form-control inative" id="copy-basic-input{{$var}}" value="{{$var}}" readonly>
                        <div class="copy-icon jsclipboard cbBasic" data-bs-trigger="click" title="Copied" data-clipboard-target="#copy-basic-input{{$var}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></div>
                    </div>
                </form>
            </div>
            @endforeach
            
            </div>
        </div>

        <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form action="{{ getRouterValue(); }}/app/campaign/msg/send/wp/{{$form->id}}"  method="post" enctype="multipart/form-data" name="form1" class="was-validated">
                @csrf
            <div class="widget-content widget-content-area blog-create-section mb-4">
                <h5 class="mb-4">Sistema de envio de Mensagens</h5>
                <div class="row mb-4">
                    <div class="col-xxl-8 col-md-8 mb-3">
                        <label>Campanha: {{$form->city}} | {{$form->name}}</label>
                    </div>
                </div>
                <div class="col-xxl-12 col-lg-6 col-md-12 md-3 mt-4">
                    <div class="switch form-switch-custom switch-inline form-switch-primary">
                        <label for="tags">Eviar somente para interações</label>
                        <input class="switch-input" type="checkbox" role="switch" id="interact" name="interact">
                    </div>
                </div>
            </div>
            
              
            <div class="widget-content widget-content-area blog-create-section">
                <div class="row mb-2">
                   
                        <div class="col-xxl-6 col-md-6 mb-3">
                            <label for="flow">Escolha o modelo de mensagem</label>
                            <select name="templates" id="templates" class="form-control mb-2" onchange="creare_input()" required>
                                <option value=""></option>
                                @foreach ($templates as $template)
                                <option value="{{$template->id}}">{{$template->name}}</option>
                                @endforeach
                            </select>
                            <div id="app"></div>
                            
                            <p id="demo"></p>
                        </div>
                        
                        <div class="col-xxl-6 col-md-6 mb-3">
                            
                        <div class="card">
                            <img src="http://127.0.0.1:5173/resources/images/grid-blog-style-2.jpeg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text" id="message"></p>
                                <div id="but"></div>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-12">
                            <button id="adicionar" class="btn btn-success w-100">Enviar</button>
                        </div>
                </div>
                <div class="col-sm-6 mb-2">
                    <form action="{{ route('campaign-msg-template-send-test') }}" method="POST" id="send_test" class="py-12">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="phone_test" id="phone_test" placeholder="5542991622889" aria-label="Telefone Teste">
                            <input type="submit" class="btn btn-primary" value="Testar">
                        </div>
                    </form>
                    </div>
                </div>
            </div>

            
            </form>
        </div>

    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
    <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr2.js')}}"></script>
    <script src="{{asset('plugins/autocomplete/autoComplete.min.js')}}"></script>
    <script src="{{asset('plugins/autocomplete/city_autoComplete.js')}}"></script>
        @vite(['resources/assets/js/apps/blog-create.js'])

        <script src="{{asset('plugins/clipboard/clipboard.min.js')}}"></script>
        <script type="module" src="{{asset('plugins/clipboard/custom-clipboard.min.js')}}"></script>

        <script>
            function submeter() {
                var inpname = document.querySelector('#autoComplete').value;
                document.cookie = "city=" + inpname + ";" + "path=/";
                console.log(inpname);
            }
        
        </script>
        
        <script>
            function creare_input() {

                if(document.getElementById("variavel1")){
                        for (var a = 1; a <= 10; a++) {
                        console.log(a);
                        if(document.getElementById("variavel" + a)){
                        document.getElementById("variavel" + a).remove();
                        }
                        }
                }

                const sel = document.getElementById("app");
                const but = document.getElementById("but");
                var x = document.getElementById("templates");

                var node = document.getElementById("variavel1");
                if (node) {
                node.parentNode.removeChild(node);
                }
            

                var t = {!!$templates!!};
                t.forEach(t => {
                    if(t['id'] == x.value){
                        console.log(t['variables']);
                        console.log(t['button']);
                        var b = t['button'];
                        var n = t['variables'];
                        
                    }
                        
                        for (var i = 1; i <= n; i++) {
                        console.log(i);
                        var inp = document.createElement("INPUT");
                            inp.setAttribute("type", "text");
                            inp.setAttribute("class", "form-control");
                            inp.setAttribute("name", "variavel" + i);
                            inp.setAttribute("id", "variavel" + i);
                            inp.setAttribute("placeholder", "Variável " + i);
                            sel.appendChild(inp);
                        }

                        for (var i = 1; i <= b; i++) {
                        console.log(b+'button');
                        var bt = document.createElement("a");
                            bt.setAttribute("class", "btn btn-secondary mt-3");
                            bt.setAttribute("name", "button" + i);
                            bt.setAttribute("id", "button" + i);
                            bt.innerText = 'Button' + i;
                            but.appendChild(bt);
                        }
                    
                });

                const msg = document.getElementById("message");
                var x = document.getElementById("templates");

                t.forEach(t => {
                    if(t['id'] == x.value){
                        console.log(t['msg']);
                        var n = t['msg']; 
                        msg.innerHTML = n;
                    }  
                });

                }
        </script>

        <script>
            function myFunction() {
                const sel = document.getElementById("message");
                var x = document.getElementById("templates");

                var t = {!!$templates!!};
                t.forEach(t => {
                    if(t['id'] == x.value){
                        console.log(t['msg']);
                        var n = t['msg']; 
                        sel.innerHTML = n;
                    }  
                });
                }
        </script>
        <script>
            function copy_clipboard(id) {
              // Get the text field
              console.log(id);
              var copyText = document.getElementById($id);
            
              // Select the text field
              copyText.select();
              copyText.setSelectionRange(0, 99999); // For mobile devices
            
              // Copy the text inside the text field
              navigator.clipboard.writeText(copyText.value);
              
              // Alert the copied text
              alert("Copied the text: " + copyText.value);
            }
            </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>