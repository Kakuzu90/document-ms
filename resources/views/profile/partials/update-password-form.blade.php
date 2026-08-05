<section>
    <header>
        <div class="flex items-center gap-3 mb-1">
            <div class="w-9 h-9 rounded-lg bg-primary-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-surface-900">
                    {{ __('Update Password') }}
                </h2>
                <p class="text-sm text-surface-500">
                    {{ __('Use a long, random password to stay secure.') }}
                </p>
            </div>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current password')" />
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        {{-- New Password --}}
        <div>
            <x-input-label for="update_password_password" :value="__('New password')" />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        {{-- Confirm Password --}}
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm new password')" />
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-2">
            <x-primary-button>{{ __('Update password') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-success-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
