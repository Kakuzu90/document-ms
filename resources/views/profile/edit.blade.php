<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-surface-900 tracking-tight">
            {{ __('Profile Settings') }}
        </h1>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Left Column: Sticky Profile Card --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-8 card overflow-hidden border-0 ring-1 ring-surface-200/50 shadow-xl shadow-surface-200/20 bg-white/70 backdrop-blur-xl animate-fade-in">
                        <div class="h-32 w-full bg-gradient-to-br from-primary-400 via-secondary-500 to-primary-600 relative">
                            {{-- Decorative pattern overlay --}}
                            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 16px 16px;"></div>
                        </div>
                        <div class="px-6 pb-6 pt-0 relative flex flex-col items-center">
                            {{-- Avatar --}}
                            <div class="-mt-16 mb-4 relative group">
                                <div class="w-32 h-32 rounded-full ring-4 ring-white shadow-lg bg-gradient-to-br from-surface-100 to-surface-200 flex items-center justify-center text-4xl font-black text-surface-400 uppercase relative overflow-hidden transition-transform duration-300 group-hover:scale-105">
                                    {{ substr($user->name, 0, 1) }}
                                    <div class="absolute inset-0 bg-gradient-to-tr from-primary-500/10 to-transparent"></div>
                                </div>
                                <div class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 border-4 border-white rounded-full"></div>
                            </div>
                            
                            {{-- Info --}}
                            <div class="text-center w-full">
                                <h2 class="text-xl font-bold text-surface-900 tracking-tight truncate">{{ $user->name }}</h2>
                                <p class="text-surface-500 text-sm font-medium mt-1 truncate">{{ $user->email }}</p>
                                
                                <div class="mt-4 pt-4 border-t border-surface-200/60 flex items-center justify-between px-2">
                                    <div class="text-left">
                                        <p class="text-xs text-surface-400 uppercase tracking-wider font-semibold mb-1">Role</p>
                                        <p class="text-sm font-medium text-surface-800 capitalize flex items-center gap-1.5">
                                            @if($user->isAdmin())
                                                <span class="w-2 h-2 rounded-full bg-secondary-500"></span>
                                            @else
                                                <span class="w-2 h-2 rounded-full bg-primary-500"></span>
                                            @endif
                                            {{ $user->role }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-surface-400 uppercase tracking-wider font-semibold mb-1">Joined</p>
                                        <p class="text-sm font-medium text-surface-800">{{ $user->created_at->format('M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Settings Forms --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Profile Information --}}
                    <div class="card border-0 ring-1 ring-surface-200/50 shadow-md bg-white/80 backdrop-blur-lg animate-slide-up" style="animation-delay: 100ms;">
                        <div class="card-body p-8">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    {{-- Update Password --}}
                    <div class="card border-0 ring-1 ring-surface-200/50 shadow-md bg-white/80 backdrop-blur-lg animate-slide-up" style="animation-delay: 200ms;">
                        <div class="card-body p-8">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
