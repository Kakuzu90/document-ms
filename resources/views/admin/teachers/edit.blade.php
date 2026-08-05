<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Edit Teacher') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="card p-6 sm:p-8 animate-slide-up">
                <header class="mb-6">
                    <h2 class="text-lg font-medium text-surface-900">
                        {{ __('Teacher Profile Information') }}
                    </h2>
                    <p class="mt-1 text-sm text-surface-500">
                        {{ __("Update the teacher's account details and active status.") }}
                    </p>
                </header>

                <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $teacher->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $teacher->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Account Status')" />
                        <div class="mt-1 relative z-20">
                            <x-searchable-select 
                                name="status" 
                                :options="[
                                    ['value' => 'active', 'label' => 'Active'],
                                    ['value' => 'inactive', 'label' => 'Inactive'],
                                ]" 
                                :value="old('status', $teacher->status)"
                                :searchable="false"
                            />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        <p class="mt-2 text-sm text-surface-500">Inactive teachers will not be able to log in or submit documents.</p>
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-surface-100">
                        <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                        <a href="{{ route('admin.teachers.index') }}" class="text-sm text-surface-600 hover:text-surface-900 transition-colors">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
