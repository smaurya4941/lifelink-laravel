<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin - Matches</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 rounded shadow">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-600">
                                <th class="py-2">Request</th>
                                <th>Donor</th>
                                <th>Score</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matches as $match)
                                <tr class="border-t">
                                    <td class="py-2">{{ $match->request_id }}</td>
                                    <td>{{ $match->donor?->name ?? 'N/A' }}</td>
                                    <td>{{ $match->match_score }}</td>
                                    <td>{{ ucfirst($match->status) }}</td>
                                    <td>{{ $match->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $matches->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
