@extends('layouts.default')

@section('title', 'Book Incubation Services')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Book Incubation Services</h1>
        
        @if(session()->has('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session()->get('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <p class="font-semibold">Please correct the following errors:</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-neutral to-accent text-white">
                <h2 class="text-xl font-semibold">Incubation Service Booking</h2>
                <p class="text-sm opacity-90 mt-1">Fill out the form below to book our professional incubation services</p>
            </div>
            
            <form action="{{ route('booking.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                
                <!-- Personal Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-neutral border-b pb-2">Personal Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        </div>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        </div>
                    </div>
                </div>
                
                <!-- Service Details -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-neutral border-b pb-2">Service Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="service_type" class="block text-sm font-medium text-gray-700 mb-1">Incubation Service Type *</label>
                            <select id="service_type" name="service_type" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                                <option value="">Select a service</option>
                                @foreach($incubationServices as $value => $label)
                                    <option value="{{ $value }}" {{ old('service_type') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="egg_quantity" class="block text-sm font-medium text-gray-700 mb-1">Number of Eggs *</label>
                            <input type="number" id="egg_quantity" name="egg_quantity" value="{{ old('egg_quantity') }}" min="1" max="300" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                            <p class="text-xs text-gray-500 mt-1">Price is calculated per batch of 30 eggs</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="egg_source" class="block text-sm font-medium text-gray-700 mb-1">Egg Source *</label>
                            <select id="egg_source" name="egg_source" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                                <option value="">Select egg source</option>
                                <option value="own_farm" {{ old('egg_source') == 'own_farm' ? 'selected' : '' }}>Own Farm</option>
                                <option value="jm_casabar" {{ old('egg_source') == 'jm_casabar' ? 'selected' : '' }}>JM Casabar Pekin Store</option>
                                <option value="other_supplier" {{ old('egg_source') == 'other_supplier' ? 'selected' : '' }}>Other Supplier</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Preferred Start Date *</label>
                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        </div>
                    </div>
                    
                    <div>
                        <label for="special_instructions" class="block text-sm font-medium text-gray-700 mb-1">Special Instructions</label>
                        <textarea id="special_instructions" name="special_instructions" rows="4"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors">{{ old('special_instructions') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">For custom formulas, please specify your requirements here</p>
                    </div>
                </div>
                
                <!-- Service Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-neutral mb-3">Service Information</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="font-medium">JM Casabar Formula:</div>
                            <div>₱1,500 per batch of 30 eggs</div>
                            
                            <div class="font-medium">Custom Formula:</div>
                            <div>₱2,200 per batch of 30 eggs</div>
                            
                            <div class="font-medium">Experimental Formula:</div>
                            <div>₱2,800 per batch of 30 eggs</div>
                            
                            <div class="font-medium">World-Based Formula:</div>
                            <div>₱2,500 per batch of 30 eggs</div>
                        </div>
                        
                        <div class="text-xs text-gray-600 mt-2">
                            <p>* Incubation period is approximately 28 days for duck eggs</p>
                            <p>* You will be notified when hatching begins</p>
                            <p>* Pickup or delivery arrangements will be made after successful hatching</p>
                        </div>
                    </div>
                </div>
                
                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required
                            class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-gray-700">I agree to the terms and conditions *</label>
                        <p class="text-gray-500">I understand that incubation success rates depend on egg quality and other factors. I agree to pay 50% deposit upon booking confirmation.</p>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-primary text-white py-3 px-6 rounded-full font-medium hover:bg-opacity-90 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-calendar-check"></i>
                        Book Incubation Service
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Additional Information -->
        <div class="mt-8 bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-neutral mb-4">What to Expect After Booking</h3>
            
            <div class="space-y-4">
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">Confirmation</h4>
                        <p class="text-sm text-gray-600">You'll receive a booking confirmation with payment instructions within 24 hours.</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">Payment</h4>
                        <p class="text-sm text-gray-600">50% deposit is required to secure your booking, with the balance due upon successful hatching.</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary">
                        <i class="fas fa-egg"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">Egg Delivery/Drop-off</h4>
                        <p class="text-sm text-gray-600">Arrange to deliver your eggs or purchase them directly from us.</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">Progress Updates</h4>
                        <p class="text-sm text-gray-600">Receive regular updates on the incubation progress, including candling results.</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary">
                        <i class="fas fa-baby"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">Hatching</h4>
                        <p class="text-sm text-gray-600">We'll notify you when hatching begins and is complete.</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary">
                        <i class="fas fa-home"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">Pickup/Delivery</h4>
                        <p class="text-sm text-gray-600">Arrange for pickup or delivery of your newly hatched ducklings.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Calculate and display estimated price
    const serviceTypeSelect = document.getElementById('service_type');
    const eggQuantityInput = document.getElementById('egg_quantity');
    
    function updatePrice() {
        const serviceType = serviceTypeSelect.value;
        const eggQuantity = parseInt(eggQuantityInput.value) || 0;
        
        if (!serviceType || eggQuantity <= 0) return;
        
        const pricePerBatch = {
            'jm_casabar': 1500,
            'custom': 2200,
            'experimental': 2800,
            'world_based': 2500
        };
        
        const batchSize = 30;
        const batches = Math.ceil(eggQuantity / batchSize);
        const totalPrice = pricePerBatch[serviceType] * batches;
        
        // You could display this price somewhere on the form if desired
        console.log(`Estimated price: ₱${totalPrice}`);
    }
    
    serviceTypeSelect.addEventListener('change', updatePrice);
    eggQuantityInput.addEventListener('input', updatePrice);
</script>
@endpush