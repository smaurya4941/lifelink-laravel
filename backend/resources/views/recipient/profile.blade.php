<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Recipient Profile</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('recipient.profile.update') }}" class="bg-white shadow sm:rounded-lg p-6 space-y-4">
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
                </div>

                <div>
                    <label class="block text-sm font-medium">Emergency Contact</label>
                    <input type="text" name="emergency_contact" class="mt-1 w-full border rounded" value="{{ old('emergency_contact', $profile->emergency_contact) }}" required>
                    @error('emergency_contact')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Medical Condition</label>
                    <textarea name="medical_condition" class="mt-1 w-full border rounded" rows="3">{{ old('medical_condition', $profile->medical_condition) }}</textarea>
                    @error('medical_condition')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
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

                <div class="pt-4">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">Save Profile</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
