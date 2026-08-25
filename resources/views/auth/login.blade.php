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
            <div x-data="{ show: false }">
                <div class="flex items-center justify-between mb-1">
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
                <div class="relative">
                    <x-text-input
                        id="password"
                        x-bind:type="show ? 'text' : 'password'"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full pr-10"
                    />
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-surface-400 hover:text-surface-600 transition-colors focus:outline-none cursor-pointer" aria-label="Toggle password visibility">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" />
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center group cursor-pointer w-fit">
                <div class="relative flex items-center justify-center w-5 h-5">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="peer sr-only"
                    >
                    <div class="w-5 h-5 bg-white border border-surface-300 rounded-md peer-checked:bg-primary-600 peer-checked:border-primary-600 peer-focus:ring-2 peer-focus:ring-primary-500/30 transition-all duration-200 ease-in-out group-hover:border-primary-400"></div>
                    <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-200 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <label for="remember_me" class="ml-3 text-sm font-medium text-surface-600 cursor-pointer select-none group-hover:text-surface-900 transition-colors">
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
