<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <span>{{ __("You're logged in as a Teacher!") }}</span>
                    <div class="flex gap-4">
                        <a href="{{ route('teacher.documents.index') }}" class="btn btn-secondary">
                            {{ __('My Documents') }}
                        </a>
                        <a href="{{ route('teacher.documents.create') }}" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            {{ __('Upload Document') }}
                        </a>
                    </div>
                </div>
            </div>
            
            @if (session('status'))
                <x-auth-session-status class="mb-4" :status="session('status')" />
            @endif
        </div>
    </div>
</x-app-layout>
