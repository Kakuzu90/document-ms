<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'DocumentMS') }} — Secure Document Management</title>
        <meta name="description" content="A secure, streamlined workspace for organizing, tracking, and collaborating on your important documents.">
        
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-surface-50 text-surface-900">
        {{-- Navigation --}}
        <nav class="
            fixed top-0 inset-x-0 z-50
            glass
            border-b border-surface-200/60
        ">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    {{-- Logo --}}
                    <a href="/" class="inline-flex items-center gap-2.5 group">
                        <div class="
                            w-9 h-9 rounded-full overflow-hidden
                            flex items-center justify-center
                            transition-transform duration-200
                            group-hover:scale-105
                        ">
                            <img src="{{ asset('favicon.png') }}" alt="{{ config('app.name') }} Logo" class="w-full h-full object-contain drop-shadow-sm" />
                        </div>
                        <span class="text-base font-semibold text-surface-800 tracking-tight">
                            {{ config('app.name', 'DocumentMS') }}
                        </span>
                    </a>

                    {{-- Auth links --}}
                    <div class="flex items-center gap-3">
                        @auth
                            <a
                                href="{{ route('dashboard') }}"
                                class="btn btn-primary text-sm"
                            >
                                {{ __('Dashboard') }}
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="
                                    px-4 py-2 text-sm font-medium
                                    text-surface-600 hover:text-surface-800
                                    transition-colors
                                "
                            >
                                {{ __('Sign in') }}
                            </a>
                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="btn btn-primary text-sm"
                                >
                                    {{ __('Get Started') }}
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        {{-- Hero Section --}}
        <section class="relative pt-32 pb-20 sm:pt-40 sm:pb-28 overflow-hidden">
            {{-- Background decoration --}}
            <div class="absolute inset-0 -z-10">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[600px] rounded-full bg-primary-100/50 blur-[100px]"></div>
                <div class="absolute bottom-0 left-1/4 w-[400px] h-[400px] rounded-full bg-primary-200/30 blur-[80px]"></div>
            </div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                {{-- Badge --}}
                <div class="animate-fade-in">
                    <span class="
                        inline-flex items-center gap-1.5
                        px-3 py-1
                        text-xs font-medium
                        text-primary-700 bg-primary-50
                        border border-primary-100
                        rounded-full
                    ">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></span>
                        {{ __('Secure & Reliable') }}
                    </span>
                </div>

                {{-- Title --}}
                <h1 class="
                    mt-6
                    text-4xl sm:text-5xl lg:text-6xl
                    font-extrabold tracking-tight
                    text-surface-900
                    leading-[1.1]
                    animate-slide-up
                ">
                    {{ __('Document management,') }}
                    <br>
                    <span class="
                        bg-gradient-to-r from-primary-500 to-primary-700
                        bg-clip-text text-transparent
                    ">{{ __('simplified.') }}</span>
                </h1>

                {{-- Subtitle --}}
                <p class="
                    mt-6
                    text-lg sm:text-xl
                    text-surface-500
                    max-w-2xl mx-auto
                    leading-relaxed
                    animate-slide-up
                " style="animation-delay: 100ms;">
                    {{ __('A secure, streamlined workspace for organizing, tracking, and collaborating on your important documents. Built for teams that value simplicity.') }}
                </p>

                {{-- CTA buttons --}}
                <div class="
                    mt-10
                    flex flex-col sm:flex-row
                    items-center justify-center
                    gap-3
                    animate-slide-up
                " style="animation-delay: 200ms;">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary px-8 py-3 text-base">
                            {{ __('Go to Dashboard') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary px-8 py-3 text-base">
                                {{ __('Start for free') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        @endif
                        <a href="{{ route('login') }}" class="btn btn-secondary px-8 py-3 text-base">
                            {{ __('Sign in') }}
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        {{-- Features Section --}}
        <section class="py-20 sm:py-28">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-2xl sm:text-3xl font-bold text-surface-900 tracking-tight">
                        {{ __('Everything you need') }}
                    </h2>
                    <p class="mt-3 text-base text-surface-500 max-w-lg mx-auto">
                        {{ __('Powerful features to help you manage documents efficiently and securely.') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Feature 1 --}}
                    <div class="card group hover:shadow-md transition-shadow duration-300">
                        <div class="card-body">
                            <div class="w-11 h-11 rounded-xl bg-primary-50 flex items-center justify-center mb-4 group-hover:bg-primary-100 transition-colors">
                                <svg class="w-5.5 h-5.5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-surface-900">{{ __('Easy Uploads') }}</h3>
                            <p class="mt-1.5 text-sm text-surface-500 leading-relaxed">
                                {{ __('Drag and drop files or use the uploader. Supports all common document formats.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Feature 2 --}}
                    <div class="card group hover:shadow-md transition-shadow duration-300">
                        <div class="card-body">
                            <div class="w-11 h-11 rounded-xl bg-success-50 flex items-center justify-center mb-4 group-hover:bg-success-100 transition-colors">
                                <svg class="w-5.5 h-5.5 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-surface-900">{{ __('Secure Storage') }}</h3>
                            <p class="mt-1.5 text-sm text-surface-500 leading-relaxed">
                                {{ __('Your documents are encrypted and protected. Access controls ensure only authorized users can view them.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Feature 3 --}}
                    <div class="card group hover:shadow-md transition-shadow duration-300 sm:col-span-2 lg:col-span-1">
                        <div class="card-body">
                            <div class="w-11 h-11 rounded-xl bg-warning-50 flex items-center justify-center mb-4 group-hover:bg-primary-50 transition-colors">
                                <svg class="w-5.5 h-5.5 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-surface-900">{{ __('Instant Search') }}</h3>
                            <p class="mt-1.5 text-sm text-surface-500 leading-relaxed">
                                {{ __('Find any document in seconds with powerful full-text search across all your files.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="border-t border-surface-200 py-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-md flex items-center justify-center">
                            <img src="{{ asset('favicon.png') }}" alt="{{ config('app.name') }} Logo" class="w-full h-full object-contain drop-shadow-sm" />
                        </div>
                        <span class="text-sm font-medium text-surface-600">{{ config('app.name', 'DocumentMS') }}</span>
                    </div>
                    <p class="text-sm text-surface-400">
                        &copy; {{ date('Y') }} {{ config('app.name', 'DocumentMS') }}. {{ __('All rights reserved.') }}
                    </p>
                </div>
            </div>
        </footer>
    </body>
</html>
