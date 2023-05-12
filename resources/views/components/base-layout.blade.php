{{-- 

/**
*
* Created a new component <x-base-layout/>.
* 
*/

--}}

@php
    $isBoxed = layoutConfig()['boxed'];
    $isAltMenu = layoutConfig()['alt-menu']; 
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="description" content="Venha fazer parte de uma das maiores plataformas profissionalizantes do Brasil.">
    <meta name="keywords" content="curso, curso online, preparatorios, cpa10, aprendiz, aprendiz bancario">
    <meta name="robots" content="index, follow">
    <meta http-equiv="content-language" content="pt">
    
    
    <meta name="twitter:card" content="Profissionaliza EAD" />
    <meta name="twitter:description" content="Venha fazer parte de uma das maiores plataformas profissionalizantes do Brasil." />
    <meta property="og:site_name" content="Profissionaliza EAD" />
    <meta name="title" content="Profissionaliza EAD" />
    <meta property="og:title" content="Profissionaliza EAD" />
    <meta property="og:description" content="Venha fazer parte de uma das maiores plataformas profissionalizantes do Brasil." />
    <meta property="og:image" content="{{Vite::asset('resources/images/url-image.jpg')}}" />
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
        
    <title>{{ $pageTitle }}</title>
    <link rel="icon" type="image/x-icon" href="{{Vite::asset('resources/images/favicon.ico')}}"/>
    @vite(['resources/scss/layouts/vertical-light-menu/light/loader.scss'])

    @if (Request::is('modern-light-menu/*'))
        @vite(['resources/layouts/vertical-light-menu/loader.js'])
    @elseif ((Request::is('modern-dark-menu/*')))
        @vite(['resources/layouts/vertical-dark-menu/loader.js'])
    @elseif ((Request::is('collapsible-menu/*')))
        @vite(['resources/layouts/collapsible-menu/loader.js'])
    @else @vite(['resources/layouts/vertical-dark-menu/loader.js'])
    @endif

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id="{{env('GOOGLE_TAG_ANALYTICS_ID')}}></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{env('GOOGLE_TAG_ANALYTICS_ID')}}');
    </script>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{env('GOOGLE_TAG_MANAGER_ID')}}');</script>
    <!-- End Google Tag Manager -->


    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ env('CONVERSIONS_API_PIXEL_ID') }}');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{ env('CONVERSIONS_API_PIXEL_ID') }}&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap/bootstrap.min.css')}}">
    @vite(['resources/scss/light/assets/main.scss', 'resources/scss/dark/assets/main.scss'])

    @if (
            !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&

            // Real Logins
            !Request::routeIs('login')
        )
        @if ($scrollspy == 1) @vite(['resources/scss/light/assets/scrollspyNav.scss', 'resources/scss/dark/assets/scrollspyNav.scss']) @endif
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/waves/waves.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/highlight/styles/monokai-sublime.css')}}">
        @vite([
            'resources/scss/light/plugins/perfect-scrollbar/perfect-scrollbar.scss',
            'resources/scss/layouts/vertical-light-menu/light/structure.scss',
            'resources/scss/layouts/vertical-light-menu/dark/structure.scss',
        ])

    @endif
    
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{$headerFiles}}
    <!-- END GLOBAL MANDATORY STYLES -->
</head>
<body @class([
        // 'layout-dark' => $isDark,
        'layout-boxed' => $isBoxed,
        'alt-menu' => ($isAltMenu || Request::routeIs('collapsibleMenu') ? true : false),
        'error' => (Request::routeIs('404') ? true : false),
        'maintanence' => (Request::routeIs('maintenance') ? true : false),
    ]) @if ($scrollspy == 1) {{ $scrollspyConfig }} @else {{''}} @endif   @if (Request::routeIs('fullWidth')) layout="full-width"  @endif >

    <!-- BEGIN LOADER -->

    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{env('GOOGLE_TAG_MANAGER_ID')}}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <x-layout-loader/>
    <!--  END LOADER -->

    {{--
        
    /*
    *
    *   Check if the routes are not single pages ( which does not contains sidebar or topbar  ) such as :-
    *   - 404
    *   - maintenance
    *   - authentication
    *
    */

    --}}

    @if (
            !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&

            // Real Logins
            !Request::routeIs('login')
        )

        @if (!Request::routeIs('*blank*', 'aluno.first', 'aluno.second', 'aluno.pw_change', 'aluno.post', 'eco_checkout*', 'form-*'))  
        <!--  BEGIN NAVBAR  -->
        @isset((Auth::user()->role))
        <x-navbar.style-vertical-menu avatar="{{ Auth::user()->image }}" classes="{{($isBoxed ? 'container-xxl' : '')}}"/>
        @endisset
        @unless (Auth::check())
        <x-navbar.style-sales-menu avatar="" classes="{{($isBoxed ? 'container-xxl' : '')}}"/>
        @endunless
        <!--  END NAVBAR  -->
        @endif

        <!--  BEGIN MAIN CONTAINER  -->
        <div class="main-container " id="container">
            
            <!--  BEGIN LOADER  -->
            <x-layout-overlay/>
            <!--  END LOADER  -->

            @if (!Request::routeIs('*blank*', 'aluno.first', 'aluno.second', 'aluno.pw_change', 'aluno.post', 'eco_checkout*', 'form-*')) 
            <!--  BEGIN SIDEBAR  -->
            
           
                <x-menu.stand-menu/>
              
                       
            
            
            <!--  END SIDEBAR  -->   
            @endif
            
            <!--  BEGIN CONTENT AREA  -->
            <div id="content" class="main-content {{(Request::routeIs('*blank*') ? 'ms-0 mt-0' : '')}}">

                @if ($scrollspy == 1)
                    <div class="container">
                        <div class="container">
                            {{ $slot }}
                        </div>
                    </div>                
                @else
                    <div class="layout-px-spacing">
                        <div class="middle-content {{($isBoxed ? 'container-xxl' : '')}} p-0">
                            {{ $slot }}
                        </div>
                    </div>
                @endif

                <!--  BEGIN FOOTER  -->
                <x-layout-footer/>
                <!--  END FOOTER  -->
                
            </div>
            <!--  END CONTENT AREA  -->

        </div>
        <!--  END MAIN CONTAINER  -->
        
    @else
        {{ $slot }}
    @endif

    @if (
            !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&

            // Real Logins
            !Request::routeIs('login')
        )
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <script src="{{asset('plugins/bootstrap/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
        <script src="{{asset('plugins/mousetrap/mousetrap.min.js')}}"></script>
        <script src="{{asset('plugins/waves/waves.min.js')}}"></script>
        <script src="{{asset('plugins/highlight/highlight.pack.js')}}"></script>
        @if ($scrollspy == 1) @vite(['resources/assets/js/scrollspyNav.js']) @endif

        @if (Request::is('modern-light-menu/*'))
            @vite(['resources/layouts/vertical-light-menu/app.js'])
        @elseif ((Request::is('modern-dark-menu/*')))
            @vite(['resources/layouts/vertical-dark-menu/app.js'])
        @elseif ((Request::is('collapsible-menu/*')))
            @vite(['resources/layouts/collapsible-menu/app.js'])
        @endif
        <!-- END GLOBAL MANDATORY STYLES -->

    @endif
         
        {{$footerFiles}}
</body>
</html>