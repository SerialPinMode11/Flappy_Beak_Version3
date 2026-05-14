@extends('layouts.static')

@section('title', 'Billing Details - Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold">Billing Details #{{ $billing->id }}</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.billing.edit', $billing->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition-colors">
                Edit
            </a>
            <a href="{{ route('admin.billing.index') }}" class="bg-gray-200 px-4 py-2 rounded-md hover:bg-gray-300 transition-colors">
                Back to List
            </a>
        </div>
    </div>

    {{-- 1. Customer Information, Payment, and Order Status --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
            
            <div class="space-y-3">
                <div>
                    <span class="block text-sm text-gray-500">Name</span>
                    <span class="font-medium">{{ $billing->name }}</span>
                </div>
                
                <div>
                    <span class="block text-sm text-gray-500">Email</span>
                    <span class="font-medium">{{ $billing->email }}</span>
                </div>
                
                <div>
                    <span class="block text-sm text-gray-500">Address</span>
                    <span class="font-medium">{{ $billing->address }}</span>
                </div>

                <div>
                    <span class="block text-sm text-gray-500">City</span>
                    <span class="font-medium">{{ $billing->city }}</span>
                </div>

                <div>
                    <span class="block text-sm text-gray-500">ZIP Code</span>
                    <span class="font-medium">{{ $billing->zip }}</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Payment Information</h3>
            
            <div class="space-y-3">
                <div>
                    <span class="block text-sm text-gray-500">Payment Method</span>
                    <span class="font-medium">{{ ucfirst($billing->payment_method) }}</span>
                </div>
                
                @if($billing->online_payment_method)
                <div>
                    <span class="block text-sm text-gray-500">Online Payment Method</span>
                    <span class="font-medium">{{ ucfirst($billing->online_payment_method) }}</span>
                </div>
                @endif
                
                @if($billing->reference_number)
                <div>
                    <span class="block text-sm text-gray-500">Reference Number</span>
                    <span class="font-medium">{{ $billing->reference_number }}</span>
                </div>
                @endif
                
                <div>
                    <span class="block text-sm text-gray-500">Total Amount</span>
                    <span class="font-medium text-lg text-primary">₱{{ number_format($billing->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Order Status</h3>
            
            <div class="space-y-3">
                <div>
                    <span class="block text-sm text-gray-500">Status</span>
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if(in_array($billing->status, ['completed', 'delivered'])) bg-green-100 text-green-800
                        @elseif($billing->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($billing->status == 'preparing') bg-amber-100 text-amber-800
                        @elseif($billing->status == 'processing') bg-blue-100 text-blue-800
                        @elseif($billing->status == 'out_for_delivery') bg-purple-100 text-purple-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucwords(str_replace('_', ' ', $billing->status)) }}
                    </span>
                </div>
                
                <div>
                    <span class="block text-sm text-gray-500">Order Date</span>
                    <span class="font-medium">{{ $billing->created_at->format('F d, Y h:i A') }}</span>
                </div>
                
                <div>
                    <span class="block text-sm text-gray-500">Last Updated</span>
                    <span class="font-medium">{{ $billing->updated_at->format('F d, Y h:i A') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Purchased Products --}}
    @if(is_array($billing->items) && count($billing->items) > 0)
    <div class="mt-6 bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Purchased Products</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Line Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($billing->items as $item)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $item['name'] ?? 'Product' }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-right">
                            ₱{{ number_format($item['price'] ?? 0, 2) }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-right">
                            {{ $item['quantity'] ?? 0 }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-right">
                            ₱{{ number_format($item['total'] ?? 0, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- 3. Delivery Address --}}
    <div class="mt-6 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl shadow-md p-6">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-truck text-amber-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Delivery Address</h3>
                    <p class="text-sm text-gray-500 mb-3">Where to deliver this order</p>
                    <div class="space-y-2">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-map-marker-alt text-amber-500 mt-1 w-4 text-center"></i>
                            <span class="font-medium text-gray-900 text-base">{{ $billing->address }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-city text-amber-500 w-4 text-center"></i>
                            <span class="font-medium text-gray-800">{{ $billing->city }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-mail-bulk text-amber-500 w-4 text-center"></i>
                            <span class="font-medium text-gray-800">{{ $billing->zip }}</span>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-amber-200/60">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-user text-gray-400 mr-1"></i>
                            <strong>{{ $billing->name }}</strong> — {{ $billing->email }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-2 flex-shrink-0">
                <button type="button" onclick="copyAddress()" class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium bg-white border border-amber-300 rounded-lg hover:bg-amber-50 transition-colors text-amber-700" title="Copy full address">
                    <i class="fas fa-copy"></i> Copy
                </button>
                <a href="https://www.google.com/maps/search/{{ urlencode($billing->address . ', ' . $billing->city . ', ' . $billing->zip) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium bg-white border border-amber-300 rounded-lg hover:bg-amber-50 transition-colors text-amber-700" title="Open in Google Maps">
                    <i class="fas fa-map"></i> Map
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function copyAddress() {
    var address = @json($billing->address . ', ' . $billing->city . ', ' . $billing->zip);
    navigator.clipboard.writeText(address).then(function() {
        var btn = event.currentTarget;
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
        btn.classList.add('bg-green-50', 'border-green-300', 'text-green-700');
        setTimeout(function() {
            btn.innerHTML = original;
            btn.classList.remove('bg-green-50', 'border-green-300', 'text-green-700');
        }, 2000);
    });
}
</script>
@endsection
