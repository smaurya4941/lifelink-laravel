<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hospital Requests</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('status'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">{{ $hospital->hospital_name }}</p>
                    <p class="text-xs text-slate-500">Verification: {{ ucfirst($hospital->verification_status) }}</p>
                </div>
                <a href="{{ route('hospital.requests.create') }}" class="rounded bg-rose-600 px-4 py-2 text-white">Create Hospital Request</a>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                @if($requests->isEmpty())
                    <p class="text-sm text-slate-500">No hospital requests yet.</p>
                @else
                    <div class="space-y-3">
                        @foreach($requests as $req)
                            <div class="rounded-lg border border-slate-200 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-slate-900">#{{ $req->id }} - {{ $req->patient_name }} ({{ $req->blood_group }})</p>
                                        <p class="text-sm text-slate-600">{{ ucfirst($req->urgency_level) }} | Units: {{ $req->units_required }} | {{ ucfirst($req->status) }}</p>
                                    </div>
                                    <a href="{{ route('hospital.requests.show', $req) }}" class="rounded bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">View</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-4">{{ $requests->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

