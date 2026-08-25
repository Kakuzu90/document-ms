<x-guest-layout>
    <div class="space-y-6">
        {{-- Heading --}}
        <div>
            <h1 class="text-2xl font-bold text-surface-900 tracking-tight">
                {{ __('Reset your password') }}
            </h1>
            <p class="mt-1.5 text-sm text-surface-500">
                {{ __('Enter your email address and we\'ll send you a link to reset your password.') }}
            </p>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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
                    placeholder="you@example.com"
                />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            {{-- Submit --}}
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Send reset link') }}
            </x-primary-button>
        </form>

        {{-- Back to login --}}
        <p class="text-center text-sm text-surface-500">
            {{ __('Remember your password?') }}
            <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-700 transition-colors">
                {{ __('Sign in') }}
            </a>
        </p>
    </div>
</x-guest-layout>
