<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Document Submissions') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Filters -->
            @php
                $statusOptions = collect($statuses)->filter(fn($s) => $s->value !== 'draft')->map(fn($s) => ['value' => $s->value, 'label' => $s->label()])->values()->toArray();
                $typeOptions = collect($types)->map(fn($t) => ['value' => $t->value, 'label' => $t->label()])->toArray();
            @endphp
            <div class="card mb-6 animate-slide-up relative z-20">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.documents.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <!-- Search -->
                            <div class="md:col-span-3 lg:col-span-1">
                                <x-input-label for="search" :value="__('Search')" />
                                <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-input mt-1 w-full bg-white" placeholder="Search by title or teacher name...">
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <x-searchable-select
                                    name="status"
                                    id="status"
                                    :options="$statusOptions"
                                    :value="request('status')"
                                    placeholder="All Statuses"
                                    :searchable="false"
                                />
                            </div>

                            <!-- Type -->
                            <div>
                                <x-input-label for="type" :value="__('Type')" />
                                <x-searchable-select
                                    name="type"
                                    id="type"
                                    :options="$typeOptions"
                                    :value="request('type')"
                                    placeholder="All Types"
                                    :searchable="false"
                                />
                            </div>

                            <!-- Date From -->
                            <div>
                                <x-input-label for="submitted_from" :value="__('Submitted From')" />
                                <input type="date" name="submitted_from" id="submitted_from" value="{{ request('submitted_from') }}" class="form-input mt-1 w-full bg-white">
                            </div>

                            <!-- Date To -->
                            <div>
                                <x-input-label for="submitted_to" :value="__('Submitted To')" />
                                <input type="date" name="submitted_to" id="submitted_to" value="{{ request('submitted_to') }}" class="form-input mt-1 w-full bg-white">
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <x-primary-button>
                                {{ __('Filter Results') }}
                            </x-primary-button>
                            
                            @if(request()->hasAny(['search', 'status', 'type', 'submitted_from', 'submitted_to']))
                                <a href="{{ route('admin.documents.index') }}" class="text-sm font-medium text-surface-500 hover:text-surface-900 transition-colors">
                                    {{ __('Clear Filters') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card animate-fade-in relative z-10" style="animation-delay: 100ms;">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-surface-500">
                        <thead class="text-xs text-surface-700 uppercase bg-surface-50 border-b border-surface-200">
                            <tr>
                                <th scope="col" class="px-6 py-3">Teacher</th>
                                <th scope="col" class="px-6 py-3">Document Title</th>
                                <th scope="col" class="px-6 py-3">Type</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Submitted</th>
                                <th scope="col" class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($documents as $document)
                                <tr class="bg-white border-b border-surface-100 hover:bg-surface-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-surface-900">
                                        {{ $document->user->name }}
                                        <div class="font-normal text-surface-500 text-xs mt-0.5">{{ $document->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-surface-900">
                                        {{ $document->title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $document->type->label() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-status-badge :status="$document->status" />
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $document->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.documents.show', $document) }}" class="font-medium text-primary-600 hover:text-primary-700">Review</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-surface-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-surface-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-base font-medium">No documents found</p>
                                            <p class="mt-1 text-sm">No submissions match your current filters.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if ($documents->hasPages())
                    <div class="px-6 py-4 border-t border-surface-200">
                        {{ $documents->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
