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

            <div class="card overflow-hidden animate-slide-up" style="animation-delay: 50ms;">
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-surface-500">
                        <thead class="text-xs text-surface-700 uppercase bg-surface-50 border-b border-surface-200">
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
                                <tr class="hover:bg-surface-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-xs font-bold uppercase">
                                                {{ substr($teacher->name, 0, 1) }}
                                            </div>
                                            <div class="font-medium text-surface-900">{{ $teacher->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-surface-600">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-surface-600">
                                        {{ $teacher->documents_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.teachers.show', $teacher) }}" class="text-primary-600 hover:text-primary-900 transition-colors">View</a>
                                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="text-surface-600 hover:text-surface-900 transition-colors">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <p class="mt-4 text-sm text-surface-500">No teachers found.</p>
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
