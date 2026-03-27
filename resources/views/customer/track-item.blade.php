@extends('layouts.default')

@section('title', 'Track Item - Flappy Beak')

@section('content')
    @php
        $statusLabels = [
            'pending' => 'Pending',
            'preparing' => 'Preparing',
            'processing' => 'Processing',
            'out_for_delivery' => 'Out for delivery',
            'delivered' => 'Delivered',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
        $timelineStatuses = ['pending', 'preparing', 'processing', 'out_for_delivery', 'delivered'];
        $currentStatus = $selectedOrder->status ?? null;
        $effectiveStatus = $currentStatus === 'completed' ? 'delivered' : $currentStatus;
        $currentIndex = $effectiveStatus ? array_search($effectiveStatus, $timelineStatuses, true) : false;
    @endphp

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-neutral">Track Item</h2>
            <p class="text-sm text-gray-600 mt-1">
                Track each purchase status and delivery location updates.
            </p>
        </div>

        @if(($orders ?? collect())->isEmpty())
            <div class="bg-white rounded-xl shadow-md p-6">
                <p class="text-gray-700">No purchase records found for your account yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 bg-white rounded-xl shadow-md p-4 md:p-6">
                    <h3 class="text-lg font-semibold text-neutral mb-3">Your Purchases</h3>
                    <form method="GET" action="{{ route('checkout.track-item') }}" class="mb-4">
                        <label for="billing" class="block text-sm font-medium text-gray-700 mb-1">Select Order</label>
                        <select id="billing" name="billing" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary" onchange="if(this.value){window.location.href='{{ url('/checkout/track-item') }}/'+this.value}">
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}" {{ ($selectedOrder && $selectedOrder->id === $order->id) ? 'selected' : '' }}>
                                    #{{ $order->id }} - {{ $order->created_at->format('M d, Y h:i A') }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    @if($selectedOrder)
                        <div class="space-y-2 text-sm mb-5">
                            <p><span class="font-semibold">Order #:</span> {{ $selectedOrder->id }}</p>
                            <p><span class="font-semibold">Amount:</span> P{{ number_format($selectedOrder->total_amount, 2) }}</p>
                            <p>
                                <span class="font-semibold">Current Status:</span>
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold
                                    @if(in_array($selectedOrder->status, ['delivered', 'completed'])) bg-green-100 text-green-800
                                    @elseif($selectedOrder->status === 'out_for_delivery') bg-purple-100 text-purple-800
                                    @elseif($selectedOrder->status === 'processing') bg-blue-100 text-blue-800
                                    @elseif($selectedOrder->status === 'preparing') bg-amber-100 text-amber-800
                                    @elseif($selectedOrder->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $statusLabels[$selectedOrder->status] ?? ucwords(str_replace('_', ' ', $selectedOrder->status ?? 'unknown')) }}
                                </span>
                            </p>
                            <p><span class="font-semibold">Delivery Address:</span> {{ $selectedOrder->address }}, {{ $selectedOrder->city }}, {{ $selectedOrder->zip }}</p>
                        </div>

                        <h4 class="font-semibold text-neutral mb-2">Order Timeline</h4>
                        <div class="space-y-2">
                            @foreach($timelineStatuses as $idx => $statusKey)
                                @php
                                    $isDone = ($currentIndex !== false) && ($idx <= $currentIndex);
                                @endphp
                                <div class="flex items-center gap-3">
                                    <span class="w-3 h-3 rounded-full {{ $isDone ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                                    <span class="text-sm {{ $isDone ? 'text-neutral font-medium' : 'text-gray-500' }}">
                                        {{ $statusLabels[$statusKey] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-4 md:p-6">
                    <div class="mb-4">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Store:</span> {{ $storeName }}
                        </p>
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Store Address:</span> {{ $ownerAddress }}
                        </p>
                    </div>

                    <div id="track-map" class="w-full rounded-lg border border-gray-200" style="height: 480px;"></div>
                    <p id="map-status" class="text-sm text-gray-600 mt-3">Loading map...</p>
                </div>
            </div>
        @endif
    </main>
@endsection

@push('styles')
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""
    >
@endpush

@push('scripts')
    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""
    ></script>
    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            const ownerAddress = @json($ownerAddress);
            const storeName = @json($storeName);
            const customerAddress = @json($selectedOrder ? ($selectedOrder->address . ', ' . $selectedOrder->city . ', ' . $selectedOrder->zip) : null);
            const statusEl = document.getElementById('map-status');
            if (!statusEl) return;

            const fallback = { lat: 13.086, lng: 121.182, label: ownerAddress };
            const map = L.map('track-map', {
                center: [fallback.lat, fallback.lng],
                zoom: 14
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const ownerMarker = L.marker([fallback.lat, fallback.lng]).addTo(map);
            ownerMarker.bindPopup(`<strong>${storeName}</strong><br>${ownerAddress}`).openPopup();
            let customerMarker = null;
            let routeLine = null;

            async function geocodeAddress(address) {
                const url = `https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(address)}`;
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) {
                    throw new Error('Unable to geocode address');
                }
                const data = await res.json();
                if (!Array.isArray(data) || data.length === 0) {
                    throw new Error('No location found for owner address');
                }
                return {
                    lat: parseFloat(data[0].lat),
                    lng: parseFloat(data[0].lon),
                    label: data[0].display_name || address
                };
            }

            try {
                statusEl.textContent = 'Finding owner address on map...';
                const ownerPoint = await geocodeAddress(ownerAddress);
                ownerMarker.setLatLng([ownerPoint.lat, ownerPoint.lng]);
                ownerMarker.bindPopup(`<strong>${storeName}</strong><br>${ownerPoint.label}`).openPopup();
                let points = [[ownerPoint.lat, ownerPoint.lng]];

                if (customerAddress) {
                    statusEl.textContent = 'Loading customer delivery address...';
                    const customerPoint = await geocodeAddress(customerAddress);
                    customerMarker = L.marker([customerPoint.lat, customerPoint.lng]).addTo(map);
                    customerMarker.bindPopup(`<strong>Delivery Address</strong><br>${customerPoint.label}`);
                    points.push([customerPoint.lat, customerPoint.lng]);
                    routeLine = L.polyline(points, { color: '#4ECDC4', weight: 4, opacity: 0.8 }).addTo(map);
                    map.fitBounds(routeLine.getBounds(), { padding: [30, 30] });
                    statusEl.textContent = 'Order map and status loaded successfully.';
                } else {
                    map.setView([ownerPoint.lat, ownerPoint.lng], 16);
                    statusEl.textContent = 'Store location loaded successfully.';
                }
            } catch (error) {
                statusEl.textContent = 'Using fallback location. Could not geocode owner address.';
            }
        });
    </script>
@endpush
