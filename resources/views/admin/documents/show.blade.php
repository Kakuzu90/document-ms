<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Document Details') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Document Info -->
            <div class="card animate-slide-up">
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold text-surface-900">{{ $document->title }}</h3>
                            <p class="text-sm text-surface-500 mt-1">
                                Submitted by <span class="font-medium text-surface-700">{{ $document->user->name }}</span> 
                                on {{ $document->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <x-status-badge :status="$document->status" />
                    </div>
                    <div class="mt-4 flex gap-4 text-sm text-surface-700">
                        <div class="bg-surface-50 px-3 py-2 rounded-lg border border-surface-200">
                            <span class="text-surface-500 font-medium">Type:</span> {{ $document->type->label() }}
                        </div>
                        <div class="bg-surface-50 px-3 py-2 rounded-lg border border-surface-200">
                            <span class="text-surface-500 font-medium">File:</span> 
                            <a href="#" class="text-primary-600 hover:underline">Download</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Update Panel -->
            <div class="card animate-fade-in relative z-30" style="animation-delay: 50ms;">
                <div class="px-6 py-4 border-b border-surface-200 bg-surface-50">
                    <h4 class="font-semibold text-surface-900">Update Status</h4>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.documents.status.update', $document) }}" class="flex flex-col sm:flex-row sm:items-end gap-4">
                        @csrf
                        @method('PUT')
                        <div class="flex-1 max-w-sm w-full">
                            <x-input-label for="status_update" :value="__('Status')" />
                            <div class="mt-1">
                                <x-searchable-select 
                                    name="status" 
                                    :options="[
                                        ['value' => 'submitted', 'label' => 'Submitted'],
                                        ['value' => 'under_review', 'label' => 'Under Review'],
                                        ['value' => 'reviewed', 'label' => 'Reviewed'],
                                        ['value' => 'needs_revision', 'label' => 'Needs Revision'],
                                    ]" 
                                    :value="old('status', $document->status->value)"
                                    :searchable="false"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>
                        <div class="w-full sm:w-auto">
                            <x-primary-button class="w-full justify-center">
                                {{ __('Update Status') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Status History Panel -->
            @if($document->statusHistories->isNotEmpty())
            <div class="card animate-fade-in relative z-20" style="animation-delay: 75ms;">
                <div class="px-6 py-4 border-b border-surface-200 bg-surface-50">
                    <h4 class="font-semibold text-surface-900">Status History</h4>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($document->statusHistories as $history)
                            <div class="flex items-start gap-3 text-sm">
                                <div class="mt-1 shrink-0 w-2 h-2 rounded-full bg-primary-500"></div>
                                <div>
                                    <p class="text-surface-900">
                                        From <span class="font-semibold">{{ $history->from_status instanceof \App\Enums\DocumentStatus ? $history->from_status->label() : $history->from_status }}</span> &rarr; <span class="font-semibold">{{ $history->to_status instanceof \App\Enums\DocumentStatus ? $history->to_status->label() : $history->to_status }}</span>
                                    </p>
                                    <p class="text-surface-500 text-xs mt-0.5">
                                        by {{ $history->user->name }} on {{ $history->created_at->format('M j, Y g:i A') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Comments Section -->
            <div class="card animate-fade-in relative z-10" style="animation-delay: 100ms;">
                <div class="px-6 py-4 border-b border-surface-200 bg-surface-50">
                    <h4 class="font-semibold text-surface-900">Comments</h4>
                </div>
                <div class="p-6 space-y-6">
                    @forelse($document->comments as $comment)
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-surface-200 flex items-center justify-center text-surface-600 font-bold">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1 bg-surface-50 rounded-xl rounded-tl-none p-4 border border-surface-200">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-medium text-sm text-surface-900">{{ $comment->user->name }}</span>
                                    <span class="text-xs text-surface-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-surface-700 whitespace-pre-wrap">{{ $comment->body }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-sm text-surface-500 py-4">No comments yet.</p>
                    @endforelse
                </div>

                <!-- Add Comment Form -->
                <div class="p-6 border-t border-surface-200 bg-surface-50">
                    <form method="POST" action="{{ route('admin.comments.store', $document) }}">
                        @csrf
                        <div>
                            <x-input-label for="status" :value="__('Document Status')" />
                            <select id="status" name="status" class="form-input mt-1 w-full bg-white sm:w-1/3" required>
                                <option value="under_review" {{ $document->status->value === 'under_review' ? 'selected' : '' }}>Under Review</option>
                                <option value="reviewed" {{ $document->status->value === 'reviewed' ? 'selected' : '' }}>Reviewed (Approved)</option>
                                <option value="needs_revision" {{ $document->status->value === 'needs_revision' ? 'selected' : '' }}>Needs Revision</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="body" :value="__('Add a Comment')" />
                            <textarea id="body" name="body" rows="3" class="form-input mt-1 w-full bg-white" required minlength="5" maxlength="2000" placeholder="Type your review comments here..."></textarea>
                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                        </div>
                        <div class="mt-4 flex justify-end">
                            <x-primary-button>
                                {{ __('Post Comment') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
