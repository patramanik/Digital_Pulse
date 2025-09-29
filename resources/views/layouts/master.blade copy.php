<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Fonts and Styles -->
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet" />
    <!-- <link href="{{ asset('public/assets/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" /> -->
</head>

<body>
    @include('layouts.admin.admin-navbar')
    <div id="layoutSidenav">
        @include('layouts.inc.admin-sidbar')
        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            @include('layouts.inc.admin-footer')
        </div>
    </div>

    <!-- Scripts -->
    <!-- Load jQuery from CDN first -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- {{-- jquery validatin cdn --}} -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>


    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Then load other scripts that depend on jQuery -->
    <script src="{{ asset('public/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/main.js') }}"></script>
    <script src="{{ asset('public/assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Yield page-specific scripts here (after jQuery is loaded) -->
    @yield('scripts')
    <!-- {{-- <script>
        console.log(typeof jQuery !== 'undefined' ? "jQuery is loaded! Version: " + jQuery.fn.jquery : "jQuery is NOT loaded!");
    </script> --}} -->
</body>

</html>
