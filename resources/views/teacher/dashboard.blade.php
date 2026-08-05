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
            <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-surface-200 shadow-sm animate-slide-up">
                <div>
                    <h3 class="text-lg font-medium text-surface-900">Welcome back, {{ auth()->user()->name }}</h3>
                    <p class="text-surface-500 text-sm mt-1">Track the status of your document submissions.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('teacher.documents.index') }}" class="btn btn-secondary">
                        {{ __('My Documents') }}
                    </a>
                    <a href="{{ route('teacher.documents.create') }}" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        {{ __('Upload Document') }}
                    </a>
                </div>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-slide-up" style="animation-delay: 50ms;">
                <div class="bg-white p-6 rounded-xl border border-surface-200 shadow-sm">
                    <dt class="text-sm font-medium text-surface-500 truncate">Total Submitted</dt>
                    <dd class="mt-2 text-3xl font-bold text-surface-900">{{ $stats['total_submitted'] }}</dd>
                </div>
                <div class="bg-white p-6 rounded-xl border border-surface-200 shadow-sm">
                    <dt class="text-sm font-medium text-surface-500 truncate">Approved</dt>
                    <dd class="mt-2 text-3xl font-bold text-success-600">{{ $stats['approved'] }}</dd>
                </div>
                <div class="bg-white p-6 rounded-xl border border-surface-200 shadow-sm">
                    <dt class="text-sm font-medium text-surface-500 truncate">Needs Revision</dt>
                    <dd class="mt-2 text-3xl font-bold text-warning-600">{{ $stats['needs_revision'] }}</dd>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in" style="animation-delay: 150ms;">
                <!-- Action Required Table -->
                <div class="card flex flex-col h-full">
                    <div class="px-6 py-5 border-b border-surface-200 flex justify-between items-center">
                        <h3 class="text-base font-semibold text-surface-900">Action Required</h3>
                        @if($actionRequired->count() > 0)
                            <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-warning-500 rounded-full">{{ $actionRequired->count() }}</span>
                        @endif
                    </div>
                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-sm text-left text-surface-500">
                            <thead class="text-xs text-surface-700 uppercase bg-surface-50 border-b border-surface-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Document</th>
                                    <th scope="col" class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($actionRequired as $document)
                                    <tr class="bg-white border-b border-surface-100 hover:bg-surface-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-surface-900">{{ $document->title }}</div>
                                            <div class="text-xs text-surface-500 mt-0.5">{{ $document->type->label() }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('teacher.documents.show', $document) }}" class="text-primary-600 hover:text-primary-700 font-medium">Update</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-8 text-center text-surface-500">
                                            <svg class="mx-auto h-8 w-8 text-surface-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <p class="text-sm">You have no documents needing revision.</p>
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
                                            <a href="{{ route('teacher.documents.show', $document) }}" class="text-primary-600 hover:text-primary-700 font-medium">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-surface-500">
                                            <p class="text-sm">No recently reviewed documents.</p>
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
