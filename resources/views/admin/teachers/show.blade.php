<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Teacher Profile') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Header Card -->
            <div class="card p-6 animate-slide-up">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="flex items-center gap-5">
                        <div class="h-16 w-16 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-2xl font-bold uppercase shrink-0">
                            {{ substr($teacher->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-surface-900 flex items-center gap-3">
                                {{ $teacher->name }}
                                @if($teacher->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-surface-100 text-surface-800">Inactive</span>
                                @endif
                            </h3>
                            <p class="text-surface-500 mt-1">{{ $teacher->email }}</p>
                            <p class="text-surface-400 text-sm mt-1">Joined {{ $teacher->created_at->format('M j, Y') }}</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-secondary w-full sm:w-auto">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Documents List -->
            <div class="card overflow-hidden animate-slide-up" style="animation-delay: 50ms;">
                <div class="px-6 py-5 border-b border-surface-200">
                    <h3 class="text-lg font-medium text-surface-900">Recent Documents</h3>
                    <p class="text-sm text-surface-500 mt-1">The 10 most recently submitted documents by this teacher.</p>
                </div>
                
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-surface-500">
                        <thead class="text-xs text-surface-700 uppercase bg-surface-50 border-b border-surface-200">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">Title</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Type</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Submitted</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-100 bg-white">
                            @forelse($documents as $document)
                                <tr class="hover:bg-surface-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-surface-900">
                                        {{ $document->title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $document->type->label() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-status-badge :status="$document->status" />
                                    </td>
                                    <td class="px-6 py-4 text-surface-600">
                                        {{ $document->created_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.documents.show', $document) }}" class="text-primary-600 hover:text-primary-900 font-medium transition-colors">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="mt-4 text-sm text-surface-500">This teacher hasn't submitted any documents yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
