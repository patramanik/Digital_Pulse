<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

    @include('landing.components.landing-header')
    <main>
        @yield('content')
    </main>
    @include('landing.components..landing-footer')
    @yield('scripts')
    <script src="{{ asset('/assets/js/main.js') }}"></script>
</body>

</html>
