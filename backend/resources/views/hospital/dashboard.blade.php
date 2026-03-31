<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>LifeLink Hospital Portal</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "tertiary-container": "#00845a",
        "secondary-container": "#d5e3fc",
        "on-surface-variant": "#5c3f40",
        "inverse-on-surface": "#eaf1ff",
        "primary-container": "#e11d48",
        "inverse-primary": "#ffb3b6",
        "surface": "#f8f9ff",
        "outline-variant": "#e5bdbe",
        "surface-container-high": "#dce9ff",
        "inverse-surface": "#213145",
        "primary-fixed": "#ffdada",
        "on-primary": "#ffffff",
        "secondary-fixed-dim": "#b9c7df",
        "secondary-fixed": "#d5e3fc",
        "surface-container-lowest": "#ffffff",
        "on-tertiary": "#ffffff",
        "on-tertiary-fixed": "#002113",
        "on-secondary-fixed-variant": "#3a485b",
        "surface-container": "#e5eeff",
        "on-tertiary-container": "#eefff3",
        "tertiary": "#006847",
        "primary-fixed-dim": "#ffb3b6",
        "secondary": "#515f74",
        "on-secondary-fixed": "#0d1c2e",
        "on-error-container": "#93000a",
        "surface-container-low": "#eff4ff",
        "error": "#ba1a1a",
        "on-tertiary-fixed-variant": "#005236",
        "on-primary-container": "#fffaf9",
        "on-primary-fixed-variant": "#920028",
        "on-background": "#0b1c30",
        "surface-variant": "#d3e4fe",
        "error-container": "#ffdad6",
        "outline": "#906f70",
        "on-primary-fixed": "#40000c",
        "surface-tint": "#be0037",
        "surface-dim": "#cbdbf5",
        "tertiary-fixed-dim": "#4edea3",
        "on-surface": "#0b1c30",
        "surface-bright": "#f8f9ff",
        "background": "#f8f9ff",
        "on-secondary": "#ffffff",
        "surface-container-highest": "#d3e4fe",
        "on-error": "#ffffff",
        "primary": "#b80035",
        "on-secondary-container": "#57657a",
        "tertiary-fixed": "#6ffbbe"
      },
      fontFamily: {
        "headline": ["Manrope"],
        "body": ["Inter"],
        "label": ["Inter"]
      },
      borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
    },
  },
}
</script>
<style>
.material-symbols-outlined {
  font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
}
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
</head>
<body class="bg-surface-container-low font-body text-on-surface antialiased">
@php
  $user = auth()->user();
  $verificationTone = match($hospital->verification_status) {
    'verified' => 'bg-tertiary-container text-on-tertiary-container',
    'rejected' => 'bg-error-container text-error',
    default => 'bg-amber-100 text-amber-800',
  };
  $profileFields = [
    $hospital->hospital_name,
    $hospital->license_number,
    $hospital->address,
    $hospital->city,
    $hospital->state,
    $hospital->pincode,
    $hospital->contact_phone,
    $hospital->latitude,
    $hospital->longitude,
  ];
  $profileCompletion = (int) round((collect($profileFields)->filter(fn ($value) => !is_null($value) && $value !== '')->count() / count($profileFields)) * 100);
  $inventoryHealth = $stats['matched_donors'] > 0 ? min(100, max(12, $stats['matched_donors'] * 12)) : 12;
@endphp

<aside class="fixed left-0 top-0 z-40 flex h-screen w-64 flex-col overflow-y-auto bg-slate-50 p-4 space-y-2">
  <div class="mb-8 px-2">
    <h1 class="font-headline text-2xl font-black text-rose-700">LifeLink</h1>
    <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-container">Hospital Portal</p>
  </div>

  <nav class="flex-1 space-y-1">
    <a class="flex items-center space-x-3 rounded-xl bg-rose-100/50 px-4 py-3 font-bold text-rose-700 transition-transform duration-200 hover:translate-x-1" href="{{ route('hospital.dashboard') }}">
      <span class="material-symbols-outlined">dashboard</span>
      <span class="text-sm">Dashboard</span>
    </a>
    <a class="flex items-center space-x-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('hospital.requests.index') }}">
      <span class="material-symbols-outlined">bloodtype</span>
      <span class="text-sm">Requests</span>
    </a>
    <a class="flex items-center space-x-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('hospital.requests.index') }}">
      <span class="material-symbols-outlined">swap_horiz</span>
      <span class="text-sm">Matches</span>
    </a>
    <a class="flex items-center space-x-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('hospital.profile.edit') }}">
      <span class="material-symbols-outlined">inventory_2</span>
      <span class="text-sm">Inventory</span>
    </a>
    <a class="flex items-center space-x-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('analytics.index') }}">
      <span class="material-symbols-outlined">analytics</span>
      <span class="text-sm">Analytics</span>
    </a>
    <a class="flex items-center space-x-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('hospital.profile.edit') }}">
      <span class="material-symbols-outlined">settings</span>
      <span class="text-sm">Settings</span>
    </a>
  </nav>

  <div class="mt-auto space-y-1 border-t border-slate-200/20 pt-4">
    <a href="{{ route('hospital.requests.create') }}" class="mb-4 block w-full rounded-xl bg-primary py-3 text-center text-sm font-bold text-on-primary shadow-sm transition-all hover:opacity-90 active:scale-95">
      Emergency Request
    </a>
    <a class="flex items-center space-x-3 px-4 py-2 text-slate-500 transition-all hover:text-rose-500" href="{{ route('notifications.index') }}">
      <span class="material-symbols-outlined text-sm">help</span>
      <span class="text-xs font-medium">Help Center</span>
    </a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="flex w-full items-center space-x-3 px-4 py-2 text-slate-500 transition-all hover:text-rose-500" type="submit">
        <span class="material-symbols-outlined text-sm">logout</span>
        <span class="text-xs font-medium">Logout</span>
      </button>
    </form>
  </div>
</aside>

<main class="ml-64 min-h-screen p-8">
  <header class="mb-12 flex items-start justify-between">
    <div>
      <h2 class="font-headline text-4xl font-black tracking-tight text-on-surface">{{ $hospital->hospital_name ?: 'Hospital Workspace' }}</h2>
      <div class="mt-2 flex items-center space-x-3">
        <span class="flex items-center rounded-full px-3 py-1 text-xs font-bold {{ $verificationTone }}">
          <span class="material-symbols-outlined mr-1 text-xs" style="font-variation-settings: 'FILL' 1;">verified</span>
          {{ ucfirst($hospital->verification_status) }} Facility
        </span>
        <span class="text-sm font-medium text-on-secondary-container">ID: {{ $hospital->license_number ?: 'PENDING-LICENSE' }}</span>
      </div>
    </div>
    <div class="flex space-x-4">
      <a href="{{ route('notifications.index') }}" class="rounded-xl bg-surface-container-lowest p-3 text-on-surface shadow-sm transition-colors hover:bg-surface-container">
        <span class="material-symbols-outlined">notifications</span>
      </a>
      <div class="flex items-center space-x-3 rounded-xl bg-surface-container-lowest py-2 pl-4 pr-2 shadow-sm">
        <div class="text-right">
          <p class="text-sm font-bold leading-none">{{ $user->name }}</p>
          <p class="text-[10px] text-on-secondary-container">{{ $user->email }}</p>
        </div>
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-fixed text-sm font-bold text-on-primary-fixed-variant">
          {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
      </div>
    </div>
  </header>

  @if(session('status'))
    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
  @endif
  @if(session('error'))
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
  @endif

  <div class="mb-12 grid grid-cols-1 gap-6 md:grid-cols-3">
    <div class="group relative overflow-hidden rounded-xl bg-surface-container-lowest p-8">
      <div class="relative z-10">
        <p class="mb-1 text-sm font-bold text-on-secondary-container">Active Requests</p>
        <h3 class="font-headline text-5xl font-black text-primary">{{ $stats['active_requests'] }}</h3>
        <div class="mt-4 flex items-center text-xs font-semibold text-tertiary">
          <span class="material-symbols-outlined mr-1 text-sm">trending_up</span>
          {{ $stats['critical_requests'] }} urgent pending
        </div>
      </div>
      <span class="material-symbols-outlined absolute -bottom-4 -right-4 text-9xl text-slate-50 opacity-50 transition-transform group-hover:scale-110">emergency_share</span>
    </div>

    <div class="group relative overflow-hidden rounded-xl bg-surface-container-lowest p-8">
      <div class="relative z-10">
        <p class="mb-1 text-sm font-bold text-on-secondary-container">Matched Donors</p>
        <h3 class="font-headline text-5xl font-black text-on-surface">{{ $stats['matched_donors'] }} <span class="text-xl font-medium text-slate-400">links</span></h3>
        <div class="mt-4 flex items-center text-xs font-semibold {{ $stats['matched_donors'] > 0 ? 'text-tertiary' : 'text-error' }}">
          <span class="material-symbols-outlined mr-1 text-sm">{{ $stats['matched_donors'] > 0 ? 'task_alt' : 'warning' }}</span>
          {{ $stats['matched_donors'] > 0 ? 'Donor pipeline active' : 'Donor pipeline needs attention' }}
        </div>
      </div>
      <span class="material-symbols-outlined absolute -bottom-4 -right-4 text-9xl text-slate-50 opacity-50 transition-transform group-hover:scale-110">bloodtype</span>
    </div>

    <div class="group relative overflow-hidden rounded-xl bg-surface-container-lowest p-8">
      <div class="relative z-10">
        <p class="mb-1 text-sm font-bold text-on-secondary-container">Profile Integrity</p>
        <h3 class="font-headline text-5xl font-black text-tertiary">{{ $profileCompletion }}%</h3>
        <div class="mt-4 flex items-center text-xs font-semibold text-on-secondary-container">
          <span class="material-symbols-outlined mr-1 text-sm">task_alt</span>
          {{ $hospital->updated_at?->diffForHumans() ?? 'Recently updated' }}
        </div>
      </div>
      <div class="absolute right-8 top-8 flex h-16 w-16 items-center justify-center rounded-full border-4 border-slate-100">
        <div class="h-12 w-12 rounded-full border-4 border-tertiary border-t-transparent"></div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-12 gap-8">
    <section class="col-span-8 space-y-6">
      <div class="mb-2 flex items-center justify-between">
        <h4 class="font-headline text-2xl font-black text-on-surface">Hospital Requests</h4>
        <div class="flex space-x-2">
          <a href="{{ route('hospital.requests.index') }}" class="rounded-lg bg-surface-container-high px-4 py-2 text-xs font-bold transition-colors hover:bg-surface-variant">All Types</a>
          <a href="{{ route('hospital.requests.create') }}" class="rounded-lg bg-surface-container-lowest px-4 py-2 text-xs font-bold transition-colors hover:bg-surface-container">Create New</a>
        </div>
      </div>

      <div class="space-y-4">
        @forelse($recentRequests as $req)
          @php
            $urgencyBadge = match($req->urgency_level) {
              'critical' => 'bg-error text-on-error',
              'high' => 'bg-rose-200 text-rose-800',
              'medium' => 'bg-slate-200 text-slate-600',
              default => 'bg-slate-100 text-slate-500',
            };
            $statusBadge = match($req->status) {
              'matched', 'confirmed', 'in_progress' => 'bg-tertiary-container text-on-tertiary-container',
              'completed' => 'bg-emerald-100 text-emerald-700',
              default => 'bg-slate-200 text-slate-600',
            };
          @endphp
          <a href="{{ route('hospital.requests.show', $req) }}" class="group flex items-center justify-between rounded-xl bg-surface-container-lowest p-6 transition-all hover:bg-surface-bright">
            <div class="flex items-center space-x-6">
              <div class="flex h-14 w-14 items-center justify-center rounded-xl {{ $urgencyBadge }} font-black text-xl">{{ $req->blood_group }}</div>
              <div>
                <p class="font-bold text-on-surface">{{ $req->patient_name ?: 'Emergency Transfusion Support' }}</p>
                <p class="text-xs text-on-secondary-container">Request #REQ-{{ $req->id }} • {{ $req->hospital_name }}</p>
              </div>
            </div>
            <div class="text-right">
              <span class="rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest {{ $statusBadge }}">{{ str_replace('_', ' ', $req->status) }}</span>
              <p class="mt-2 text-xs font-medium text-slate-400">{{ $req->created_at?->diffForHumans() ?? 'Recently placed' }}</p>
            </div>
            <div class="ml-4 rounded-lg bg-slate-100 p-2 opacity-0 transition-opacity group-hover:opacity-100">
              <span class="material-symbols-outlined">chevron_right</span>
            </div>
          </a>
        @empty
          <div class="rounded-xl bg-surface-container-lowest p-8 text-center text-sm text-slate-500">
            No hospital requests created yet.
          </div>
        @endforelse
      </div>

      <a href="{{ route('hospital.requests.create') }}" class="group flex w-full flex-col items-center justify-center rounded-xl border-2 border-dashed border-outline-variant py-8 font-bold text-on-secondary-container transition-colors hover:bg-white/50">
        <span class="material-symbols-outlined mb-2 text-3xl transition-transform group-hover:scale-110">add_circle</span>
        Create New Resource Request
      </a>
    </section>

    <section class="col-span-4 space-y-8">
      <div class="rounded-xl bg-surface-container-lowest p-8 shadow-sm">
        <div class="mb-6 flex items-center justify-between">
          <h4 class="font-headline text-xl font-black">Profile Details</h4>
          <a href="{{ route('hospital.profile.edit') }}" class="flex items-center text-xs font-bold text-primary hover:underline">
            <span class="material-symbols-outlined mr-1 text-sm">edit</span>
            Edit
          </a>
        </div>

        <div class="space-y-6">
          <div class="relative mb-6 h-40 w-full overflow-hidden rounded-xl">
            <img alt="Hospital facade" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDK9ijrq14WGc-8j1Pb0vMv-q4TXHv6bJ7-MJ9kCU9yFZAKOTIsACrWuATWfrjavEQy4YRqESsZH4Wk-Va3LCs1Nf4_hbVd8XZDm5yLQNF2gLuEGiEgM99s4JakzAGhjGwIVwD_iOOeaJH3PMGB_HXEUPDtzA8JnySqIO_8NFf6RCNC7ll0b2mYVgMaIR656d18m2Dp-WzW4q3REYyCnqZHWlXlhiIwW5oY-L5SGcponbVzTQcbMmMPO05yYvUhlbxDU0UeeMiElg"/>
            <div class="absolute bottom-3 left-3 flex space-x-2">
              <span class="rounded bg-white/90 px-2 py-1 text-[10px] font-bold shadow-sm">Main Campus</span>
            </div>
          </div>

          <div class="space-y-4">
            <div>
              <label class="text-[10px] font-black uppercase tracking-wider text-slate-400">Official Name</label>
              <p class="text-sm font-bold text-on-surface">{{ $hospital->hospital_name ?: 'Not provided' }}</p>
            </div>
            <div>
              <label class="text-[10px] font-black uppercase tracking-wider text-slate-400">Primary Contact</label>
              <p class="text-sm font-bold text-on-surface">{{ $user->email }}</p>
            </div>
            <div>
              <label class="text-[10px] font-black uppercase tracking-wider text-slate-400">Location</label>
              <p class="text-sm font-bold text-on-surface">
                {{ $hospital->address ?: 'No address set' }}
                @if($hospital->city || $hospital->state)
                  <span class="block">{{ trim(($hospital->city ?: '').($hospital->city && $hospital->state ? ', ' : '').($hospital->state ?: '')) }}</span>
                @endif
              </p>
            </div>
            <div>
              <label class="text-[10px] font-black uppercase tracking-wider text-slate-400">License Verification</label>
              <div class="mt-1 flex items-center space-x-2">
                <span class="material-symbols-outlined text-sm {{ $hospital->isVerified() ? 'text-tertiary' : ($hospital->verification_status === 'rejected' ? 'text-error' : 'text-amber-600') }}" style="font-variation-settings: 'FILL' 1;">verified</span>
                <span class="text-xs font-bold text-on-surface">
                  {{ ucfirst($hospital->verification_status) }}{{ $hospital->verified_at ? ' • '.$hospital->verified_at->format('Y-m-d') : '' }}
                </span>
              </div>
            </div>
          </div>

          <div class="border-t border-slate-100 pt-6">
            <h5 class="mb-4 text-xs font-black uppercase tracking-widest text-slate-400">Operational Health</h5>
            <div class="space-y-3">
              <div class="flex items-center justify-between text-xs">
                <span class="font-bold">Active Requests</span>
                <div class="h-1.5 w-32 overflow-hidden rounded-full bg-slate-100">
                  <div class="h-full rounded-full bg-tertiary" style="width: {{ min(100, max(10, $stats['active_requests'] * 12)) }}%"></div>
                </div>
                <span class="text-[10px] font-bold text-slate-500">{{ min(100, max(10, $stats['active_requests'] * 12)) }}%</span>
              </div>
              <div class="flex items-center justify-between text-xs">
                <span class="font-bold">Matched Donors</span>
                <div class="h-1.5 w-32 overflow-hidden rounded-full bg-slate-100">
                  <div class="h-full rounded-full {{ $stats['matched_donors'] > 0 ? 'bg-tertiary' : 'bg-error' }}" style="width: {{ $inventoryHealth }}%"></div>
                </div>
                <span class="text-[10px] font-bold {{ $stats['matched_donors'] > 0 ? 'text-slate-500' : 'text-error' }}">{{ $inventoryHealth }}%</span>
              </div>
              <div class="flex items-center justify-between text-xs">
                <span class="font-bold">Profile Integrity</span>
                <div class="h-1.5 w-32 overflow-hidden rounded-full bg-slate-100">
                  <div class="h-full rounded-full bg-slate-400" style="width: {{ $profileCompletion }}%"></div>
                </div>
                <span class="text-[10px] font-bold text-slate-500">{{ $profileCompletion }}%</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="group relative h-48 overflow-hidden rounded-xl bg-surface-container-lowest p-6 shadow-sm">
        <div class="absolute inset-0 grayscale opacity-30 transition-all duration-700 group-hover:opacity-60 group-hover:grayscale-0">
          <img alt="Map location" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCi4QeSpaHvxPJSrQ6mvKoq-K1j6H2ynCEUb1qznH3TMPT6ywHK-zLxASUaAlUR5okWD89-_QHyKd6ZomhYgAhGdDa9bj8C5DvtMQ4-UzAvz5TezGzeAm3Z_VMTrQDZWlt9L--EvEryTIK_s9Dvpmeg9EgPycXWHKX47VHknZcqYYD0ubNJKias0NxNdZUySVfbE9gWHL85llWLrE8BzU5DKjWuvzq2Fmbq2t8hTdrRu6RW-1LWfFVkdpRnmNohmF1lIrG0ONbykw"/>
        </div>
        <div class="relative z-10">
          <h4 class="font-headline text-sm font-black">Logistics View</h4>
          <p class="text-[10px] text-on-secondary-container">{{ $stats['matched_donors'] }} couriers or donor links in motion</p>
        </div>
        <div class="absolute bottom-4 left-6 flex items-center space-x-2">
          <div class="h-2 w-2 animate-pulse rounded-full bg-primary"></div>
          <span class="rounded bg-white/80 px-2 py-1 text-[10px] font-bold uppercase tracking-widest">Live Tracking</span>
        </div>
      </div>
    </section>
  </div>
</main>

<footer class="ml-64 mt-12 border-t border-slate-200/10 bg-slate-50 px-8 py-12">
  <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 md:grid-cols-4">
    <div class="col-span-1">
      <span class="text-lg font-bold text-slate-900">LifeLink Pulse</span>
      <p class="mt-4 text-xs text-slate-500 leading-relaxed">
        Bridging the gap between life-saving resources and hospital care through precision data and real-time logistics.
      </p>
    </div>
    <div>
      <h5 class="mb-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Operations</h5>
      <ul class="space-y-2">
        <li><a class="text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Emergency Protocol</a></li>
        <li><a class="text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Courier Dashboard</a></li>
        <li><a class="text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Hospital Network</a></li>
      </ul>
    </div>
    <div>
      <h5 class="mb-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Support</h5>
      <ul class="space-y-2">
        <li><a class="text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">API Documentation</a></li>
        <li><a class="text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Incident Reporting</a></li>
        <li><a class="text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Contact Support</a></li>
      </ul>
    </div>
    <div>
      <h5 class="mb-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Legal</h5>
      <ul class="space-y-2">
        <li><a class="text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Privacy Policy</a></li>
        <li><a class="text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Terms of Service</a></li>
      </ul>
    </div>
  </div>
  <div class="mx-auto mt-12 flex max-w-7xl flex-col items-center justify-between border-t border-slate-200/10 pt-8 md:flex-row">
    <p class="text-xs text-slate-500">© {{ date('Y') }} LifeLink Vital Pulse. All rights reserved.</p>
    <div class="mt-4 flex space-x-6 md:mt-0">
      <span class="text-[10px] font-bold uppercase text-tertiary">System Status: Operational</span>
      <span class="text-[10px] font-bold uppercase text-slate-400">hospital-workspace</span>
    </div>
  </div>
</footer>
</body>
</html>
