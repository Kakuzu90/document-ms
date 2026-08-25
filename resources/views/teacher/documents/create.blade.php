<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Upload Document') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-surface-200 shadow-sm overflow-hidden animate-slide-up">
                <div class="px-6 py-5 border-b border-surface-200 bg-surface-50/50">
                    <h3 class="text-lg font-semibold text-surface-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Upload Details
                    </h3>
                </div>
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('teacher.documents.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Title --}}
                        <div>
                            <x-input-label for="title" :value="__('Document Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="e.g. Q1 Lesson Plan" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- Document Type --}}
                        <div>
                            <x-input-label for="type" :value="__('Document Type')" />
                            <div class="mt-1">
                                <x-searchable-select
                                    name="type"
                                    id="type"
                                    :value="old('type')"
                                    placeholder="Select document type..."
                                    :options="[
                                        ['value' => 'lesson_plan', 'label' => 'Lesson Plan'],
                                        ['value' => 'form', 'label' => 'Form'],
                                        ['value' => 'report', 'label' => 'Report'],
                                        ['value' => 'other', 'label' => 'Other']
                                    ]"
                                />
                            </div>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        {{-- File Upload --}}
                        <div>
                            <x-input-label for="file" :value="__('File (PDF, DOC, DOCX - Max 10MB)')" />
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

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-surface-100 gap-3">
                            <a href="{{ route('teacher.dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-surface-200 rounded-xl font-semibold text-surface-600 hover:bg-surface-50 hover:text-surface-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-surface-200 transition-all">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary-600 border border-transparent rounded-xl font-semibold text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                {{ __('Upload Document') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
