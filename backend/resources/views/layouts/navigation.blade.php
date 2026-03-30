<nav x-data="{ open: false }" class="sticky top-0 z-30 border-b border-rose-100 bg-white/85 backdrop-blur">
    @php
        $navUser = Auth::user();
        $hospitalOnly = $navUser->hasCapability('hospital') && !$navUser->hasCapability('donor') && !$navUser->hasCapability('recipient');
        $profileRoute = $hospitalOnly ? 'hospital.profile.edit' : 'profile.edit';
        $profileLabel = $hospitalOnly ? 'Organization Profile' : 'Profile';
        $profileIsActive = $hospitalOnly ? request()->routeIs('hospital.profile.*') : request()->routeIs('profile.*');
    @endphp

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1.5 text-sm font-bold tracking-tight text-rose-700">
                        LifeLink
                    </a>
                </div>

                <div class="hidden space-x-2 sm:ms-8 sm:flex sm:items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->hasCapability('recipient'))
                        <x-nav-link :href="route('requests.index')" :active="request()->routeIs('requests.*')">
                            {{ __('Requests') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->hasCapability('donor'))
                        <x-nav-link :href="route('matches.index')" :active="request()->routeIs('matches.*')">
                            {{ __('Matches') }}
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route($profileRoute)" :active="$profileIsActive">
                        {{ __($profileLabel) }}
                    </x-nav-link>

                    <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
                        {{ __('Notifications') }}
                    </x-nav-link>

                    <x-nav-link :href="route('map.index')" :active="request()->routeIs('map.*')">
                        {{ __('Map') }}
                    </x-nav-link>

                </div>
            </div>

            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-xl border border-rose-100 bg-white px-3 py-2 text-sm font-medium text-slate-600 shadow-sm hover:text-rose-700 focus:outline-none">
                            <div>{{ Auth::user()->name }} ({{ implode(' / ', Auth::user()->capabilityLabels()) }})</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route($profileRoute)">
                            {{ __($profileLabel) }}
                        </x-dropdown-link>

                        @if(Auth::user()->hasCapability('hospital'))
                            <x-dropdown-link :href="route('hospital.dashboard')">
                                {{ __('Hospital Workspace') }}
                            </x-dropdown-link>
                        @endif

                        @if(Auth::user()->isAdmin())
                            <x-dropdown-link :href="route('admin.index')">
                                {{ __('Admin Panel') }}
                            </x-dropdown-link>
                        @endif

                        <x-dropdown-link :href="route('security.dashboard')">
                            {{ __('Security Settings') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-lg border border-rose-100 bg-white p-2 text-slate-500 hover:bg-rose-50 hover:text-rose-700 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-rose-100 bg-white/95 sm:hidden">
        <div class="space-y-1 px-3 pb-3 pt-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->hasCapability('recipient'))
                <x-responsive-nav-link :href="route('requests.index')" :active="request()->routeIs('requests.*')">
                    {{ __('Requests') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->hasCapability('donor'))
                <x-responsive-nav-link :href="route('matches.index')" :active="request()->routeIs('matches.*')">
                    {{ __('Matches') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route($profileRoute)" :active="$profileIsActive">
                {{ __($profileLabel) }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
                {{ __('Notifications') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('map.index')" :active="request()->routeIs('map.*')">
                {{ __('Map') }}
            </x-responsive-nav-link>

        </div>

        <div class="border-t border-rose-100 pb-3 pt-4">
            <div class="px-4">
                <div class="text-base font-semibold text-slate-800">{{ Auth::user()->name }}</div>
                <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route($profileRoute)">
                    {{ __($profileLabel) }}
                </x-responsive-nav-link>

                @if(Auth::user()->hasCapability('hospital'))
                    <x-responsive-nav-link :href="route('hospital.dashboard')">
                        {{ __('Hospital Workspace') }}
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.index')">
                        {{ __('Admin Panel') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('security.dashboard')">
                    {{ __('Security Settings') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
