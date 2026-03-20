<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin - Users</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 rounded shadow">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-600">
                                <th class="py-2">Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Donor</th>
                                <th>Recipient</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="border-t">
                                    <td class="py-2">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->is_donor ? 'Yes' : 'No' }}</td>
                                    <td>{{ $user->is_recipient ? 'Yes' : 'No' }}</td>
                                    <td>{{ $user->status ? 'Active' : 'Inactive' }}</td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
