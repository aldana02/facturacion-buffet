<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <base href="{{ config('app.url') }}">

        <title>{{ config('app.name', 'Facturación') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased" style="background-color: rgb(186, 121, 43);">

        @auth
            <x-banner />
        @endauth

        <div class="min-h-screen" style="background-color:rgb(186, 121, 43);">
            @auth
                @livewire('navigation-menu')
            @endauth

            <!-- Page Heading -->
            @auth
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif
            @endauth



            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>