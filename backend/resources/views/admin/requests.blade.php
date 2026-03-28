<x-layouts.admin title="Manage Requests">
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-xs uppercase tracking-wider text-slate-500">
                        <th class="py-3">Request</th>
                        <th class="py-3">Requester</th>
                        <th class="py-3">Details</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Created</th>
                        <th class="py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr class="border-b align-top">
                            <td class="py-3 font-semibold text-slate-900">#{{ $request->id }}</td>
                            <td class="py-3 text-slate-700">{{ $request->requester?->name ?? 'N/A' }}</td>
                            <td class="py-3 text-xs text-slate-600">
                                <p>{{ $request->blood_group }} | Units: {{ $request->units_required }}</p>
                                <p>{{ $request->city }} | Urgency: {{ ucfirst($request->urgency_level) }}</p>
                            </td>
                            <td class="py-3">
                                <span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($request->status) }}</span>
                            </td>
                            <td class="py-3 text-xs text-slate-500">{{ $request->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="py-3">
                                <form method="POST" action="{{ route('admin.requests.update', $request) }}" class="flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="rounded-lg border-slate-300 text-sm">
                                        @foreach(['pending','matched','confirmed','in_progress','completed','cancelled'] as $status)
                                            <option value="{{ $status }}" @selected($request->status === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                        @endforeach
                                    </select>
                                    <button class="rounded-lg bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-700">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $requests->links() }}</div>
    </div>
</x-layouts.admin>
