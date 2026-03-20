<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Donor Profile</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('donor.profile.update') }}" class="bg-white shadow sm:rounded-lg p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium">Blood Group</label>
                    <select name="blood_group" class="mt-1 w-full border rounded">
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $group)
                            <option value="{{ $group }}" @selected(old('blood_group', $profile->blood_group) === $group)>{{ $group }}</option>
                        @endforeach
                    </select>
                    @error('blood_group')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Age</label>
                        <input type="number" name="age" class="mt-1 w-full border rounded" value="{{ old('age', $profile->age) }}" required>
                        @error('age')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Weight (kg)</label>
                        <input type="number" name="weight" class="mt-1 w-full border rounded" value="{{ old('weight', $profile->weight) }}" required>
                        @error('weight')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Height (cm)</label>
                        <input type="number" name="height" class="mt-1 w-full border rounded" value="{{ old('height', $profile->height) }}">
                        @error('height')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Emergency Contact</label>
                        <input type="text" name="emergency_contact" class="mt-1 w-full border rounded" value="{{ old('emergency_contact', $profile->emergency_contact) }}">
                        @error('emergency_contact')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Last Donation Date</label>
                    <input type="date" name="last_donation_date" class="mt-1 w-full border rounded" value="{{ old('last_donation_date', $profile->last_donation_date) }}">
                    @error('last_donation_date')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Medical Conditions</label>
                    <textarea name="medical_conditions" class="mt-1 w-full border rounded" rows="3">{{ old('medical_conditions', $profile->medical_conditions) }}</textarea>
                    @error('medical_conditions')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Address</label>
                    <input type="text" name="address" class="mt-1 w-full border rounded" value="{{ old('address', $profile->address) }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">City</label>
                        <input type="text" name="city" class="mt-1 w-full border rounded" value="{{ old('city', $profile->city) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">State</label>
                        <input type="text" name="state" class="mt-1 w-full border rounded" value="{{ old('state', $profile->state) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Pincode</label>
                        <input type="text" name="pincode" class="mt-1 w-full border rounded" value="{{ old('pincode', $profile->pincode) }}">
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="availability_status" value="1" class="rounded" @checked(old('availability_status', $profile->availability_status))>
                        <span class="ml-2 text-sm">Available to donate</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_live_location_enabled" value="1" class="rounded" @checked(old('is_live_location_enabled', $profile->is_live_location_enabled))>
                        <span class="ml-2 text-sm">Share live location</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Current Latitude</label>
                        <input type="text" name="current_latitude" class="mt-1 w-full border rounded" value="{{ old('current_latitude', $profile->current_latitude) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Current Longitude</label>
                        <input type="text" name="current_longitude" class="mt-1 w-full border rounded" value="{{ old('current_longitude', $profile->current_longitude) }}">
                    </div>
                </div>

                <div class="pt-4">
                    <button class="px-4 py-2 bg-red-600 text-white rounded">Save Profile</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
