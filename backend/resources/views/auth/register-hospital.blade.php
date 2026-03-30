<x-guest-layout>
    <div class="mb-5">
        <p class="ll-badge">Hospital Signup</p>
        <h1 class="mt-2 text-2xl font-extrabold text-slate-900">Create a hospital account</h1>
        <p class="mt-1 text-sm text-slate-500">Register your hospital with license details for trust and verification.</p>
    </div>

    <form method="POST" action="{{ route('register.hospital.store') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Admin Contact Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="hospital_name" :value="__('Hospital Name')" />
            <x-text-input id="hospital_name" class="block mt-1 w-full" type="text" name="hospital_name" :value="old('hospital_name')" required />
            <x-input-error :messages="$errors->get('hospital_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="license_number" :value="__('License Number')" />
            <x-text-input id="license_number" class="block mt-1 w-full" type="text" name="license_number" :value="old('license_number')" required />
            <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="address" :value="__('Hospital Address')" />
            <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-rose-300 focus:ring-rose-200" required>{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm font-medium text-rose-700 hover:text-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-200 focus:ring-offset-2" href="{{ route('register') }}">
                {{ __('Back to user registration') }}
            </a>

            <x-primary-button>
                {{ __('Register Hospital') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

