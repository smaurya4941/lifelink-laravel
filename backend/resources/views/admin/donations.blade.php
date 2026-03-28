<x-layouts.admin title="Manage Donations">
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-xs uppercase tracking-wider text-slate-500">
                        <th class="py-3">Donation</th>
                        <th class="py-3">Donor</th>
                        <th class="py-3">Recipient</th>
                        <th class="py-3">Units/Date</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Success</th>
                        <th class="py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                        <tr class="border-b align-top">
                            <td class="py-3 font-semibold text-slate-900">#{{ $donation->id }}</td>
                            <td class="py-3 text-slate-700">{{ $donation->donor?->name ?? 'N/A' }}</td>
                            <td class="py-3 text-slate-700">{{ $donation->recipient?->name ?? 'N/A' }}</td>
                            <td class="py-3 text-xs text-slate-600">
                                <p>{{ $donation->units_donated }} unit(s)</p>
                                <p>{{ $donation->donation_date ?? 'N/A' }}</p>
                            </td>
                            <td class="py-3"><span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($donation->status ?? 'N/A') }}</span></td>
                            <td class="py-3 text-slate-700">{{ $donation->is_successful ? 'Yes' : 'No' }}</td>
                            <td class="py-3">
                                <form method="POST" action="{{ route('admin.donations.update', $donation) }}" class="grid grid-cols-1 gap-2 sm:grid-cols-3">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="rounded-lg border-slate-300 text-sm">
                                        <option value="completed" @selected($donation->status === 'completed')>Completed</option>
                                        <option value="failed" @selected($donation->status === 'failed')>Failed</option>
                                    </select>
                                    <select name="is_successful" class="rounded-lg border-slate-300 text-sm">
                                        <option value="1" @selected($donation->is_successful)>Yes</option>
                                        <option value="0" @selected(!$donation->is_successful)>No</option>
                                    </select>
                                    <button class="rounded-lg bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-700">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $donations->links() }}</div>
    </div>
</x-layouts.admin>
