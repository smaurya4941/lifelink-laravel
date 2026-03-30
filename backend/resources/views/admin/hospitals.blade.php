<x-layouts.admin title="Hospital Verification">
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-xs uppercase tracking-wider text-slate-500">
                        <th class="py-3">Hospital</th>
                        <th class="py-3">Account</th>
                        <th class="py-3">License</th>
                        <th class="py-3">Address</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hospitals as $hospital)
                        <tr class="border-b align-top">
                            <td class="py-3 font-semibold text-slate-900">{{ $hospital->hospital_name }}</td>
                            <td class="py-3 text-slate-700">
                                <p>{{ $hospital->user?->name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-500">{{ $hospital->user?->email ?? 'N/A' }}</p>
                            </td>
                            <td class="py-3 text-slate-700">{{ $hospital->license_number }}</td>
                            <td class="py-3 text-xs text-slate-600">
                                <p>{{ $hospital->address }}</p>
                                <p>{{ collect([$hospital->city, $hospital->state, $hospital->pincode])->filter()->join(', ') }}</p>
                            </td>
                            <td class="py-3">
                                <span class="rounded-full px-2 py-1 text-xs font-semibold
                                    {{ $hospital->verification_status === 'verified' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $hospital->verification_status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $hospital->verification_status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}">
                                    {{ ucfirst($hospital->verification_status) }}
                                </span>
                            </td>
                            <td class="py-3">
                                <form method="POST" action="{{ route('admin.hospitals.update', $hospital) }}" class="flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="verification_status" class="rounded-lg border-slate-300 text-sm">
                                        @foreach(['pending', 'verified', 'rejected'] as $status)
                                            <option value="{{ $status }}" @selected($hospital->verification_status === $status)>{{ ucfirst($status) }}</option>
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

        <div class="mt-4">{{ $hospitals->links() }}</div>
    </div>
</x-layouts.admin>

