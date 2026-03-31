<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>LifeLink | Live Network Map</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css"/>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        primary: "#b80035",
        "primary-container": "#e11d48",
        surface: "#f8f9ff",
        "surface-low": "#eff4ff",
        "surface-card": "#ffffff",
        "surface-high": "#e5eeff",
        tertiary: "#00845a",
      },
      fontFamily: {
        headline: ["Manrope", "sans-serif"],
        body: ["Inter", "sans-serif"],
      },
    }
  }
}
</script>
<style>
body { font-family: Inter, sans-serif; }
.font-headline { font-family: Manrope, sans-serif; }
.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
#lifelink-map, .leaflet-container { height: 100%; width: 100%; border-radius: 1rem; }
.ll-pin { width: 18px; height: 18px; border-radius: 9999px; border: 3px solid #fff; box-shadow: 0 0 0 2px rgba(15,23,42,.15); }
.ll-pin-donor { background: #00845a; }
.ll-pin-recipient { background: #b80035; }
.ll-pin-hospital { background: #2563eb; }
.ll-user-dot { width: 18px; height: 18px; border-radius: 9999px; background: #0b1c30; border: 3px solid #fff; box-shadow: 0 0 0 8px rgba(184,0,53,.18); }
.marker-cluster-small, .marker-cluster-medium, .marker-cluster-large { background: rgba(184,0,53,.16); }
.marker-cluster-small div, .marker-cluster-medium div, .marker-cluster-large div { background: linear-gradient(135deg, #b80035 0%, #e11d48 100%); color: #fff; font-family: Manrope, sans-serif; font-weight: 800; }
.ll-popup-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: .75rem; padding: .6rem .9rem; font-size: 12px; font-weight: 700; text-decoration: none; }
</style>
</head>
<body class="bg-surface text-slate-900">
@php
  $mapUser = auth()->user();
  $isDonor = $mapUser->hasCapability('donor');
  $isRecipient = $mapUser->hasCapability('recipient');
@endphp

<header class="fixed top-0 z-50 flex w-full items-center justify-between bg-white/80 px-6 py-3 shadow-sm backdrop-blur-xl">
  <div class="font-headline text-2xl font-extrabold tracking-tight text-rose-700">LifeLink</div>
  <div class="flex items-center gap-4">
    <a href="{{ route('notifications.index') }}" class="rounded-full p-2 text-slate-600 hover:bg-rose-50"><span class="material-symbols-outlined">notifications</span></a>
    <a href="{{ route('security.dashboard') }}" class="rounded-full p-2 text-slate-600 hover:bg-rose-50"><span class="material-symbols-outlined">help_outline</span></a>
    <a href="{{ route('profile.edit') }}" class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-rose-100 bg-rose-100 text-sm font-bold text-rose-700">{{ strtoupper(substr($mapUser->name, 0, 1)) }}</a>
  </div>
</header>

<aside class="fixed left-0 top-0 flex h-screen w-64 flex-col bg-slate-50 px-4 pb-6 pt-20">
  <div class="mb-8 px-2">
    <h2 class="font-headline text-lg font-extrabold">The Vital Pulse</h2>
    <p class="text-xs text-slate-500">Blood Management Portal</p>
  </div>
  <nav class="flex-1 space-y-1 text-sm font-medium text-slate-500">
    <a class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-slate-100" href="{{ route('dashboard') }}"><span class="material-symbols-outlined">dashboard</span>Dashboard</a>
    <a class="flex items-center gap-3 rounded-xl bg-white px-4 py-3 font-bold text-rose-700 shadow-sm" href="{{ route('map.index') }}"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">map</span>Live Map</a>
    @if($isDonor)
      <a class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-slate-100" href="{{ route('matches.index') }}"><span class="material-symbols-outlined">opacity</span>Donations</a>
    @endif
    @if($isRecipient)
      <a class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-slate-100" href="{{ route('requests.index') }}"><span class="material-symbols-outlined">volunteer_activism</span>Requests</a>
    @endif
    <a class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-slate-100" href="{{ route('profile.edit') }}"><span class="material-symbols-outlined">person</span>Profile</a>
    <a class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-slate-100" href="{{ route('security.dashboard') }}"><span class="material-symbols-outlined">settings</span>Settings</a>
  </nav>
  <div class="space-y-2 border-t border-slate-200 pt-4">
    <a href="{{ $isRecipient ? route('requests.create') : route('dashboard') }}" class="flex items-center justify-center gap-2 rounded-xl bg-gradient-to-br from-primary to-primary-container px-4 py-3 text-sm font-bold text-white shadow-lg shadow-rose-200"><span class="material-symbols-outlined text-sm">emergency</span>Request Emergency</a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 hover:bg-slate-100" type="submit"><span class="material-symbols-outlined">logout</span>Sign Out</button>
    </form>
  </div>
</aside>

<main class="ml-64 px-8 pb-16 pt-24">
  <section class="mb-8 grid gap-6 xl:grid-cols-12">
    <div class="rounded-[1.5rem] bg-surface-card p-8 shadow-sm xl:col-span-8">
      <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-rose-100 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.2em] text-rose-700">
        <span class="material-symbols-outlined text-sm">radar</span>
        Live Coordination
      </div>
      <h1 class="font-headline text-4xl font-extrabold tracking-tight">Network Map</h1>
      <p class="mt-3 max-w-2xl text-base font-medium leading-relaxed text-slate-600">Leaflet-powered live map for donors, recipients, and hospitals. Use popup actions to inspect markers, open your request, and draw route lines from your location to donors or hospitals.</p>
      <div class="mt-6 flex flex-wrap gap-3">
        <button id="locate-me-btn" class="rounded-xl bg-primary px-5 py-3 font-bold text-white" type="button">Center On Me</button>
        <button id="refresh-map-btn" class="rounded-xl bg-surface-high px-5 py-3 font-bold text-slate-700" type="button">Refresh Live Data</button>
        <button id="reset-view-btn" class="rounded-xl border border-slate-200 bg-white px-5 py-3 font-bold text-slate-600" type="button">Reset View</button>
      </div>
    </div>

    <div class="rounded-[1.5rem] bg-slate-900 p-8 text-white shadow-xl xl:col-span-4">
      <div class="flex items-center justify-between">
        <h2 class="font-headline text-2xl font-black">Pulse Status</h2>
        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-[11px] font-bold uppercase tracking-widest"><span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>Live</span>
      </div>
      <div class="mt-8 space-y-5">
        <div>
          <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Markers In View</p>
          <p id="stat-total" class="mt-1 text-5xl font-black">0</p>
        </div>
        <div class="grid grid-cols-3 gap-3 text-center">
          <div class="rounded-2xl bg-white/5 p-4"><p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Donors</p><p id="stat-donor" class="mt-2 text-2xl font-black text-emerald-300">0</p></div>
          <div class="rounded-2xl bg-white/5 p-4"><p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Recipients</p><p id="stat-recipient" class="mt-2 text-2xl font-black text-rose-200">0</p></div>
          <div class="rounded-2xl bg-white/5 p-4"><p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Hospitals</p><p id="stat-hospital" class="mt-2 text-2xl font-black text-blue-200">0</p></div>
        </div>
        <div class="rounded-2xl bg-white/5 p-4">
          <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Last Sync</p>
          <p id="last-sync" class="mt-2 text-sm font-semibold">Waiting for first refresh...</p>
        </div>
      </div>
    </div>
  </section>

  <section class="grid gap-8 xl:grid-cols-12">
    <div class="space-y-8 xl:col-span-8">
      <div class="rounded-[1.5rem] bg-surface-card p-5 shadow-sm">
        <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
          <div>
            <h3 class="font-headline text-xl font-bold">Viewport Filters</h3>
            <p class="text-sm text-slate-600">Choose which live entities appear and whether to limit donors to available only.</p>
          </div>
          <div class="inline-flex items-center gap-2 rounded-full bg-surface-low px-4 py-2 text-xs font-semibold text-slate-600">
            <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
            <span id="map-status">Map idle</span>
          </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
          <label class="flex items-center justify-between rounded-2xl bg-surface-low px-4 py-3"><span class="font-semibold text-sm">Donors</span><input id="filter-donor" class="h-5 w-5 rounded text-primary" type="checkbox" checked></label>
          <label class="flex items-center justify-between rounded-2xl bg-surface-low px-4 py-3"><span class="font-semibold text-sm">Recipients</span><input id="filter-recipient" class="h-5 w-5 rounded text-primary" type="checkbox" checked></label>
          <label class="flex items-center justify-between rounded-2xl bg-surface-low px-4 py-3"><span class="font-semibold text-sm">Hospitals</span><input id="filter-hospital" class="h-5 w-5 rounded text-primary" type="checkbox" checked></label>
          <label class="flex items-center justify-between rounded-2xl bg-surface-low px-4 py-3"><span class="font-semibold text-sm">Available Donors Only</span><input id="filter-available-only" class="h-5 w-5 rounded text-primary" type="checkbox" checked></label>
        </div>
      </div>

      <div class="rounded-[1.75rem] bg-surface-card p-4 shadow-sm">
        <div class="relative h-[680px] overflow-hidden rounded-[1.25rem] border border-slate-200">
          <div id="lifelink-map"></div>
          <div id="map-overlay" class="pointer-events-none absolute inset-0 hidden items-center justify-center bg-white/70 backdrop-blur-sm">
            <div class="rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-lg">Refreshing live network data...</div>
          </div>
        </div>
      </div>
    </div>

    <aside class="space-y-8 xl:col-span-4">
      <div class="rounded-[1.5rem] bg-surface-card p-6 shadow-sm">
        <div class="mb-5 flex items-center gap-3">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-surface-high text-slate-700"><span class="material-symbols-outlined">person_search</span></div>
          <div>
            <h3 class="font-headline text-xl font-bold">Selected Entity</h3>
            <p class="text-sm text-slate-600">Popup actions update this panel.</p>
          </div>
        </div>
        <div id="selected-entity" class="rounded-2xl bg-surface-low px-4 py-4 text-sm text-slate-500">Select a donor, recipient, or hospital marker to see details here.</div>
      </div>

      <div class="rounded-[1.5rem] bg-surface-high p-6">
        <div class="mb-5 flex items-center gap-3">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-100 text-rose-700"><span class="material-symbols-outlined">hub</span></div>
          <div>
            <h3 class="font-headline text-xl font-bold">Live Feed</h3>
            <p class="text-sm text-slate-600">Closest entities in the current viewport.</p>
          </div>
        </div>
        <div id="live-feed" class="space-y-3">
          <div class="rounded-2xl bg-white/80 px-4 py-3 text-sm text-slate-500">Refresh the map to load nearby donors, recipients, and hospitals.</div>
        </div>
      </div>

      <div class="rounded-[1.5rem] bg-surface-card p-6 shadow-sm">
        <div class="mb-5 flex items-center gap-3">
          <span class="material-symbols-outlined text-primary">my_location</span>
          <h3 class="font-headline text-xl font-bold">Geo Snapshot</h3>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div class="rounded-2xl bg-surface-low p-4 text-center"><p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Latitude</p><p id="user-latitude" class="mt-2 text-sm font-mono font-bold">{{ $mapUser->latitude ?? 'Not set' }}</p></div>
          <div class="rounded-2xl bg-surface-low p-4 text-center"><p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Longitude</p><p id="user-longitude" class="mt-2 text-sm font-mono font-bold">{{ $mapUser->longitude ?? 'Not set' }}</p></div>
        </div>
      </div>
    </aside>
  </section>
</main>

<footer class="ml-64 px-12 py-8 text-xs text-slate-500">
  © {{ date('Y') }} LifeLink Health. All rights reserved.
</footer>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const defaultCenter = [20.5937, 78.9629];
  const map = L.map('lifelink-map', { zoomControl: true, minZoom: 3 }).setView(defaultCenter, 5);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap contributors' }).addTo(map);

  const elements = {
    donor: document.getElementById('filter-donor'),
    recipient: document.getElementById('filter-recipient'),
    hospital: document.getElementById('filter-hospital'),
    availableOnly: document.getElementById('filter-available-only'),
    refreshBtn: document.getElementById('refresh-map-btn'),
    resetBtn: document.getElementById('reset-view-btn'),
    locateBtn: document.getElementById('locate-me-btn'),
    overlay: document.getElementById('map-overlay'),
    status: document.getElementById('map-status'),
    statTotal: document.getElementById('stat-total'),
    statDonor: document.getElementById('stat-donor'),
    statRecipient: document.getElementById('stat-recipient'),
    statHospital: document.getElementById('stat-hospital'),
    lastSync: document.getElementById('last-sync'),
    feed: document.getElementById('live-feed'),
    selected: document.getElementById('selected-entity'),
    userLatitude: document.getElementById('user-latitude'),
    userLongitude: document.getElementById('user-longitude'),
  };

  const clusters = L.markerClusterGroup({ showCoverageOnHover: false, spiderfyOnMaxZoom: true, maxClusterRadius: 42, disableClusteringAtZoom: 13 });
  map.addLayer(clusters);

  let userMarker = null;
  let routeLine = null;
  let currentOrigin = null;
  let refreshTimer = null;
  let markerIndex = new Map();

  const typeLabels = { donor: 'Donor', recipient: 'Recipient', hospital: 'Hospital' };
  const typeTone = {
    donor: { dot: 'll-pin-donor', badge: 'background:#eefff3;color:#005236;', border: '#00845a' },
    recipient: { dot: 'll-pin-recipient', badge: 'background:#ffdada;color:#920028;', border: '#b80035' },
    hospital: { dot: 'll-pin-hospital', badge: 'background:#dbeafe;color:#1d4ed8;', border: '#2563eb' },
  };

  const escapeHtml = (value) => String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\"/g, '&quot;').replace(/'/g, '&#039;');
  const iconFor = (type) => L.divIcon({ className: '', html: `<div class="ll-pin ${typeTone[type].dot}"></div>`, iconSize: [18, 18], iconAnchor: [9, 9], popupAnchor: [0, -12] });
  const userIcon = L.divIcon({ className: '', html: '<div class="ll-user-dot"></div>', iconSize: [18, 18], iconAnchor: [9, 9], popupAnchor: [0, -12] });

  const setLoading = (loading) => {
    elements.overlay.classList.toggle('hidden', !loading);
    elements.overlay.classList.toggle('flex', loading);
    elements.refreshBtn.disabled = loading;
  };

  const selectedTypes = () => {
    const types = [];
    if (elements.donor.checked) types.push('donor');
    if (elements.recipient.checked) types.push('recipient');
    if (elements.hospital.checked) types.push('hospital');
    return types;
  };

  const buildUrl = () => {
    const bounds = map.getBounds();
    return `{{ route('map.markers') }}?${new URLSearchParams({
      types: selectedTypes().join(','),
      available_only: elements.availableOnly.checked ? '1' : '0',
      north: String(bounds.getNorth()),
      south: String(bounds.getSouth()),
      east: String(bounds.getEast()),
      west: String(bounds.getWest()),
    }).toString()}`;
  };

  const updateStats = (counts) => {
    elements.statTotal.textContent = String(counts.total || 0);
    elements.statDonor.textContent = String(counts.donor || 0);
    elements.statRecipient.textContent = String(counts.recipient || 0);
    elements.statHospital.textContent = String(counts.hospital || 0);
  };

  const setOrigin = (lat, lng, label = 'Your location') => {
    currentOrigin = [lat, lng];
    if (userMarker) map.removeLayer(userMarker);
    userMarker = L.marker([lat, lng], { icon: userIcon }).addTo(map);
    userMarker.bindPopup(label);
    elements.userLatitude.textContent = Number(lat).toFixed(5);
    elements.userLongitude.textContent = Number(lng).toFixed(5);
  };

  const clearRoute = () => {
    if (routeLine) {
      map.removeLayer(routeLine);
      routeLine = null;
    }
  };

  const drawRouteTo = (marker) => {
    if (!currentOrigin) {
      elements.status.textContent = 'Center on your location first to draw a route.';
      return;
    }
    if (!(marker.type === 'donor' || marker.type === 'hospital')) {
      elements.status.textContent = 'Routes are available for donor and hospital markers.';
      return;
    }
    clearRoute();
    routeLine = L.polyline([currentOrigin, [Number(marker.lat), Number(marker.lng)]], {
      color: marker.type === 'donor' ? '#00845a' : '#2563eb',
      weight: 4,
      opacity: 0.85,
      dashArray: '10 8',
    }).addTo(map);
    map.fitBounds(routeLine.getBounds().pad(0.2), { maxZoom: 12 });
    elements.status.textContent = `Route highlighted to ${marker.name}.`;
  };

  const renderSelectedEntity = (marker) => {
    const label = typeLabels[marker.type] || 'Entity';
    const tone = typeTone[marker.type] || typeTone.hospital;
    const routeButton = (marker.type === 'donor' || marker.type === 'hospital')
      ? `<button class="rounded-xl bg-slate-900 px-4 py-2 text-xs font-bold text-white" data-map-action="route" data-marker-id="${marker.id}" data-marker-type="${marker.type}" type="button">Show Route</button>`
      : '';
    const requestButton = marker.request_url
      ? `<a class="rounded-xl bg-primary px-4 py-2 text-xs font-bold text-white" href="${escapeHtml(marker.request_url)}">Open Request</a>`
      : '';

    elements.selected.innerHTML = `
      <div class="space-y-4">
        <div class="flex items-start justify-between gap-3">
          <div>
            <div class="inline-flex rounded-full px-2 py-1 text-[10px] font-black uppercase tracking-widest" style="${tone.badge}">${escapeHtml(label)}</div>
            <h4 class="mt-2 text-lg font-bold text-slate-900">${escapeHtml(marker.name || 'Unknown')}</h4>
          </div>
          ${marker.blood_group ? `<span class="rounded-xl bg-surface-low px-3 py-2 text-sm font-black text-slate-900">${escapeHtml(marker.blood_group)}</span>` : ''}
        </div>
        <div class="space-y-1 text-sm text-slate-600">
          ${marker.city ? `<p>${escapeHtml(marker.city)}${marker.state ? `, ${escapeHtml(marker.state)}` : ''}</p>` : ''}
          ${marker.address ? `<p>${escapeHtml(marker.address)}</p>` : ''}
          ${marker.medical_condition ? `<p>Condition: ${escapeHtml(marker.medical_condition)}</p>` : ''}
          ${marker.last_donation_date ? `<p>Last Donation: ${escapeHtml(marker.last_donation_date)}</p>` : ''}
          <p>${Number(marker.lat).toFixed(5)}, ${Number(marker.lng).toFixed(5)}</p>
        </div>
        <div class="flex flex-wrap gap-2">
          <button class="rounded-xl bg-surface-high px-4 py-2 text-xs font-bold text-slate-700" data-map-action="profile" data-marker-id="${marker.id}" data-marker-type="${marker.type}" type="button">View Profile</button>
          ${routeButton}
          ${requestButton}
        </div>
      </div>`;
  };

  const updateFeed = (markers) => {
    const top = markers.slice(0, 5);
    if (!top.length) {
      elements.feed.innerHTML = '<div class=\"rounded-2xl bg-white/80 px-4 py-3 text-sm text-slate-500\">No live entities found in this viewport. Try zooming out or resetting the map.</div>';
      return;
    }
    elements.feed.innerHTML = top.map((marker) => {
      const tone = typeTone[marker.type] || typeTone.hospital;
      return `<div class=\"rounded-2xl bg-white px-4 py-4 shadow-sm\" style=\"border-left:4px solid ${tone.border}\"><div class=\"text-[10px] font-black uppercase tracking-widest\" style=\"${tone.badge} display:inline-flex; border-radius:9999px; padding:4px 8px;\">${escapeHtml(typeLabels[marker.type] || 'Entity')}</div><h4 class=\"mt-2 text-sm font-bold\">${escapeHtml(marker.name || 'Unknown')}</h4><p class=\"mt-2 text-xs text-slate-500\">${escapeHtml(marker.city || '')}${marker.state ? `, ${escapeHtml(marker.state)}` : ''}</p></div>`;
    }).join('');
  };

  const bindPopup = (marker, leafletMarker) => {
    const routeButton = (marker.type === 'donor' || marker.type === 'hospital')
      ? `<button class=\"ll-popup-btn\" style=\"background:#0b1c30;color:#ffffff;\" data-map-action=\"route\" data-marker-id=\"${marker.id}\" data-marker-type=\"${marker.type}\" type=\"button\">Show Route</button>`
      : '';
    const requestButton = marker.request_url
      ? `<a class=\"ll-popup-btn\" style=\"background:#b80035;color:#ffffff;\" href=\"${escapeHtml(marker.request_url)}\">Open Request</a>`
      : '';
    leafletMarker.bindPopup(`<div style=\"min-width:250px\"><strong>${escapeHtml(marker.name || 'Unknown')}</strong>${marker.blood_group ? `<div style=\"margin-top:6px;\">Blood Group: ${escapeHtml(marker.blood_group)}</div>` : ''}${marker.city ? `<div>City: ${escapeHtml(marker.city)}</div>` : ''}${marker.state ? `<div>State: ${escapeHtml(marker.state)}</div>` : ''}${marker.address ? `<div>Address: ${escapeHtml(marker.address)}</div>` : ''}${marker.medical_condition ? `<div>Condition: ${escapeHtml(marker.medical_condition)}</div>` : ''}<div style=\"margin-top:6px;font-size:12px;color:#64748b;\">${Number(marker.lat).toFixed(5)}, ${Number(marker.lng).toFixed(5)}</div><div style=\"display:flex;flex-wrap:wrap;gap:8px;margin-top:12px;\"><button class=\"ll-popup-btn\" style=\"background:#d5e3fc;color:#3a485b;\" data-map-action=\"profile\" data-marker-id=\"${marker.id}\" data-marker-type=\"${marker.type}\" type=\"button\">View Profile</button>${routeButton}${requestButton}</div></div>`);
  };

  const renderMarkers = (payload) => {
    clusters.clearLayers();
    markerIndex = new Map();
    const markers = payload?.markers || [];
    const bounds = L.latLngBounds([]);

    markers.forEach((marker) => {
      const lat = Number(marker.lat);
      const lng = Number(marker.lng);
      if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;
      const leafletMarker = L.marker([lat, lng], { icon: iconFor(marker.type) });
      bindPopup(marker, leafletMarker);
      leafletMarker.on('click', () => renderSelectedEntity(marker));
      clusters.addLayer(leafletMarker);
      markerIndex.set(`${marker.type}:${marker.id}`, marker);
      bounds.extend([lat, lng]);
    });

    updateStats(payload?.meta?.counts || {});
    updateFeed(markers);
    if (bounds.isValid() && markers.length) map.fitBounds(bounds.pad(0.12), { animate: false, maxZoom: 12 });
  };

  const loadMarkers = async (preserveView = true) => {
    const chosen = selectedTypes();
    if (!chosen.length) {
      clusters.clearLayers();
      clearRoute();
      updateStats({ total: 0, donor: 0, recipient: 0, hospital: 0 });
      updateFeed([]);
      elements.status.textContent = 'Choose at least one live entity type.';
      return;
    }

    const center = preserveView ? map.getCenter() : null;
    const zoom = preserveView ? map.getZoom() : null;
    setLoading(true);
    elements.status.textContent = 'Refreshing live network...';

    try {
      const response = await fetch(buildUrl(), { headers: { Accept: 'application/json' }, credentials: 'same-origin' });
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      const payload = await response.json();
      renderMarkers(payload);
      if (preserveView && center && Number.isFinite(zoom)) map.setView(center, zoom, { animate: false });
      const generatedAt = payload?.meta?.generated_at ? new Date(payload.meta.generated_at) : new Date();
      elements.lastSync.textContent = generatedAt.toLocaleString();
      elements.status.textContent = `${payload?.meta?.counts?.total || 0} live marker(s) in view`;
    } catch (error) {
      console.error(error);
      elements.status.textContent = 'Unable to refresh map right now.';
    } finally {
      setLoading(false);
    }
  };

  const locateUser = () => {
    if (!navigator.geolocation) {
      elements.status.textContent = 'Geolocation is not supported in this browser.';
      return;
    }
    elements.status.textContent = 'Locating your device...';
    navigator.geolocation.getCurrentPosition((position) => {
      setOrigin(position.coords.latitude, position.coords.longitude, 'Your current browser location');
      userMarker.openPopup();
      map.setView([position.coords.latitude, position.coords.longitude], 12);
      elements.status.textContent = 'Centered on your current location.';
      loadMarkers(true);
    }, () => {
      elements.status.textContent = 'Location access was denied or unavailable.';
    }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 30000 });
  };

  [elements.donor, elements.recipient, elements.hospital, elements.availableOnly].forEach((element) => {
    element.addEventListener('change', () => loadMarkers(true));
  });

  elements.refreshBtn.addEventListener('click', () => loadMarkers(true));
  elements.resetBtn.addEventListener('click', () => {
    clearRoute();
    map.setView(defaultCenter, 5);
    loadMarkers(false);
  });
  elements.locateBtn.addEventListener('click', locateUser);

  document.addEventListener('click', (event) => {
    const trigger = event.target.closest('[data-map-action]');
    if (!trigger) return;
    const marker = markerIndex.get(`${trigger.getAttribute('data-marker-type')}:${trigger.getAttribute('data-marker-id')}`);
    if (!marker) return;
    if (trigger.getAttribute('data-map-action') === 'profile') {
      renderSelectedEntity(marker);
      elements.status.textContent = `${marker.name} details loaded.`;
    }
    if (trigger.getAttribute('data-map-action') === 'route') {
      renderSelectedEntity(marker);
      drawRouteTo(marker);
    }
  });

  map.whenReady(() => {
    setTimeout(() => map.invalidateSize(), 100);
    @if($mapUser->latitude && $mapUser->longitude)
      setOrigin({{ (float) $mapUser->latitude }}, {{ (float) $mapUser->longitude }}, 'Your saved profile location');
    @endif
    loadMarkers(false);
    refreshTimer = window.setInterval(() => loadMarkers(true), 30000);
  });

  window.addEventListener('resize', () => map.invalidateSize());
  window.addEventListener('beforeunload', () => {
    if (refreshTimer) window.clearInterval(refreshTimer);
  });
});
</script>
</body>
</html>
