<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-surface-900 tracking-tight">
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Welcome card --}}
            <div class="card animate-slide-up">
                <div class="card-body flex flex-col sm:flex-row sm:items-center gap-4">
                    {{-- Avatar --}}
                    <div class="
                        w-14 h-14 rounded-2xl
                        bg-gradient-to-br from-primary-400 to-primary-600
                        flex items-center justify-center
                        text-white text-xl font-bold uppercase
                        shadow-md
                        shrink-0
                    ">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>

                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-surface-900">
                            {{ __('Welcome back, :name!', ['name' => Auth::user()->name]) }}
                        </h2>
                        <p class="mt-0.5 text-sm text-surface-500">
                            {{ __("You're logged in. Here's an overview of your workspace.") }}
                        </p>
                    </div>

                    <div class="sm:ml-auto">
                        <span class="
                            inline-flex items-center gap-1.5
                            px-3 py-1.5
                            text-xs font-medium
                            text-success-600 bg-success-50
                            border border-success-100
                            rounded-full
                        ">
                            <span class="w-1.5 h-1.5 rounded-full bg-success-500"></span>
                            {{ __('Active') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Stats grid --}}
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- Documents stat --}}
                <div class="card animate-slide-up" style="animation-delay: 100ms;">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-surface-500">{{ __('Documents') }}</p>
                                <p class="mt-1 text-2xl font-bold text-surface-900">0</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent activity stat --}}
                <div class="card animate-slide-up" style="animation-delay: 200ms;">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-surface-500">{{ __('Recent Activity') }}</p>
                                <p class="mt-1 text-2xl font-bold text-surface-900">0</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-success-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Storage stat --}}
                <div class="card animate-slide-up sm:col-span-2 lg:col-span-1" style="animation-delay: 300ms;">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-surface-500">{{ __('Storage Used') }}</p>
                                <p class="mt-1 text-2xl font-bold text-surface-900">0 MB</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-warning-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Empty state --}}
            <div class="mt-6 card animate-slide-up" style="animation-delay: 400ms;">
                <div class="card-body text-center py-12">
                    <div class="
                        w-16 h-16 rounded-2xl
                        bg-surface-100
                        flex items-center justify-center
                        mx-auto mb-4
                    ">
                        <svg class="w-8 h-8 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-surface-800">{{ __('No documents yet') }}</h3>
                    <p class="mt-1 text-sm text-surface-500 max-w-sm mx-auto">
                        {{ __('Get started by creating or uploading your first document.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
