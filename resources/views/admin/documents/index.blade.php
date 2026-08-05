<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Document Submissions') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Filters -->
            <div class="card mb-6 animate-slide-up">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.documents.index') }}" class="flex flex-col sm:flex-row items-end gap-4">
                        <div class="w-full sm:w-1/3">
                            <x-input-label for="status" :value="__('Filter by Status')" />
                            <select name="status" id="status" class="form-input mt-1 w-full bg-white">
                                <option value="">All Statuses</option>
                                @foreach($statuses as $status)
                                    @if($status->value !== 'draft')
                                        <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                                            {{ $status->label() }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full sm:w-1/3">
                            <x-input-label for="type" :value="__('Filter by Type')" />
                            <select name="type" id="type" class="form-input mt-1 w-full bg-white">
                                <option value="">All Types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->value }}" {{ request('type') === $type->value ? 'selected' : '' }}>
                                        {{ $type->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full sm:w-auto">
                            <x-primary-button class="w-full sm:w-auto justify-center">
                                {{ __('Filter') }}
                            </x-primary-button>
                        </div>
                        @if(request()->hasAny(['status', 'type']))
                            <div class="w-full sm:w-auto">
                                <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary w-full sm:w-auto justify-center">
                                    {{ __('Clear') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card animate-fade-in" style="animation-delay: 100ms;">
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
                                        <a href="#" class="font-medium text-primary-600 hover:text-primary-700">Review</a>
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
