<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-surface-900 leading-tight">
                {{ __('Document Details') }}
            </h2>
            <div class="flex items-center gap-4">
                @if($document->status->value === 'submitted')
                    <a href="{{ route('teacher.documents.revise', $document) }}" class="btn btn-primary">Update File</a>
                @elseif($document->status->value === 'needs_revision')
                    <a href="{{ route('teacher.documents.revise', $document) }}" class="btn btn-primary">Upload Revision</a>
                @endif
                <a href="{{ route('teacher.documents.index') }}" class="text-sm font-medium text-surface-500 hover:text-surface-900">
                    &larr; Back to List
                </a>
            </div>
        </div>
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
                                Submitted on {{ $document->created_at->format('M d, Y') }}
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

            <!-- Comments Section -->
            <div class="card animate-fade-in" style="animation-delay: 100ms;">
                <div class="px-6 py-4 border-b border-surface-200 bg-surface-50">
                    <h4 class="font-semibold text-surface-900">Review Comments</h4>
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
                        <p class="text-center text-sm text-surface-500 py-4">No comments have been left on this document yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
