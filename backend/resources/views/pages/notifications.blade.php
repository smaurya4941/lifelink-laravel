<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="ll-badge">Inbox</p>
                <h2 class="mt-2 text-2xl font-extrabold leading-tight text-white">Notifications</h2>
            </div>
            <p class="hidden text-sm font-medium text-rose-100 sm:block">Stay on top of matches and updates</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-emerald-700">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('notifications.read_all') }}" class="mb-4">
                @csrf
                <button class="ll-btn-soft">Mark All Read</button>
            </form>

            <div class="ll-surface p-6">
                @if($notifications->isEmpty())
                    <p class="text-sm text-slate-500">No notifications.</p>
                @else
                    <div class="space-y-4">
                        @foreach($notifications as $notification)
                            <div class="rounded-xl border p-4 {{ $notification->is_read ? 'border-slate-200 bg-white' : 'border-rose-200 bg-rose-50' }}">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $notification->title }}</p>
                                        <p class="text-sm text-slate-600">{{ $notification->message }}</p>
                                        <p class="text-xs text-slate-400">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                    @if(!$notification->is_read)
                                        <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                            @csrf
                                            <button class="ll-btn-primary !px-3 !py-2 !text-xs">Mark Read</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
