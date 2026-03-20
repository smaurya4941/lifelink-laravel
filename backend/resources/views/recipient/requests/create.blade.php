<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Blood Request</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('recipient.requests.store') }}" class="bg-white shadow sm:rounded-lg p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium">Blood Group</label>
                    <select name="blood_group" class="mt-1 w-full border rounded">
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $group)
                            <option value="{{ $group }}" @selected(old('blood_group') === $group)>{{ $group }}</option>
                        @endforeach
                    </select>
                    @error('blood_group')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Patient Name</label>
                    <input type="text" name="patient_name" class="mt-1 w-full border rounded" value="{{ old('patient_name') }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Units Required</label>
                        <input type="number" name="units_required" class="mt-1 w-full border rounded" value="{{ old('units_required', 1) }}" required>
                        @error('units_required')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Urgency</label>
                        <select name="urgency_level" class="mt-1 w-full border rounded">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Hospital Name</label>
                    <input type="text" name="hospital_name" class="mt-1 w-full border rounded" value="{{ old('hospital_name') }}" required>
                    @error('hospital_name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Hospital Address</label>
                    <input type="text" name="hospital_address" class="mt-1 w-full border rounded" value="{{ old('hospital_address') }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">City</label>
                        <input type="text" name="city" class="mt-1 w-full border rounded" value="{{ old('city') }}" required>
                        @error('city')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Required Date</label>
                        <input type="date" name="required_date" class="mt-1 w-full border rounded" value="{{ old('required_date') }}">
                        @error('required_date')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">State</label>
                        <input type="text" name="state" class="mt-1 w-full border rounded" value="{{ old('state') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Pincode</label>
                        <input type="text" name="pincode" class="mt-1 w-full border rounded" value="{{ old('pincode') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Contact Person</label>
                        <input type="text" name="contact_person" class="mt-1 w-full border rounded" value="{{ old('contact_person') }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Contact Phone</label>
                    <input type="text" name="contact_phone" class="mt-1 w-full border rounded" value="{{ old('contact_phone') }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Latitude (optional)</label>
                        <input type="text" name="latitude" class="mt-1 w-full border rounded" value="{{ old('latitude') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Longitude (optional)</label>
                        <input type="text" name="longitude" class="mt-1 w-full border rounded" value="{{ old('longitude') }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Search Radius (km)</label>
                    <input type="number" name="radius_km" class="mt-1 w-full border rounded" value="{{ old('radius_km', 10) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Notes</label>
                    <textarea name="notes" class="mt-1 w-full border rounded" rows="3">{{ old('notes') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium">Description</label>
                    <textarea name="description" class="mt-1 w-full border rounded" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="pt-4">
                    <button class="px-4 py-2 bg-green-600 text-white rounded">Create Request</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
