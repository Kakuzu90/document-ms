<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Document Details') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            @if(request()->query('from') === 'teacher' && request()->query('teacher'))
                <a href="{{ route('admin.teachers.show', request()->query('teacher')) }}" class="inline-flex items-center text-sm font-medium text-surface-500 hover:text-surface-900 transition-colors mb-2">
                    ← Back to {{ $document->user->name }}
                </a>
            @else
                <a href="{{ route('admin.documents.index') }}" class="inline-flex items-center text-sm font-medium text-surface-500 hover:text-surface-900 transition-colors mb-2">
                    ← Back to Documents
                </a>
            @endif

            <!-- 2-Column Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- Main Column (Left, Span 2) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Document Hero Card -->
                    <div class="card overflow-hidden animate-slide-up shadow-sm">
                        <div class="bg-gradient-to-r from-primary-600 to-primary-800 px-6 py-8 text-white relative">
                            <!-- Subtle pattern overlay -->
                            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                            
                            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <div>
                                    <h3 class="text-2xl font-bold tracking-tight">{{ $document->title }}</h3>
                                    <p class="text-primary-100 mt-2 flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $document->user->name }}
                                        <span class="opacity-50 mx-1">•</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $document->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                                <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-lg border border-white/20 shadow-sm flex items-center gap-3 shrink-0">
                                    <span class="text-sm font-medium text-white/90">Status:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wide bg-white text-primary-800 shadow-sm">
                                        {{ $document->status->label() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-white border-t border-surface-200">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-surface-100 text-surface-600 rounded-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-surface-500 font-medium uppercase tracking-wider mb-0.5">Document Type</p>
                                        <p class="text-base font-semibold text-surface-900">{{ $document->type->label() }}</p>
                                    </div>
                                </div>
                                <div>
                                    <a href="#" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-surface-300 rounded-lg text-sm font-medium text-surface-700 hover:bg-surface-50 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download File
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="animate-fade-in relative z-10" style="animation-delay: 50ms;">
                        <div class="px-2 mb-4">
                            <h4 class="font-semibold text-surface-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-surface-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                Comments
                            </h4>
                        </div>
                        <div class="space-y-5">
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
                                    <div class="flex-1 {{ $isOwn ? 'bg-primary-50 border-primary-200' : 'bg-white border-surface-200' }} rounded-xl rounded-tl-none p-4 border shadow-sm">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="font-semibold text-sm text-surface-900">{{ $isOwn ? 'You' : $comment->user->name }}</span>
                                            <span class="text-xs text-surface-500 font-medium">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-surface-700 whitespace-pre-wrap leading-relaxed">{{ $comment->body }}</p>
                                        @if($document->status->value !== 'reviewed')
                                        <div class="mt-3 text-right">
                                            <a href="?reply_to={{ $comment->id }}#comment-form" class="text-xs font-semibold text-primary-600 hover:text-primary-800 transition-colors">Reply</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Replies -->
                                @foreach($comment->replies as $reply)
                                    @php $isOwnReply = auth()->id() === $reply->user_id; @endphp
                                    <div class="flex gap-3 ml-8 border-l-2 border-primary-200 pl-4 @if(request('reply_to') == $reply->id) ring-2 ring-primary-400 rounded-xl @endif mt-4">
                                        <div class="relative inline-block flex-shrink-0 h-8 w-8">
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
                                            <div class="{{ $isOwnReply ? 'bg-primary-50 border-primary-200' : 'bg-white border-surface-200' }} rounded-xl rounded-tl-none p-4 border relative z-10 shadow-sm">
                                                <div class="flex justify-between items-center mb-2">
                                                    <span class="font-semibold text-sm text-surface-900">{{ $isOwnReply ? 'You' : $reply->user->name }}</span>
                                                    <span class="text-xs text-surface-500 font-medium">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-sm text-surface-700 whitespace-pre-wrap leading-relaxed">{{ $reply->body }}</p>
                                                @if($document->status->value !== 'reviewed')
                                                <div class="mt-3 text-right">
                                                    <a href="?reply_to={{ $reply->id }}#comment-form" class="text-xs font-semibold text-primary-600 hover:text-primary-800 transition-colors">Reply</a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @empty
                                <div class="text-center py-10 bg-white border border-surface-200 rounded-xl shadow-sm">
                                    <div class="w-12 h-12 bg-surface-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    </div>
                                    <p class="text-sm text-surface-500 font-medium">No comments yet. Start the conversation!</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Add Comment Form -->
                        <div class="mt-6" id="comment-form">
                            @if($document->status->value === 'reviewed')
                                <div class="bg-primary-50 text-primary-700 px-4 py-3 rounded-lg text-sm mb-4 border border-primary-100 flex items-center gap-2 shadow-sm">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    This document has been finalized and reviewed. New comments cannot be added.
                                </div>
                            @else
                                <form method="POST" action="{{ route('admin.comments.store', $document) }}">
                                    @csrf
                                    @if(isset($replyToComment))
                                        <input type="hidden" name="parent_id" value="{{ $replyToComment->parent_id ?? $replyToComment->id }}">
                                        <input type="hidden" name="quoted_text" value="{{ \Illuminate\Support\Str::limit($replyToComment->body, 120) }}">
                                        <div class="mb-4">
                                            <div class="text-sm text-surface-600 bg-white border border-surface-200 rounded-lg p-3 shadow-sm flex justify-between items-start">
                                                <div>
                                                    <span class="font-bold text-surface-800 flex items-center gap-1 mb-1">
                                                        <svg class="w-3.5 h-3.5 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                                        Replying to {{ $replyToComment->user->name }}
                                                    </span>
                                                    <p class="italic text-surface-500 truncate max-w-md">{{ \Illuminate\Support\Str::limit($replyToComment->body, 120) }}</p>
                                                </div>
                                                <a href="{{ request()->url() }}#comment-form" class="text-surface-400 hover:text-surface-600 shrink-0 p-1">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    <div>
                                        <label for="body" class="sr-only">Add a Comment</label>
                                        <textarea id="body" name="body" rows="3" class="form-input mt-1 w-full bg-white border-surface-300 rounded-xl focus:border-primary-500 focus:ring-primary-500 shadow-sm resize-none transition-colors" required minlength="5" maxlength="2000" placeholder="Type your review comments here..."></textarea>
                                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                                    </div>
                                    <div class="mt-3 flex justify-end">
                                        <x-primary-button class="rounded-full px-6 shadow-md hover:shadow-lg transition-all">
                                            {{ __('Post Comment') }}
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                        </x-primary-button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Sidebar Column (Right, Span 1) -->
                <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-8">
                    
                    <!-- Status Update Panel -->
                    <div class="card animate-fade-in relative z-30 shadow-md border-t-4 border-t-primary-500 !overflow-visible" style="animation-delay: 100ms;">
                        <div class="px-6 py-4 border-b border-surface-200 bg-white">
                            <h4 class="font-bold text-surface-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Action Panel
                            </h4>
                        </div>
                        <div class="p-6 bg-surface-50/50">
                            <form method="POST" action="{{ route('admin.documents.status.update', $document) }}" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <x-input-label for="status_update" :value="__('Update Status')" class="text-surface-700 font-medium mb-2 block" />
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
                                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                                </div>
                                <x-primary-button class="w-full justify-center py-2.5 shadow-sm hover:shadow-md transition-all">
                                    {{ __('Save Changes') }}
                                </x-primary-button>
                            </form>
                        </div>
                    </div>

                    <!-- Status History Panel -->
                    @if($document->statusHistories->isNotEmpty())
                    <div class="card animate-fade-in relative z-20 shadow-sm" style="animation-delay: 150ms;">
                        <div class="px-6 py-4 border-b border-surface-200 bg-white">
                            <h4 class="font-bold text-surface-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Timeline
                            </h4>
                        </div>
                        <div class="p-6 bg-white max-h-[420px] overflow-y-auto">
                            <div class="relative border-l-2 border-surface-200 ml-3 space-y-6">
                                @foreach($document->statusHistories as $index => $history)
                                    <div class="relative pl-6 group">
                                        <!-- Glowing Dot -->
                                        @php
                                            $isLatest = $index === 0;
                                            $statusColor = match($history->to_status instanceof \App\Enums\DocumentStatus ? $history->to_status->value : $history->to_status) {
                                                'reviewed' => 'bg-success-500 ring-success-100',
                                                'needs_revision' => 'bg-amber-500 ring-amber-100',
                                                'under_review' => 'bg-blue-500 ring-blue-100',
                                                default => 'bg-primary-500 ring-primary-100'
                                            };
                                        @endphp
                                        <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full border-2 border-white {{ $statusColor }} {{ $isLatest ? 'ring-4 shadow-sm' : '' }} transition-all group-hover:scale-125"></div>
                                        
                                        <div class="bg-surface-50 rounded-lg p-3 border border-surface-100 shadow-sm transition-colors group-hover:bg-white group-hover:border-surface-200">
                                            <p class="text-sm text-surface-900 font-medium">
                                                Status changed to <span class="font-bold">{{ $history->to_status instanceof \App\Enums\DocumentStatus ? $history->to_status->label() : $history->to_status }}</span>
                                            </p>
                                            <div class="flex justify-between items-center mt-2 text-xs">
                                                <span class="text-surface-500 flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                    {{ $history->user->name }}
                                                </span>
                                                <span class="text-surface-400 font-medium">
                                                    {{ $history->created_at->format('M j, g:i A') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
