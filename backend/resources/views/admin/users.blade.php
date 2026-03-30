<x-layouts.admin title="Manage Users">
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-xs uppercase tracking-wider text-slate-500">
                        <th class="py-3">User</th>
                        <th class="py-3">Access</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Capabilities</th>
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
                            <td class="py-3">
                                <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $user->isAdmin() ? 'bg-violet-100 text-violet-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $user->isAdmin() ? 'Admin' : 'Standard' }}
                                </span>
                            </td>
                            <td class="py-3">
                                <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $user->status ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $user->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-3 text-xs text-slate-600">
                                Donor: {{ $user->is_donor ? 'Yes' : 'No' }}<br>
                                Recipient: {{ $user->is_recipient ? 'Yes' : 'No' }}<br>
                                Hospital: {{ $user->is_hospital ? 'Yes' : 'No' }}
                            </td>
                            <td class="py-3 text-xs text-slate-500">{{ $user->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="py-3">
                                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-2 rounded-lg border border-slate-200 p-3">
                                    @csrf
                                    @method('PUT')

                                    <label class="inline-flex items-center gap-2 text-xs text-slate-700">
                                        <input
                                            type="checkbox"
                                            name="is_admin"
                                            value="1"
                                            class="rounded border-slate-300"
                                            @checked($user->isAdmin())
                                            @disabled(auth()->id() === $user->id)
                                        >
                                        <span>Admin Access</span>
                                    </label>
                                    @if(auth()->id() === $user->id)
                                        <p class="text-[11px] text-slate-500">Your own admin access is protected.</p>
                                    @endif

                                    <div class="grid grid-cols-1 gap-1 sm:grid-cols-3">
                                        <label class="inline-flex items-center gap-2 text-xs text-slate-700">
                                            <input type="checkbox" name="is_donor" value="1" class="rounded border-slate-300" @checked($user->is_donor)>
                                            <span>Donor</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-xs text-slate-700">
                                            <input type="checkbox" name="is_recipient" value="1" class="rounded border-slate-300" @checked($user->is_recipient)>
                                            <span>Recipient</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-xs text-slate-700">
                                            <input type="checkbox" name="is_hospital" value="1" class="rounded border-slate-300" @checked($user->is_hospital)>
                                            <span>Hospital</span>
                                        </label>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <select name="status" class="rounded-lg border-slate-300 text-xs">
                                            <option value="1" @selected($user->status)>Active</option>
                                            <option value="0" @selected(!$user->status)>Inactive</option>
                                        </select>
                                        <button class="rounded-lg bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-700">
                                            Save
                                        </button>
                                    </div>
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
