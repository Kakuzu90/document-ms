<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-surface-900 leading-tight">
                {{ __('Notifications') }}
            </h2>
            @if($notifications->whereNull('read_at')->count() > 0)
                <form method="POST" action="{{ url('/notifications/read-all') }}">
                    @csrf
                    <x-primary-button class="text-sm px-4 py-2">
                        {{ __('Mark all as read') }}
                    </x-primary-button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-surface-900">
                    
                    @if($notifications->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-zinc-400">You have no notifications.</p>
                        </div>
                    @else
                        <div class="divide-y divide-surface-100">
                            @foreach($notifications as $notification)
                                <a href="{{ route('notifications.read', $notification->id) }}" class="flex items-start gap-4 py-4 hover:bg-surface-50 transition-colors {{ $notification->read_at ? 'opacity-70' : '' }}">
                                    <div class="flex-shrink-0 mt-1.5 ml-2">
                                        @if($notification->read_at)
                                            <!-- Hollow zinc-300 = read -->
                                            <span class="block w-2.5 h-2.5 rounded-full border-2 border-zinc-300"></span>
                                        @else
                                            <!-- Filled zinc-800 = unread -->
                                            <span class="block w-2.5 h-2.5 rounded-full bg-zinc-800"></span>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-baseline mb-1">
                                            <p class="text-sm font-semibold {{ $notification->read_at ? 'text-surface-700' : 'text-surface-900' }}">
                                                {{ $notification->data['title'] ?? 'Notification' }}
                                            </p>
                                            <span class="text-xs text-surface-500 whitespace-nowrap ml-4">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="text-sm {{ $notification->read_at ? 'text-surface-500' : 'text-surface-700' }}">
                                            {{ $notification->data['message'] ?? '' }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
