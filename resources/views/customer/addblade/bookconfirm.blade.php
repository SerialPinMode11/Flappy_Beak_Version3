@extends('layouts.public-site')

@section('title', 'Booking confirmed — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-stone-200/80 shadow-md overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-forest to-forest-dark text-white">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-3xl text-gold-pale"></i>
                    <h1 class="text-2xl font-serif font-semibold">Booking confirmed</h1>
                </div>
                <p class="mt-2 opacity-90 text-sm">Your incubation service has been booked successfully</p>
            </div>
            
            <div class="p-6 sm:p-8 space-y-6">
                <div class="flex justify-between items-center border-b border-stone-200/80 pb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-forest">Booking reference</h2>
                        <p class="text-stone-600 text-sm">Keep this for your records</p>
                    </div>
                    <div class="text-xl font-mono font-bold text-forest">{{ $booking->booking_reference }}</div>
                </div>
                
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-forest">Booking details</h3>
                    
                    <div class="grid grid-cols-2 gap-y-3 text-sm text-stone-700">
                        <div class="font-medium text-forest">Service type:</div>
                        <div>{{ $serviceName[$booking->service_type] }}</div>
                        
                        <div class="font-medium text-forest">Number of eggs:</div>
                        <div>{{ $booking->egg_quantity }}</div>
                        
                        <div class="font-medium text-forest">Start date:</div>
                        <div>{{ date('F j, Y', strtotime($booking->start_date)) }}</div>
                        
                        <div class="font-medium text-forest">Estimated completion:</div>
                        <div>{{ date('F j, Y', strtotime($booking->start_date . ' + 28 days')) }}</div>
                        
                        <div class="font-medium text-forest">Total price:</div>
                        <div class="font-semibold text-gold-deep">₱{{ number_format($totalPrice, 2) }}</div>
                    </div>
                </div>
                
                <div class="bg-amber-50/90 p-4 rounded-xl border border-amber-200/80">
                    <h3 class="font-semibold text-amber-950 flex items-center gap-2">
                        <i class="fas fa-info-circle text-amber-700"></i>
                        Next steps
                    </h3>
                    <ul class="mt-2 space-y-2 text-sm text-amber-950/90">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-arrow-right mt-1 text-amber-800"></i>
                            <span>Our team will contact you within 24 hours to confirm your booking and arrange payment.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-arrow-right mt-1 text-amber-800"></i>
                            <span>A 50% deposit (₱{{ number_format($totalPrice * 0.5, 2) }}) is required to secure your booking.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-arrow-right mt-1 text-amber-800"></i>
                            <span>Please prepare your eggs or coordinate with us for egg purchase.</span>
                        </li>
                    </ul>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <a href="{{ route('home') }}" class="flex-1 py-3 px-6 bg-cream border border-stone-200 text-center rounded-xl font-medium text-forest hover:bg-stone-100 transition-colors">
                        Return to home
                    </a>
                    <a href="{{ route('booking.status', ['reference' => $booking->booking_reference]) }}" class="flex-1 py-3 px-6 bg-forest text-white text-center rounded-xl font-medium hover:bg-forest-dark transition-colors shadow-sm">
                        Check booking status
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
