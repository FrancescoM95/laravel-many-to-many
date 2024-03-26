<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Boolfolio') }} | @yield('title')</title>
    <link rel="icon" href="{{ Vite::asset('resources/img/logo.png')}}">

    <style>
        body{visibility: hidden;}
    </style>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!--§ font-awesome -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'
    integrity='sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=='
    crossorigin='anonymous'>

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])

    @yield('cdns')
</head>

<body>
    <div id="app">
        @include('includes.layouts.navbar')

        <main class="container">
            @include('includes.alert')
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>

</html>
