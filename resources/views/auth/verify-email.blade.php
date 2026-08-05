<x-guest-layout>
    <div class="space-y-6">
        {{-- Heading --}}
        <div>
            <div class="
                w-12 h-12 rounded-xl
                bg-primary-50
                flex items-center justify-center
                mb-4
            ">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-surface-900 tracking-tight">
                {{ __('Verify your email') }}
            </h1>
            <p class="mt-1.5 text-sm text-surface-500 leading-relaxed">
                {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we just sent you.') }}
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>{{ __('A new verification link has been sent to your email address.') }}</span>
            </div>
        @endif

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>
                    {{ __('Resend verification email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="text-sm font-medium text-surface-500 hover:text-surface-700 transition-colors"
                >
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
