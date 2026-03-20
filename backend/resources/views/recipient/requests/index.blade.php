<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Blood Requests</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="flex items-center justify-between gap-3">
                    <h3 class="text-lg font-semibold">Recipient Profile Snapshot</h3>
                    <a href="{{ route('recipient.profile.edit') }}" class="px-3 py-2 bg-slate-100 text-slate-700 rounded">Edit Profile</a>
                </div>

                @if($profile)
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3 text-sm text-slate-700">
                        <p><span class="font-semibold">Blood Group:</span> {{ $profile->blood_group ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Age:</span> {{ $profile->age ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Weight:</span> {{ $profile->weight ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Emergency Contact:</span> {{ $profile->emergency_contact ?? 'N/A' }}</p>
                        <p><span class="font-semibold">City:</span> {{ $profile->city ?? 'N/A' }}</p>
                        <p><span class="font-semibold">State:</span> {{ $profile->state ?? 'N/A' }}</p>
                    </div>
                @else
                    <p class="mt-3 text-sm text-gray-500">No recipient profile found yet.</p>
                @endif
            </div>

            <div class="flex justify-end mb-4">
                <a href="{{ route('recipient.requests.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Create Request</a>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                @if($requests->isEmpty())
                    <p class="text-sm text-gray-500">No requests yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($requests as $req)
                            <div class="border rounded p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold">{{ $req->hospital_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $req->city }} - {{ $req->blood_group }}</p>
                                        <p class="text-sm text-gray-600">Urgency: {{ ucfirst($req->urgency_level) }}</p>
                                    </div>
                                    <a class="text-blue-600" href="{{ route('recipient.requests.show', $req) }}">View Matches</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
