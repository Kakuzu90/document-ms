<x-guest-layout>
    <div class="space-y-6">
        {{-- Heading --}}
        <div>
            <h1 class="text-2xl font-bold text-surface-900 tracking-tight">
                {{ __('Create your account') }}
            </h1>
            <p class="mt-1.5 text-sm text-surface-500">
                {{ __('Get started with your document workspace.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <x-input-label for="name" :value="__('Full name')" />
                <x-text-input
                    id="name"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="John Doe"
                />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            {{-- Email Address --}}
            <div>
                <x-input-label for="email" :value="__('Email address')" />
                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autocomplete="username"
                    placeholder="you@example.com"
                />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            {{-- Password --}}
            <div x-data="{ show: false }">
                <x-input-label for="password" :value="__('Password')" class="mb-1" />
                <div class="relative">
                    <x-text-input
                        id="password"
                        x-bind:type="show ? 'text' : 'password'"
                        name="password"
                        required
                        autocomplete="new-password"
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

            {{-- Confirm Password --}}
            <div x-data="{ show: false }">
                <x-input-label for="password_confirmation" :value="__('Confirm password')" class="mb-1" />
                <div class="relative">
                    <x-text-input
                        id="password_confirmation"
                        x-bind:type="show ? 'text' : 'password'"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full pr-10"
                    />
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-surface-400 hover:text-surface-600 transition-colors focus:outline-none cursor-pointer" aria-label="Toggle password visibility">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            {{-- Submit --}}
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Create account') }}
            </x-primary-button>
        </form>

        {{-- Login link --}}
        <p class="text-center text-sm text-surface-500">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-700 transition-colors">
                {{ __('Sign in') }}
            </a>
        </p>
    </div>
</x-guest-layout>
