<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Header -->
            <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-surface-200 shadow-sm animate-slide-up">
                <div>
                    <h3 class="text-lg font-medium text-surface-900">Welcome back, {{ auth()->user()->name }}</h3>
                    <p class="text-surface-500 text-sm mt-1">Here is the latest overview of document submissions.</p>
                </div>
                <a href="{{ route('admin.documents.index') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    {{ __('View All Submissions') }}
                </a>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 animate-slide-up" style="animation-delay: 50ms;">
                <div class="card">
                    <div class="card-body">
                        <dt class="text-sm font-medium text-surface-500 truncate">Total Teachers</dt>
                        <dd class="mt-2 text-3xl font-bold text-surface-900">{{ $totalTeachers }}</dd>
                        <p class="text-xs text-surface-500 mt-1"><span class="text-success-600 font-medium">{{ $teacherCounts['active'] }} active</span> · {{ $teacherCounts['inactive'] }} inactive</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <dt class="text-sm font-medium text-surface-500 truncate">Total Submitted</dt>
                        <dd class="mt-2 text-3xl font-bold text-surface-900">{{ $stats['total_submitted'] }}</dd>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <dt class="text-sm font-medium text-surface-500 truncate">Under Review</dt>
                        <dd class="mt-2 text-3xl font-bold text-primary-600">{{ $stats['under_review'] }}</dd>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <dt class="text-sm font-medium text-surface-500 truncate">Approved</dt>
                        <dd class="mt-2 text-3xl font-bold text-success-600">{{ $stats['approved'] }}</dd>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <dt class="text-sm font-medium text-surface-500 truncate">Needs Revision</dt>
                        <dd class="mt-2 text-3xl font-bold text-warning-600">{{ $stats['needs_revision'] }}</dd>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in" style="animation-delay: 150ms;">
                <!-- Action Required Table -->
                <div class="card flex flex-col h-full">
                    <div class="px-6 py-5 border-b border-surface-200 flex justify-between items-center">
                        <h3 class="text-base font-semibold text-surface-900">Action Required</h3>
                        <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-primary-500 rounded-full">{{ $actionRequired->count() }}</span>
                    </div>
                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-sm text-left text-surface-500">
                            <thead class="text-xs text-surface-700 uppercase bg-surface-50 border-b border-surface-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Document</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($actionRequired as $document)
                                    <tr class="bg-white border-b border-surface-100 hover:bg-surface-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-surface-900">{{ $document->title }}</div>
                                            <div class="text-xs text-surface-500 mt-0.5">by {{ $document->user->name }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-status-badge :status="$document->status" />
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('admin.documents.show', $document) }}" class="text-primary-600 hover:text-primary-700 font-medium">Review</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-surface-500">
                                            <p class="text-sm">No submissions pending action.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recently Reviewed Table -->
                <div class="card flex flex-col h-full">
                    <div class="px-6 py-5 border-b border-surface-200">
                        <h3 class="text-base font-semibold text-surface-900">Recently Reviewed</h3>
                    </div>
                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-sm text-left text-surface-500">
                            <thead class="text-xs text-surface-700 uppercase bg-surface-50 border-b border-surface-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Document</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentlyReviewed as $document)
                                    <tr class="bg-white border-b border-surface-100 hover:bg-surface-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-surface-900">{{ $document->title }}</div>
                                            <div class="text-xs text-surface-500 mt-0.5">{{ $document->updated_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-status-badge :status="$document->status" />
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('admin.documents.show', $document) }}" class="text-primary-600 hover:text-primary-700 font-medium">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-surface-500">
                                            <p class="text-sm">No reviewed documents found.</p>
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
