<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DocumentMS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="
            min-h-screen flex flex-col
            bg-surface-50
            lg:flex-row
        ">
            {{-- Left branding panel — hidden on mobile --}}
            <div class="
                hidden lg:flex lg:w-1/2 xl:w-[55%]
                relative overflow-hidden
                flex-col justify-between
                p-12
                bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900
            ">
                {{-- Decorative circles --}}
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary-500/20 blur-3xl"></div>
                <div class="absolute -bottom-32 -right-32 w-[28rem] h-[28rem] rounded-full bg-primary-400/15 blur-3xl"></div>
                <div class="absolute top-1/2 left-1/3 w-64 h-64 rounded-full bg-primary-300/10 blur-2xl"></div>

                {{-- Logo & tagline --}}
                <div class="relative z-10">
                    <a href="/" class="inline-flex items-center gap-3 group">
                        <div class="
                            w-10 h-10 rounded-xl
                            bg-white/15 backdrop-blur-sm
                            flex items-center justify-center
                            group-hover:bg-white/20
                            transition-colors duration-200
                        ">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        <span class="text-xl font-semibold text-white tracking-tight">
                            {{ config('app.name', 'DocumentMS') }}
                        </span>
                    </a>
                </div>

                {{-- Center illustration text --}}
                <div class="relative z-10 max-w-md">
                    <h1 class="text-3xl xl:text-4xl font-bold text-white leading-tight mb-4">
                        Manage your documents with confidence
                    </h1>
                    <p class="text-primary-100/80 text-lg leading-relaxed">
                        A secure, streamlined workspace for organizing, tracking, and collaborating on your important documents.
                    </p>
                </div>

                {{-- Footer --}}
                <div class="relative z-10">
                    <p class="text-primary-200/50 text-sm">
                        &copy; {{ date('Y') }} {{ config('app.name', 'DocumentMS') }}. All rights reserved.
                    </p>
                </div>
            </div>

            {{-- Right form panel --}}
            <div class="
                flex flex-1 flex-col items-center justify-center
                px-6 py-12
                sm:px-12
                lg:w-1/2 xl:w-[45%]
            ">
                {{-- Mobile logo (hidden on large screens) --}}
                <div class="lg:hidden mb-8">
                    <a href="/" class="inline-flex items-center gap-2.5 group">
                        <div class="
                            w-9 h-9 rounded-lg
                            bg-primary-500
                            flex items-center justify-center
                        ">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        <span class="text-lg font-semibold text-surface-800 tracking-tight">
                            {{ config('app.name', 'DocumentMS') }}
                        </span>
                    </a>
                </div>

                {{-- Form card --}}
                <div class="
                    w-full max-w-md
                    animate-fade-in
                ">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
