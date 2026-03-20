<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="mb-5">
        <p class="ll-badge">Welcome Back</p>
        <h1 class="mt-2 text-2xl font-extrabold text-slate-900">Sign in to LifeLink</h1>
        <p class="mt-1 text-sm text-slate-500">Access your dashboard, matches, and live request updates.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-rose-600 shadow-sm focus:ring-rose-200" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end pt-2">
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-rose-700 hover:text-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-200 focus:ring-offset-2" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
