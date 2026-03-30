@php
    $uid = $uid ?? uniqid('loc_', false);
    $label = $label ?? 'Current Location';
    $helpText = $helpText ?? 'Click "Use Current Location" to fetch your coordinates before saving.';
    $buttonText = $buttonText ?? 'Use Current Location';
    $latName = $latName ?? 'latitude';
    $lngName = $lngName ?? 'longitude';
    $latId = $latId ?? ($uid . '_latitude');
    $lngId = $lngId ?? ($uid . '_longitude');
    $latValue = old($latName, $latValue ?? null);
    $lngValue = old($lngName, $lngValue ?? null);
    $requireWhenCheckboxId = $requireWhenCheckboxId ?? null;
@endphp

<div class="rounded-lg border border-slate-200 bg-slate-50 p-4" id="{{ $uid }}_wrapper">
    <input type="hidden" id="{{ $latId }}" name="{{ $latName }}" value="{{ $latValue }}">
    <input type="hidden" id="{{ $lngId }}" name="{{ $lngName }}" value="{{ $lngValue }}">

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm font-medium text-slate-800">{{ $label }}</p>
            <p class="text-xs text-slate-600">{{ $helpText }}</p>
        </div>
        <button
            type="button"
            id="{{ $uid }}_btn"
            class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-medium text-slate-700 ring-1 ring-slate-300 hover:bg-slate-100"
        >
            {{ $buttonText }}
        </button>
    </div>

    <p id="{{ $uid }}_text" class="mt-3 text-sm text-slate-700"></p>
    <p id="{{ $uid }}_hint" class="mt-1 text-xs text-slate-500"></p>

    @error($latName)<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    @error($lngName)<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<script>
    (() => {
        const locationBtn = document.getElementById('{{ $uid }}_btn');
        const latInput = document.getElementById('{{ $latId }}');
        const lonInput = document.getElementById('{{ $lngId }}');
        const locationText = document.getElementById('{{ $uid }}_text');
        const locationHint = document.getElementById('{{ $uid }}_hint');
        const form = locationBtn?.closest('form');
        const requiredToggle = {!! $requireWhenCheckboxId ? 'document.getElementById("' . $requireWhenCheckboxId . '")' : 'null' !!};

        if (!locationBtn || !latInput || !lonInput || !locationText || !locationHint || !form) {
            return;
        }

        const renderStoredLocation = () => {
            if (latInput.value && lonInput.value) {
                locationText.textContent = `Lat: ${latInput.value}, Lng: ${lonInput.value}`;
                locationHint.textContent = 'Location ready to be saved.';
            } else {
                locationText.textContent = 'Location not fetched yet.';
                locationHint.textContent = 'Press "Use Current Location" to fetch your coordinates.';
            }
        };

        const setLoading = (isLoading) => {
            locationBtn.disabled = isLoading;
            locationBtn.textContent = isLoading ? 'Fetching location...' : '{{ $buttonText }}';
        };

        const getLocation = () => {
            if (!navigator.geolocation) {
                locationHint.textContent = 'Geolocation is not supported by this browser.';
                return;
            }

            setLoading(true);

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = Number(position.coords.latitude).toFixed(7);
                    const lng = Number(position.coords.longitude).toFixed(7);

                    latInput.value = lat;
                    lonInput.value = lng;
                    locationText.textContent = `Lat: ${lat}, Lng: ${lng}`;
                    locationHint.textContent = 'Location fetched successfully.';
                    setLoading(false);
                },
                (error) => {
                    const messages = {
                        1: 'Location permission denied. Please allow access and try again.',
                        2: 'Location unavailable right now. Try again in a moment.',
                        3: 'Location request timed out. Try again.',
                    };

                    locationHint.textContent = messages[error.code] || 'Unable to fetch location. Please try again.';
                    setLoading(false);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0,
                }
            );
        };

        locationBtn.addEventListener('click', getLocation);

        form.addEventListener('submit', (event) => {
            if (requiredToggle?.checked && (!latInput.value || !lonInput.value)) {
                event.preventDefault();
                locationHint.textContent = 'Please fetch your current location before saving.';
                locationBtn.focus();
            }
        });
        renderStoredLocation();
    })();
</script>
