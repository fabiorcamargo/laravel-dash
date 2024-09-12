<x-base-layout :scrollspy="false" :avatar="$avatar">

    <x-slot:pageTitle>
        {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

            @vite(['resources/scss/light/assets/components/list-group.scss'])
            @vite(['resources/scss/light/assets/widgets/modules-widgets.scss'])

            @vite(['resources/scss/dark/assets/components/list-group.scss'])
            @vite(['resources/scss/dark/assets/widgets/modules-widgets.scss'])

            @vite(['resources/scss/dark/assets/components/modal.scss'])

            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])


            @vite(['resources/scss/light/plugins/loaders/custom-loader.scss',
            'resources/scss/dark/plugins/loaders/custom-loader.scss'])

            <!-- Basic stylesheet -->
            <link rel="stylesheet" href={{asset("plugins/owl-carousel/owl.carousel.css")}}>
            <!-- Default Theme -->
            <link rel="stylesheet" href={{asset("plugins/owl-carousel/owl.theme.css")}}>
            <!-- You can use latest version of jQuery  -->

            <!-- Include js plugin -->
            <script src={{asset("plugins/owl-carousel/owl.carousel.js")}}></script>



            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <!-- Analytics -->



            <div class="row  mt-4">

                <div class="row">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4 text-success" :status="session('status')" />
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                </div>

                @isset($groups[0])

                @foreach ($groups as $group)

                @php
                $imagePath = 'peoples';
                $files = \Illuminate\Support\Facades\File::files($imagePath);
                $images = array_filter($files, function ($file) {
                return in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']);
                });
                shuffle($images);
                @endphp

                {{-- <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><svg> ...
                        </svg></button>
                    <strong>Primary!</strong> Lorem Ipsum is simply dummy text of the printing.
                </div>
                <a href="{{ $group->group_link }}" target="_blank"
                    class="alert alert-warning alert-dismissible fade show mb-4 text-white" role="alert">
                    <img src="{{Vite::asset('resources/images/whatsapp.svg')}}" alt="avatar" width="30" class="me-2">
                    Entre no grupo {{ $group->group_name }} para não perder as
                    notificações.
                </a> --}}



                <div class="card style-4 mb-4 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 mx-0">
                    <div class="card-body pt-3">


                        <div class="m-o-dropdown-list">
                            <div class="media mt-0 mb-3">
                                <div class="badge--group me-3">

                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading mb-0">
                                        <span class="media-title">Entre no Grupo {{$group->name}}</span>
                                        <div class="dropdown-list dropdown" role="group">
                                            <a href="javascript:void(0);" class="dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </a>
                                            <div class="dropdown-menu left">
                                                <a class="dropdown-item" href="javascript:void(0);"><span>Start
                                                        chat</span> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-message-circle">
                                                        <path
                                                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                                        </path>
                                                    </svg></a>
                                                <a class="dropdown-item" href="javascript:void(0);"><span>Todo</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit">
                                                        <path
                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                        </path>
                                                        <path
                                                            d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                        </path>
                                                    </svg></a>
                                                <a class="dropdown-item"
                                                    href="javascript:void(0);"><span>Statistics</span> <svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-bar-chart-2">
                                                        <line x1="18" y1="20" x2="18" y2="10"></line>
                                                        <line x1="12" y1="20" x2="12" y2="4"></line>
                                                        <line x1="6" y1="20" x2="6" y2="14"></line>
                                                    </svg></a>
                                            </div>

                                        </div>

                                    </h4>
                                </div>
                            </div>

                        </div>

                        <p class="card-text mt-4 mb-0">Grupo de informações e lembrete aulas, fique por dentro de tudo
                            relacionado ao seu curso.</p>

                    </div>
                    <div class="card-footer pt-0 border-0">
                        <div class="progress br-30 progress-sm">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="d-flex justify-content-between">

                            <div class="avatar--group">
                                <div class="avatar avatar-sm ms-0">
                                    <img alt="avatar" src="{{asset('peoples/' . $images[0]->getFilename())}}"
                                        class="rounded-circle">
                                </div>
                                <div class="avatar avatar-sm">
                                    <img alt="avatar" src="{{asset('peoples/' . $images[1]->getFilename())}}"
                                        class="rounded-circle">
                                </div>
                                <div class="avatar avatar-sm">
                                    <img alt="avatar" src="{{asset('peoples/' . $images[2]->getFilename())}}"
                                        class="rounded-circle">
                                </div>
                                <div class="avatar avatar-sm">
                                    <img alt="avatar" src="{{asset('peoples/' . $images[3]->getFilename())}}"
                                        class="rounded-circle">
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="card-footer pt-0 border-0 text-center">
                        <a href="{{ $group->group_link }}" target="_blank"
                            class="btn btn-success w-100 _effect--ripple waves-effect waves-light"><img
                                src="{{Vite::asset('resources/images/whatsapp.svg')}}" alt="avatar" width="30"
                                class="me-2"> <span class="btn-text-inner ms-3">Entrar no Grupo</span></a>
                    </div>

                    <small class="mb-0 py-2 ms-4">
                        {{ Auth::user()->contract_date
                        ? 'Válido até ' .
                        \Carbon\Carbon::parse(Auth::user()->contract_date)->addDays(7)->format('d/m/Y')
                        : 'Data de contrato não disponível' }}
                    </small>
                </div>

                @endforeach
                @endisset


                {{--}}
                @if(App\Models\OuroClient::where('user_id', (Auth::user()->id))->value('login_auto'))
                @isset($ouro)
                <div class="row">
                    <div class="mb-3">
                        <h5>Acesso Cursos Ouro</h5>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <x-widgets._w-card-ouro title="Acesse seu curso" card={{$ouro}} />
                    </div>
                </div>
                @endisset
                @endif

                @if(App\Models\Cademi::where('user_id', (Auth::user()->id))->value('login_auto') || $card)
                <div class="row">
                    <div class="mb-3">
                        <h5>Olá {{Auth::user()->name}}</h5>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <x-widgets._w-card-cademi title="Acesse seu curso" card={{$card}} />
                    </div>
                </div>
                @endif --}}






                @if(Auth::user()->active == 1)
                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 mx-0 px-0">
                    <x-widgets._w-pay-asaas title="Pagamentos" chart-id="pay-asaas" />
                </div>

                @endif


                <div id="owl-demo" class="mt-2 mx-0 px-0">

                    @if(!(App\Models\Cademi::where('user_id', (Auth::user()->id))->value('login_auto')) /*||
                    !(Auth::user()->client_ouro()->first()) &&
                    !(Auth::user()->client_ouro()->first()->matricula_ouro()->get())*/)

                    <x-widgets._w-card-cademi title="Em Breve" card="{{'em-breve.jpg'}}" />

                    @endif
                    @if(Auth::user()->first == 3 || Auth::user()->first == 5)
                    <x-widgets._w-card-bloqueado title="Cursos Premium" card="{{'Curso_Bloqueado.jpg'}}" />
                    @else
                    @if(App\Models\Cademi::where('user_id', (Auth::user()->id))->value('login_auto') )

                    @foreach ($cards as $card)

                    
                    @if($card['tag'] == "PLATAFORMAANTIGA")

                    <div class="mx-0">
                        @livewire('get-old-system-token', ['title' => $card['title'], 'card' => $card['img']])
                    </div>

                    @else

                    <div class="mx-0">
                        <x-widgets._w-card-cademi title="{{$card['title']}}" card="{{$card['img']}}" />
                    </div>

                    @endif
                    @endforeach

                    @endif
                    @endif

                </div>
                <div id="owl-demo-1" class="mt-2 mx-0 px-0">
                    @if(Auth::user()->first == 4 || Auth::user()->first == 5)
                    <div class="mx-0">
                        <x-widgets._w-card-bloqueado title="Cursos Ouro" card="{{'Curso_Bloqueado.jpg'}}" />
                    </div>
                    @else
                    @if(Auth::user()->client_ouro()->first() && $courses =
                    Auth::user()->client_ouro()->first()->matricula_ouro()->get())
                    @foreach ($courses as $course)
                    <div class="mx-0">
                        <x-widgets._w-card-ouro title="{{$course->name}}"
                            card="{{$course->get_course()->first()->img}}" />
                    </div>
                    @endforeach
                    @endif
                    @endif

                </div>

                @if(Auth::user()->active == 1)
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing mt-4 px-0">
                    <x-widgets._w-support title="Suporte" />
                </div>
                @endif


            </div>




            @if (str_contains(url()->previous(), 'form/end'))
            <p> {{ Cookie::get('fbid1') }} </p>

            @endif

            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                @vite(['resources/assets/js/authentication/2-Step-Verification.js'])
                {{-- <script src="{{asset('plugins/apex/custom-apexcharts.js')}}"></script> --}}
                @vite(['resources/assets/js/widgets/modules-widgets.js'])

                <script>
                    $(document).ready(function() {

                        $("#owl-demo").owlCarousel({

                            autoPlay: 3000, //Set AutoPlay to 3 seconds

                            items : 3,
                            itemsDesktop : [2000,3],
                            itemsDesktopSmall : [1500,3]

                        });

                    });
                </script>

                <script>
                    $(document).ready(function() {

                        $("#owl-demo-1").owlCarousel({

                            autoPlay: 2500, //Set AutoPlay to 3 seconds

                            items : 3,
                            itemsDesktop : [2000,3],
                            itemsDesktopSmall : [1500,3]

                        });

                    });
                </script>

                @if (str_contains(url()->previous(), 'form/end'))
                <script>
                    fbq("track", "Lead", {
                                        "event_name": "Lead",
                                        "event_time": "{{ Cookie::get('fbtime') }}",
                                        "action_source": "website",
                                        "event_source_url": "{{ Cookie::get('fbpage') }}",
                                        "eventID": "{{ Cookie::get('fbid1') }}",
                                        "user_data":
                                        {
                                            "em":
                                            [
                                                "{{Hash::make(Auth::user()->email)}}"
                                            ],
                                            "ph":
                                            [
                                                "{{Hash::make(Auth::user()->cellphone)}}"
                                            ],
                                            "fn":
                                            [
                                                "{{Hash::make(Auth::user()->name)}}"
                                            ],
                                            "ln":
                                            [
                                                "{{Hash::make(Auth::user()->lastname)}}"
                                            ],
                                            "client_ip_address": "{{$_SERVER['REMOTE_ADDR']}}",
                                            "client_user_agent": "{{$_SERVER['HTTP_USER_AGENT']}}"
                                            @isset($_COOKIE['_fbp'])
                                            ,"fbp": "{{$_COOKIE['_fbp']}}",
                                            "fbc": "{{$_COOKIE['_fbp']}}.{{ Cookie::get('fbid1') }}"
                                            @endisset
                                        },
                                    }
                                );
                </script>
                @endif
                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>