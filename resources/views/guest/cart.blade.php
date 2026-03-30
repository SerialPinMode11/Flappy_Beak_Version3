@extends('layouts.public-site')

@section('title', 'Your bag — JM Casabar Mini Farm')

@push('styles')
<style>
    .cart-table-wrap { overflow-x: auto; }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
    <h1 class="font-serif text-3xl md:text-4xl text-forest font-semibold mb-2">Your bag</h1>
    <p class="text-stone-600 text-sm mb-8">Review items saved in your session. Sign in when you’re ready to check out.</p>

    @php
        $cart = $cart ?? session('cart', []);
        $total = 0;
    @endphp

    @if(empty($cart))
        <div class="bg-white rounded-2xl border border-stone-200 shadow-sm p-10 text-center">
            <i class="fas fa-shopping-bag text-4xl text-stone-300 mb-4"></i>
            <p class="text-stone-600 mb-6">Your bag is empty.</p>
            <a href="{{ url('/') }}#products" class="inline-flex items-center justify-center px-6 py-3 bg-forest text-white font-medium rounded-lg hover:bg-forest-light transition-colors">
                Browse products
            </a>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden cart-table-wrap">
            <table class="w-full min-w-[640px]">
                <thead>
                    <tr class="bg-cream border-b border-stone-200">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider">Price</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider">Qty</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider">Total</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-stone-500 uppercase tracking-wider"> </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach($cart as $id => $details)
                        @php
                            $line = (float) ($details['price'] ?? 0) * (int) ($details['quantity'] ?? 0);
                            $total += $line;
                            $imgPath = $details['image'] ?? null;
                            $img = $imgPath ? asset($imgPath) : asset('images/pekin-young-alive.jpg');
                            $isWine = ($details['type'] ?? '') === 'wine';
                        @endphp
                        <tr>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $img }}" alt="" class="h-12 w-12 rounded-lg object-cover border border-stone-100">
                                    <span class="font-medium text-stone-900 text-sm">{{ $details['name'] ?? 'Product' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-stone-700">₱{{ number_format((float) ($details['price'] ?? 0), 2) }}</td>
                            <td class="px-4 py-4">
                                <form action="{{ route('cart.update-quantity') }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ (int) ($details['quantity'] ?? 1) }}" min="1" class="w-16 px-2 py-1.5 border border-stone-200 rounded-md text-sm" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="px-4 py-4 text-sm font-medium text-stone-900">₱{{ number_format($line, 2) }}</td>
                            <td class="px-4 py-4 text-right">
                                <form action="{{ $isWine ? route('cart.remove.wine') : route('cart.remove') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-8">
            <div class="rounded-xl border border-amber-200 bg-amber-50/80 px-4 py-3 text-sm text-amber-950 max-w-xl">
                <p class="font-semibold mb-1"><i class="fas fa-lock mr-2"></i>Checkout requires an account</p>
                <p class="text-amber-900/90">Sign in to complete your order and enter delivery details. Your bag is kept until you clear it or check out.</p>
            </div>
            <div class="w-full lg:max-w-sm bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
                <p class="text-sm text-stone-500 mb-1">Subtotal</p>
                <p class="text-2xl font-serif font-semibold text-forest mb-4">₱{{ number_format($total, 2) }}</p>
                <p class="text-xs text-stone-500 mb-6">Taxes and shipping are calculated at checkout after you sign in.</p>
                <a href="{{ route('login') }}" class="block w-full text-center px-6 py-3.5 bg-forest text-white font-semibold rounded-lg hover:bg-forest-light transition-colors mb-3">
                    Log in to checkout
                </a>
                <a href="{{ url('/') }}#products" class="block w-full text-center px-6 py-3 border border-stone-300 rounded-lg text-stone-700 font-medium hover:bg-cream transition-colors">
                    Continue shopping
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
