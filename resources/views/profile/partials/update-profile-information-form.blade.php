<section>
    <header class="border-b border-surface-200/60 pb-5 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center shadow-sm ring-1 ring-primary-200/50">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-surface-900 tracking-tight">
                    {{ __('Profile Information') }}
                </h2>
                <p class="text-sm text-surface-500 mt-0.5">
                    {{ __("Update your account's profile information and email address.") }}
                </p>
            </div>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div class="group">
            <x-input-label for="name" :value="__('Full Name')" class="mb-1.5 transition-colors group-focus-within:text-primary-600" />
            <div class="relative">
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    :value="old('name', $user->name)"
                    required
                    autofocus
                    autocomplete="name"
                    class="w-full transition-all duration-200 focus:ring-4 focus:ring-primary-500/20"
                />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div class="group">
            <x-input-label for="email" :value="__('Email Address')" class="mb-1.5 transition-colors group-focus-within:text-primary-600" />
            <div class="relative">
                <x-text-input
                    id="email"
                    name="email"
                    type="email"
                    :value="old('email', $user->email)"
                    required
                    autocomplete="username"
                    class="w-full transition-all duration-200 focus:ring-4 focus:ring-primary-500/20"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-4 bg-yellow-50 rounded-lg border border-yellow-100 flex items-start gap-3 animate-fade-in">
                    <svg class="w-5 h-5 text-yellow-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <p class="text-sm font-medium text-yellow-800">
                            {{ __('Your email address is unverified.') }}
                        </p>
                        <button
                            form="send-verification"
                            class="mt-1 text-sm font-semibold text-yellow-700 hover:text-yellow-900 transition-colors underline underline-offset-2"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </div>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-3 text-sm font-medium text-success-600 flex items-center gap-2 animate-fade-in">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-4 pt-4 border-t border-surface-100">
            <x-primary-button class="shadow-sm hover:shadow-md transition-all px-6 py-2.5">
                {{ __('Save Changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    x-init="setTimeout(() => show = false, 2500)"
                    class="flex items-center gap-2 text-sm font-medium text-success-600 bg-success-50 px-3 py-1.5 rounded-full"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Saved Successfully') }}
                </div>
            @endif
        </div>
    </form>
</section>
