<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Teachers') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-slide-up">
                <div>
                    <h3 class="text-lg font-medium text-surface-900">Manage Teachers</h3>
                    <p class="mt-1 text-sm text-surface-500">A list of all teachers in the system, including their status and document submissions.</p>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="card mb-6 animate-slide-up relative z-20 shadow-sm border border-surface-200">
                <div class="bg-surface-50/50 px-6 py-4 border-b border-surface-200">
                    <h3 class="font-semibold text-surface-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-surface-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter Teachers
                    </h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.teachers.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Search -->
                            <div>
                                <x-input-label for="search" :value="__('Search')" />
                                <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-input mt-1 w-full bg-white" placeholder="Search by name or email…">
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <x-searchable-select
                                    name="status"
                                    id="status"
                                    :options="[
                                        ['value' => 'active', 'label' => 'Active'],
                                        ['value' => 'inactive', 'label' => 'Inactive']
                                    ]"
                                    :value="request('status')"
                                    placeholder="All Statuses"
                                    :searchable="false"
                                />
                            </div>

                            <!-- Joined Date -->
                            <div>
                                <x-input-label for="joined_date" :value="__('Joined Date')" />
                                <input type="date" name="joined_date" id="joined_date" value="{{ request('joined_date') }}" class="form-input mt-1 w-full bg-white">
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <x-primary-button>
                                {{ __('Search') }}
                            </x-primary-button>
                            
                            @if(request()->hasAny(['search', 'status', 'joined_date']))
                                <a href="{{ route('admin.teachers.index') }}" class="text-sm font-medium text-surface-500 hover:text-surface-900 transition-colors">
                                    {{ __('Clear') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-surface-200 shadow-sm flex flex-col overflow-hidden animate-fade-in relative z-10" style="animation-delay: 50ms;">
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-surface-600">
                        <thead class="text-xs text-surface-500 uppercase bg-surface-50/50 border-b border-surface-200 font-semibold tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">Name</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Email</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Joined Date</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Documents</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-100 bg-white">
                            @forelse($teachers as $teacher)
                                <tr class="hover:bg-primary-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <div class="h-8 w-8 rounded-full bg-surface-100 text-surface-600 group-hover:bg-primary-100 group-hover:text-primary-700 flex items-center justify-center text-xs font-bold uppercase transition-colors">
                                                    {{ substr($teacher->name, 0, 1) }}
                                                </div>
                                                @if($teacher->isOnline())
                                                    <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-success-500 border-2 border-white rounded-full"></div>
                                                @endif
                                            </div>
                                            <div class="font-semibold text-surface-900 group-hover:text-primary-800 transition-colors">{{ $teacher->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-surface-600 font-medium group-hover:text-primary-700 transition-colors">
                                        {{ $teacher->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($teacher->status === 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-surface-100 text-surface-800">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-surface-600 text-sm">
                                        {{ $teacher->created_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-surface-600 font-semibold">
                                        {{ $teacher->documents_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.teachers.show', $teacher) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary-600 hover:text-primary-800 bg-primary-50 px-3 py-1.5 rounded-lg group-hover:bg-primary-100 transition-colors">
                                                View
                                            </a>
                                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-surface-600 hover:text-surface-800 bg-surface-50 px-3 py-1.5 rounded-lg group-hover:bg-surface-100 border border-surface-200 transition-colors">
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <p class="mt-4 text-sm text-surface-500">
                                            @if(request()->hasAny(['search', 'status', 'joined_date']))
                                                No teachers found for the current filters.
                                            @else
                                                No teachers found.
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($teachers->hasPages())
                    <div class="border-t border-surface-200 bg-white px-6 py-4">
                        {{ $teachers->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
