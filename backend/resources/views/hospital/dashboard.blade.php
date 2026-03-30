<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="ll-badge">Hospital Workspace</p>
                <h2 class="mt-2 text-2xl font-extrabold leading-tight text-white">Hospital Operations Dashboard</h2>
            </div>
            <span class="rounded-full px-3 py-1 text-xs font-semibold
                {{ $hospital->verification_status === 'verified' ? 'bg-emerald-100 text-emerald-800' : '' }}
                {{ $hospital->verification_status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                {{ $hospital->verification_status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                {{ strtoupper($hospital->verification_status) }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif
            @if(session('error'))
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Requests</p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['total_requests'] }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Active Requests</p>
                    <p class="mt-2 text-3xl font-extrabold text-amber-700">{{ $stats['active_requests'] }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Critical + High</p>
                    <p class="mt-2 text-3xl font-extrabold text-rose-700">{{ $stats['critical_requests'] }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Matched Donors</p>
                    <p class="mt-2 text-3xl font-extrabold text-emerald-700">{{ $stats['matched_donors'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <a href="{{ route('hospital.requests.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-rose-300 hover:shadow">
                    <p class="text-lg font-bold text-slate-900">Requests</p>
                    <p class="mt-1 text-sm text-slate-600">Manage all patient blood requests.</p>
                </a>
                <a href="{{ route('hospital.requests.create') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-rose-300 hover:shadow">
                    <p class="text-lg font-bold text-slate-900">Create Request</p>
                    <p class="mt-1 text-sm text-slate-600">Create high-priority requests for patients.</p>
                </a>
                <a href="{{ route('hospital.profile.edit') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-rose-300 hover:shadow">
                    <p class="text-lg font-bold text-slate-900">Organization Profile</p>
                    <p class="mt-1 text-sm text-slate-600">Maintain license, address, and verification data.</p>
                </a>
                <a href="{{ route('analytics.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-rose-300 hover:shadow">
                    <p class="text-lg font-bold text-slate-900">Analytics</p>
                    <p class="mt-1 text-sm text-slate-600">View operational trends and urgency patterns.</p>
                </a>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-bold text-slate-900">Recent Requests</h3>
                @if($recentRequests->isEmpty())
                    <p class="text-sm text-slate-500">No requests created yet.</p>
                @else
                    <div class="space-y-3">
                        @foreach($recentRequests as $req)
                            <div class="rounded-xl border border-slate-200 p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $req->patient_name }} - {{ $req->blood_group }}</p>
                                        <p class="text-sm text-slate-600">{{ ucfirst($req->urgency_level) }} | Units: {{ $req->units_required }}</p>
                                    </div>
                                    <a href="{{ route('hospital.requests.show', $req) }}" class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">
                                        Open
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

