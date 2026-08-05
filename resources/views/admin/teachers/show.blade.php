<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-surface-900 leading-tight">
            {{ __('Teacher Profile') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Header Card -->
            <div class="card overflow-hidden animate-slide-up shadow-sm">
                <div class="bg-gradient-to-r from-primary-600 to-primary-800 px-6 py-8 text-white relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 rounded-xl">
                    <!-- Subtle pattern overlay -->
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                    
                    <div class="relative z-10 flex items-center gap-5">
                        <div class="h-16 w-16 rounded-full bg-white/20 backdrop-blur-sm border-2 border-white/40 flex items-center justify-center text-3xl font-bold uppercase shrink-0 shadow-inner">
                            {{ substr($teacher->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold tracking-tight flex items-center gap-3">
                                {{ $teacher->name }}
                                @if($teacher->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white text-success-600 shadow-sm uppercase tracking-wider">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white shadow-sm uppercase tracking-wider">Inactive</span>
                                @endif
                            </h3>
                            <p class="text-primary-100 mt-1 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $teacher->email }}
                            </p>
                            <p class="text-primary-200 text-sm mt-1 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Joined {{ $teacher->created_at->format('M j, Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="relative z-10 w-full sm:w-auto mt-4 sm:mt-0">
                        <a href="{{ route('admin.teachers.edit', $teacher) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 w-full bg-white border border-transparent rounded-full font-semibold text-primary-700 hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Documents List -->
            <div class="bg-white rounded-2xl border border-surface-200 shadow-sm flex flex-col overflow-hidden animate-slide-up relative z-10" style="animation-delay: 50ms;">
                <div class="px-6 py-5 border-b border-surface-200 bg-surface-50/50">
                    <h3 class="font-semibold text-surface-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Recent Documents
                    </h3>
                    <p class="text-sm text-surface-500 mt-1 ml-7">The 10 most recently submitted documents by this teacher.</p>
                </div>
                
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-surface-600">
                        <thead class="text-xs text-surface-500 uppercase bg-surface-50/50 border-b border-surface-200 font-semibold tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">Title</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Type</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Submitted</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-100 bg-white">
                            @forelse($documents as $document)
                                <tr class="hover:bg-primary-50/50 transition-colors group">
                                    <td class="px-6 py-4 font-semibold text-surface-900 group-hover:text-primary-800 transition-colors">
                                        {{ $document->title }}
                                    </td>
                                    <td class="px-6 py-4 text-surface-600 font-medium">
                                        {{ $document->type->label() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-status-badge :status="$document->status" />
                                    </td>
                                    <td class="px-6 py-4 text-surface-600 font-medium">
                                        {{ $document->created_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.documents.show', ['document' => $document, 'from' => 'teacher', 'teacher' => $teacher->id]) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary-600 hover:text-primary-800 bg-primary-50 px-3 py-1.5 rounded-lg group-hover:bg-primary-100 transition-colors">
                                            View
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="mt-4 text-sm text-surface-500">This teacher hasn't submitted any documents yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
