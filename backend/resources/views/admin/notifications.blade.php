<x-layouts.admin title="Manage Notifications">
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-xs uppercase tracking-wider text-slate-500">
                        <th class="py-3">Notification</th>
                        <th class="py-3">User</th>
                        <th class="py-3">Type</th>
                        <th class="py-3">Created</th>
                        <th class="py-3">Read</th>
                        <th class="py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $notification)
                        <tr class="border-b align-top">
                            <td class="py-3">
                                <p class="font-semibold text-slate-900">{{ $notification->title }}</p>
                                <p class="text-xs text-slate-600">{{ $notification->message }}</p>
                            </td>
                            <td class="py-3 text-slate-700">{{ $notification->user?->name ?? 'N/A' }}</td>
                            <td class="py-3 text-slate-700">{{ $notification->notification_type }}</td>
                            <td class="py-3 text-xs text-slate-500">{{ $notification->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="py-3 text-slate-700">{{ $notification->is_read ? 'Yes' : 'No' }}</td>
                            <td class="py-3">
                                <form method="POST" action="{{ route('admin.notifications.update', $notification) }}" class="flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="is_read" class="rounded-lg border-slate-300 text-sm">
                                        <option value="1" @selected($notification->is_read)>Read</option>
                                        <option value="0" @selected(!$notification->is_read)>Unread</option>
                                    </select>
                                    <button class="rounded-lg bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-700">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $notifications->links() }}</div>
    </div>
</x-layouts.admin>
