<!DOCTYPE html>

<html class="opacity-0" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Biblioteca de imágenes obtenidas por un Microscopio Electrónico de Barrido en el ITRANS - UdeG">
        <meta name="keywords" content="UDG, UdeG, ITRANS, Instituto Transdiciplinar de Investigación y Servicios, Microscopía, Microscopia">
        <meta name="author" content="ITRANS - UDG">

        @yield('head')

        <!-- BEGIN: CSS Assets-->
        @stack('styles')
        <!-- END: CSS Assets-->

        @vite('resources/css/app.css')
    </head>
    <!-- END: Head -->

    <body>
        @yield('content')

        <!-- BEGIN: Vendor JS Assets-->
        @vite('resources/js/vendors/dom.js')
        @vite('resources/js/vendors/tailwind-merge.js')
        @stack('vendors')
        <!-- END: Vendor JS Assets-->

        <!-- BEGIN: Pages, layouts, components JS Assets-->
        @vite('resources/js/components/base/theme-color.js')
        @stack('scripts')
        <!-- END: Pages, layouts, components JS Assets-->
    </body>
</html>
