<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin - Notifications</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 rounded shadow">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-600">
                                <th class="py-2">User</th>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Read</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifications as $notification)
                                <tr class="border-t">
                                    <td class="py-2">{{ $notification->user?->name ?? 'N/A' }}</td>
                                    <td>{{ $notification->notification_type }}</td>
                                    <td>{{ $notification->title }}</td>
                                    <td>{{ $notification->is_read ? 'Yes' : 'No' }}</td>
                                    <td>{{ $notification->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
