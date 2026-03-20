<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Security Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('status'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif
            @if(session('error'))
                <div class="p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Two-Factor Authentication</h3>
                <p class="text-sm text-gray-600">Status: {{ $twoFactor->is_enabled ? 'Enabled' : 'Disabled' }}</p>

                <div class="mt-4" id="twofa-setup">
                    <button id="load-qr" class="px-4 py-2 bg-blue-600 text-white rounded">Generate QR Code</button>
                    <div id="qr-container" class="mt-4 hidden">
                        <img id="qr-image" alt="QR Code" class="border p-2" />
                        <p class="text-sm text-gray-600 mt-2">Scan with your authenticator app, then enter the code below.</p>
                        <form method="POST" action="{{ route('security.2fa.enable') }}" class="mt-2 flex gap-2">
                            @csrf
                            <input type="text" name="token" class="border rounded px-2 py-1" placeholder="6-digit code" required>
                            <button class="px-3 py-1 bg-green-600 text-white rounded">Enable 2FA</button>
                        </form>
                    </div>
                </div>

                <form method="POST" action="{{ route('security.2fa.disable') }}" class="mt-4">
                    @csrf
                    <input type="password" name="password" class="border rounded px-2 py-1" placeholder="Confirm password" required>
                    <button class="px-3 py-1 bg-red-600 text-white rounded">Disable 2FA</button>
                </form>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Change Password</h3>
                <form method="POST" action="{{ route('security.password.update') }}" class="space-y-3">
                    @csrf
                    <div>
                        <input type="password" name="current_password" class="border rounded w-full px-2 py-1" placeholder="Current password" required>
                    </div>
                    <div>
                        <input type="password" name="new_password" class="border rounded w-full px-2 py-1" placeholder="New password" required>
                    </div>
                    <button class="px-4 py-2 bg-gray-800 text-white rounded">Update Password</button>
                </form>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Recent Security Events</h3>
                <ul class="divide-y">
                    @forelse($recentEvents as $event)
                        <li class="py-2">
                            <p class="text-sm font-medium">{{ $event->event_type }}</p>
                            <p class="text-xs text-gray-500">{{ $event->created_at->toDayDateTimeString() }}</p>
                        </li>
                    @empty
                        <li class="py-2 text-sm text-gray-500">No events yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('load-qr')?.addEventListener('click', async () => {
            const res = await fetch('{{ route('security.2fa.setup') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();
            const container = document.getElementById('qr-container');
            const img = document.getElementById('qr-image');
            img.src = 'data:image/svg+xml;base64,' + data.qr_svg;
            container.classList.remove('hidden');
        });
    </script>
</x-app-layout>
