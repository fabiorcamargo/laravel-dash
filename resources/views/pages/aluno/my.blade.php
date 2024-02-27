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


        @vite(['resources/scss/light/plugins/loaders/custom-loader.scss', 'resources/scss/dark/plugins/loaders/custom-loader.scss'])

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



    <div class="row ms-1 mt-4">
        @isset($groups[0])
            @foreach ($groups as $group)
            <a href="{{ $group->group_link }}" target="_blank" class="alert alert-light-warning alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <img src="{{Vite::asset('resources/images/whatsapp.svg')}}" alt="avatar" width="30" class="me-2"> Entre no grupo <b>{{ $group->group_name }}</b> para não perder as notificações. </a>
            @endforeach
        @endisset


        <div class="row">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-success" :status="session('status')"/>
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors"/>

        </div>


{{--}}
        @if(App\Models\OuroClient::where('user_id', (Auth::user()->id))->value('login_auto'))
            @isset($ouro)
                <div class="row">
                    <div class="mb-3"><h5>Acesso Cursos Ouro</h5></div>
                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <x-widgets._w-card-ouro title="Acesse seu curso" card={{$ouro}}/>
                    </div>
                </div>
            @endisset
        @endif

        @if(App\Models\Cademi::where('user_id', (Auth::user()->id))->value('login_auto') || $card)
        <div class="row">
            <div class="mb-3"><h5>Olá {{Auth::user()->name}}</h5></div>
            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <x-widgets._w-card-cademi title="Acesse seu curso" card={{$card}}/>
            </div>
        </div>
        @endif --}}

        @if(Auth::user()->active == 1)
        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
            <x-widgets._w-pay-asaas title="Pagamentos" chart-id="pay-asaas"/>
        </div>

        @endif

        <div id="owl-demo" class="mt-4">

            @if(!(App\Models\Cademi::where('user_id', (Auth::user()->id))->value('login_auto')) /*|| !(Auth::user()->client_ouro()->first()) && !(Auth::user()->client_ouro()->first()->matricula_ouro()->get())*/)
                <div class="me-2">
                    <x-widgets._w-card-cademi title="Em Breve" card="product/cademi/em-breve.jpg"/>
                </div>
            @endif
            @if(Auth::user()->first == 3 || Auth::user()->first == 5)
                <x-widgets._w-card-bloqueado title="Cursos Premium" card="{{Vite::asset('resources/images/Curso_Bloqueado.jpg')}}"/>
            @else
                @if(App\Models\Cademi::where('user_id', (Auth::user()->id))->value('login_auto') )
                @foreach ($cards as $card)
                <div class="me-2">
                    <x-widgets._w-card-cademi title="{{$card['title']}}" card="{{$card['img']}}"/>
                </div>
                @endforeach

                @endif
            @endif

            @if(Auth::user()->first == 4 || Auth::user()->first == 5)
                <x-widgets._w-card-bloqueado title="Cursos Ouro" card="{{Vite::asset('resources/images/Curso_Bloqueado.jpg')}}"/>
            @else
                @if(Auth::user()->client_ouro()->first() && $courses = Auth::user()->client_ouro()->first()->matricula_ouro()->get())
                    @foreach ($courses as $course)
                        <div class="me-2">
                            <x-widgets._w-card-ouro title="{{$course->name}}" card="{{$course->get_course()->first()->img}}"/>
                        </div>
                    @endforeach
                @endif
            @endif

        </div>

        @if(Auth::user()->active == 1)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing mt-4">
            <x-widgets._w-support title="Suporte"/>
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

                autoPlay: 2000, //Set AutoPlay to 3 seconds

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
