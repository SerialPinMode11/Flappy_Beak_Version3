@extends('layouts.default')

@section('title', 'My Cart')

@section('content')
    <div class="flex-grow container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-8 text-neutral">Your Shopping Cart</h2>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php $total = 0 @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full mr-3" src="{{ asset($details['image']) }}" alt="{{ $details['name'] }}">
                                        <div class="text-sm font-medium text-gray-900">{{ $details['name'] }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">₱{{ $details['price'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" value="{{ $details['quantity'] }}" min="1" class="w-16 px-2 py-1 border rounded-md">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">₱{{ $details['price'] * $details['quantity'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-primary hover:underline">
                <i class="fas fa-arrow-left mr-2"></i>Continue Shopping
            </a>
            <div class="text-right">
                <p class="text-lg font-semibold">Subtotal: <span class="text-primary">₱{{ $total }}</span></p>
                <p class="text-sm text-gray-500 mb-4">Taxes and shipping calculated at checkout</p>
                <a href="{{ route('checkout') }}" class="bg-primary text-white px-6 py-3 rounded-full hover:bg-primary-dark transition-colors">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    </div>
@endsection