<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name') }} | @yield('title')</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('material/img/favicon.png') }}">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.page_templates.style')
</head>

<body id="bodySide" class="{{ $class ?? '' }}">
    @auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @include('layouts.page_templates.auth')
    @include('layouts.page_templates.fondo')
    @endauth
    @guest()
    @include('layouts.page_templates.guest')
    @endguest
    @include('layouts.page_templates.script')
    @stack('js')
    <script>
        $("#minimizeSidebar").on( "click", function(e) {
            e.preventDefault();
            if($("body").hasClass("sidebar-mini")) {
                $("body").removeClass("sidebar-mini");
            } else {
                $("body").attr("class", "sidebar-mini");
            }
        });
    </script>
</body>

</html>