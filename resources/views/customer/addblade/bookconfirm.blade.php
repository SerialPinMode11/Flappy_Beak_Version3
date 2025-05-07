@extends('layouts.default')

@section('title', 'Booking Confirmation')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-green-500 to-green-600 text-white">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-3xl"></i>
                    <h1 class="text-2xl font-bold">Booking Confirmed!</h1>
                </div>
                <p class="mt-2 opacity-90">Your incubation service has been booked successfully</p>
            </div>
            
            <div class="p-6 space-y-6">
                <div class="flex justify-between items-center border-b pb-4">
                    <div>
                        <h2 class="text-lg font-semibold">Booking Reference</h2>
                        <p class="text-gray-600">Keep this for your records</p>
                    </div>
                    <div class="text-xl font-mono font-bold text-primary">{{ $booking->booking_reference }}</div>
                </div>
                
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-neutral">Booking Details</h3>
                    
                    <div class="grid grid-cols-2 gap-y-3 text-sm">
                        <div class="font-medium">Service Type:</div>
                        <div>{{ $serviceName[$booking->service_type] }}</div>
                        
                        <div class="font-medium">Number of Eggs:</div>
                        <div>{{ $booking->egg_quantity }}</div>
                        
                        <div class="font-medium">Start Date:</div>
                        <div>{{ date('F j, Y', strtotime($booking->start_date)) }}</div>
                        
                        <div class="font-medium">Estimated Completion:</div>
                        <div>{{ date('F j, Y', strtotime($booking->start_date . ' + 28 days')) }}</div>
                        
                        <div class="font-medium">Total Price:</div>
                        <div class="font-semibold text-primary">₱{{ number_format($totalPrice, 2) }}</div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                    <h3 class="font-semibold text-yellow-800 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        Next Steps
                    </h3>
                    <ul class="mt-2 space-y-2 text-sm text-yellow-800">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-arrow-right mt-1"></i>
                            <span>Our team will contact you within 24 hours to confirm your booking and arrange payment.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-arrow-right mt-1"></i>
                            <span>A 50% deposit (₱{{ number_format($totalPrice * 0.5, 2) }}) is required to secure your booking.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-arrow-right mt-1"></i>
                            <span>Please prepare your eggs or coordinate with us for egg purchase.</span>
                        </li>
                    </ul>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <a href="{{ route('home') }}" class="flex-1 py-3 px-6 bg-gray-200 hover:bg-gray-300 text-center rounded-full font-medium transition-colors">
                        Return to Home
                    </a>
                    <a href="{{ route('booking.status', ['reference' => $booking->booking_reference]) }}" class="flex-1 py-3 px-6 bg-primary text-white text-center rounded-full font-medium hover:bg-opacity-90 transition-colors">
                        Check Booking Status
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection