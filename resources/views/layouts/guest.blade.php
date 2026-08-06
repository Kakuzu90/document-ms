<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DocumentMS') }}</title>
        
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

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
                            w-12 h-12 rounded-full overflow-hidden
                            bg-white/10 backdrop-blur-md
                            border border-white/20
                            flex items-center justify-center
                            group-hover:bg-white/20
                            transition-colors duration-200
                            p-1
                        ">
                            <img src="{{ asset('favicon.png') }}" alt="{{ config('app.name') }} Logo" class="w-full h-full object-contain drop-shadow-md" />
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
                            w-10 h-10 rounded-full overflow-hidden
                            flex items-center justify-center
                        ">
                            <img src="{{ asset('favicon.png') }}" alt="{{ config('app.name') }} Logo" class="w-full h-full object-contain" />
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
