<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            @if (session('status'))
                <x-auth-session-status class="mb-4" :status="session('status')" />
            @endif
            
            <!-- Welcome Header -->
            <div class="card overflow-hidden animate-slide-up shadow-sm">
                <div class="bg-gradient-to-r from-primary-600 to-primary-800 px-6 py-8 text-white relative flex justify-between items-center rounded-xl">
                    <!-- Subtle pattern overlay -->
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold tracking-tight">Welcome back, {{ auth()->user()->name }}</h3>
                        <p class="text-primary-100 mt-2 text-sm">Track the status of your document submissions.</p>
                    </div>
                    <div class="relative z-10 flex gap-3">
                        <a href="{{ route('teacher.documents.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full font-semibold text-white hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all shadow-sm">
                            {{ __('My Documents') }}
                        </a>
                        <a href="{{ route('teacher.documents.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-transparent rounded-full font-semibold text-primary-700 hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            {{ __('Upload Document') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-slide-up" style="animation-delay: 50ms;">
                <!-- Total Submitted -->
                <div class="bg-white rounded-2xl p-6 border border-surface-200 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-surface-100 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2.5 bg-surface-100 text-surface-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                        </div>
                        <dt class="text-sm font-semibold text-surface-500 uppercase tracking-wider">Total Submitted</dt>
                        <dd class="mt-1 text-3xl font-bold text-surface-900">{{ $stats['total_submitted'] }}</dd>
                    </div>
                </div>

                <!-- Approved -->
                <div class="bg-white rounded-2xl p-6 border border-surface-200 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-success-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2.5 bg-success-100 text-success-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <dt class="text-sm font-semibold text-surface-500 uppercase tracking-wider">Approved</dt>
                        <dd class="mt-1 text-3xl font-bold text-success-600">{{ $stats['approved'] }}</dd>
                    </div>
                </div>

                <!-- Needs Revision -->
                <div class="bg-white rounded-2xl p-6 border border-surface-200 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-warning-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2.5 bg-warning-100 text-warning-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                        </div>
                        <dt class="text-sm font-semibold text-surface-500 uppercase tracking-wider">Needs Revision</dt>
                        <dd class="mt-1 text-3xl font-bold text-warning-600">{{ $stats['needs_revision'] }}</dd>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in" style="animation-delay: 150ms;">
                <!-- Action Required Table -->
                <div class="bg-white rounded-2xl border border-surface-200 shadow-sm flex flex-col h-full overflow-hidden">
                    <div class="px-6 py-5 border-b border-surface-200 bg-surface-50/50 flex justify-between items-center">
                        <h3 class="text-base font-semibold text-surface-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Action Required
                        </h3>
                        @if($actionRequired->count() > 0)
                            <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-bold text-white bg-warning-500 rounded-full shadow-sm">{{ $actionRequired->count() }} Pending</span>
                        @endif
                    </div>
                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-sm text-left text-surface-600">
                            <thead class="text-xs text-surface-500 uppercase bg-surface-50/50 border-b border-surface-200 font-semibold tracking-wider">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Document</th>
                                    <th scope="col" class="px-6 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-100">
                                @forelse ($actionRequired as $document)
                                    <tr class="bg-white hover:bg-warning-50/50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-surface-900 group-hover:text-warning-800 transition-colors">{{ $document->title }}</div>
                                            <div class="text-xs text-surface-500 mt-1 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                {{ $document->type->label() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('teacher.documents.show', $document) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-warning-700 hover:text-warning-900 bg-warning-100 px-3 py-1.5 rounded-lg group-hover:bg-warning-200 transition-colors">
                                                Update
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-12 text-center text-surface-500">
                                            <div class="w-12 h-12 bg-surface-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-6 h-6 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <p class="text-sm font-medium">You have no documents needing revision.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recently Reviewed Table -->
                <div class="bg-white rounded-2xl border border-surface-200 shadow-sm flex flex-col h-full overflow-hidden">
                    <div class="px-6 py-5 border-b border-surface-200 bg-surface-50/50">
                        <h3 class="text-base font-semibold text-surface-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Recently Reviewed
                        </h3>
                    </div>
                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-sm text-left text-surface-600">
                            <thead class="text-xs text-surface-500 uppercase bg-surface-50/50 border-b border-surface-200 font-semibold tracking-wider">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Document</th>
                                    <th scope="col" class="px-6 py-4">Status</th>
                                    <th scope="col" class="px-6 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-100">
                                @forelse ($recentlyReviewed as $document)
                                    <tr class="bg-white hover:bg-surface-50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-surface-900">{{ $document->title }}</div>
                                            <div class="text-xs text-surface-500 mt-1 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $document->updated_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-status-badge :status="$document->status" />
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('teacher.documents.show', $document) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-surface-600 hover:text-surface-900 bg-surface-100 px-3 py-1.5 rounded-lg group-hover:bg-surface-200 transition-colors">
                                                View
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-surface-500">
                                            <div class="w-12 h-12 bg-surface-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-6 h-6 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="text-sm font-medium">No recently reviewed documents.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
