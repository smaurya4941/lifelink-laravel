<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-semibold text-xl leading-tight text-white">Live Network Map</h2>
            <p class="text-sm text-rose-100">Donors, requests, and hospitals</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto space-y-4 px-4 sm:px-6 lg:px-8">
            <div class="ll-surface p-4 sm:p-5">
                <div class="grid grid-cols-1 gap-3 lg:grid-cols-12 lg:items-end">
                    <div class="lg:col-span-8">
                        <p class="text-sm font-semibold text-slate-800">Map Filters</p>
                        <p class="text-xs text-slate-500">Toggle marker types and refresh map data in current viewport.</p>
                        <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-slate-700">
                            <label class="inline-flex items-center gap-2">
                                <input id="filter-donor" type="checkbox" class="rounded border-slate-300" checked>
                                <span>Donors</span>
                            </label>
                            <label class="inline-flex items-center gap-2">
                                <input id="filter-request" type="checkbox" class="rounded border-slate-300" checked>
                                <span>Requests</span>
                            </label>
                            <label class="inline-flex items-center gap-2">
                                <input id="filter-hospital" type="checkbox" class="rounded border-slate-300" checked>
                                <span>Hospitals</span>
                            </label>
                            <label class="inline-flex items-center gap-2">
                                <input id="filter-available-only" type="checkbox" class="rounded border-slate-300" checked>
                                <span>Available Donors Only</span>
                            </label>
                        </div>
                    </div>

                    <div class="lg:col-span-4">
                        <div class="flex flex-wrap items-center justify-start gap-2 lg:justify-end">
                            <button id="center-india-btn" type="button" class="ll-btn-soft">Reset View</button>
                            <button id="refresh-map-btn" type="button" class="ll-btn-primary">Refresh In View</button>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-4 text-xs text-slate-600">
                    <span><span class="mr-1 inline-block h-3 w-3 rounded-full bg-emerald-600"></span>Donor</span>
                    <span><span class="mr-1 inline-block h-3 w-3 rounded-full bg-blue-600"></span>Request</span>
                    <span><span class="mr-1 inline-block h-3 w-3 rounded-full bg-red-600"></span>Hospital</span>
                    <span id="map-status" class="ml-auto text-slate-500"></span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="ll-surface p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Total</p>
                    <p id="stat-total" class="mt-1 text-2xl font-bold text-slate-900">0</p>
                </div>
                <div class="ll-surface p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Donors</p>
                    <p id="stat-donor" class="mt-1 text-2xl font-bold text-emerald-700">0</p>
                </div>
                <div class="ll-surface p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Requests</p>
                    <p id="stat-request" class="mt-1 text-2xl font-bold text-blue-700">0</p>
                </div>
                <div class="ll-surface p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Hospitals</p>
                    <p id="stat-hospital" class="mt-1 text-2xl font-bold text-red-700">0</p>
                </div>
            </div>

            <div class="ll-surface overflow-hidden p-3 sm:p-4">
                <div class="relative">
                    <div id="lifelink-map" class="h-[620px] w-full rounded-xl border border-slate-200"></div>
                    <div id="map-overlay" class="pointer-events-none absolute inset-0 hidden items-center justify-center rounded-xl bg-white/70 backdrop-blur-sm">
                        <p class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow">Loading map data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

    <style>
        /* Defensive fallback in case external stylesheet load order is delayed. */
        .leaflet-container {
            position: relative;
            overflow: hidden;
            outline: 0;
        }

        .leaflet-pane,
        .leaflet-tile,
        .leaflet-marker-icon,
        .leaflet-marker-shadow {
            position: absolute;
        }

        .leaflet-container img.leaflet-tile {
            max-width: none !important;
            max-height: none !important;
        }

        .ll-marker-dot {
            display: inline-block;
            width: 14px;
            height: 14px;
            line-height: 14px;
            border-radius: 9999px;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px rgba(15, 23, 42, 0.18);
        }

        .ll-marker-donor { background: #059669; }
        .ll-marker-request { background: #2563eb; }
        .ll-marker-hospital { background: #dc2626; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const map = L.map('lifelink-map', {
                zoomControl: true,
                minZoom: 3,
            }).setView([20.5937, 78.9629], 5);

            // Ensure proper tile layout after parent containers finish layout/animation.
            setTimeout(() => map.invalidateSize(), 100);
            window.addEventListener('resize', () => map.invalidateSize());

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            const elements = {
                donor: document.getElementById('filter-donor'),
                request: document.getElementById('filter-request'),
                hospital: document.getElementById('filter-hospital'),
                availableOnly: document.getElementById('filter-available-only'),
                refreshBtn: document.getElementById('refresh-map-btn'),
                resetBtn: document.getElementById('center-india-btn'),
                overlay: document.getElementById('map-overlay'),
                status: document.getElementById('map-status'),
                statTotal: document.getElementById('stat-total'),
                statDonor: document.getElementById('stat-donor'),
                statRequest: document.getElementById('stat-request'),
                statHospital: document.getElementById('stat-hospital'),
            };

            const clusterGroup = L.markerClusterGroup({
                showCoverageOnHover: false,
                spiderfyOnMaxZoom: true,
                maxClusterRadius: 45,
            });
            map.addLayer(clusterGroup);

            const colorByType = {
                donor: '#059669',
                request: '#2563eb',
                hospital: '#dc2626',
            };

            const escapeHtml = (value) => String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');

            const setLoading = (isLoading) => {
                elements.overlay.classList.toggle('hidden', !isLoading);
                elements.overlay.classList.toggle('flex', isLoading);
                elements.refreshBtn.disabled = isLoading;
            };

            const selectedTypes = () => {
                const types = [];
                if (elements.donor.checked) types.push('donor');
                if (elements.request.checked) types.push('request');
                if (elements.hospital.checked) types.push('hospital');
                return types;
            };

            const buildUrl = () => {
                const bounds = map.getBounds();
                const params = new URLSearchParams({
                    types: selectedTypes().join(','),
                    available_only: elements.availableOnly.checked ? '1' : '0',
                    north: String(bounds.getNorth()),
                    south: String(bounds.getSouth()),
                    east: String(bounds.getEast()),
                    west: String(bounds.getWest()),
                });
                return `{{ route('map.markers') }}?${params.toString()}`;
            };

            const markerIcon = (type) => L.divIcon({
                className: '',
                html: `<span class="ll-marker-dot ll-marker-${type}"></span>`,
                iconSize: [14, 14],
                iconAnchor: [7, 7],
                popupAnchor: [0, -8],
            });

            const updateStats = (meta) => {
                const counts = meta?.counts || { total: 0, donor: 0, request: 0, hospital: 0 };
                elements.statTotal.textContent = String(counts.total || 0);
                elements.statDonor.textContent = String(counts.donor || 0);
                elements.statRequest.textContent = String(counts.request || 0);
                elements.statHospital.textContent = String(counts.hospital || 0);
            };

            const renderMarkers = (payload) => {
                clusterGroup.clearLayers();

                const markers = payload?.markers || [];
                const bounds = L.latLngBounds([]);

                markers.forEach((m) => {
                    const lat = Number(m.lat);
                    const lng = Number(m.lng);

                    if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
                        return;
                    }

                    const marker = L.marker([lat, lng], {
                        icon: markerIcon(m.type),
                        keyboard: true,
                    });

                    const badgeColor = colorByType[m.type] || '#334155';
                    marker.bindPopup(`
                        <div style="min-width:220px">
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                                <span style="display:inline-block;width:10px;height:10px;border-radius:9999px;background:${badgeColor};"></span>
                                <strong>${escapeHtml(m.name || 'Unknown')}</strong>
                            </div>
                            <div>Type: ${escapeHtml(m.type || 'unknown')}</div>
                            ${m.blood_group ? `<div>Blood Group: ${escapeHtml(m.blood_group)}</div>` : ''}
                            ${m.urgency ? `<div>Urgency: ${escapeHtml(m.urgency)}</div>` : ''}
                            ${m.hospital_name ? `<div>Hospital: ${escapeHtml(m.hospital_name)}</div>` : ''}
                            ${m.city ? `<div>City: ${escapeHtml(m.city)}</div>` : ''}
                            ${m.state ? `<div>State: ${escapeHtml(m.state)}</div>` : ''}
                            ${m.address ? `<div>Address: ${escapeHtml(m.address)}</div>` : ''}
                            <div style="margin-top:4px;font-size:12px;color:#475569;">Lat: ${lat.toFixed(5)}, Lng: ${lng.toFixed(5)}</div>
                        </div>
                    `);

                    clusterGroup.addLayer(marker);
                    bounds.extend([lat, lng]);
                });

                if (bounds.isValid() && markers.length > 0) {
                    map.fitBounds(bounds.pad(0.15), { animate: false });
                }

                updateStats(payload.meta);
                elements.status.textContent = `${markers.length} marker(s) loaded`;
            };

            const loadMarkers = async () => {
                const types = selectedTypes();
                if (types.length === 0) {
                    clusterGroup.clearLayers();
                    updateStats({ counts: { total: 0, donor: 0, recipient: 0, hospital: 0 } });
                    elements.status.textContent = 'Select at least one marker type.';
                    return;
                }

                setLoading(true);
                elements.status.textContent = 'Loading...';

                try {
                    const response = await fetch(buildUrl(), {
                        headers: { Accept: 'application/json' },
                        credentials: 'same-origin',
                    });

                    const contentType = response.headers.get('content-type') || '';

                    if (!response.ok) {
                        const errBody = await response.text();
                        throw new Error(`Request failed (${response.status}): ${errBody.slice(0, 160)}`);
                    }

                    if (!contentType.includes('application/json')) {
                        const body = await response.text();
                        throw new Error(`Expected JSON but received ${contentType || 'unknown'}: ${body.slice(0, 160)}`);
                    }

                    const payload = await response.json();
                    renderMarkers(payload);
                } catch (error) {
                    console.error(error);
                    elements.status.textContent = `Unable to load map markers: ${error.message}`;
                } finally {
                    setLoading(false);
                }
            };

            [elements.donor, elements.request, elements.hospital, elements.availableOnly].forEach((input) => {
                input.addEventListener('change', loadMarkers);
            });

            elements.refreshBtn.addEventListener('click', loadMarkers);
            elements.resetBtn.addEventListener('click', () => {
                map.setView([20.5937, 78.9629], 5);
            });

            loadMarkers();
        });
    </script>
</x-app-layout>
