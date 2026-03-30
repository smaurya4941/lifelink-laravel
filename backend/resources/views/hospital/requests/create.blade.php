<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Hospital Request</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('error'))
                <div class="p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="rounded-xl border border-slate-200 bg-white p-4">
                <p class="text-sm text-slate-600">Hospital: {{ $hospital->hospital_name }}</p>
                <p class="text-xs text-slate-500">Verification: {{ ucfirst($hospital->verification_status) }}</p>
            </div>

            <form method="POST" action="{{ route('hospital.requests.store') }}" class="bg-white shadow sm:rounded-lg p-6 space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Patient Name</label>
                        <input type="text" name="patient_name" class="mt-1 w-full border rounded" value="{{ old('patient_name') }}" required>
                        @error('patient_name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Blood Group</label>
                        <select name="blood_group" class="mt-1 w-full border rounded" required>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $group)
                                <option value="{{ $group }}" @selected(old('blood_group') === $group)>{{ $group }}</option>
                            @endforeach
                        </select>
                        @error('blood_group')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Units Required</label>
                        <input type="number" name="units_required" class="mt-1 w-full border rounded" value="{{ old('units_required', 1) }}" required>
                        @error('units_required')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Urgency Level</label>
                        <select name="urgency_level" class="mt-1 w-full border rounded" required>
                            @foreach(['critical', 'high', 'medium', 'low'] as $urgency)
                                <option value="{{ $urgency }}" @selected(old('urgency_level') === $urgency)>{{ ucfirst($urgency) }}</option>
                            @endforeach
                        </select>
                        @error('urgency_level')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Required Date</label>
                        <input type="date" name="required_date" class="mt-1 w-full border rounded" value="{{ old('required_date') }}">
                        @error('required_date')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Contact Person</label>
                        <input type="text" name="contact_person" class="mt-1 w-full border rounded" value="{{ old('contact_person') }}" required>
                        @error('contact_person')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Contact Phone</label>
                        <input type="text" name="contact_phone" class="mt-1 w-full border rounded" value="{{ old('contact_phone', $hospital->contact_phone) }}" required>
                        @error('contact_phone')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Latitude (optional)</label>
                        <input type="text" name="latitude" class="mt-1 w-full border rounded" value="{{ old('latitude', $hospital->latitude) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Longitude (optional)</label>
                        <input type="text" name="longitude" class="mt-1 w-full border rounded" value="{{ old('longitude', $hospital->longitude) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Radius (km)</label>
                        <input type="number" name="radius_km" class="mt-1 w-full border rounded" value="{{ old('radius_km', 20) }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Notes</label>
                    <textarea name="notes" rows="3" class="mt-1 w-full border rounded">{{ old('notes') }}</textarea>
                    @error('notes')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Clinical Description</label>
                    <textarea name="description" rows="3" class="mt-1 w-full border rounded">{{ old('description') }}</textarea>
                    @error('description')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="pt-2">
                    <button class="rounded bg-rose-600 px-4 py-2 text-white">Create Hospital Request</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

