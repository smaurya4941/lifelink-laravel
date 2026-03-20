<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="ll-badge">Control Center</p>
                <h2 class="mt-2 text-2xl font-extrabold leading-tight text-white">{{ __('LifeLink Dashboard') }}</h2>
            </div>
            <p class="hidden rounded-lg bg-white/20 px-3 py-1 text-sm font-semibold text-rose-50 sm:block">Welcome {{ $user->name }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="ll-surface p-6">
                <h3 class="text-xl font-bold text-slate-900">Welcome, {{ $user->name }}!</h3>
                <p class="mt-1 text-sm text-slate-600">Role: {{ ucfirst($user->role) }}</p>
                <p class="text-sm text-slate-600">Unread Notifications: {{ $unreadNotifications }}</p>

                <div class="mt-5 flex flex-wrap gap-2">
                    @if($user->role === 'donor')
                        <a href="{{ route('donor.profile.edit') }}" class="ll-btn-primary">Donor Profile</a>
                        <a href="{{ route('donor.matches') }}" class="ll-btn-soft">My Matches</a>
                        <a href="{{ route('notifications.index') }}" class="ll-btn-soft">Notifications</a>
                        <a href="{{ route('map.index') }}" class="ll-btn-soft">Map</a>
                    @elseif($user->role === 'recipient')
                        <a href="{{ route('recipient.profile.edit') }}" class="ll-btn-primary">Recipient Profile</a>
                        <a href="{{ route('recipient.requests.index') }}" class="ll-btn-soft">My Requests</a>
                        <a href="{{ route('recipient.requests.create') }}" class="ll-btn-soft">Create Request</a>
                        <a href="{{ route('notifications.index') }}" class="ll-btn-soft">Notifications</a>
                        <a href="{{ route('analytics.index') }}" class="ll-btn-soft">Analytics</a>
                        <a href="{{ route('map.index') }}" class="ll-btn-soft">Map</a>
                    @endif
                </div>
            </div>

            @if($user->role === 'recipient')
                <div class="ll-surface p-6">
                    <h4 class="mb-4 text-lg font-bold text-slate-900">Recent Requests</h4>
                    @if($recentRequests->isEmpty())
                        <p class="text-sm text-slate-500">No requests yet.</p>
                    @else
                        <ul class="divide-y divide-slate-200">
                            @foreach($recentRequests as $req)
                                <li class="flex items-center justify-between py-3">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $req->blood_group }} · {{ ucfirst($req->urgency_level) }}</p>
                                        <p class="text-sm text-slate-600">{{ $req->hospital_name }} — {{ $req->city }}</p>
                                    </div>
                                    <a class="ll-btn-soft !px-3 !py-2" href="{{ route('recipient.requests.show', $req) }}">View Matches</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

            @if($user->role === 'donor')
                <div class="ll-surface p-6">
                    <h4 class="mb-4 text-lg font-bold text-slate-900">Recent Matches</h4>
                    @if($recentMatches->isEmpty())
                        <p class="text-sm text-slate-500">No matches yet.</p>
                    @else
                        <ul class="divide-y divide-slate-200">
                            @foreach($recentMatches as $match)
                                <li class="py-3">
                                    <p class="font-semibold text-slate-900">{{ $match->bloodRequest?->blood_group }} · {{ ucfirst($match->status) }}</p>
                                    <p class="text-sm text-slate-600">{{ $match->bloodRequest?->hospital_name }} — {{ $match->bloodRequest?->city }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
