<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>LifeLink - Matches Portal</title>
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
  display: inline-block;
  vertical-align: middle;
}
body { font-family: 'Inter', sans-serif; }
h1, h2, h3 { font-family: 'Manrope', sans-serif; }
</style>
</head>
<body class="bg-surface-container-low text-on-surface antialiased">
@php
  $statusBadges = [
      'pending' => 'bg-primary-fixed text-on-primary-fixed-variant',
      'accepted' => 'bg-tertiary-container/10 text-tertiary',
      'completed' => 'bg-emerald-100 text-emerald-700',
      'rejected' => 'bg-slate-200 text-slate-500',
  ];
  $bestPending = $matches->where('status', 'pending')->sortByDesc('match_score')->first();
@endphp

<aside class="fixed left-0 top-0 z-50 hidden h-screen w-64 overflow-y-auto bg-slate-50 p-4 md:flex md:flex-col md:space-y-2">
  <div class="mb-8 px-2">
    <h1 class="font-headline text-2xl font-black tracking-tighter text-rose-700">LifeLink Portal</h1>
    <p class="mt-1 text-xs font-medium uppercase tracking-widest text-slate-500">Premium Vital Management</p>
  </div>
  <nav class="flex-1 space-y-1">
    <a class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('dashboard') }}">
      <span class="material-symbols-outlined">dashboard</span>
      <span>Dashboard</span>
    </a>
    @if($user->hasCapability('recipient'))
      <a class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('requests.index') }}">
        <span class="material-symbols-outlined">bloodtype</span>
        <span>Requests</span>
      </a>
    @endif
    <a class="flex items-center gap-3 rounded-xl bg-slate-900/5 px-4 py-3 text-sm font-bold text-rose-700 transition-transform duration-200 hover:translate-x-1" href="{{ route('matches.index') }}">
      <span class="material-symbols-outlined">swap_horiz</span>
      <span>Matches</span>
    </a>
    <a class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('map.index') }}">
      <span class="material-symbols-outlined">inventory_2</span>
      <span>Map</span>
    </a>
    <a class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('notifications.index') }}">
      <span class="material-symbols-outlined">analytics</span>
      <span>Notifications</span>
    </a>
    <a class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('security.dashboard') }}">
      <span class="material-symbols-outlined">settings</span>
      <span>Settings</span>
    </a>
  </nav>
  <div class="space-y-1 border-t border-slate-200 pt-4">
    <a href="{{ $user->hasCapability('recipient') ? route('requests.create') : route('matches.index') }}" class="mb-4 flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 font-bold text-on-primary transition-all hover:opacity-90 active:scale-95">
      <span class="material-symbols-outlined">emergency</span>
      Emergency Request
    </a>
    <a class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('notifications.index') }}">
      <span class="material-symbols-outlined">help</span>
      <span>Help Center</span>
    </a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="flex w-full items-center gap-3 px-4 py-2 text-sm font-medium text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" type="submit">
        <span class="material-symbols-outlined">logout</span>
        <span>Logout</span>
      </button>
    </form>
  </div>
</aside>

<main class="min-h-screen p-8 lg:p-12 md:ml-64">
  <header class="mb-12 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
    <div>
      <nav class="mb-3 flex gap-2 text-xs font-bold uppercase tracking-widest text-primary">
        <span>Portal</span>
        <span class="text-slate-300">/</span>
        <span class="text-slate-500">Matches Optimization</span>
      </nav>
      <h2 class="text-4xl font-black tracking-tight text-on-surface md:text-5xl">Vital Matches</h2>
      <p class="mt-4 max-w-xl text-lg font-medium leading-relaxed text-on-secondary-container">
        AI-driven cross-matching for blood distribution. Review incoming compatibility alerts and keep your donor response pipeline moving.
      </p>
    </div>
    <div class="flex gap-4">
      <div class="flex items-center gap-4 rounded-xl border border-outline-variant/10 bg-surface-container-lowest p-6 shadow-sm">
        <div class="rounded-full bg-primary-fixed p-3 text-on-primary-fixed-variant">
          <span class="material-symbols-outlined">bolt</span>
        </div>
        <div>
          <p class="text-xs font-bold uppercase tracking-tighter text-slate-500">Match Accuracy</p>
          <p class="text-2xl font-black text-on-surface">{{ $stats['avg_score'] > 0 ? $stats['avg_score'].'%' : 'N/A' }}</p>
        </div>
      </div>
    </div>
  </header>

  @if(session('status'))
    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
      {{ session('status') }}
    </div>
  @endif

  @if(session('error'))
    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
      {{ session('error') }}
    </div>
  @endif

  <div class="grid grid-cols-12 gap-8">
    <section class="col-span-12 space-y-6 lg:col-span-7">
      <div class="mb-2 flex items-center justify-between">
        <h3 class="flex items-center gap-2 text-xl font-bold">
          <span class="material-symbols-outlined text-rose-600">input</span>
          Incoming Donor Matches
        </h3>
        <span class="rounded-full bg-primary-fixed px-3 py-1 text-xs font-bold text-on-primary-fixed-variant">{{ $stats['pending'] }} Pending</span>
      </div>

      @forelse($matches as $match)
        @php
          $request = $match->bloodRequest;
          $badgeClasses = $statusBadges[$match->status] ?? 'bg-slate-200 text-slate-600';
        @endphp
        <div class="relative overflow-hidden rounded-xl {{ $match->status === 'pending' ? 'bg-surface-container-lowest p-1' : 'border border-dashed border-outline-variant/30 bg-surface-container-low p-6 '.($match->status === 'rejected' ? 'opacity-60' : '') }}">
          @if($match->status === 'pending')
            <div class="absolute right-0 top-0 p-4">
              <div class="flex items-center gap-1 rounded-full bg-tertiary-container/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-tertiary">
                <span class="h-1.5 w-1.5 rounded-full bg-tertiary"></span>
                {{ $match->match_score >= 80 ? 'High Compatibility' : 'Potential Match' }}
              </div>
            </div>
          @endif

          <div class="{{ $match->status === 'pending' ? 'p-6' : '' }}">
            <div class="flex gap-6">
              <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-primary-fixed text-2xl font-black text-on-primary-fixed-variant">
                {{ strtoupper(substr($request?->hospital_name ?? 'LL', 0, 1)) }}
              </div>
              <div class="flex-1">
                <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between">
                  <div>
                    <h4 class="text-xl font-bold text-on-surface">{{ $request?->hospital_name ?? 'Unknown Request' }}</h4>
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Match #{{ $match->id }}</p>
                  </div>
                  <span class="rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest {{ $badgeClasses }}">
                    {{ ucfirst($match->status) }}
                  </span>
                </div>

                <div class="mt-3 grid grid-cols-1 gap-y-2 md:grid-cols-2">
                  <div class="flex items-center gap-2 text-sm text-on-secondary-container">
                    <span class="material-symbols-outlined text-xs">bloodtype</span>
                    <span class="font-bold">{{ $request?->blood_group ?? 'N/A' }}</span>
                  </div>
                  <div class="flex items-center gap-2 text-sm text-on-secondary-container">
                    <span class="material-symbols-outlined text-xs">location_on</span>
                    <span>{{ number_format((float) $match->distance_km, 1) }} km away</span>
                  </div>
                  <div class="flex items-center gap-2 text-sm text-on-secondary-container">
                    <span class="material-symbols-outlined text-xs">warning</span>
                    <span>Urgency: {{ ucfirst($request?->urgency_level ?? 'medium') }}</span>
                  </div>
                  <div class="flex items-center gap-2 text-sm text-on-secondary-container">
                    <span class="material-symbols-outlined text-xs">verified</span>
                    <span class="font-medium text-tertiary">Score {{ $match->match_score }}</span>
                  </div>
                </div>
              </div>
            </div>

            @if($match->status === 'pending')
              <div class="mt-8 flex items-center gap-3">
                <form class="flex-1" method="POST" action="{{ route('matches.accept', $match) }}">
                  @csrf
                  <button class="flex w-full items-center justify-center gap-2 rounded-lg bg-slate-900 py-3 font-bold text-on-primary shadow-md transition-all hover:opacity-90 active:scale-95" type="submit">
                    <span class="material-symbols-outlined">check_circle</span>
                    Accept Match
                  </button>
                </form>
                <form class="flex-1" method="POST" action="{{ route('matches.reject', $match) }}">
                  @csrf
                  <button class="flex w-full items-center justify-center gap-2 rounded-lg bg-secondary-container py-3 font-bold text-on-secondary-container transition-all hover:bg-surface-container-high active:scale-95" type="submit">
                    <span class="material-symbols-outlined">cancel</span>
                    Decline
                  </button>
                </form>
              </div>
            @elseif($match->status === 'accepted')
              <div class="mt-6 flex items-center gap-3">
                <span class="flex-1 rounded-lg bg-slate-900 py-3 text-center font-bold text-on-primary">Accepted Match</span>
                <a href="{{ $request ? route('requests.show', $request) : route('matches.index') }}" class="rounded-lg bg-secondary-container px-4 py-3 text-on-secondary-container">
                  <span class="material-symbols-outlined">more_vert</span>
                </a>
              </div>
            @else
              @if($match->status === 'completed' && $request?->confirmation_notes)
                <div class="mt-4 rounded-lg border border-blue-200 bg-blue-50 p-3 text-xs text-blue-900">
                  Reason / note: {{ $request->confirmation_notes }}
                </div>
              @elseif($match->status === 'rejected')
                <div class="mt-4 rounded-lg border border-slate-100 bg-white/50 p-3 text-xs text-slate-400">
                  Status locked. This request has already been resolved from your side.
                </div>
              @endif
            @endif
          </div>
        </div>
      @empty
        <div class="rounded-xl bg-surface-container-lowest p-8 text-sm text-slate-500 shadow-sm">
          No donor matches yet. We will show compatible requests here as soon as the engine finds them.
        </div>
      @endforelse
    </section>

    <aside class="col-span-12 space-y-6 lg:col-span-5">
      <div class="sticky top-8 rounded-3xl bg-surface-container-highest/30 p-8">
        <h3 class="mb-6 flex items-center gap-2 text-xl font-bold">
          <span class="material-symbols-outlined text-primary">output</span>
          Outbound Fulfillment
        </h3>
        <div class="space-y-4">
          @forelse($requestMatches->take(2) as $match)
            <div class="rounded-2xl bg-surface-container-lowest p-5 shadow-sm transition-transform hover:-translate-y-[2px]">
              <div class="mb-4 flex items-start justify-between">
                <div>
                  <span class="mb-2 inline-block rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-tighter {{ ($match->bloodRequest?->urgency_level === 'critical' || $match->bloodRequest?->urgency_level === 'high') ? 'bg-error-container text-error' : 'bg-tertiary-container/10 text-tertiary' }}">
                    {{ ($match->bloodRequest?->urgency_level === 'critical' || $match->bloodRequest?->urgency_level === 'high') ? 'Urgent' : 'Scheduled' }}
                  </span>
                  <h5 class="font-bold text-on-surface">{{ $match->bloodRequest?->hospital_name ?? 'Recipient Request' }}</h5>
                </div>
                <p class="text-[10px] font-black text-on-secondary-fixed-variant">#REQ-{{ $match->bloodRequest?->id }}</p>
              </div>
              <div class="mb-6 flex items-center justify-between text-sm">
                <div class="flex flex-col">
                  <span class="text-xs font-medium text-slate-400">Needed</span>
                  <span class="font-black text-rose-700">{{ $match->bloodRequest?->units_required ?? 0 }} Units {{ $match->bloodRequest?->blood_group ?? 'N/A' }}</span>
                </div>
                <div class="h-8 w-px bg-slate-100"></div>
                <div class="flex flex-col text-right">
                  <span class="text-xs font-medium text-slate-400">Status</span>
                  <span class="font-bold">{{ ucfirst($match->status) }}</span>
                </div>
              </div>
              <div class="flex gap-2">
                @if($match->bloodRequest)
                  <a href="{{ route('requests.show', $match->bloodRequest) }}" class="flex-1 rounded-xl bg-on-surface py-3 text-center text-sm font-bold text-surface transition-colors hover:bg-slate-800">
                    Review
                  </a>
                @endif
                <span class="flex-1 rounded-xl border border-outline-variant/30 py-3 text-center text-sm font-bold text-slate-500">Score {{ $match->match_score }}</span>
              </div>
            </div>
          @empty
            <div class="rounded-2xl bg-surface-container-lowest p-5 text-sm text-slate-500 shadow-sm">
              No recipient-side match summaries yet.
            </div>
          @endforelse

          <div class="mt-6 border-t border-slate-200/50 pt-6">
            <div class="mb-2 flex items-center justify-between">
              <span class="text-sm font-medium text-slate-500">Weekly Goal</span>
              <span class="text-sm font-black text-on-surface">{{ min(100, max(10, ($stats['completed'] + $stats['accepted']) * 10)) }}%</span>
            </div>
            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-200">
              <div class="h-full bg-primary" style="width: {{ min(100, max(10, ($stats['completed'] + $stats['accepted']) * 10)) }}%"></div>
            </div>
            <p class="mt-4 text-center text-[10px] font-medium text-slate-400">
              You are {{ max(0, 12 - ($stats['completed'] + $stats['accepted'])) }} matches away from your monthly vital impact target.
            </p>
          </div>
        </div>
      </div>
    </aside>
  </div>

  <section class="mt-16">
    <h3 class="mb-8 text-2xl font-black text-on-surface">Matching Ecosystem</h3>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
      <div class="flex h-64 flex-col justify-between rounded-3xl border border-slate-50 bg-white p-8 shadow-sm md:col-span-2">
        <div class="flex items-start justify-between">
          <div class="rounded-2xl bg-rose-50 p-4 text-rose-600">
            <span class="material-symbols-outlined">groups</span>
          </div>
          <span class="text-xs font-black text-tertiary">+12.5% vs LW</span>
        </div>
        <div>
          <p class="text-4xl font-black tracking-tighter text-on-surface">{{ $stats['pending'] + $stats['accepted'] + $stats['completed'] }}</p>
          <p class="mt-1 text-xs font-bold uppercase tracking-widest text-slate-400">Total Active Match Records</p>
        </div>
      </div>
      <div class="flex h-64 flex-col justify-between rounded-3xl bg-on-surface p-8 text-surface">
        <span class="material-symbols-outlined text-3xl opacity-50">speed</span>
        <div>
          <p class="text-3xl font-black tracking-tighter">{{ $stats['avg_score'] > 0 ? $stats['avg_score'] : '0' }}</p>
          <p class="mt-1 text-xs font-bold uppercase tracking-widest text-slate-400">Avg Match Score</p>
        </div>
      </div>
      <div class="flex h-64 flex-col justify-between rounded-3xl border border-outline-variant/10 bg-surface-container p-8">
        <span class="material-symbols-outlined text-3xl text-primary">emergency_share</span>
        <div>
          <p class="text-3xl font-black tracking-tighter text-on-surface">{{ $stats['pending'] }}</p>
          <p class="mt-1 text-xs font-bold uppercase tracking-widest text-slate-500">Critical Alerts</p>
        </div>
      </div>
    </div>
  </section>
</main>

<footer class="w-[calc(100%-16rem)] border-t border-slate-200/10 bg-slate-50 px-12 py-12 md:ml-64">
  <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 md:grid-cols-4">
    <div class="space-y-4">
      <div class="text-lg font-bold text-slate-900">LifeLink Vital Pulse</div>
      <p class="text-xs text-slate-500">Leading the world in precision medical logistics and life-saving donor connectivity through high-performance technology.</p>
    </div>
    <div class="space-y-3">
      <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Resources</p>
      <a class="block text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Privacy Policy</a>
      <a class="block text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Terms of Service</a>
    </div>
    <div class="space-y-3">
      <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Support</p>
      <a class="block text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Contact Support</a>
      <a class="block text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Global Directory</a>
    </div>
    <div class="flex items-end justify-end">
      <p class="text-xs text-slate-500 opacity-60">Â© {{ date('Y') }} LifeLink Vital Pulse. All rights reserved.</p>
    </div>
  </div>
</footer>
</body>
</html>


