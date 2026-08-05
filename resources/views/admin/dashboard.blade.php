<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Header -->
            <div class="card overflow-hidden animate-slide-up shadow-sm">
                <div class="bg-gradient-to-r from-primary-600 to-primary-800 px-6 py-8 text-white relative flex justify-between items-center rounded-xl">
                    <!-- Subtle pattern overlay -->
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold tracking-tight">Welcome back, {{ auth()->user()->name }}</h3>
                        <p class="text-primary-100 mt-2 text-sm">Here is the latest overview of document submissions.</p>
                    </div>
                    <div class="relative z-10">
                        <a href="{{ route('admin.documents.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-transparent rounded-full font-semibold text-primary-700 hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            {{ __('View All Submissions') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 animate-slide-up" style="animation-delay: 50ms;">
                <!-- Teachers -->
                <div class="bg-white rounded-2xl p-6 border border-surface-200 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2.5 bg-primary-100 text-primary-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                        </div>
                        <dt class="text-sm font-semibold text-surface-500 uppercase tracking-wider">Total Teachers</dt>
                        <dd class="mt-1 text-3xl font-bold text-surface-900">{{ $totalTeachers }}</dd>
                        <p class="text-xs text-surface-500 mt-auto pt-4 border-t border-surface-100">
                            <span class="text-success-600 font-semibold">{{ $teacherCounts['active'] }} active</span> &middot; {{ $teacherCounts['inactive'] }} inactive
                        </p>
                    </div>
                </div>

                <!-- Submitted -->
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

                <!-- Under Review -->
                <div class="bg-white rounded-2xl p-6 border border-surface-200 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2.5 bg-blue-100 text-blue-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                        </div>
                        <dt class="text-sm font-semibold text-surface-500 uppercase tracking-wider">Under Review</dt>
                        <dd class="mt-1 text-3xl font-bold text-blue-600">{{ $stats['under_review'] }}</dd>
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
                                    <th scope="col" class="px-6 py-4">Status</th>
                                    <th scope="col" class="px-6 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-100">
                                @forelse ($actionRequired as $document)
                                    <tr class="bg-white hover:bg-primary-50/50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-surface-900 group-hover:text-primary-700 transition-colors">{{ $document->title }}</div>
                                            <div class="text-xs text-surface-500 mt-1 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                {{ $document->user->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-status-badge :status="$document->status" />
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('admin.documents.show', $document) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary-600 hover:text-primary-800 bg-primary-50 px-3 py-1.5 rounded-lg group-hover:bg-primary-100 transition-colors">
                                                Review
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-surface-500">
                                            <div class="w-12 h-12 bg-surface-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-6 h-6 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <p class="text-sm font-medium">No submissions pending action.</p>
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
                                            <a href="{{ route('admin.documents.show', $document) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-surface-600 hover:text-surface-900 bg-surface-100 px-3 py-1.5 rounded-lg group-hover:bg-surface-200 transition-colors">
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
                                            <p class="text-sm font-medium">No reviewed documents found.</p>
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
