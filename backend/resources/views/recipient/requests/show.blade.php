<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>LifeLink | Request Matches</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&display=swap" rel="stylesheet"/>
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
  vertical-align: middle;
}
.bg-gradient-primary {
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}
body { font-family: 'Inter', sans-serif; }
h1, h2, h3 { font-family: 'Manrope', sans-serif; }
</style>
</head>
<body class="bg-surface text-on-surface">
@php
  $urgencyMap = [
      'critical' => 'bg-error text-on-primary',
      'high' => 'bg-rose-200 text-rose-800',
      'medium' => 'bg-slate-200 text-slate-700',
      'low' => 'bg-slate-100 text-slate-600',
  ];
  $statusMap = [
      'pending' => ['label' => 'Pending', 'dot' => 'bg-orange-500'],
      'matched' => ['label' => 'Matched', 'dot' => 'bg-blue-500'],
      'confirmed' => ['label' => 'Confirmed', 'dot' => 'bg-indigo-500'],
      'in_progress' => ['label' => 'In Progress', 'dot' => 'bg-violet-500'],
      'completed' => ['label' => 'Completed', 'dot' => 'bg-tertiary'],
      'cancelled' => ['label' => 'Cancelled', 'dot' => 'bg-slate-400'],
  ];
  $requestStatus = $statusMap[$bloodRequest->status] ?? ['label' => ucfirst($bloodRequest->status), 'dot' => 'bg-slate-400'];
  $acceptedCount = $matches->where('status', 'accepted')->count();
  $completedCount = $matches->where('status', 'completed')->count();
  $bestMatch = $matches->sortByDesc('match_score')->first();
@endphp

<aside class="fixed left-0 top-0 hidden h-screen w-64 overflow-y-auto bg-slate-50 p-4 md:flex md:flex-col md:space-y-2">
  <div class="mb-8 px-2">
    <h1 class="font-headline text-2xl font-black text-rose-700">LifeLink Portal</h1>
    <p class="text-xs font-medium text-on-secondary-container">Premium Vital Management</p>
  </div>
  <nav class="flex-1 space-y-1">
    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 hover:bg-slate-100" href="{{ route('dashboard') }}">
      <span class="material-symbols-outlined">dashboard</span>
      <span>Dashboard</span>
    </a>
    <a class="flex items-center gap-3 rounded-xl bg-slate-900/5 px-4 py-3 font-bold text-rose-700" href="{{ route('requests.index') }}">
      <span class="material-symbols-outlined">bloodtype</span>
      <span>Requests</span>
    </a>
    @if(auth()->user()->hasCapability('donor'))
      <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 hover:bg-slate-100" href="{{ route('matches.index') }}">
        <span class="material-symbols-outlined">swap_horiz</span>
        <span>Matches</span>
      </a>
    @endif
    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 hover:bg-slate-100" href="{{ route('map.index') }}">
      <span class="material-symbols-outlined">map</span>
      <span>Map</span>
    </a>
    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 hover:bg-slate-100" href="{{ route('notifications.index') }}">
      <span class="material-symbols-outlined">notifications</span>
      <span>Notifications</span>
    </a>
    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 hover:bg-slate-100" href="{{ route('profile.edit') }}">
      <span class="material-symbols-outlined">person</span>
      <span>Profile</span>
    </a>
  </nav>
  <div class="mt-auto space-y-1 pt-6">
    <a href="{{ route('requests.index') }}#new-request" class="mb-4 block w-full rounded-xl bg-gradient-primary px-4 py-3 text-center text-sm font-bold text-on-primary shadow-sm transition-transform active:scale-95">
      Emergency Request
    </a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 hover:bg-slate-100" type="submit">
        <span class="material-symbols-outlined">logout</span>
        <span>Logout</span>
      </button>
    </form>
  </div>
</aside>

<main class="min-h-screen bg-surface-container-low p-8 md:ml-64">
  <header class="mb-10 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
    <div class="space-y-1">
      <span class="text-sm font-bold uppercase tracking-widest text-primary">Request Tracking</span>
      <h2 class="text-4xl font-black tracking-tight text-on-surface">Request Matches</h2>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('requests.index') }}" class="rounded-xl bg-surface-container-lowest px-4 py-3 text-sm font-bold text-on-surface-variant ring-1 ring-outline-variant/15 transition-all hover:bg-surface-container-high">
        Back to Requests
      </a>
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
    <section class="col-span-12 space-y-8 xl:col-span-8">
      <div class="overflow-hidden rounded-2xl bg-surface-container-lowest shadow-sm ring-1 ring-outline-variant/5">
        <div class="relative bg-gradient-primary p-8 text-on-primary">
          <div class="relative z-10">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
              <div class="flex items-center gap-3">
                <span class="rounded-full bg-white/20 px-3 py-1 text-[10px] font-black uppercase tracking-widest backdrop-blur-md">Active Request</span>
                <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-bold">
                  <span class="h-2 w-2 rounded-full {{ $requestStatus['dot'] }}"></span>
                  {{ $requestStatus['label'] }}
                </span>
              </div>
              <span class="rounded-lg bg-white/15 px-3 py-1.5 text-sm font-bold">{{ $bloodRequest->blood_group }}</span>
            </div>
            <h3 class="text-3xl font-black">{{ $bloodRequest->patient_name ?: ($bloodRequest->contact_person ?: 'Unnamed Patient') }}</h3>
            <p class="mt-2 text-sm text-rose-100 opacity-90">REQ-{{ str_pad((string) $bloodRequest->id, 4, '0', STR_PAD_LEFT) }} â€¢ {{ $bloodRequest->hospital_name }}</p>
          </div>
          <div class="absolute -bottom-6 -right-6 opacity-10">
            <span class="material-symbols-outlined text-[120px]">bloodtype</span>
          </div>
        </div>

        <div class="grid grid-cols-1 gap-6 p-8 md:grid-cols-3">
          <div class="rounded-xl bg-surface-container-low p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-on-secondary-container">Urgency</p>
            <div class="mt-3">
              <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] font-bold uppercase {{ $urgencyMap[$bloodRequest->urgency_level] ?? 'bg-slate-200 text-slate-700' }}">
                {{ ucfirst($bloodRequest->urgency_level) }}
              </span>
            </div>
          </div>
          <div class="rounded-xl bg-surface-container-low p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-on-secondary-container">Location</p>
            <p class="mt-3 text-sm font-semibold text-on-surface">{{ $bloodRequest->city ?: 'Unknown City' }}{{ $bloodRequest->state ? ', '.$bloodRequest->state : '' }}</p>
          </div>
          <div class="rounded-xl bg-surface-container-low p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-on-secondary-container">Required Date</p>
            <p class="mt-3 text-sm font-semibold text-on-surface">{{ $bloodRequest->required_date ? \Illuminate\Support\Carbon::parse($bloodRequest->required_date)->format('d M Y') : 'Not specified' }}</p>
          </div>
        </div>

        <div class="border-t border-surface-container px-8 py-6">
          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
              <p class="text-xs font-bold uppercase tracking-widest text-on-secondary-container">Hospital Address</p>
              <p class="mt-2 text-sm text-on-surface">{{ $bloodRequest->hospital_address ?: 'No address provided' }}</p>
            </div>
            <div>
              <p class="text-xs font-bold uppercase tracking-widest text-on-secondary-container">Contact</p>
              <p class="mt-2 text-sm text-on-surface">{{ $bloodRequest->contact_person ?: 'No contact person' }}{{ $bloodRequest->contact_phone ? ' â€¢ '.$bloodRequest->contact_phone : '' }}</p>
            </div>
            @if($bloodRequest->notes || $bloodRequest->description)
              <div class="md:col-span-2">
                <p class="text-xs font-bold uppercase tracking-widest text-on-secondary-container">Clinical Notes</p>
                <p class="mt-2 text-sm text-on-surface">{{ $bloodRequest->notes ?: $bloodRequest->description }}</p>
              </div>
            @endif
          </div>
        </div>
      </div>

      @if($bloodRequest->status === 'confirmed')
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-6">
          <h4 class="text-lg font-bold text-emerald-800">Donor Confirmed</h4>
          <p class="mt-2 text-sm text-emerald-700">Confirmed Donor ID: {{ $bloodRequest->confirmed_donor_id ?? 'N/A' }}</p>
          @if($bloodRequest->confirmation_date)
            <p class="mt-1 text-sm text-emerald-700">Confirmed At: {{ \Illuminate\Support\Carbon::parse($bloodRequest->confirmation_date)->format('d M Y, h:i A') }}</p>
          @endif
          @if($bloodRequest->confirmation_notes)
            <p class="mt-2 text-sm text-emerald-800"><span class="font-semibold">Your Note:</span> {{ $bloodRequest->confirmation_notes }}</p>
          @endif
        </div>
      @endif

      <div class="rounded-2xl bg-surface-container-lowest p-8 shadow-sm ring-1 ring-outline-variant/5">
        <div class="mb-6 flex items-center justify-between">
          <div>
            <h4 class="text-2xl font-bold text-on-surface">Potential Matches</h4>
            <p class="mt-1 text-sm text-on-secondary-container">Review donor responses and confirm the best available match.</p>
          </div>
          <div class="rounded-xl bg-surface-container-low px-4 py-2 text-sm font-bold text-on-surface-variant">
            {{ $matches->count() }} Total
          </div>
        </div>

        <div class="space-y-4">
          @forelse($matches as $match)
            @php
              $matchStatus = $statusMap[$match->status] ?? ['label' => ucfirst($match->status), 'dot' => 'bg-slate-400'];
              $donorInitial = strtoupper(substr($match->donor?->name ?? 'D', 0, 1));
            @endphp
            <div class="rounded-2xl border border-outline-variant/10 bg-surface-container-low p-5">
              <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div class="flex items-start gap-4">
                  <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-fixed font-bold text-on-primary-fixed-variant">{{ $donorInitial }}</div>
                  <div class="space-y-1">
                    <p class="text-lg font-bold text-on-surface">{{ $match->donor?->name ?? 'Unknown Donor' }}</p>
                    <p class="text-sm text-on-secondary-container">City: {{ $match->donor?->city ?? 'N/A' }}</p>
                    <div class="flex flex-wrap gap-2 pt-1">
                      <span class="rounded-full bg-white px-3 py-1 text-xs font-bold text-on-surface">Score: {{ $match->match_score }}</span>
                      <span class="rounded-full bg-white px-3 py-1 text-xs font-bold text-on-surface">Distance: {{ number_format((float) $match->distance_km, 1) }} km</span>
                    </div>
                  </div>
                </div>
                <div class="flex items-center gap-2">
                  <span class="h-2 w-2 rounded-full {{ $matchStatus['dot'] }}"></span>
                  <span class="text-sm font-semibold text-on-surface">{{ $matchStatus['label'] }}</span>
                </div>
              </div>

              @if($match->notes)
                <div class="mt-4 rounded-xl bg-white px-4 py-3 text-sm text-on-surface-variant">
                  {{ $match->notes }}
                </div>
              @endif

              @if($match->status === 'accepted')
                <form method="POST" action="{{ route('requests.confirm', $bloodRequest) }}" class="mt-4 space-y-3">
                  @csrf
                  <input type="hidden" name="match_id" value="{{ $match->id }}">
                  <div class="flex flex-col gap-3 md:flex-row">
                    <input type="text" name="confirmation_notes" class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm ring-1 ring-outline-variant/15 focus:ring-2 focus:ring-primary" placeholder="Confirmation notes for the donor">
                    <button class="rounded-xl bg-gradient-primary px-5 py-3 text-sm font-bold text-on-primary shadow-sm" type="submit">
                      Confirm Donor
                    </button>
                  </div>
                </form>
              @endif
            </div>
          @empty
            <div class="rounded-2xl bg-surface-container-low p-6 text-sm text-slate-500">
              No matches found yet. The matching engine is still searching for compatible donors.
            </div>
          @endforelse
        </div>
      </div>
    </section>

    <aside class="col-span-12 space-y-8 xl:col-span-4">
      <div class="relative overflow-hidden rounded-[2rem] bg-inverse-surface p-8 text-inverse-on-surface shadow-xl">
        <div class="relative z-10 space-y-6">
          <h3 class="text-2xl font-black leading-tight">Request Confidence</h3>
          <div class="flex items-end gap-2">
            <span class="text-5xl font-black">{{ $bestMatch ? min(99, max(18, (int) $bestMatch->match_score)) : 18 }}</span>
            <span class="mb-2 text-sm font-bold opacity-70">/ 100</span>
          </div>
          <p class="text-sm opacity-80">
            @if($bestMatch)
              Your best current donor alignment has a match score of {{ $bestMatch->match_score }} with {{ number_format((float) $bestMatch->distance_km, 1) }} km proximity.
            @else
              Matching has started, but no compatible donors have been surfaced for this request yet.
            @endif
          </p>
          <a href="{{ route('requests.index') }}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary-container py-3 font-bold text-on-primary">
            <span class="material-symbols-outlined">list_alt</span>
            View All Requests
          </a>
        </div>
        <div class="absolute -bottom-12 -right-12 h-48 w-48 rounded-full bg-primary/20 blur-3xl"></div>
      </div>

      <div class="rounded-2xl bg-surface-container-low p-6">
        <h4 class="flex items-center gap-2 font-bold text-on-surface">
          <span class="material-symbols-outlined text-rose-600">monitor_heart</span>
          Match Snapshot
        </h4>
        <div class="mt-5 grid grid-cols-2 gap-4">
          <div class="rounded-xl bg-white p-4">
            <p class="text-xs font-bold uppercase tracking-widest text-on-secondary-container">Accepted</p>
            <p class="mt-2 text-3xl font-black text-on-surface">{{ $acceptedCount }}</p>
          </div>
          <div class="rounded-xl bg-white p-4">
            <p class="text-xs font-bold uppercase tracking-widest text-on-secondary-container">Completed</p>
            <p class="mt-2 text-3xl font-black text-on-surface">{{ $completedCount }}</p>
          </div>
        </div>
      </div>

      <div class="rounded-2xl bg-surface-container-lowest p-4 ring-1 ring-outline-variant/10">
        <div class="relative h-56 overflow-hidden rounded-xl bg-surface-container">
          <img class="h-full w-full object-cover opacity-50 grayscale transition-all duration-700 hover:grayscale-0" alt="Map insight" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCX41f8tIkVcp6jdmzyB-Fg0Brz7ilCCbPV-I0763Qbsk5GT1yyz2H9k-RP69ci8HnmaLmJKmaAZF78vW_9nwYtIdVNQ1ycD1BOwnhd487-QEr4Od-2dI3PQB3e0CZr4CL0F0BUC6uLJrWK43SMLKLrp5YupnT-QcFd-Cxll7DOszHjSmjBH0l4UycGkLhNvYibso8fJ5nMzNDgCSAyY2TCZtAu2eCg8cs0SO3eO32B5NNSNIYGoUsCsU-dy4Z0pGMrb__Jvbi3JA"/>
          <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest/80 to-transparent"></div>
          <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between">
            <p class="text-xs font-bold text-on-surface">Live Donor Radius</p>
            <span class="h-2 w-2 animate-pulse rounded-full bg-error"></span>
          </div>
        </div>
      </div>
    </aside>
  </div>
</main>
</body>
</html>



