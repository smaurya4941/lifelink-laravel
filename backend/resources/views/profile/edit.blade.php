<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Profile') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="bg-white shadow sm:rounded-lg p-6 space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Core Profile</h3>
                    <p class="text-xs text-slate-500">One profile, multiple capabilities.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Name</label>
                        <input type="text" name="name" class="mt-1 w-full border rounded" value="{{ old('name', $user->name) }}" required>
                        @error('name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" class="mt-1 w-full border rounded" value="{{ old('email', $user->email) }}" required>
                        @error('email')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Phone</label>
                        <input type="text" name="phone_number" class="mt-1 w-full border rounded" value="{{ old('phone_number', $user->phone_number) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="mt-1 w-full border rounded" value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Address</label>
                    <input type="text" name="address" class="mt-1 w-full border rounded" value="{{ old('address', $user->address) }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">City</label>
                        <input type="text" name="city" class="mt-1 w-full border rounded" value="{{ old('city', $user->city) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">State</label>
                        <input type="text" name="traditional_state" class="mt-1 w-full border rounded" value="{{ old('traditional_state', $user->traditional_state) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Pincode</label>
                        <input type="text" name="pincode" class="mt-1 w-full border rounded" value="{{ old('pincode', $user->pincode) }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Blood Group</label>
                        <select name="blood_group" class="mt-1 w-full border rounded">
                            <option value="">Select blood group</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $group)
                                <option value="{{ $group }}" @selected(old('blood_group', $donorProfile->blood_group ?? $recipientProfile->blood_group) === $group)>{{ $group }}</option>
                            @endforeach
                        </select>
                        @error('blood_group')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Emergency Contact</label>
                        <input type="text" name="emergency_contact" class="mt-1 w-full border rounded" value="{{ old('emergency_contact', $donorProfile->emergency_contact ?? $recipientProfile->emergency_contact) }}">
                        @error('emergency_contact')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Age</label>
                        <input type="number" name="age" class="mt-1 w-full border rounded" value="{{ old('age', $donorProfile->age ?? $recipientProfile->age) }}">
                        @error('age')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Weight (kg)</label>
                        <input type="number" name="weight" class="mt-1 w-full border rounded" value="{{ old('weight', $donorProfile->weight ?? $recipientProfile->weight) }}">
                        @error('weight')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Height (cm)</label>
                        <input type="number" name="height" class="mt-1 w-full border rounded" value="{{ old('height', $donorProfile->height) }}">
                        @error('height')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 space-y-3">
                    <p class="text-sm font-semibold text-slate-900">Capabilities</p>

                    <div class="flex flex-wrap items-center gap-6">
                        <label class="inline-flex items-center">
                            <input type="hidden" name="is_donor" value="0">
                            <input type="checkbox" name="is_donor" value="1" class="rounded" @checked(old('is_donor', $user->is_donor))>
                            <span class="ml-2 text-sm">Available as Donor</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="hidden" name="is_recipient" value="0">
                            <input type="checkbox" name="is_recipient" value="1" class="rounded" @checked(old('is_recipient', $user->is_recipient))>
                            <span class="ml-2 text-sm">Can Request Blood</span>
                        </label>
                    </div>
                    @error('is_donor')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="rounded-lg border border-emerald-200 bg-emerald-50/40 p-4 space-y-3">
                    <p class="text-sm font-semibold text-emerald-800">Donor Settings</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Last Donation Date</label>
                            <input type="date" name="last_donation_date" class="mt-1 w-full border rounded" value="{{ old('last_donation_date', $donorProfile->last_donation_date) }}">
                        </div>
                        <div class="flex flex-wrap items-center gap-4 pt-6">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="availability_status" value="1" class="rounded" @checked(old('availability_status', $donorProfile->availability_status))>
                                <span class="ml-2 text-sm">Actively accepting matches</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" id="is_live_location_enabled" name="is_live_location_enabled" value="1" class="rounded" @checked(old('is_live_location_enabled', $donorProfile->is_live_location_enabled))>
                                <span class="ml-2 text-sm">Share live location for matching</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Medical Conditions (Donor)</label>
                        <textarea name="medical_conditions" rows="3" class="mt-1 w-full border rounded">{{ old('medical_conditions', $donorProfile->medical_conditions) }}</textarea>
                    </div>
                </div>

                <div class="rounded-lg border border-blue-200 bg-blue-50/40 p-4 space-y-3">
                    <p class="text-sm font-semibold text-blue-800">Recipient Settings</p>
                    <div>
                        <label class="block text-sm font-medium">Medical Needs / Condition (Recipient)</label>
                        <textarea name="recipient_medical_condition" rows="3" class="mt-1 w-full border rounded">{{ old('recipient_medical_condition', $recipientProfile->medical_condition) }}</textarea>
                    </div>
                </div>

                @include('partials.location-picker', [
                    'uid' => 'unified_profile_loc',
                    'label' => 'Current Location',
                    'helpText' => 'Location is used for nearby donor discovery and request matching.',
                    'buttonText' => 'Use Current Location',
                    'latName' => 'latitude',
                    'lngName' => 'longitude',
                    'latId' => 'profile_latitude',
                    'lngId' => 'profile_longitude',
                    'latValue' => $user->latitude,
                    'lngValue' => $user->longitude,
                ])

                <input type="hidden" name="current_latitude" value="{{ old('current_latitude', $donorProfile->current_latitude ?? $user->latitude) }}">
                <input type="hidden" name="current_longitude" value="{{ old('current_longitude', $donorProfile->current_longitude ?? $user->longitude) }}">

                <div class="pt-2">
                    <button class="px-4 py-2 bg-rose-600 text-white rounded">Save Profile</button>
                </div>
            </form>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
