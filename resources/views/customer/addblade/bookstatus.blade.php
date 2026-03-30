@extends('layouts.public-site')

@section('title', 'Booking status — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@php
    $activeBooking = $booking ?? $defaultBooking ?? null;
    // The UI expects `$booking->...` in multiple places; for the two-column
    // layout we map it to the active (default or searched) booking.
    $booking = $activeBooking;
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-deep/90 mb-2">Incubation</p>
        <h1 class="font-serif text-2xl sm:text-3xl font-semibold text-forest mb-6">Check booking status</h1>
        
        @if(session()->has('error'))
            <div class="rounded-xl border border-red-200 bg-red-50/90 text-red-900 text-sm px-4 py-3 mb-6 flex gap-3 items-start">
                <i class="fas fa-exclamation-circle mt-0.5 text-red-600"></i>
                <span>{{ session()->get('error') }}</span>
            </div>
        @endif
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        <div class="bg-white rounded-2xl border border-stone-200/80 shadow-md overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-forest to-forest-dark text-white">
                <h2 class="text-xl font-semibold">Enter your booking reference</h2>
                <p class="text-sm opacity-90 mt-1">Check the status of your incubation service booking</p>
            </div>
            
            <div class="p-6">
                <form action="{{ route('booking.status') }}" method="GET" class="space-y-4">
                    <div>
                        <label for="reference" class="block text-sm font-medium text-stone-700 mb-1">Booking reference number</label>
                        <input type="text" id="reference" name="reference" placeholder="e.g. INC-16234567891234" required
                            class="w-full px-4 py-3 border border-stone-200 rounded-lg focus:ring-2 focus:ring-gold/40 focus:border-forest transition-colors">
                    </div>
                    
                    <button type="submit" class="w-full bg-forest text-white py-3 px-6 rounded-xl font-medium hover:bg-forest-dark transition-colors flex items-center justify-center gap-2 shadow-sm">
                        <i class="fas fa-search"></i>
                        Check status
                    </button>
                </form>
            </div>
        </div>
        
        @if($activeBooking)
            <div class="bg-white rounded-2xl border border-stone-200/80 shadow-md overflow-hidden">
                <div class="p-6 bg-gradient-to-r from-forest-light to-forest text-white">
                    <h2 class="text-xl font-semibold">Booking status</h2>
                    <p class="text-sm opacity-90 mt-1">Reference: {{ $booking->booking_reference }}</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div>
                            <h3 class="font-semibold text-forest">Current status</h3>
                            <p class="text-sm text-stone-600">Last updated: <span id="booking-updated-at">{{ $booking->updated_at->format('F j, Y, g:i a') }}</span></p>
                        </div>
                        
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-900',
                                'confirmed' => 'bg-emerald-100 text-emerald-900',
                                'in_progress' => 'bg-violet-100 text-violet-900',
                                'candling' => 'bg-indigo-100 text-indigo-900',
                                'lockdown' => 'bg-orange-100 text-orange-900',
                                'hatching' => 'bg-green-100 text-green-900',
                                'completed' => 'bg-green-100 text-green-900',
                                'cancelled' => 'bg-red-100 text-red-900',
                            ];
                            
                            $statusLabels = [
                                'pending' => 'Pending Confirmation',
                                'confirmed' => 'Booking Confirmed',
                                'in_progress' => 'Incubation In Progress',
                                'candling' => 'Candling Phase',
                                'lockdown' => 'Lockdown Phase',
                                'hatching' => 'Hatching In Progress',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ];
                            
                            $statusColor = $statusColors[$booking->status] ?? 'bg-stone-100 text-stone-800';
                            $statusLabel = $statusLabels[$booking->status] ?? 'Unknown';
                        @endphp
                        
                        <span id="booking-status-badge" class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                    
                    <div class="border-t border-stone-200/80 pt-4">
                        <h3 class="font-semibold text-forest mb-3">Incubation progress</h3>
                        
                        @php
                            $startDate = \Carbon\Carbon::parse($booking->start_date);
                            $today = \Carbon\Carbon::now();
                            $endDate = \Carbon\Carbon::parse($booking->start_date)->addDays(28);
                            
                            $totalDays = 28;
                            $daysElapsed = min($totalDays, max(0, $today->diffInDays($startDate)));
                            $progressPercent = min(100, round(($daysElapsed / $totalDays) * 100));
                            
                            $phases = [
                                ['day' => 0, 'name' => 'Start', 'status' => $progressPercent >= 0 ? 'completed' : 'pending'],
                                ['day' => 7, 'name' => 'First Candling', 'status' => $progressPercent >= 25 ? 'completed' : 'pending'],
                                ['day' => 14, 'name' => 'Second Candling', 'status' => $progressPercent >= 50 ? 'completed' : 'pending'],
                                ['day' => 25, 'name' => 'Lockdown', 'status' => $progressPercent >= 89 ? 'completed' : 'pending'],
                                ['day' => 28, 'name' => 'Hatching', 'status' => $progressPercent >= 100 ? 'completed' : 'pending'],
                            ];
                        @endphp
                        
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    <span class="text-xs font-semibold inline-block text-forest">
                                        Day {{ $daysElapsed }} of {{ $totalDays }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold inline-block text-gold-deep">
                                        {{ $progressPercent }}%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-stone-200">
                                <div style="width:{{ $progressPercent }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-forest"></div>
                            </div>
                            
                            <div class="flex justify-between mb-1">
                                @foreach($phases as $phase)
                                    <div class="text-center">
                                        <div class="relative">
                                            <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center {{ $phase['status'] == 'completed' ? 'bg-forest text-gold-pale' : 'bg-stone-200 text-stone-400' }}">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            @if(!$loop->last)
                                                <div class="absolute top-4 w-full h-0.5 {{ $phase['status'] == 'completed' ? 'bg-forest' : 'bg-stone-200' }}"></div>
                                            @endif
                                        </div>
                                        <span class="text-xs mt-1 block {{ $phase['status'] == 'completed' ? 'text-forest font-medium' : 'text-stone-500' }}">
                                            {{ $phase['name'] }}
                                        </span>
                                        <span class="text-xs text-stone-400">Day {{ $phase['day'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-stone-200/80 pt-4">
                        <h3 class="font-semibold text-forest mb-3">Booking details</h3>
                        
                        <div class="grid grid-cols-2 gap-y-3 text-sm text-stone-700">
                            <div class="font-medium text-forest">Service type:</div>
                            <div>{{ $booking->service_type_name }}</div>
                            
                            <div class="font-medium text-forest">Number of eggs:</div>
                            <div>{{ $booking->egg_quantity }}</div>
                            
                            <div class="font-medium text-forest">Start date:</div>
                            <div>{{ $booking->start_date ? $booking->start_date->format('F j, Y') : '—' }}</div>
                            
                            <div class="font-medium text-forest">Expected completion:</div>
                            <div>{{ $booking->expected_completion_date ? $booking->expected_completion_date->format('F j, Y') : '—' }}</div>

                            <div class="font-medium text-forest">Total price:</div>
                            <div class="font-semibold text-gold-deep">₱{{ number_format((float) ($booking->total_price ?? 0), 2) }}</div>
                        </div>
                    </div>
                    
                    <div class="border-t border-stone-200/80 pt-4">
                        <h3 class="font-semibold text-forest mb-3">Need help?</h3>
                        <p class="text-sm text-stone-600">If you have any questions about your booking, please contact us:</p>
                        <div class="flex flex-wrap items-center gap-4 mt-2">
                            <a href="tel:{{ config('contact.owner_phone_tel') }}" class="text-forest hover:text-gold-deep transition-colors flex items-center gap-2">
                                <i class="fas fa-phone"></i>
                                <span>{{ config('contact.owner_phone_display') }}</span>
                            </a>
                            <a href="mailto:jmcasabar@gmail.com" class="text-forest hover:text-gold-deep transition-colors flex items-center gap-2">
                                <i class="fas fa-envelope"></i>
                                <span>jmcasabar@gmail.com</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-stone-200/80 shadow-md p-6">
                <h2 class="text-xl font-semibold text-forest">No incubation bookings found</h2>
                <p class="text-sm text-stone-600 mt-2">
                    Once you book incubation services, the latest status will appear here.
                </p>
                <a href="{{ route('booking.index') }}" class="inline-flex mt-5 items-center justify-center gap-2 bg-forest text-white px-5 py-2 rounded-xl text-sm font-medium hover:bg-forest-dark transition-colors">
                    <i class="fas fa-calendar-check"></i> Book incubation
                </a>
            </div>
        @endif
        </div>
    </div>
</div>
@endsection

@if($activeBooking)
@push('scripts')
<script>
(function () {
    var pollUrl = @json(route('booking.status.json')) + '?reference=' + encodeURIComponent(@json($activeBooking->booking_reference));
    var lastStatus = @json($activeBooking->status);

    function poll() {
        fetch(pollUrl, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data || data.error) return;
                if (data.status && data.status !== lastStatus) {
                    lastStatus = data.status;
                    if (typeof window.showToast === 'function') {
                        window.showToast('Booking status updated: ' + (data.status_label || data.status), 'success');
                    }
                    window.location.reload();
                }
            })
            .catch(function () {});
    }
    setInterval(poll, 25000);
})();
</script>
@endpush
@endif
