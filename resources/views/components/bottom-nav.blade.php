{{-- Mobile-only bottom navigation bar --}}
<nav class="
    sm:hidden
    fixed bottom-0 inset-x-0 z-50
    glass
    border-t border-surface-200/60
" style="padding-bottom: env(safe-area-inset-bottom, 0px);">
    <div class="flex items-center justify-around h-16 px-2">
        {{-- Dashboard --}}
        <a
            href="{{ route('dashboard') }}"
            class="
                flex flex-col items-center justify-center gap-0.5
                w-16 py-1.5 rounded-xl
                transition-colors duration-200
                {{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-surface-400 hover:text-surface-600' }}
            "
        >
            @if(request()->routeIs('dashboard'))
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                    <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                </svg>
            @else
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
            @endif
            <span class="text-[10px] font-medium leading-none">{{ __('Home') }}</span>
        </a>

        @if(Auth::user()->isAdmin())
            {{-- Teachers --}}
            <a
                href="{{ route('admin.teachers.index') }}"
                class="
                    flex flex-col items-center justify-center gap-0.5
                    w-16 py-1.5 rounded-xl
                    transition-colors duration-200
                    {{ request()->routeIs('admin.teachers.*') ? 'text-primary-600' : 'text-surface-400 hover:text-surface-600' }}
                "
            >
                @if(request()->routeIs('admin.teachers.*'))
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd" />
                        <path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.56.196-1.15.352-1.764.441Z" />
                    </svg>
                @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                @endif
                <span class="text-[10px] font-medium leading-none">{{ __('Teachers') }}</span>
            </a>
        @endif

        {{-- Profile --}}
        <a
            href="{{ route('profile.edit') }}"
            class="
                flex flex-col items-center justify-center gap-0.5
                w-16 py-1.5 rounded-xl
                transition-colors duration-200
                {{ request()->routeIs('profile.*') ? 'text-primary-600' : 'text-surface-400 hover:text-surface-600' }}
            "
        >
            @if(request()->routeIs('profile.*'))
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                </svg>
            @else
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            @endif
            <span class="text-[10px] font-medium leading-none">{{ __('Profile') }}</span>
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" class="contents">
            @csrf
            <button
                type="submit"
                class="
                    flex flex-col items-center justify-center gap-0.5
                    w-16 py-1.5 rounded-xl
                    text-surface-400 hover:text-danger-500
                    transition-colors duration-200
                "
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                </svg>
                <span class="text-[10px] font-medium leading-none">{{ __('Logout') }}</span>
            </button>
        </form>
    </div>
</nav>
