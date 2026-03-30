<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Donor Matches</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="mb-4 text-lg font-semibold text-slate-900">Incoming Matches (As Donor)</h3>
                @if($matches->isEmpty())
                    <p class="text-sm text-gray-500">No matches yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($matches as $match)
                            <div class="border rounded p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold">{{ $match->bloodRequest?->hospital_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $match->bloodRequest?->city }} - {{ $match->bloodRequest?->blood_group }}</p>
                                        <p class="text-sm text-gray-600">Urgency: {{ ucfirst($match->bloodRequest?->urgency_level) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm">Score: {{ $match->match_score }}</p>
                                        <p class="text-sm">Status: {{ ucfirst($match->status) }}</p>
                                    </div>
                                </div>

                                <div class="mt-3 flex gap-2">
                                    <form method="POST" action="{{ route('matches.accept', $match) }}">
                                        @csrf
                                        <button class="px-3 py-1 bg-green-600 text-white rounded" @disabled($match->status !== 'pending')>Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('matches.reject', $match) }}">
                                        @csrf
                                        <button class="px-3 py-1 bg-red-600 text-white rounded" @disabled($match->status !== 'pending')>Reject</button>
                                    </form>
                                </div>

                                @if($match->status === 'completed' && $match->bloodRequest?->confirmation_notes)
                                    <div class="mt-3 rounded border border-blue-200 bg-blue-50 p-3 text-sm text-blue-900">
                                        <span class="font-semibold">Recipient Note:</span> {{ $match->bloodRequest->confirmation_notes }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @if(isset($requestMatches))
                <div class="mt-6 bg-white shadow sm:rounded-lg p-6">
                    <h3 class="mb-4 text-lg font-semibold text-slate-900">My Request Matches (As Recipient)</h3>

                    @if($requestMatches->isEmpty())
                        <p class="text-sm text-gray-500">No request matches yet.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($requestMatches as $match)
                                <div class="border rounded p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="font-semibold">Request #{{ $match->bloodRequest?->id }} - {{ $match->bloodRequest?->hospital_name }}</p>
                                            <p class="text-sm text-gray-600">{{ $match->bloodRequest?->city }} - {{ $match->bloodRequest?->blood_group }}</p>
                                            <p class="text-sm text-gray-600">Donor: {{ $match->donor?->name ?? 'N/A' }}</p>
                                            <p class="text-sm text-gray-600">Score: {{ $match->match_score }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-700">Status: {{ ucfirst($match->status) }}</p>
                                            @if($match->bloodRequest)
                                                <a href="{{ route('requests.show', $match->bloodRequest) }}" class="mt-2 inline-flex rounded bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-200">
                                                    Open Request
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
