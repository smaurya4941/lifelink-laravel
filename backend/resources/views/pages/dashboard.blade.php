<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>LifeLink | Donor & Recipient Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
      borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
    },
  },
}
</script>
<style>
.material-symbols-outlined {
  font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
}
body { font-family: 'Inter', sans-serif; }
h1, h2, h3, .font-headline { font-family: 'Manrope', sans-serif; }
</style>
</head>
<body class="bg-surface text-on-surface">
@php
    $isDonor = $user->hasCapability('donor');
    $isRecipient = $user->hasCapability('recipient');
    $statusLabel = $stats['critical_requests'] > 0 ? 'Needs Attention' : (($isDonor && $user->status) ? 'Ready' : 'Active');
    $statusTone = $stats['critical_requests'] > 0 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700';
    $heroTitle = $isDonor && $isRecipient ? 'Donor & Recipient Portal' : ($isDonor ? 'Donor Portal' : 'Recipient Portal');
    $heroLine = $isDonor && $isRecipient
        ? 'You can respond to nearby requests and manage your own blood needs from one coordinated workspace.'
        : ($isDonor
            ? 'Stay ready for the next vital match and monitor your response pipeline in real time.'
            : 'Manage your requests, track donor responses, and coordinate urgent care with confidence.');
    $primaryActionRoute = $isRecipient ? route('requests.create') : route('matches.index');
    $primaryActionLabel = $isRecipient ? 'New Request' : 'View Matches';
    $secondaryActionRoute = $isDonor ? route('matches.index') : route('map.index');
    $secondaryActionLabel = $isDonor ? 'Review Matches' : 'Find a Donor';
@endphp

<aside class="fixed left-0 top-0 hidden h-screen w-64 overflow-y-auto bg-slate-50 p-4 md:flex md:flex-col">
  <div class="mb-8 px-2">
    <h1 class="font-headline text-2xl font-black tracking-tighter text-rose-700">LifeLink</h1>
    <p class="text-xs font-medium text-on-secondary-container opacity-70">{{ $heroTitle }}</p>
  </div>

  <nav class="flex-1 space-y-1">
    <a class="flex items-center gap-3 rounded-xl bg-rose-100/50 px-4 py-3 font-bold text-rose-700 transition-transform duration-200 hover:translate-x-1" href="{{ route('dashboard') }}">
      <span class="material-symbols-outlined">dashboard</span>
      <span class="text-sm">Dashboard</span>
    </a>

    @if($isRecipient)
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('requests.index') }}">
        <span class="material-symbols-outlined">bloodtype</span>
        <span class="text-sm">Requests</span>
      </a>
    @endif

    @if($isDonor)
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('matches.index') }}">
        <span class="material-symbols-outlined">swap_horiz</span>
        <span class="text-sm">Matches</span>
      </a>
    @endif

    <a class="flex items-center gap-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('map.index') }}">
      <span class="material-symbols-outlined">map</span>
      <span class="text-sm">Map</span>
    </a>

    <a class="flex items-center gap-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('notifications.index') }}">
      <span class="material-symbols-outlined">notifications</span>
      <span class="text-sm">Notifications</span>
    </a>

    <a class="flex items-center gap-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('profile.edit') }}">
      <span class="material-symbols-outlined">person</span>
      <span class="text-sm">Profile</span>
    </a>

    <a class="flex items-center gap-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('security.dashboard') }}">
      <span class="material-symbols-outlined">settings</span>
      <span class="text-sm">Settings</span>
    </a>
  </nav>

  <div class="mt-auto space-y-1 pt-6">
    <a href="{{ $primaryActionRoute }}" class="mb-4 block w-full rounded-xl bg-gradient-to-br from-primary to-primary-container px-4 py-3 text-center text-sm font-bold text-on-primary shadow-lg shadow-primary/20 transition-transform active:scale-95">
      {{ $primaryActionLabel }}
    </a>

    <a class="flex items-center gap-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('notifications.index') }}">
      <span class="material-symbols-outlined">help</span>
      <span class="text-sm">Help Center</span>
    </a>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="flex w-full items-center gap-3 px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" type="submit">
        <span class="material-symbols-outlined">logout</span>
        <span class="text-sm">Logout</span>
      </button>
    </form>
  </div>
</aside>

<main class="min-h-screen md:ml-64">
  <header class="fixed left-0 right-0 top-0 z-30 bg-white/80 shadow-sm backdrop-blur-xl md:left-64">
    <div class="mx-auto flex items-center justify-between px-6 py-4">
      <div class="flex items-center gap-4">
        <span class="text-2xl font-black tracking-tighter text-rose-700 md:hidden">LifeLink</span>
        <h2 class="hidden text-xl font-bold tracking-tight text-on-surface md:block">Portal Dashboard</h2>
      </div>

      <div class="flex items-center gap-6">
        <div class="hidden items-center gap-2 rounded-full bg-surface-container-low px-4 py-2 sm:flex">
          <span class="material-symbols-outlined text-sm text-on-secondary-container">search</span>
          <input class="w-48 border-none bg-transparent text-sm text-on-surface-variant focus:ring-0" placeholder="Search requests..." type="text"/>
        </div>
        <div class="flex items-center gap-4 text-slate-600">
          <a href="{{ route('notifications.index') }}" class="relative transition-colors hover:text-rose-500">
            <span class="material-symbols-outlined">notifications</span>
            @if($unreadNotifications > 0)
              <span class="absolute -right-1 -top-1 inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-rose-600 px-1 text-[10px] font-bold text-white">{{ min($unreadNotifications, 9) }}</span>
            @endif
          </a>
          <a href="{{ route('notifications.index') }}" class="transition-colors hover:text-rose-500">
            <span class="material-symbols-outlined">mail</span>
          </a>
          <a href="{{ route('profile.edit') }}" class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full border-2 border-primary/10 bg-primary-fixed text-sm font-bold text-primary">
            {{ strtoupper(substr($user->name, 0, 1)) }}
          </a>
        </div>
      </div>
    </div>
  </header>

  <div class="mx-auto max-w-7xl space-y-12 px-6 pb-24 pt-24">
    @if(session('status'))
      <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
        {{ session('status') }}
      </div>
    @endif

    @if(session('error'))
      <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
        {{ session('error') }}
      </div>
    @endif

    <section class="flex flex-col items-center gap-8 rounded-2xl border border-outline-variant/5 bg-surface-container-lowest p-8 shadow-sm lg:flex-row">
      <div class="flex-1 space-y-4">
        <div class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold {{ $statusTone }}">
          {{ implode(' / ', $user->capabilityLabels()) }} Member
        </div>
        <h1 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface">Welcome back, {{ $user->name }}</h1>
        <p class="max-w-xl text-lg text-on-secondary-container">{{ $heroLine }}</p>
        <div class="flex flex-wrap gap-4 pt-2">
          <a href="{{ $primaryActionRoute }}" class="flex items-center gap-2 rounded-xl bg-primary px-6 py-3 font-bold text-on-primary shadow-lg shadow-primary/10 transition-all hover:bg-primary-container active:scale-95">
            <span class="material-symbols-outlined text-lg">{{ $isRecipient ? 'add_circle' : 'swap_horiz' }}</span>
            {{ $primaryActionLabel }}
          </a>
          <a href="{{ $secondaryActionRoute }}" class="flex items-center gap-2 rounded-xl bg-secondary-container px-6 py-3 font-bold text-on-secondary-container transition-all hover:bg-surface-container-high active:scale-95">
            <span class="material-symbols-outlined text-lg">{{ $isDonor ? 'person_search' : 'map' }}</span>
            {{ $secondaryActionLabel }}
          </a>
        </div>
      </div>

      <div class="group relative h-48 w-full overflow-hidden rounded-2xl lg:w-72">
        <img alt="Blood donation" class="h-full w-full object-cover opacity-80 grayscale transition-all duration-500 group-hover:grayscale-0" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCahiG7AaMw1vU1WhtSHCcgT5j1PaGNIHy5OUSAilVWmkY34vmfuiPaDmJspRmIr9cB0Q2pJoBap1PBJ3Uu2VOnRXVr6ZinKDLjxFw8Yd46d7mWO48spCnKlEEwCCruVOV-eiovNjA9kM6f8dS1d5afUfrCKPPHqDzWwS1DwQ0_CspfQwo16R4qdj08P_Lfzia8TolgNDBkn992VIb2RAPXjRSkJkXBQG_aT8nMf1Y5zJmJ9GO9gZhzHsEqqCHX7ovkQXJamQ2uzQ"/>
        <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent"></div>
      </div>
    </section>

    <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
      <div class="space-y-3 rounded-2xl bg-surface-container-low p-6">
        <div class="flex items-start justify-between">
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-rose-600 shadow-sm">
            <span class="material-symbols-outlined">volunteer_activism</span>
          </div>
          <span class="flex items-center gap-1 text-xs font-bold text-tertiary-container">
            <span class="material-symbols-outlined text-sm">trending_up</span>
            {{ $stats['completed_donations'] > 0 ? '+'.max($stats['completed_donations'], 1) : 'New' }}
          </span>
        </div>
        <div>
          <p class="text-sm font-medium text-on-secondary-container">Total Donations</p>
          <h3 class="text-3xl font-black text-on-surface">{{ $stats['total_units_donated'] }} units</h3>
        </div>
        <div class="h-1 w-full overflow-hidden rounded-full bg-slate-200">
          <div class="h-full bg-rose-500" style="width: {{ min(100, max(18, $stats['completed_donations'] * 12)) }}%"></div>
        </div>
      </div>

      <div class="space-y-3 rounded-2xl bg-surface-container-low p-6">
        <div class="flex items-start justify-between">
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-primary shadow-sm">
            <span class="material-symbols-outlined">handshake</span>
          </div>
          <span class="flex items-center gap-1 text-xs font-bold text-tertiary-container">
            <span class="material-symbols-outlined text-sm">verified</span>
            Active
          </span>
        </div>
        <div>
          <p class="text-sm font-medium text-on-secondary-container">Matches Found</p>
          <h3 class="text-3xl font-black text-on-surface">{{ $stats['accepted_matches'] + $stats['completed_matches'] }}</h3>
        </div>
        <p class="text-xs italic text-on-surface-variant">{{ $stats['pending_matches'] }} pending confirmation</p>
      </div>

      <div class="space-y-3 rounded-2xl bg-surface-container-low p-6">
        <div class="flex items-start justify-between">
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-700 shadow-sm">
            <span class="material-symbols-outlined">pulse_alert</span>
          </div>
          <span class="rounded bg-rose-100 px-2 py-0.5 text-[10px] font-bold text-rose-700">{{ $stats['critical_requests'] > 0 ? 'URGENT' : 'LIVE' }}</span>
        </div>
        <div>
          <p class="text-sm font-medium text-on-secondary-container">Current Status</p>
          <h3 class="text-3xl font-black text-on-surface">{{ $statusLabel }}</h3>
        </div>
        <div class="flex gap-1">
          <div class="h-2 w-2 animate-pulse rounded-full {{ $stats['critical_requests'] > 0 ? 'bg-rose-500' : 'bg-tertiary' }}"></div>
          <p class="text-xs text-on-surface-variant">
            @if($stats['critical_requests'] > 0)
              You have high priority requests needing attention.
            @elseif($isDonor)
              Live pulse monitoring active for donor opportunities.
            @else
              Tracking your latest recipient activity in real time.
            @endif
          </p>
        </div>
      </div>
    </section>

    <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-12">
      <section class="space-y-6 lg:col-span-8">
        <div class="flex items-center justify-between">
          <h2 class="text-2xl font-headline font-bold text-on-surface">Recent Activity</h2>
          <a href="{{ $isRecipient ? route('requests.index') : route('matches.index') }}" class="text-sm font-bold text-primary hover:underline">View All History</a>
        </div>

        <div class="space-y-4">
          @forelse($recentActivity as $activity)
            @php
              $iconToneClasses = [
                'rose' => 'bg-rose-50 text-rose-600',
                'blue' => 'bg-blue-50 text-blue-600',
                'slate' => 'bg-slate-100 text-slate-600',
              ];
              $badgeToneClasses = [
                'success' => 'bg-emerald-100 text-emerald-700',
                'critical' => 'bg-rose-100 text-rose-700',
                'info' => 'bg-surface-container-high text-on-secondary-container',
                'neutral' => 'bg-slate-100 text-slate-700',
              ];
            @endphp
            <div class="group rounded-2xl border border-transparent bg-surface-container-lowest p-6 transition-all duration-300 hover:translate-x-1 hover:border-outline-variant/20">
              <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
                <div class="h-14 w-14 shrink-0 rounded-full flex items-center justify-center {{ $iconToneClasses[$activity['icon_tone']] ?? $iconToneClasses['slate'] }}">
                  <span class="material-symbols-outlined text-2xl">{{ $activity['icon'] }}</span>
                </div>
                <div class="flex-1 space-y-1">
                  <div class="flex items-start justify-between gap-4">
                    <h4 class="font-bold text-on-surface">{{ $activity['title'] }}</h4>
                    <span class="text-xs font-medium text-on-surface-variant">{{ $activity['time'] ?? 'Recently' }}</span>
                  </div>
                  <p class="text-sm text-on-secondary-container">{{ $activity['description'] }}</p>
                  <div class="flex flex-wrap items-center gap-2 pt-2">
                    <span class="rounded-full px-2 py-0.5 text-[10px] font-bold {{ $badgeToneClasses[$activity['badge_tone']] ?? $badgeToneClasses['neutral'] }}">
                      {{ $activity['badge'] }}
                    </span>
                    <span class="text-[10px] font-medium text-slate-400">{{ $activity['meta'] }}</span>
                  </div>
                  @if(!empty($activity['actions']))
                    <div class="flex flex-wrap gap-3 pt-3">
                      @foreach($activity['actions'] as $action)
                        <a href="{{ $action['href'] }}" class="{{ $action['tone'] === 'primary' ? 'bg-primary text-on-primary' : 'bg-surface-container-low text-on-surface-variant' }} rounded-lg px-4 py-1.5 text-xs font-bold">
                          {{ $action['label'] }}
                        </a>
                      @endforeach
                    </div>
                  @endif
                </div>
              </div>
            </div>
          @empty
            <div class="rounded-2xl bg-surface-container-lowest p-8 text-sm text-slate-500">
              No dashboard activity yet. Complete your profile and start using requests or matches to see live updates here.
            </div>
          @endforelse
        </div>
      </section>

      <aside class="space-y-8 pt-4 lg:col-span-4">
        <div class="relative overflow-hidden rounded-[2rem] bg-inverse-surface p-8 text-inverse-on-surface shadow-xl">
          <div class="relative z-10 space-y-6">
            <h3 class="text-2xl font-black leading-tight">Your Impact Score</h3>
            <div class="flex items-end gap-2">
              <span class="text-5xl font-black">{{ $impactScore }}</span>
              <span class="mb-2 text-sm font-bold opacity-70">/ 100</span>
            </div>
            <p class="text-sm opacity-80">
              @if($impactScore >= 80)
                You are among the most responsive members in your network. Your actions are creating measurable impact.
              @elseif($impactScore >= 50)
                Your account is building strong momentum. Keep responding quickly to improve your network impact.
              @else
                Complete your profile and start engaging with requests to grow your LifeLink impact score.
              @endif
            </p>
            <a href="{{ route('profile.edit') }}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary-container py-3 font-bold text-on-primary">
              <span class="material-symbols-outlined">share</span>
              Share Journey
            </a>
          </div>
          <div class="absolute -bottom-12 -right-12 h-48 w-48 rounded-full bg-primary/20 blur-3xl"></div>
        </div>

        <div class="space-y-4 rounded-2xl bg-surface-container-low p-6">
          <h4 class="flex items-center gap-2 font-bold text-on-surface">
            <span class="material-symbols-outlined text-rose-600">notification_important</span>
            Priority Queue
          </h4>
          <div class="space-y-3">
            @forelse($priorityItems as $item)
              <a href="{{ $item['href'] }}" class="block rounded-xl border-l-4 bg-white p-3 {{ $item['tone'] === 'critical' ? 'border-rose-500' : 'border-slate-300' }}">
                <p class="text-xs font-bold text-on-surface">{{ $item['title'] }}</p>
                <p class="text-[10px] text-on-surface-variant">{{ $item['subtitle'] }}</p>
              </a>
            @empty
              <div class="rounded-xl bg-white p-3">
                <p class="text-xs font-bold text-on-surface">No urgent items</p>
                <p class="text-[10px] text-on-surface-variant">Your queue is clear for now.</p>
              </div>
            @endforelse
          </div>
        </div>
      </aside>
    </div>
  </div>

  <footer class="mt-12 w-full border-t border-slate-200/10 bg-slate-50 px-6 py-12">
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 md:grid-cols-4">
      <div class="col-span-1 md:col-span-1">
        <h5 class="mb-4 text-lg font-bold text-slate-900">LifeLink</h5>
        <p class="text-xs text-slate-500">Connecting life-saving vital resources through intelligent matching and ethical management since 2024.</p>
      </div>
      <div>
        <h6 class="mb-4 text-xs font-black uppercase tracking-widest text-on-surface-variant">Platform</h6>
        <ul class="space-y-2">
          <li><a class="text-xs text-slate-400 hover:text-rose-500" href="{{ url('/') }}#how-it-works">How it Works</a></li>
          <li><a class="text-xs text-slate-400 hover:text-rose-500" href="{{ url('/') }}#actors">Donor/Recipient</a></li>
          <li><a class="text-xs text-slate-400 hover:text-rose-500" href="{{ route('register.hospital') }}">Hospital Portal</a></li>
        </ul>
      </div>
      <div>
        <h6 class="mb-4 text-xs font-black uppercase tracking-widest text-on-surface-variant">Legal</h6>
        <ul class="space-y-2">
          <li><a class="text-xs text-slate-400 hover:text-rose-500" href="#">Privacy Policy</a></li>
          <li><a class="text-xs text-slate-400 hover:text-rose-500" href="#">Terms of Service</a></li>
        </ul>
      </div>
      <div>
        <h6 class="mb-4 text-xs font-black uppercase tracking-widest text-on-surface-variant">Connect</h6>
        <ul class="space-y-2">
          <li><a class="text-xs text-slate-400 hover:text-rose-500" href="#">Contact Support</a></li>
          <li><a class="text-xs text-slate-400 hover:text-rose-500" href="#">Global Directory</a></li>
        </ul>
      </div>
    </div>
    <div class="mx-auto mt-12 max-w-7xl border-t border-slate-200/20 pt-8">
      <p class="text-xs text-slate-500">© {{ date('Y') }} LifeLink Vital Pulse. All rights reserved.</p>
    </div>
  </footer>
</main>

<nav class="fixed bottom-0 left-0 right-0 z-50 flex items-center justify-between border-t border-slate-100 bg-white px-6 py-3 md:hidden">
  <a class="flex flex-col items-center text-rose-600" href="{{ route('dashboard') }}">
    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
    <span class="text-[10px] font-bold">Home</span>
  </a>
  @if($isRecipient)
    <a class="flex flex-col items-center text-slate-400" href="{{ route('requests.index') }}">
      <span class="material-symbols-outlined">bloodtype</span>
      <span class="text-[10px] font-medium">Reqs</span>
    </a>
  @else
    <a class="flex flex-col items-center text-slate-400" href="{{ route('map.index') }}">
      <span class="material-symbols-outlined">map</span>
      <span class="text-[10px] font-medium">Map</span>
    </a>
  @endif
  <a class="-mt-10 flex h-12 w-12 items-center justify-center rounded-full border-4 border-white bg-primary text-white shadow-lg" href="{{ $primaryActionRoute }}">
    <span class="material-symbols-outlined">add</span>
  </a>
  @if($isDonor)
    <a class="flex flex-col items-center text-slate-400" href="{{ route('matches.index') }}">
      <span class="material-symbols-outlined">swap_horiz</span>
      <span class="text-[10px] font-medium">Match</span>
    </a>
  @else
    <a class="flex flex-col items-center text-slate-400" href="{{ route('notifications.index') }}">
      <span class="material-symbols-outlined">notifications</span>
      <span class="text-[10px] font-medium">Alerts</span>
    </a>
  @endif
  <a class="flex flex-col items-center text-slate-400" href="{{ route('profile.edit') }}">
    <span class="material-symbols-outlined">settings</span>
    <span class="text-[10px] font-medium">Config</span>
  </a>
</nav>
</body>
</html>
