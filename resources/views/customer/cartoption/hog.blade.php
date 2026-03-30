@extends('layouts.public-site')

@section('title', 'Cart — Hog — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <div class="mb-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-deep/90 mb-2">Prime cut</p>
            <h2 class="font-serif text-2xl sm:text-3xl font-semibold text-forest">Your cart — hog</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-md border border-stone-200/80 overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-cream/80 border-b border-stone-200/80">
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-600 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-600 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-600 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-600 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200/80">
                    @php $total = 0 @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full mr-3 ring-1 ring-stone-200" src="{{ asset($details['image']) }}" alt="{{ $details['name'] }}">
                                        <div class="text-sm font-medium text-stone-900">{{ $details['name'] }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-stone-800">₱{{ number_format($details['price'], 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" value="{{ $details['quantity'] }}" min="1" class="w-16 px-2 py-1 border border-stone-200 rounded-lg focus:ring-2 focus:ring-gold/40 focus:border-forest">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-stone-800">₱{{ number_format($details['price'] * $details['quantity'], 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('cart.remove.wine') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="text-red-600 hover:text-red-800">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-6">
            <a href="{{ route('home') }}" class="text-forest hover:underline font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Continue shopping
            </a>
            <div class="text-left sm:text-right">
                <p class="text-lg font-semibold text-forest">Subtotal: <span class="text-gold-deep">₱{{ number_format($total, 2) }}</span></p>
                <p class="text-sm text-stone-500 mb-4">Taxes and shipping calculated at checkout</p>
                <a href="{{ route('checkout') }}" class="inline-flex items-center justify-center bg-forest text-white px-6 py-3 rounded-xl hover:bg-forest-dark transition-colors font-medium shadow-sm">
                    Proceed to checkout
                </a>
            </div>
        </div>
    </div>
@endsection
