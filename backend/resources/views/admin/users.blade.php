<x-layouts.admin title="Manage Users">
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-xs uppercase tracking-wider text-slate-500">
                        <th class="py-3">User</th>
                        <th class="py-3">Role</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Flags</th>
                        <th class="py-3">Created</th>
                        <th class="py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b align-top">
                            <td class="py-3">
                                <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $user->email }}</p>
                            </td>
                            <td class="py-3">{{ ucfirst($user->role) }}</td>
                            <td class="py-3">
                                <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $user->status ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $user->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-3 text-xs text-slate-600">
                                Donor: {{ $user->is_donor ? 'Yes' : 'No' }}<br>
                                Recipient: {{ $user->is_recipient ? 'Yes' : 'No' }}
                            </td>
                            <td class="py-3 text-xs text-slate-500">{{ $user->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="py-3">
                                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="grid grid-cols-1 gap-2 sm:grid-cols-3">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="rounded-lg border-slate-300 text-sm">
                                        @foreach($roleOptions as $role)
                                            <option value="{{ $role }}" @selected($user->role === $role)>{{ ucfirst($role) }}</option>
                                        @endforeach
                                    </select>
                                    <select name="status" class="rounded-lg border-slate-300 text-sm">
                                        <option value="1" @selected($user->status)>Active</option>
                                        <option value="0" @selected(!$user->status)>Inactive</option>
                                    </select>
                                    <button class="rounded-lg bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-700">
                                        Save
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-layouts.admin>
