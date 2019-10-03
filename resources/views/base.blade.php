<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('stylesheets')

    {!! NoCaptcha::renderJs('fr') !!}

    @include('includes.favicons')
    <title>AlloCar</title>
</head>

<body class="bg-grey-lightest flex flex-col h-full">

@include('includes.header')
@include('includes.navigation')

{{--<div id="app" class="flex-1 pb-10">--}}
{{--    @yield('content')--}}
{{--</div>--}}


{{--DEV DEV DEV--}}
<div id="app" class="flex-1">
    @yield('content')
</div>

@include('includes.flash-messages.flash-template')

@include('includes.footer')

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@include('includes.navigation-script')

@if( session()->has('flash') )
    @include('includes.flash-messages.flash-script')
@endif

@yield('bottom_scripts')
</body>
</html>
	