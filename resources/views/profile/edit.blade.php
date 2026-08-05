<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-surface-900 tracking-tight">
            {{ __('Profile Settings') }}
        </h1>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {{-- Profile Information --}}
            <div class="card animate-slide-up">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="card animate-slide-up" style="animation-delay: 100ms;">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="card animate-slide-up" style="animation-delay: 200ms;">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
