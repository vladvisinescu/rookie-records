<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Google Tag Manager -->
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-PDCCHWM');
        </script>
        <!-- End Google Tag Manager -->


        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="https://js.stripe.com/v3/"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="flex flex-col min-h-screen font-sans antialiased {{ $bodyClass }}">

        <script src="https://consent.cookiefirst.com/banner.js" data-cookiefirst-key="6b19b491-06cf-4cbf-9e3e-e0385ff85793"></script>

        <div id="app">
            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PDCCHWM" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->

            @include('layouts.navigation-shop')

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

            <div>
                {{ $slot }}
            </div>

            @include('layouts.footer-shop')

        </div>

    </body>
</html>
