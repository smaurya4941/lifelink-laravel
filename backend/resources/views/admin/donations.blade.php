<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin - Donations</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 rounded shadow">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-600">
                                <th class="py-2">Donor</th>
                                <th>Recipient</th>
                                <th>Units</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donations as $donation)
                                <tr class="border-t">
                                    <td class="py-2">{{ $donation->donor?->name ?? 'N/A' }}</td>
                                    <td>{{ $donation->recipient?->name ?? 'N/A' }}</td>
                                    <td>{{ $donation->units_donated }}</td>
                                    <td>{{ $donation->status ?? ($donation->is_successful ? 'successful' : 'pending') }}</td>
                                    <td>{{ $donation->donation_date ?? $donation->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $donations->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
