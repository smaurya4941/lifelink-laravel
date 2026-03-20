<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hospital Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-slate-900">Welcome, {{ $user->name }}</h3>
                <p class="mt-1 text-sm text-slate-600">Role: {{ ucfirst($user->role) }}</p>
                <p class="mt-4 text-sm text-slate-600">
                    Hospital workflow skeleton is ready. Next step is adding request creation and verification-specific actions.
                </p>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h4 class="mb-4 text-lg font-bold text-slate-900">Recent Requests</h4>
                @if($recentRequests->isEmpty())
                    <p class="text-sm text-slate-500">No requests created yet.</p>
                @else
                    <ul class="divide-y divide-slate-200">
                        @foreach($recentRequests as $req)
                            <li class="py-3">
                                <p class="font-semibold text-slate-900">{{ $req->blood_group }} - {{ ucfirst($req->urgency_level) }}</p>
                                <p class="text-sm text-slate-600">{{ $req->hospital_name }} - {{ $req->city }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
