<x-guest-layout>
    <div class="mx-auto w-full sm:max-w-md">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <div class="mb-6 rounded-2xl border border-rose-100 bg-gradient-to-br from-rose-50 to-white p-5">
            <p class="inline-flex rounded-full bg-white px-3 py-1 text-xs font-semibold uppercase tracking-wider text-rose-700 ring-1 ring-rose-100">
                Welcome Back
            </p>
            <h1 class="mt-3 text-2xl font-extrabold tracking-tight text-slate-900">
                Sign in to LifeLink
            </h1>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Access your dashboard, donor matches, and live request updates in one place.
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        class="mt-1.5 block w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-rose-300 focus:ring-rose-200"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="you@example.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input
                        id="password"
                        class="mt-1.5 block w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-rose-300 focus:ring-rose-200"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between gap-3 pt-1">
                    <label for="remember_me" class="inline-flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="rounded border-slate-300 text-rose-600 shadow-sm focus:ring-rose-200"
                            name="remember"
                        >
                        <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a
                            class="text-sm font-semibold text-rose-700 transition hover:text-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-200 focus:ring-offset-2"
                            href="{{ route('password.request') }}"
                        >
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="space-y-3">
                <x-primary-button class="w-full justify-center rounded-xl py-2.5 text-sm font-semibold tracking-wide">
                    {{ __('Log In') }}
                </x-primary-button>

                <p class="text-center text-sm text-slate-600">
                    New to LifeLink?
                    <a href="{{ route('register') }}" class="font-semibold text-rose-700 hover:text-rose-800">
                        Create an account
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
