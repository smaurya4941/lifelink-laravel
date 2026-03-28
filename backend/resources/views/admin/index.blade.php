<x-layouts.admin title="Admin Overview">
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['label' => 'Users', 'value' => $stats['users'], 'tone' => 'bg-slate-900 text-white'],
            ['label' => 'Donors', 'value' => $stats['donors'], 'tone' => 'bg-rose-50 text-rose-900'],
            ['label' => 'Recipients', 'value' => $stats['recipients'], 'tone' => 'bg-blue-50 text-blue-900'],
            ['label' => 'Hospitals', 'value' => $stats['hospitals'], 'tone' => 'bg-emerald-50 text-emerald-900'],
            ['label' => 'Requests', 'value' => $stats['requests'], 'tone' => 'bg-amber-50 text-amber-900'],
            ['label' => 'Matches', 'value' => $stats['matches'], 'tone' => 'bg-fuchsia-50 text-fuchsia-900'],
            ['label' => 'Donations', 'value' => $stats['donations'], 'tone' => 'bg-cyan-50 text-cyan-900'],
            ['label' => 'Notifications', 'value' => $stats['notifications'], 'tone' => 'bg-indigo-50 text-indigo-900'],
        ] as $card)
            <div class="rounded-2xl p-5 shadow-sm {{ $card['tone'] }}">
                <p class="text-xs font-semibold uppercase tracking-wider opacity-80">{{ $card['label'] }}</p>
                <p class="mt-2 text-3xl font-extrabold">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        <a href="{{ route('admin.users') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-rose-300 hover:shadow">
            <p class="text-lg font-bold text-slate-900">Manage Users</p>
            <p class="mt-1 text-sm text-slate-600">Change role and account status.</p>
        </a>
        <a href="{{ route('admin.requests') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-rose-300 hover:shadow">
            <p class="text-lg font-bold text-slate-900">Manage Requests</p>
            <p class="mt-1 text-sm text-slate-600">Track and update request lifecycle.</p>
        </a>
        <a href="{{ route('admin.matches') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-rose-300 hover:shadow">
            <p class="text-lg font-bold text-slate-900">Manage Matches</p>
            <p class="mt-1 text-sm text-slate-600">Review and update match responses.</p>
        </a>
        <a href="{{ route('admin.donations') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-rose-300 hover:shadow">
            <p class="text-lg font-bold text-slate-900">Manage Donations</p>
            <p class="mt-1 text-sm text-slate-600">Update donation outcome records.</p>
        </a>
        <a href="{{ route('admin.notifications') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-rose-300 hover:shadow">
            <p class="text-lg font-bold text-slate-900">Manage Notifications</p>
            <p class="mt-1 text-sm text-slate-600">Audit and mark read/unread items.</p>
        </a>
    </div>
</x-layouts.admin>
