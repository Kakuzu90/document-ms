<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Revise Document') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="card animate-slide-up">
                <div class="card-body">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-surface-900">{{ $document->title }}</h3>
                        </div>
                        <x-status-badge :status="$document->status" />
                    </div>

                    @if($document->status->value === 'needs_revision' && $document->comments->isNotEmpty())
                        <div class="mb-8 card border-warning-200 bg-warning-50">
                            <div class="card-body">
                                <h4 class="font-semibold text-warning-800 mb-3 text-sm uppercase tracking-wide">Reviewer Comments</h4>
                                <div class="space-y-4">
                                    @foreach($document->comments as $comment)
                                        <div class="bg-white p-4 rounded-xl border border-warning-200 shadow-sm">
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="font-medium text-sm text-surface-900">{{ $comment->user->name }}</span>
                                                <span class="text-xs text-surface-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-surface-700 whitespace-pre-wrap">{{ $comment->body }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('teacher.documents.revise.store', $document) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- File Upload --}}
                        <div>
                            <x-input-label for="file" :value="__('New File (PDF, DOC, DOCX - Max 10MB)')" />
                            <input type="file" id="file" name="file" accept=".pdf,.doc,.docx" required class="mt-1 block w-full text-sm text-surface-500
                                file:mr-4 file:py-2.5 file:px-4
                                file:rounded-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary-50 file:text-primary-700
                                hover:file:bg-primary-100
                                transition-colors
                            " />
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                        {{-- Note --}}
                        <div>
                            <x-input-label for="note" :value="__('Note (Optional)')" />
                            <textarea id="note" name="note" rows="3" class="form-input mt-1 w-full" maxlength="500" placeholder="{{ $document->status->value === 'needs_revision' ? 'Describe what you changed...' : 'Reason for replacing file (optional)...' }}">{{ old('note') }}</textarea>
                            <x-input-error :messages="$errors->get('note')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 pt-4 border-t border-surface-100">
                            <a href="{{ route('teacher.documents.show', $document) }}" class="btn btn-secondary mr-3">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ $document->status->value === 'needs_revision' ? __('Submit Revision') : __('Replace File') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
