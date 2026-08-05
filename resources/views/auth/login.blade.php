<x-guest-layout>
    <div class="space-y-6">
        {{-- Heading --}}
        <div>
            <h1 class="text-2xl font-bold text-surface-900 tracking-tight">
                {{ __('Welcome back') }}
            </h1>
            <p class="mt-1.5 text-sm text-surface-500">
                {{ __('Sign in to your account to continue.') }}
            </p>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email Address --}}
            <div>
                <x-input-label for="email" :value="__('Email address')" />
                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="you@example.com"
                />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            {{-- Password --}}
            <div>
                <div class="flex items-center justify-between">
                    <x-input-label for="password" :value="__('Password')" />
                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-xs font-medium text-primary-600 hover:text-primary-700 transition-colors"
                        >
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>
                <x-text-input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="
                        w-4 h-4 rounded
                        border-surface-300
                        text-primary-600
                        focus:ring-primary-500 focus:ring-offset-0
                        transition-colors
                    "
                >
                <label for="remember_me" class="ml-2.5 text-sm text-surface-600">
                    {{ __('Remember me') }}
                </label>
            </div>

            {{-- Submit --}}
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Sign in') }}
            </x-primary-button>
        </form>

        {{-- Register link --}}
        <p class="text-center text-sm text-surface-500">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-700 transition-colors">
                {{ __('Create one') }}
            </a>
        </p>
    </div>
</x-guest-layout>
