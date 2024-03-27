<!DOCTYPE html>


<html lang="pt-br" itemscope="/" itemtype="http://schema.org/WebPage"><head>

<head>

    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="pragma" content="no-cache">
    
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Profissionaliza EAD">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="msapplication-TileImage" content="https://cdn.areademembros.com/image?p=instancia_1543%2Fpng%2FIfxSq2k487p0HWMA3XepFwXllqzvL8mSSXBWQO7p.png&amp;w=192&amp;h=192&amp;t=crop&amp;d=default.png&amp;uptkn=9c99b1e6faf00591827b268778f90dcf">
    <meta name="msapplication-TileColor" content="#000">
    <meta name="theme-color" content="#000000">


    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ url('images/favicon.ico') }}" type="image/png">
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"
    integrity="sha256-u7MY6EG5ass8JhTuxBek18r5YG6pllB9zLqE4vZyTn4="
    crossorigin="anonymous"></script>

    
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>



<body class="bg-gray-900">

    <div class="container mx-auto px-4 py-8">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="shadow bg-red-500 hover:bg-red-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">Logout</button>
        </form>
        @yield('content')
    </div>

</body>


</html>
