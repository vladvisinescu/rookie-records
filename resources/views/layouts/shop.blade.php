<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased {{ $bodyClass }}" id="app">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if(isset($header))
            <header class="mb-5 bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        @if(isset($banner))
            <header class="mb-5 bg-white shadow">
                <div class="py-6 px-4 sm:px-6 lg:px-8">
                    {{ $banner }}
                </div>
            </header>
        @endif

        <div class="px-4">
            {{ $slot }}
        </div>
    </body>
</html>