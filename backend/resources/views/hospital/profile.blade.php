<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hospital Organization Profile</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('status'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif
            @if(session('error'))
                <div class="p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="rounded-xl border border-slate-200 bg-white p-4">
                <p class="text-sm text-slate-600">Verification Status</p>
                <p class="mt-1 text-base font-semibold
                    {{ $hospital->verification_status === 'verified' ? 'text-emerald-700' : '' }}
                    {{ $hospital->verification_status === 'pending' ? 'text-amber-700' : '' }}
                    {{ $hospital->verification_status === 'rejected' ? 'text-red-700' : '' }}">
                    {{ ucfirst($hospital->verification_status) }}
                </p>
                @if($hospital->verified_at)
                    <p class="text-xs text-slate-500">Verified at {{ $hospital->verified_at->format('Y-m-d H:i') }}</p>
                @endif
            </div>

            <form method="POST" action="{{ route('hospital.profile.update') }}" class="bg-white shadow sm:rounded-lg p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium">Hospital Name</label>
                    <input type="text" name="hospital_name" class="mt-1 w-full border rounded" value="{{ old('hospital_name', $hospital->hospital_name) }}" required>
                    @error('hospital_name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">License Number</label>
                        <input type="text" name="license_number" class="mt-1 w-full border rounded" value="{{ old('license_number', $hospital->license_number) }}" required>
                        @error('license_number')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Contact Phone</label>
                        <input type="text" name="contact_phone" class="mt-1 w-full border rounded" value="{{ old('contact_phone', $hospital->contact_phone) }}">
                        @error('contact_phone')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Address</label>
                    <textarea name="address" class="mt-1 w-full border rounded" rows="3" required>{{ old('address', $hospital->address) }}</textarea>
                    @error('address')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">City</label>
                        <input type="text" name="city" class="mt-1 w-full border rounded" value="{{ old('city', $hospital->city) }}">
                        @error('city')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">State</label>
                        <input type="text" name="state" class="mt-1 w-full border rounded" value="{{ old('state', $hospital->state) }}">
                        @error('state')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Pincode</label>
                        <input type="text" name="pincode" class="mt-1 w-full border rounded" value="{{ old('pincode', $hospital->pincode) }}">
                        @error('pincode')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                @include('partials.location-picker', [
                    'uid' => 'hospital_loc',
                    'label' => 'Hospital Location',
                    'helpText' => 'Fixed location improves nearby donor matching and map visibility.',
                    'buttonText' => 'Use Current Location',
                    'latName' => 'latitude',
                    'lngName' => 'longitude',
                    'latId' => 'hospital_latitude',
                    'lngId' => 'hospital_longitude',
                    'latValue' => $hospital->latitude,
                    'lngValue' => $hospital->longitude,
                ])

                <div class="pt-4">
                    <button class="px-4 py-2 bg-red-600 text-white rounded">Save Organization Profile</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

