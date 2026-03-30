<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hospital Request Details</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('status'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">{{ $bloodRequest->patient_name }} ({{ $bloodRequest->blood_group }})</h3>
                <p class="text-sm text-slate-600">{{ $bloodRequest->hospital_name }} - {{ $bloodRequest->city }}</p>
                <p class="text-sm text-slate-600">Urgency: {{ ucfirst($bloodRequest->urgency_level) }} | Units: {{ $bloodRequest->units_required }}</p>
                <p class="text-sm text-slate-600">Status: {{ ucfirst($bloodRequest->status) }}</p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h4 class="mb-4 text-lg font-semibold text-slate-900">Matched Donors</h4>
                @if($matches->isEmpty())
                    <p class="text-sm text-slate-500">No donors matched yet.</p>
                @else
                    <div class="space-y-3">
                        @foreach($matches as $match)
                            <div class="rounded-lg border border-slate-200 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $match->donor?->name ?? 'Donor' }}</p>
                                        <p class="text-sm text-slate-600">Score: {{ $match->match_score }} | Status: {{ ucfirst($match->status) }}</p>
                                    </div>
                                    <div class="text-right text-sm text-slate-600">
                                        <p>{{ $match->donor?->phone_number ?? 'No phone available' }}</p>
                                        <p>{{ $match->donor?->email ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

