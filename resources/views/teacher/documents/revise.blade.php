<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Revise Document') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white rounded-2xl border border-surface-200 shadow-sm overflow-hidden animate-slide-up">
                <div class="px-6 py-5 border-b border-surface-200 bg-surface-50/50">
                    <h3 class="text-lg font-semibold text-surface-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Update Document
                    </h3>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-6 gap-4 border-b border-surface-100 pb-6">
                        <div>
                            <span class="text-sm font-medium text-surface-500 uppercase tracking-wider mb-1 block">Current File</span>
                            <h3 class="text-xl font-bold text-surface-900">{{ $document->title }}</h3>
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

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-surface-100 gap-3">
                            <a href="{{ route('teacher.documents.show', $document) }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-surface-200 rounded-xl font-semibold text-surface-600 hover:bg-surface-50 hover:text-surface-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-surface-200 transition-all">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary-600 border border-transparent rounded-xl font-semibold text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                {{ $document->status->value === 'needs_revision' ? __('Submit Revision') : __('Replace File') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
