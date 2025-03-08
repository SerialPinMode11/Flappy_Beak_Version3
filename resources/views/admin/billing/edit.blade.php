@extends('layouts.static')

@section('title', 'Edit Billing Information - Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold">Edit Billing Information</h2>
        <a href="{{ route('admin.billing.index') }}" class="bg-gray-200 px-4 py-2 rounded-md hover:bg-gray-300 transition-colors">
            Back to List
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('admin.billing.update', $billing->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $billing->name) }}" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $billing->email) }}" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $billing->address) }}" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary">
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" id="city" name="city" value="{{ old('city', $billing->city) }}" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary">
                            @error('city')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">ZIP Code</label>
                            <input type="text" id="zip" name="zip" value="{{ old('zip', $billing->zip) }}" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary">
                            @error('zip')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Order Information</h3>
                    
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                        <select id="status" name="status" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary">
                            <option value="pending" {{ old('status', $billing->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ old('status', $billing->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ old('status', $billing->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $billing->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <div class="p-2 border rounded-md bg-gray-50">
                            {{ ucfirst($billing->payment_method) }}
                            @if($billing->online_payment_method)
                                <span class="block text-sm text-gray-500 mt-1">
                                    {{ ucfirst($billing->online_payment_method) }}
                                    @if($billing->reference_number)
                                        (Ref: {{ $billing->reference_number }})
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
                        <div class="p-2 border rounded-md bg-gray-50 font-semibold">
                            ₱{{ number_format($billing->total_amount, 2) }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order Date</label>
                        <div class="p-2 border rounded-md bg-gray-50">
                            {{ $billing->created_at->format('F d, Y h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition-colors">
                    Update Billing Information
                </button>
            </div>
        </form>
    </div>
</div>
@endsection