<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach([
                    'Users' => $stats['users'],
                    'Donors' => $stats['donors'],
                    'Recipients' => $stats['recipients'],
                    'Requests' => $stats['requests'],
                    'Matches' => $stats['matches'],
                    'Donations' => $stats['donations'],
                    'Notifications' => $stats['notifications'],
                ] as $label => $value)
                    <div class="bg-white p-4 rounded shadow">
                        <p class="text-sm text-gray-600">{{ $label }}</p>
                        <p class="text-2xl font-bold">{{ $value }}</p>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.users') }}" class="bg-white p-4 rounded shadow hover:border-red-500 border">
                    Manage Users
                </a>
                <a href="{{ route('admin.requests') }}" class="bg-white p-4 rounded shadow hover:border-red-500 border">
                    View Requests
                </a>
                <a href="{{ route('admin.matches') }}" class="bg-white p-4 rounded shadow hover:border-red-500 border">
                    View Matches
                </a>
                <a href="{{ route('admin.donations') }}" class="bg-white p-4 rounded shadow hover:border-red-500 border">
                    View Donations
                </a>
                <a href="{{ route('admin.notifications') }}" class="bg-white p-4 rounded shadow hover:border-red-500 border">
                    View Notifications
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
