<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Live Map</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-4">
                <div id="map" style="height: 500px;"></div>
            </div>
        </div>
    </div>

    <script>
        async function initMap() {
            const response = await fetch('/api/map/data', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await response.json();

            const map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 28.6139, lng: 77.2090 },
                zoom: 6,
            });

            data.donors.forEach(donor => {
                new google.maps.Marker({
                    position: { lat: parseFloat(donor.lat), lng: parseFloat(donor.lng) },
                    map,
                    icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
                    title: donor.name + ' (' + donor.blood_group + ')'
                });
            });

            data.requests.forEach(req => {
                new google.maps.Marker({
                    position: { lat: parseFloat(req.lat), lng: parseFloat(req.lng) },
                    map,
                    icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
                    title: (req.patient_name || 'Request') + ' (' + req.blood_group + ')'
                });
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
</x-app-layout>
