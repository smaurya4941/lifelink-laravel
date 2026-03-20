<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin - Blood Requests</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 rounded shadow">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-600">
                                <th class="py-2">Patient</th>
                                <th>Blood Group</th>
                                <th>Units</th>
                                <th>Urgency</th>
                                <th>Status</th>
                                <th>City</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                <tr class="border-t">
                                    <td class="py-2">{{ $request->patient_name ?? 'N/A' }}</td>
                                    <td>{{ $request->blood_group }}</td>
                                    <td>{{ $request->units_required }}</td>
                                    <td>{{ ucfirst($request->urgency_level) }}</td>
                                    <td>{{ ucfirst($request->status) }}</td>
                                    <td>{{ $request->city }}</td>
                                    <td>{{ $request->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
