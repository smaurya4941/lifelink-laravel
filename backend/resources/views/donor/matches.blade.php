<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Donor Matches</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6">
                @if($matches->isEmpty())
                    <p class="text-sm text-gray-500">No matches yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($matches as $match)
                            <div class="border rounded p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold">{{ $match->bloodRequest?->hospital_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $match->bloodRequest?->city }} · {{ $match->bloodRequest?->blood_group }}</p>
                                        <p class="text-sm text-gray-600">Urgency: {{ ucfirst($match->bloodRequest?->urgency_level) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm">Score: {{ $match->match_score }}</p>
                                        <p class="text-sm">Status: {{ ucfirst($match->status) }}</p>
                                    </div>
                                </div>

                                <div class="mt-3 flex gap-2">
                                    <form method="POST" action="{{ route('donor.matches.accept', $match) }}">
                                        @csrf
                                        <button class="px-3 py-1 bg-green-600 text-white rounded" @disabled($match->status === 'accepted')>Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('donor.matches.reject', $match) }}">
                                        @csrf
                                        <button class="px-3 py-1 bg-red-600 text-white rounded" @disabled($match->status === 'rejected')>Reject</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
