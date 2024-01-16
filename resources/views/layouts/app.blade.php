<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        @yield('styles')

        @yield('scripts')
    </head>
    <body class="hold-transition sidebar-mini layout-footer-fixed">        
        <!-- Wrapper -->
        <div class="wrapper" id="app" style="position: relative">
            @component('layouts.spinner')@endcomponent
            
            @component('layouts.header')@endcomponent

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                
                @yield('breadcrumb')

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        @component('components.messages')@endcomponent
                    
                        @yield('content')
                    </div>
                </section>
            </div>
        </div>
        <!-- ./wrapper -->

        <button type="button" class="btn btn-default-color btn-floating btn-lg" id="btn-back-to-top">
            <i class="fas fa-arrow-up"></i>
        </button>
    </body>
</html>
