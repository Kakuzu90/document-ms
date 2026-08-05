<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Upload Document') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card animate-slide-up">
                <div class="card-body">
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

                        <div class="flex items-center justify-end mt-4 pt-4 border-t border-surface-100">
                            <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary mr-3">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Upload Document') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
