<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Analytics Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex gap-2">
                @foreach(['7d' => '7 Days', '30d' => '30 Days', '90d' => '90 Days', '1y' => '1 Year'] as $key => $label)
                    <a href="{{ route('analytics.index', ['time_range' => $key]) }}" class="px-3 py-1 rounded {{ $timeRange === $key ? 'bg-red-600 text-white' : 'bg-white border' }}">{{ $label }}</a>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-600">Total Matches</p>
                    <p class="text-2xl font-bold">{{ $overview['total_matches'] }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-600">Active Donors</p>
                    <p class="text-2xl font-bold">{{ $overview['active_donors'] }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-600">Success Rate</p>
                    <p class="text-2xl font-bold">{{ $overview['success_rate'] }}%</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-600">Urgent Requests</p>
                    <p class="text-2xl font-bold">{{ $overview['urgent_requests'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-semibold mb-2">Matching Trends</h3>
                    <canvas id="trendsChart" height="200"></canvas>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-semibold mb-2">Blood Group Distribution</h3>
                    <canvas id="bloodChart" height="200"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-semibold mb-2">Top Locations</h3>
                    <canvas id="locationChart" height="200"></canvas>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-semibold mb-2">Success Rate by Blood Group</h3>
                    <canvas id="successChart" height="200"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-semibold mb-2">Predictive Demand (Next 30 Days)</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-600">
                                    <th class="py-2">Blood Group</th>
                                    <th>Current</th>
                                    <th>Predicted</th>
                                    <th>Confidence</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($predictive['demand_prediction'] as $group => $row)
                                    <tr class="border-t">
                                        <td class="py-2">{{ $group }}</td>
                                        <td>{{ $row['current_demand'] }}</td>
                                        <td>{{ $row['predicted_demand'] }}</td>
                                        <td>{{ (int)($row['confidence'] * 100) }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bg-white p-4 rounded shadow space-y-4">
                    <div>
                        <h3 class="font-semibold mb-2">Predicted Donor Availability</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="border rounded p-3">
                                <p class="text-xs text-gray-600">Currently Available</p>
                                <p class="text-xl font-bold">{{ $predictive['availability_prediction']['currently_available'] }}</p>
                            </div>
                            <div class="border rounded p-3">
                                <p class="text-xs text-gray-600">Eligible Soon</p>
                                <p class="text-xl font-bold">{{ $predictive['availability_prediction']['eligible_soon'] }}</p>
                            </div>
                            <div class="border rounded p-3">
                                <p class="text-xs text-gray-600">Predicted Total</p>
                                <p class="text-xl font-bold">{{ $predictive['availability_prediction']['predicted_availability'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Success Rate Prediction</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="border rounded p-3">
                                <p class="text-xs text-gray-600">Current</p>
                                <p class="text-xl font-bold">{{ $predictive['success_prediction']['current_success_rate'] }}%</p>
                            </div>
                            <div class="border rounded p-3">
                                <p class="text-xs text-gray-600">Predicted</p>
                                <p class="text-xl font-bold">{{ $predictive['success_prediction']['predicted_success_rate'] }}%</p>
                            </div>
                            <div class="border rounded p-3">
                                <p class="text-xs text-gray-600">Confidence</p>
                                <p class="text-xl font-bold">{{ (int)($predictive['success_prediction']['confidence'] * 100) }}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-2">Recent Urgent Requests</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-600">
                                <th class="py-2">Patient</th>
                                <th>Blood Group</th>
                                <th>Location</th>
                                <th>Urgency</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($urgentRequests as $req)
                                <tr class="border-t">
                                    <td class="py-2">{{ $req['patient_name'] ?? 'N/A' }}</td>
                                    <td>{{ $req['blood_group'] }}</td>
                                    <td>{{ $req['city'] }}, {{ $req['state'] }}</td>
                                    <td>{{ ucfirst($req['urgency']) }}</td>
                                    <td>{{ ucfirst($req['status']) }}</td>
                                    <td>{{ $req['created_at'] }}</td>
                                </tr>
                            @empty
                                <tr><td class="py-2" colspan="6">No urgent requests.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const trends = @json($trends);
        const bloodGroups = @json($bloodGroupDistribution);
        const locations = @json($locationStats);
        const successRates = @json($successRates);

        new Chart(document.getElementById('trendsChart'), {
            type: 'line',
            data: {
                labels: trends.map(t => t.date),
                datasets: [
                    { label: 'Matches', data: trends.map(t => t.matches), borderColor: '#10B981', fill: false },
                    { label: 'Donations', data: trends.map(t => t.donations), borderColor: '#3B82F6', fill: false },
                ]
            }
        });

        new Chart(document.getElementById('bloodChart'), {
            type: 'pie',
            data: {
                labels: bloodGroups.map(b => b.name),
                datasets: [{ data: bloodGroups.map(b => b.value), backgroundColor: ['#ef4444','#f97316','#f59e0b','#eab308','#84cc16','#22c55e','#06b6d4','#3b82f6'] }]
            }
        });

        new Chart(document.getElementById('locationChart'), {
            type: 'bar',
            data: {
                labels: locations.map(l => l.city),
                datasets: [
                    { label: 'Matches', data: locations.map(l => l.matches), backgroundColor: '#10B981' },
                    { label: 'Donations', data: locations.map(l => l.donations), backgroundColor: '#3B82F6' },
                ]
            }
        });

        new Chart(document.getElementById('successChart'), {
            type: 'bar',
            data: {
                labels: successRates.map(s => s.blood_group),
                datasets: [{ label: 'Success Rate', data: successRates.map(s => s.success_rate), backgroundColor: '#f59e0b' }]
            }
        });
    </script>
</x-app-layout>
