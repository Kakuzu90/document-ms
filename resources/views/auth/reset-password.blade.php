<x-guest-layout>
    <div class="space-y-6">
        {{-- Heading --}}
        <div>
            <h1 class="text-2xl font-bold text-surface-900 tracking-tight">
                {{ __('Set new password') }}
            </h1>
            <p class="mt-1.5 text-sm text-surface-500">
                {{ __('Choose a strong password for your account.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            {{-- Password Reset Token --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- Email Address --}}
            <div>
                <x-input-label for="email" :value="__('Email address')" />
                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    :value="old('email', $request->email)"
                    required
                    autofocus
                    autocomplete="username"
                />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            {{-- Password --}}
            <div>
                <x-input-label for="password" :value="__('New password')" />
                <x-text-input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            {{-- Confirm Password --}}
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm new password')" />
                <x-text-input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            {{-- Submit --}}
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Reset password') }}
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
