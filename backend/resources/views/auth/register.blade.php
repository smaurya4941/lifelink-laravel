<x-guest-layout>
    <div class="mb-5">
        <p class="ll-badge">Get Started</p>
        <h1 class="mt-2 text-2xl font-extrabold text-slate-900">Create your LifeLink account</h1>
        <p class="mt-1 text-sm text-slate-500">Join as a donor, recipient, or hospital and start matching faster.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- role  -->
        <div>
            <x-input-label for="role" :value="__('Role')" />
            <select name="role" class="block mt-1 w-full rounded-xl border-slate-300 bg-white/90 text-slate-900 shadow-sm focus:border-rose-300 focus:ring-rose-200">
                <option value="donor">Donor</option>
                <option value="recipient">Recipient</option>
                <option value="hospital">Hospital</option>
            </select>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end pt-2">
            <a class="text-sm font-medium text-rose-700 hover:text-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-200 focus:ring-offset-2" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
