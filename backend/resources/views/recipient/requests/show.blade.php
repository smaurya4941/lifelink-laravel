<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Request Matches</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold">{{ $bloodRequest->hospital_name }}</h3>
                <p class="text-sm text-gray-600">{{ $bloodRequest->city }} · {{ $bloodRequest->blood_group }}</p>
                <p class="text-sm text-gray-600">Urgency: {{ ucfirst($bloodRequest->urgency_level) }}</p>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h4 class="text-md font-semibold mb-4">Matches</h4>
                @if($matches->isEmpty())
                    <p class="text-sm text-gray-500">No matches found yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($matches as $match)
                            <div class="border rounded p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold">Donor: {{ $match->donor?->name }}</p>
                                        <p class="text-sm text-gray-600">City: {{ $match->donor?->city ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-600">Score: {{ $match->match_score }}</p>
                                    </div>
                                    <div class="text-sm text-gray-600">Status: {{ ucfirst($match->status) }}</div>
                                </div>

                                @if($match->status === 'accepted')
                                    <form method="POST" action="{{ route('recipient.requests.confirm', $bloodRequest) }}" class="mt-3">
                                        @csrf
                                        <input type="hidden" name="match_id" value="{{ $match->id }}">
                                        <div class="flex flex-col md:flex-row gap-2">
                                            <input type="text" name="confirmation_notes" class="border rounded w-full px-2 py-1" placeholder="Confirmation notes (optional)">
                                            <button class="px-3 py-1 bg-green-600 text-white rounded">Confirm Donor</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
