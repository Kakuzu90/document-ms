{{-- Horizontal top navigation bar (desktop) --}}
<nav class="
    hidden sm:block
    bg-white/80 backdrop-blur-xl
    border-b border-surface-200
    sticky top-0 z-40
">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Left: Logo --}}
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2.5 group">
                    <div class="
                        w-8 h-8 rounded-lg
                        bg-primary-500
                        flex items-center justify-center
                        transition-transform duration-200
                        group-hover:scale-105
                    ">
                        <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <span class="text-base font-semibold text-surface-800 tracking-tight">
                        {{ config('app.name', 'DocumentMS') }}
                    </span>
                </a>
            </div>

            {{-- Center: Nav links --}}
            <div class="flex items-center gap-1">
                @php
                    $active = request()->routeIs('admin.dashboard') || request()->routeIs('teacher.dashboard') ? true : false;
                @endphp
                <x-nav-link :href="route('dashboard')" :active="$active">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    {{ __('Dashboard') }}
                </x-nav-link>

                @if(Auth::user()->isAdmin())
                    <x-nav-link :href="route('admin.teachers.index')" :active="request()->routeIs('admin.teachers.*')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        {{ __('Teachers') }}
                    </x-nav-link>
                @endif
            </div>

            {{-- Right: Notifications & User dropdown --}}
            <div class="flex items-center gap-2">
                {{-- Notifications Dropdown --}}
                <x-dropdown align="right" width="80">
                    <x-slot name="trigger">
                        <button class="relative p-2 text-surface-400 hover:text-surface-600 focus:outline-none transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-danger-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-danger-500"></span>
                                </span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2.5 border-b border-surface-100 flex justify-between items-center">
                            <p class="text-sm font-semibold text-surface-800">Notifications</p>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="text-xs bg-danger-100 text-danger-700 py-0.5 px-2 rounded-full font-medium">{{ Auth::user()->unreadNotifications->count() }} new</span>
                            @endif
                        </div>
                        
                        <div class="max-h-96 overflow-y-auto">
                            @forelse(Auth::user()->notifications()->take(10)->get() as $notification)
                                <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 hover:bg-surface-50 border-b border-surface-100 last:border-b-0 transition-colors {{ $notification->read_at ? 'opacity-60' : 'bg-primary-50/30' }}">
                                    <p class="text-sm font-medium text-surface-900">{{ $notification->data['title'] ?? 'Document Update' }}</p>
                                    <p class="text-xs text-surface-600 mt-0.5">{{ $notification->data['message'] ?? '' }}</p>
                                    <p class="text-[10px] text-surface-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </a>
                            @empty
                                <div class="px-4 py-6 text-center text-sm text-surface-500">
                                    No notifications yet.
                                </div>
                            @endforelse
                        </div>
                    </x-slot>
                </x-dropdown>

                {{-- User Dropdown --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="
                            inline-flex items-center gap-2.5
                            px-3 py-1.5
                            rounded-lg
                            text-sm font-medium text-surface-600
                            hover:text-surface-800 hover:bg-surface-100
                            transition-all duration-200
                            focus:outline-none
                        ">
                            {{-- Avatar initial --}}
                            <div class="
                                w-7 h-7 rounded-full
                                bg-primary-100 text-primary-700
                                flex items-center justify-center
                                text-xs font-bold uppercase
                            ">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>

                            <span class="hidden md:inline">{{ Auth::user()->name }}</span>

                            <svg class="w-4 h-4 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- User info header --}}
                        <div class="px-4 py-2.5 border-b border-surface-100">
                            <p class="text-sm font-medium text-surface-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-surface-500 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <div class="border-t border-surface-100 my-1"></div>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                </svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
