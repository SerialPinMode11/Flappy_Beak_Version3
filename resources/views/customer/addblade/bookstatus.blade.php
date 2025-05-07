@extends('layouts.default')

@section('title', 'Check Booking Status')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Check Booking Status</h1>
        
        @if(session()->has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                {{ session()->get('error') }}
            </div>
        @endif
        
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-neutral to-accent text-white">
                <h2 class="text-xl font-semibold">Enter Your Booking Reference</h2>
                <p class="text-sm opacity-90 mt-1">Check the status of your incubation service booking</p>
            </div>
            
            <div class="p-6">
                <form action="{{ route('booking.status') }}" method="GET" class="space-y-4">
                    <div>
                        <label for="reference" class="block text-sm font-medium text-gray-700 mb-1">Booking Reference Number</label>
                        <input type="text" id="reference" name="reference" placeholder="e.g. INC-16234567891234" required
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>
                    
                    <button type="submit" class="w-full bg-primary text-white py-3 px-6 rounded-full font-medium hover:bg-opacity-90 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i>
                        Check Status
                    </button>
                </form>
            </div>
        </div>
        
        @if(isset($booking))
            <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                    <h2 class="text-xl font-semibold">Booking Status</h2>
                    <p class="text-sm opacity-90 mt-1">Reference: {{ $booking->booking_reference }}</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold">Current Status</h3>
                            <p class="text-sm text-gray-600">Last updated: {{ $booking->updated_at->format('F j, Y, g:i a') }}</p>
                        </div>
                        
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'confirmed' => 'bg-blue-100 text-blue-800',
                                'in_progress' => 'bg-purple-100 text-purple-800',
                                'candling' => 'bg-indigo-100 text-indigo-800',
                                'lockdown' => 'bg-orange-100 text-orange-800',
                                'hatching' => 'bg-green-100 text-green-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
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
                            
                            $statusColor = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800';
                            $statusLabel = $statusLabels[$booking->status] ?? 'Unknown';
                        @endphp
                        
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                    
                    <div class="border-t pt-4">
                        <h3 class="font-semibold mb-3">Incubation Progress</h3>
                        
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
                                    <span class="text-xs font-semibold inline-block text-primary">
                                        Day {{ $daysElapsed }} of {{ $totalDays }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold inline-block text-primary">
                                        {{ $progressPercent }}%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                                <div style="width:{{ $progressPercent }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary"></div>
                            </div>
                            
                            <div class="flex justify-between mb-1">
                                @foreach($phases as $phase)
                                    <div class="text-center">
                                        <div class="relative">
                                            <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center {{ $phase['status'] == 'completed' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-400' }}">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            @if(!$loop->last)
                                                <div class="absolute top-4 w-full h-0.5 {{ $phase['status'] == 'completed' ? 'bg-primary' : 'bg-gray-200' }}"></div>
                                            @endif
                                        </div>
                                        <span class="text-xs mt-1 block {{ $phase['status'] == 'completed' ? 'text-primary font-medium' : 'text-gray-500' }}">
                                            {{ $phase['name'] }}
                                        </span>
                                        <span class="text-xs text-gray-400">Day {{ $phase['day'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4">
                        <h3 class="font-semibold mb-3">Booking Details</h3>
                        
                        <div class="grid grid-cols-2 gap-y-3 text-sm">
                            <div class="font-medium">Service Type:</div>
                            <div>{{ $serviceName[$booking->service_type] ?? $booking->service_type }}</div>
                            
                            <div class="font-medium">Number of Eggs:</div>
                            <div>{{ $booking->egg_quantity }}</div>
                            
                            <div class="font-medium">Start Date:</div>
                            <div>{{ date('F j, Y', strtotime($booking->start_date)) }}</div>
                            
                            <div class="font-medium">Expected Completion:</div>
                            <div>{{ date('F j, Y', strtotime($booking->start_date . ' + 28 days')) }}</div>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4">
                        <h3 class="font-semibold mb-3">Need Help?</h3>
                        <p class="text-sm text-gray-600">If you have any questions about your booking, please contact us:</p>
                        <div class="flex items-center gap-4 mt-2">
                            <a href="tel:+639776193200" class="text-primary hover:text-primary-dark transition-colors flex items-center gap-2">
                                <i class="fas fa-phone"></i>
                                <span>+63 977 6193 200</span>
                            </a>
                            <a href="mailto:jmcasabar@gmail.com" class="text-primary hover:text-primary-dark transition-colors flex items-center gap-2">
                                <i class="fas fa-envelope"></i>
                                <span>jmcasabar@gmail.com</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection