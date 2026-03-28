<x-layouts.admin title="Manage Matches">
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-xs uppercase tracking-wider text-slate-500">
                        <th class="py-3">Match</th>
                        <th class="py-3">Request</th>
                        <th class="py-3">Donor</th>
                        <th class="py-3">Score</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matches as $match)
                        <tr class="border-b align-top">
                            <td class="py-3 font-semibold text-slate-900">#{{ $match->id }}</td>
                            <td class="py-3 text-slate-700">#{{ $match->request_id }} ({{ $match->bloodRequest?->blood_group ?? 'N/A' }})</td>
                            <td class="py-3 text-slate-700">{{ $match->donor?->name ?? 'N/A' }}</td>
                            <td class="py-3 text-slate-700">{{ $match->match_score }}</td>
                            <td class="py-3"><span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($match->status) }}</span></td>
                            <td class="py-3">
                                <form method="POST" action="{{ route('admin.matches.update', $match) }}" class="flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="rounded-lg border-slate-300 text-sm">
                                        @foreach(['pending','accepted','rejected','completed'] as $status)
                                            <option value="{{ $status }}" @selected($match->status === $status)>{{ ucfirst($status) }}</option>
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

        <div class="mt-4">{{ $matches->links() }}</div>
    </div>
</x-layouts.admin>
