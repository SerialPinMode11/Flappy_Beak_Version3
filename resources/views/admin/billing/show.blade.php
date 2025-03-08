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
                    <span class="font-medium">{{ $billing->address }}, {{ $billing->city }}, {{ $billing->zip }}</span>
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
                        @if($billing->status == 'completed') bg-green-100 text-green-800 
                        @elseif($billing->status == 'pending') bg-yellow-100 text-yellow-800 
                        @elseif($billing->status == 'processing') bg-blue-100 text-blue-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($billing->status) }}
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
</div>
@endsection