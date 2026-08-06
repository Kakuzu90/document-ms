<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DocumentMS') }}</title>
        <meta name="description" content="Secure document management system for organizing, tracking, and collaborating on your important documents.">
        
        <link rel="icon" type="image/png,ico" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-surface-50 text-surface-900">
        <div class="min-h-screen flex flex-col">
            {{-- Top navigation (desktop only) --}}
            @include('layouts.navigation')

            {{-- Page Heading --}}
            @isset($header)
                <header class="
                    bg-white border-b border-surface-200
                    hidden sm:block
                ">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main class="flex-1 pb-20 sm:pb-0">
                {{ $slot }}
            </main>

            {{-- Bottom navigation (mobile only) --}}
            <x-bottom-nav />

            <!-- Scroll to Top Button -->
            <div x-data="{ show: false }" 
                 @scroll.window="show = window.pageYOffset > 300"
                 class="fixed bottom-8 right-8 z-50">
                <button x-show="show" 
                        x-transition.opacity.duration.300ms
                        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                        class="p-3 bg-primary-600 text-white rounded-full shadow-lg hover:bg-primary-700 hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all"
                        title="Scroll to top"
                        style="display: none;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
                </button>
            </div>
        </div>
    </body>
</html>
