<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Document Details') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            @if(request()->query('from') === 'teacher' && request()->query('teacher'))
                <a href="{{ route('admin.teachers.show', request()->query('teacher')) }}" class="inline-flex items-center text-sm font-medium text-surface-500 hover:text-surface-900 transition-colors">
                    ← Back to {{ $document->user->name }}
                </a>
            @else
                <a href="{{ route('admin.documents.index') }}" class="inline-flex items-center text-sm font-medium text-surface-500 hover:text-surface-900 transition-colors">
                    ← Back to Documents
                </a>
            @endif
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
                <div class="p-4 sm:p-6 space-y-4 max-h-[500px] overflow-y-auto">
                    @forelse($document->comments as $comment)
                        @php $isOwn = auth()->id() === $comment->user_id; @endphp
                        <div class="flex gap-3 @if(request('reply_to') == $comment->id) ring-2 ring-primary-400 rounded-xl @endif">
                            <div class="relative block flex-shrink-0 w-10 h-10">
                                <div class="w-10 h-10 rounded-full {{ $isOwn ? 'bg-primary-100 text-primary-700' : 'bg-surface-200 text-surface-600' }} flex items-center justify-center font-bold">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                                @if($comment->user->isOnline())
                                    <span class="absolute bottom-0 right-0 block w-3 h-3 rounded-full bg-green-500 ring-2 ring-white"></span>
                                @endif
                            </div>
                            <div class="flex-1 {{ $isOwn ? 'bg-primary-50 border-primary-200' : 'bg-surface-50 border-surface-200' }} rounded-xl rounded-tl-none p-3 border">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-medium text-sm text-surface-900">{{ $isOwn ? 'You' : $comment->user->name }}</span>
                                    <span class="text-xs text-surface-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-surface-700 whitespace-pre-wrap">{{ $comment->body }}</p>
                                <div class="mt-2 text-right">
                                    <a href="?reply_to={{ $comment->id }}#comment-form" class="text-xs font-medium text-primary-600 hover:text-primary-700">Reply</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Replies -->
                        @foreach($comment->replies as $reply)
                            @php $isOwnReply = auth()->id() === $reply->user_id; @endphp
                            <div class="flex gap-3 ml-8 border-l-2 border-primary-300 pl-3 @if(request('reply_to') == $reply->id) ring-2 ring-primary-400 rounded-xl @endif">
                                <div class="relative inline-block flex-shrink-0 h-8">
                                    <div class="w-8 h-8 rounded-full {{ $isOwnReply ? 'bg-primary-100 text-primary-700' : 'bg-surface-200 text-surface-600' }} flex items-center justify-center font-bold text-sm">
                                        {{ substr($reply->user->name, 0, 1) }}
                                    </div>
                                    @if($reply->user->isOnline())
                                        <span class="absolute bottom-0 right-0 block w-2.5 h-2.5 rounded-full bg-green-500 ring-2 ring-white"></span>
                                    @endif
                                </div>
                                <div class="flex-1 flex flex-col">
                                    @if($reply->quoted_text)
                                        <div class="text-xs text-surface-500 bg-surface-100 rounded-2xl px-4 pt-2 pb-5 border border-surface-200 mb-[-16px] z-0 ml-4 max-w-[90%] truncate opacity-80">
                                            <span class="font-semibold text-surface-600"><i class="fas fa-reply mr-1"></i> {{ $reply->parent->user->name ?? 'User' }}</span>:
                                            {{ $reply->quoted_text }}
                                        </div>
                                    @endif
                                    <div class="{{ $isOwnReply ? 'bg-primary-50 border-primary-200' : 'bg-surface-50 border-surface-200' }} rounded-xl rounded-tl-none p-3 border relative z-10">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-medium text-sm text-surface-900">{{ $isOwnReply ? 'You' : $reply->user->name }}</span>
                                            <span class="text-xs text-surface-500">{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-surface-700 whitespace-pre-wrap">{{ $reply->body }}</p>
                                        <div class="mt-2 text-right">
                                            <a href="?reply_to={{ $reply->id }}#comment-form" class="text-xs font-medium text-primary-600 hover:text-primary-700">Reply</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @empty
                        <p class="text-center text-sm text-surface-500 py-4">No comments yet.</p>
                    @endforelse
                </div>

                <!-- Add Comment Form -->
                <div class="p-6 border-t border-surface-200 bg-surface-50" id="comment-form">
                    @if($document->status->value === 'reviewed')
                        <p class="text-sm text-surface-500 italic mb-4">This document has been reviewed.</p>
                    @endif
                    <form method="POST" action="{{ route('admin.comments.store', $document) }}">
                        @csrf
                        @if(isset($replyToComment))
                            <input type="hidden" name="parent_id" value="{{ $replyToComment->parent_id ?? $replyToComment->id }}">
                            <input type="hidden" name="quoted_text" value="{{ \Illuminate\Support\Str::limit($replyToComment->body, 120) }}">
                            <div class="mb-4">
                                <div class="text-xs text-primary-400 italic bg-primary-50 rounded p-3 mb-2 flex justify-between items-start">
                                    <div>
                                        <span class="font-semibold block mb-1">Replying to {{ $replyToComment->user->name }}:</span>
                                        {{ \Illuminate\Support\Str::limit($replyToComment->body, 120) }}
                                    </div>
                                    <a href="{{ request()->url() }}#comment-form" class="text-primary-500 hover:text-primary-700 ml-4 shrink-0">Cancel reply</a>
                                </div>
                            </div>
                        @endif
                        <div class="mt-4">
                            <x-input-label for="body" :value="__('Add a Comment')" />
                            <textarea id="body" name="body" rows="3" class="form-input mt-1 w-full bg-white disabled:opacity-50 disabled:cursor-not-allowed" required minlength="5" maxlength="2000" placeholder="Type your review comments here..." @if($document->status->value === 'reviewed') disabled @endif></textarea>
                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                        </div>
                        <div class="mt-4 flex justify-end">
                            <x-primary-button :disabled="$document->status->value === 'reviewed'">
                                {{ __('Post Comment') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
