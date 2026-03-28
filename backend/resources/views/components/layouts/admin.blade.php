<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-rose-200">Admin Console</p>
                <h2 class="text-2xl font-extrabold text-white">{{ $title ?? 'Admin Dashboard' }}</h2>
            </div>
            <a href="{{ route('dashboard') }}" class="rounded-lg bg-white/15 px-3 py-2 text-sm font-semibold text-white hover:bg-white/25">
                Back To App
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                <aside class="lg:col-span-3 xl:col-span-2">
                    <div class="sticky top-20 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                        <nav class="space-y-1">
                            @php
                                $links = [
                                    ['route' => 'admin.index', 'label' => 'Overview'],
                                    ['route' => 'admin.users', 'label' => 'Users'],
                                    ['route' => 'admin.requests', 'label' => 'Requests'],
                                    ['route' => 'admin.matches', 'label' => 'Matches'],
                                    ['route' => 'admin.donations', 'label' => 'Donations'],
                                    ['route' => 'admin.notifications', 'label' => 'Notifications'],
                                ];
                            @endphp

                            @foreach($links as $link)
                                <a
                                    href="{{ route($link['route']) }}"
                                    class="block rounded-lg px-3 py-2 text-sm font-semibold transition {{ request()->routeIs($link['route']) ? 'bg-rose-600 text-white shadow' : 'text-slate-700 hover:bg-rose-50 hover:text-rose-700' }}"
                                >
                                    {{ $link['label'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </aside>

                <main class="lg:col-span-9 xl:col-span-10 space-y-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
