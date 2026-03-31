<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>LifeLink | Requests Management</title>
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
  background: linear-gradient(135deg, #b80035 0%, #e11d48 100%);
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
  $statusDotMap = [
      'pending' => 'bg-orange-500',
      'matched' => 'bg-blue-500',
      'confirmed' => 'bg-indigo-500',
      'in_progress' => 'bg-violet-500',
      'completed' => 'bg-tertiary',
      'cancelled' => 'bg-slate-400',
  ];
  $statusLabelMap = [
      'pending' => 'Pending',
      'matched' => 'Matched',
      'confirmed' => 'Confirmed',
      'in_progress' => 'In Progress',
      'completed' => 'Completed',
      'cancelled' => 'Cancelled',
  ];
  $bloodGroups = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
@endphp

<aside class="fixed left-0 top-0 hidden h-screen w-64 overflow-y-auto bg-slate-50 p-4 md:flex md:flex-col md:space-y-2">
  <div class="mb-8 px-2">
    <h1 class="font-headline text-2xl font-black text-rose-700">LifeLink Portal</h1>
    <p class="text-xs font-medium text-on-secondary-container">Premium Vital Management</p>
  </div>
  <nav class="flex-1 space-y-1">
    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('dashboard') }}">
      <span class="material-symbols-outlined">dashboard</span>
      <span>Dashboard</span>
    </a>
    <a class="flex items-center gap-3 rounded-xl bg-rose-100/50 px-4 py-3 font-bold text-rose-700 transition-transform duration-200 hover:translate-x-1" href="{{ route('requests.index') }}">
      <span class="material-symbols-outlined">bloodtype</span>
      <span>Requests</span>
    </a>
    @if(auth()->user()->hasCapability('donor'))
      <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('matches.index') }}">
        <span class="material-symbols-outlined">swap_horiz</span>
        <span>Matches</span>
      </a>
    @endif
    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('map.index') }}">
      <span class="material-symbols-outlined">inventory_2</span>
      <span>Map</span>
    </a>
    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('notifications.index') }}">
      <span class="material-symbols-outlined">analytics</span>
      <span>Notifications</span>
    </a>
    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('security.dashboard') }}">
      <span class="material-symbols-outlined">settings</span>
      <span>Settings</span>
    </a>
  </nav>
  <div class="mt-auto space-y-1 pt-6">
    <a href="#new-request" class="mb-4 block w-full rounded-xl bg-gradient-primary px-4 py-3 text-center text-sm font-bold text-on-primary shadow-lg shadow-primary/20 transition-transform active:scale-95">
      Emergency Request
    </a>
    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 hover:bg-slate-100" href="{{ route('notifications.index') }}">
      <span class="material-symbols-outlined">help</span>
      <span>Help Center</span>
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
  <header class="mb-12 flex items-end justify-between">
    <div class="space-y-1">
      <span class="text-sm font-bold uppercase tracking-widest text-primary">Management</span>
      <h2 class="text-4xl font-black tracking-tight text-on-surface">Active Requests</h2>
    </div>
    <div class="flex gap-4">
      <div class="flex items-center gap-2 rounded-xl bg-surface-container-lowest px-4 py-2 text-sm text-on-surface-variant ring-1 ring-outline-variant/15">
        <span class="material-symbols-outlined text-sm">filter_list</span>
        <span>Filter: All Statuses</span>
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
    <section class="col-span-12 space-y-6 xl:col-span-8">
      <div class="rounded-xl bg-surface-container-lowest p-6 shadow-sm ring-1 ring-outline-variant/5">
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead>
              <tr class="border-b border-surface-container text-xs font-bold uppercase tracking-wider text-on-secondary-container">
                <th class="px-4 pb-4">Patient Name</th>
                <th class="px-4 pb-4 text-center">Type</th>
                <th class="px-4 pb-4">Hospital</th>
                <th class="px-4 pb-4">Urgency</th>
                <th class="px-4 pb-4">Status</th>
                <th class="px-4 pb-4"></th>
              </tr>
            </thead>
            <tbody class="divide-y divide-surface-container">
              @forelse($requests as $req)
                @php
                  $initials = strtoupper(substr(($req->patient_name ?: $req->contact_person ?: 'LL'), 0, 2));
                  $isActive = $activeRequest && $activeRequest->id === $req->id;
                @endphp
                <tr class="group transition-colors hover:bg-surface-container-low/50 {{ $isActive ? 'bg-surface-container-low/60' : '' }}">
                  <td class="px-4 py-5">
                    <div class="flex items-center gap-3">
                      <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-fixed font-bold text-on-primary-fixed-variant">{{ $initials }}</div>
                      <div>
                        <p class="font-semibold text-on-surface">{{ $req->patient_name ?: ($req->contact_person ?: 'Unnamed Patient') }}</p>
                        <p class="text-xs text-on-secondary-container">REQ-{{ str_pad((string) $req->id, 4, '0', STR_PAD_LEFT) }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-5 text-center">
                    <span class="rounded-lg bg-primary px-3 py-1 text-sm font-black text-on-primary">{{ $req->blood_group }}</span>
                  </td>
                  <td class="px-4 py-5 text-sm font-medium text-on-surface-variant">{{ $req->hospital_name }}</td>
                  <td class="px-4 py-5">
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] font-bold uppercase {{ $urgencyMap[$req->urgency_level] ?? 'bg-slate-200 text-slate-700' }}">
                      {{ ucfirst($req->urgency_level) }}
                    </span>
                  </td>
                  <td class="px-4 py-5">
                    <div class="flex items-center gap-2">
                      <span class="h-2 w-2 rounded-full {{ $statusDotMap[$req->status] ?? 'bg-slate-400' }}"></span>
                      <span class="text-sm font-medium text-on-surface">{{ $statusLabelMap[$req->status] ?? ucfirst($req->status) }}</span>
                    </div>
                  </td>
                  <td class="px-4 py-5 text-right">
                    <a href="{{ route('requests.index', ['request' => $req->id]) }}" class="rounded-lg p-2 text-primary transition-colors hover:bg-primary-fixed">
                      <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="px-4 py-8 text-sm text-slate-500" colspan="6">No blood requests yet. Use the form below to initialize your first dispatch request.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div id="new-request" class="rounded-xl border border-white bg-surface-container p-8">
        <div class="mb-8 flex items-center gap-4">
          <div class="bg-primary p-3 text-on-primary rounded-xl">
            <span class="material-symbols-outlined">post_add</span>
          </div>
          <div>
            <h3 class="text-xl font-bold text-on-surface">New Vital Request</h3>
            <p class="text-sm text-on-secondary-container">Register a patient requiring immediate assistance.</p>
          </div>
        </div>

        <form method="POST" action="{{ route('requests.store') }}" class="grid grid-cols-1 gap-6 md:grid-cols-2">
          @csrf

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Patient Full Name</label>
            <input name="patient_name" value="{{ old('patient_name') }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" placeholder="e.g. Sarah Jenkins" type="text"/>
            @error('patient_name')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Blood Type Required</label>
            <select name="blood_group" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary">
              @foreach($bloodGroups as $group)
                <option value="{{ $group }}" @selected(old('blood_group', $profile->blood_group ?? null) === $group)>{{ $group }}</option>
              @endforeach
            </select>
            @error('blood_group')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Medical Facility</label>
            <input name="hospital_name" value="{{ old('hospital_name') }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" placeholder="Select Hospital" type="text" required/>
            @error('hospital_name')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Units Required</label>
            <input name="units_required" value="{{ old('units_required', 1) }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" min="1" max="10" type="number" required/>
            @error('units_required')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Hospital Address</label>
            <input name="hospital_address" value="{{ old('hospital_address') }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" placeholder="Street, area, landmark" type="text"/>
            @error('hospital_address')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Urgency Level</label>
            <div class="flex gap-2">
              @foreach(['critical' => 'Critical', 'high' => 'High', 'medium' => 'Normal'] as $value => $label)
                <label class="flex-1">
                  <input class="peer hidden" name="urgency_level" type="radio" value="{{ $value }}" @checked(old('urgency_level', 'high') === $value)/>
                  <div class="cursor-pointer rounded-xl py-3 text-center text-sm font-bold transition-all ring-1 ring-outline-variant/15
                    {{ $value === 'critical' ? 'peer-checked:bg-error peer-checked:text-on-primary peer-checked:ring-error' : '' }}
                    {{ $value === 'high' ? 'peer-checked:bg-rose-500 peer-checked:text-on-primary peer-checked:ring-rose-500' : '' }}
                    {{ $value === 'medium' ? 'peer-checked:bg-slate-500 peer-checked:text-on-primary peer-checked:ring-slate-500' : '' }}">
                    {{ $label }}
                  </div>
                </label>
              @endforeach
            </div>
            @error('urgency_level')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">City</label>
            <input name="city" value="{{ old('city', $profile->city ?? null) }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" placeholder="e.g. Lucknow" type="text" required/>
            @error('city')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Required Date</label>
            <input name="required_date" value="{{ old('required_date') }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" type="date"/>
            @error('required_date')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">State</label>
            <input name="state" value="{{ old('state', $profile->state ?? null) }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" placeholder="State" type="text"/>
            @error('state')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Pincode</label>
            <input name="pincode" value="{{ old('pincode') }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" placeholder="Postal code" type="text"/>
            @error('pincode')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Contact Person</label>
            <input name="contact_person" value="{{ old('contact_person', $profile->emergency_contact ?? null) }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" placeholder="Primary contact" type="text"/>
            @error('contact_person')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Contact Phone</label>
            <input name="contact_phone" value="{{ old('contact_phone') }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" placeholder="Phone number" type="text"/>
            @error('contact_phone')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Latitude</label>
            <input name="latitude" value="{{ old('latitude') }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" placeholder="Optional latitude" type="text"/>
            @error('latitude')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Longitude</label>
            <input name="longitude" value="{{ old('longitude') }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" placeholder="Optional longitude" type="text"/>
            @error('longitude')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Search Radius (km)</label>
            <input name="radius_km" value="{{ old('radius_km', 10) }}" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" min="1" max="200" type="number"/>
            @error('radius_km')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2 md:col-span-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Notes</label>
            <textarea name="notes" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" rows="3" placeholder="Clinical notes or recipient instructions">{{ old('notes') }}</textarea>
            @error('notes')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2 md:col-span-2">
            <label class="px-1 text-xs font-bold uppercase text-on-secondary-container">Description</label>
            <textarea name="description" class="w-full rounded-xl border-0 bg-surface-container-lowest px-4 py-3 ring-1 ring-outline-variant/15 transition-all focus:ring-2 focus:ring-primary" rows="3" placeholder="Additional dispatch context">{{ old('description') }}</textarea>
            @error('description')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="pt-4 md:col-span-2">
            <button class="w-full rounded-xl bg-gradient-primary py-4 font-bold tracking-tight text-on-primary shadow-lg shadow-primary/20 transition-all hover:opacity-90" type="submit">
              Initialize Dispatch Request
            </button>
          </div>
        </form>
      </div>
    </section>

    <aside class="col-span-12 space-y-8 xl:col-span-4">
      <div class="overflow-hidden rounded-xl bg-surface-container-lowest shadow-xl shadow-on-surface/5">
        <div class="relative bg-gradient-primary p-6 text-on-primary">
          <div class="relative z-10">
            <div class="mb-6 flex items-start justify-between">
              <span class="rounded-full bg-white/20 px-3 py-1 text-[10px] font-black uppercase tracking-widest backdrop-blur-md">Active Focus</span>
              <span class="material-symbols-outlined">open_in_full</span>
            </div>
            @if($activeRequest)
              <h3 class="mb-1 text-2xl font-black">{{ $activeRequest->patient_name ?: ($activeRequest->contact_person ?: 'Unnamed Patient') }}</h3>
              <p class="text-sm text-rose-100 opacity-80">Patient ID: REQ-{{ str_pad((string) $activeRequest->id, 4, '0', STR_PAD_LEFT) }}</p>
            @else
              <h3 class="mb-1 text-2xl font-black">No Active Request</h3>
              <p class="text-sm text-rose-100 opacity-80">Create your first request to activate the panel.</p>
            @endif
          </div>
          <div class="absolute -bottom-4 -right-4 opacity-10">
            <span class="material-symbols-outlined text-9xl">bloodtype</span>
          </div>
        </div>

        <div class="space-y-6 p-6">
          @if($activeRequest)
            <div class="flex items-center justify-between text-sm">
              <span class="font-medium text-on-secondary-container">Matching Progress</span>
              <span class="font-bold text-primary">{{ $activeMatches->count() }}/5 Potential Donors</span>
            </div>
            <div class="h-2 w-full rounded-full bg-surface-container">
              <div class="h-2 rounded-full bg-primary" style="width: {{ min(100, $activeMatches->count() * 20) }}%"></div>
            </div>

            <div class="space-y-4 pt-4">
              <h4 class="text-xs font-bold uppercase tracking-widest text-on-secondary-container">Potential Matches</h4>
              @forelse($activeMatches as $match)
                <div class="flex items-center justify-between rounded-xl bg-surface-container-low p-4 ring-1 ring-outline-variant/5">
                  <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-fixed font-bold text-on-primary-fixed-variant">
                      {{ strtoupper(substr($match->donor?->name ?? 'D', 0, 1)) }}
                    </div>
                    <div>
                      <p class="text-sm font-bold text-on-surface">{{ $match->donor?->name ?? 'Unknown Donor' }}</p>
                      <p class="text-[11px] font-bold text-tertiary">{{ $match->status === 'accepted' ? 'Accepted Match' : 'Verified Donor' }}</p>
                    </div>
                  </div>
                  <div class="text-right">
                    <p class="text-xs font-bold text-on-surface">{{ number_format((float) $match->distance_km, 1) }}km</p>
                    <p class="text-[10px] text-on-secondary-container">Away</p>
                  </div>
                </div>
              @empty
                <div class="rounded-xl bg-surface-container-low p-4 text-sm text-slate-500">
                  Matches will appear here once the request is processed by the matching engine.
                </div>
              @endforelse
            </div>

            <div class="grid grid-cols-2 gap-3 text-sm">
              <div class="rounded-xl bg-surface-container-low p-4">
                <p class="text-xs font-bold uppercase text-on-secondary-container">Blood Group</p>
                <p class="mt-2 text-2xl font-black text-on-surface">{{ $activeRequest->blood_group }}</p>
              </div>
              <div class="rounded-xl bg-surface-container-low p-4">
                <p class="text-xs font-bold uppercase text-on-secondary-container">Status</p>
                <p class="mt-2 text-xl font-black text-on-surface">{{ $statusLabelMap[$activeRequest->status] ?? ucfirst($activeRequest->status) }}</p>
              </div>
            </div>

            <div class="flex gap-3">
              <a href="{{ route('requests.show', $activeRequest) }}" class="flex-1 rounded-xl bg-secondary-container py-4 text-center text-sm font-bold text-on-secondary-fixed-variant transition-all hover:bg-surface-container-high">
                Open Full Request
              </a>
            </div>
          @else
            <p class="text-sm text-slate-500">Your request detail panel will populate as soon as you create a blood request.</p>
          @endif
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="rounded-xl bg-surface-container-lowest p-5 ring-1 ring-outline-variant/10">
          <p class="mb-2 text-xs font-bold uppercase text-on-secondary-container">Total Today</p>
          <p class="text-3xl font-black text-on-surface">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-xl border-l-4 border-error bg-surface-container-lowest p-5 ring-1 ring-outline-variant/10">
          <p class="mb-2 text-xs font-bold uppercase text-on-secondary-container">Critical</p>
          <p class="text-3xl font-black text-error">{{ $stats['critical'] }}</p>
        </div>
      </div>

      <div class="rounded-xl bg-surface-container-lowest p-4 ring-1 ring-outline-variant/10">
        <div class="relative h-48 overflow-hidden rounded-lg bg-surface-container">
          <img class="h-full w-full object-cover opacity-50 grayscale transition-all duration-700 hover:grayscale-0" alt="Map insight" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCX41f8tIkVcp6jdmzyB-Fg0Brz7ilCCbPV-I0763Qbsk5GT1yyz2H9k-RP69ci8HnmaLmJKmaAZF78vW_9nwYtIdVNQ1ycD1BOwnhd487-QEr4Od-2dI3PQB3e0CZr4CL0F0BUC6uLJrWK43SMLKLrp5YupnT-QcFd-Cxll7DOszHjSmjBH0l4UycGkLhNvYibso8fJ5nMzNDgCSAyY2TCZtAu2eCg8cs0SO3eO32B5NNSNIYGoUsCsU-dy4Z0pGMrb__Jvbi3JA"/>
          <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest/80 to-transparent"></div>
          <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between">
            <p class="text-xs font-bold text-on-surface">Live Network Map</p>
            <span class="h-2 w-2 animate-pulse rounded-full bg-error"></span>
          </div>
        </div>
      </div>
    </aside>
  </div>
</main>

<footer class="ml-64 w-auto border-t border-slate-200/10 bg-slate-50 px-6 py-12">
  <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 md:grid-cols-4">
    <div class="col-span-1 md:col-span-1">
      <h4 class="mb-4 text-lg font-bold text-slate-900">LifeLink</h4>
      <p class="text-xs text-slate-500">
        © {{ date('Y') }} LifeLink Vital Pulse. All rights reserved.
      </p>
    </div>
    <div class="space-y-4">
      <p class="text-xs font-black uppercase tracking-widest text-on-surface-variant">Legal</p>
      <ul class="space-y-2">
        <li><a class="text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Privacy Policy</a></li>
        <li><a class="text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Terms of Service</a></li>
      </ul>
    </div>
    <div class="space-y-4">
      <p class="text-xs font-black uppercase tracking-widest text-on-surface-variant">Support</p>
      <ul class="space-y-2">
        <li><a class="text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Contact Support</a></li>
        <li><a class="text-xs text-slate-400 transition-colors hover:text-rose-500" href="#">Global Directory</a></li>
      </ul>
    </div>
    <div class="space-y-4">
      <p class="text-xs font-black uppercase tracking-widest text-on-surface-variant">Connect</p>
      <div class="flex gap-4">
        <div class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-slate-200 opacity-80 transition-all hover:opacity-100">
          <span class="material-symbols-outlined text-sm">share</span>
        </div>
        <div class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-slate-200 opacity-80 transition-all hover:opacity-100">
          <span class="material-symbols-outlined text-sm">language</span>
        </div>
      </div>
    </div>
  </div>
</footer>
</body>
</html>
