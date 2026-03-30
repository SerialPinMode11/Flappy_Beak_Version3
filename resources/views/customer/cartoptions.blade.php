@extends('layouts.public-site')

@section('title', 'Cart — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <div class="mb-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-deep/90 mb-2">Your cart</p>
            <h2 class="font-serif text-2xl sm:text-3xl font-semibold text-forest">Choose a category</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            <div class="bg-white p-6 rounded-2xl shadow-md border border-stone-200/80 hover:border-gold/40 transition-colors">
                <a href="{{ route('cart.view') }}" class="block">
                    <img src="{{ asset('images/the-cart.jpg') }}" alt="Farm products" class="w-full h-32 object-cover rounded-xl mb-4 ring-1 ring-stone-200/80">
                </a>
                <h3 class="font-serif text-xl font-semibold text-forest mb-2">Your cart</h3>
                <a href="{{ route('cart.view') }}" class="text-stone-600 hover:text-forest transition-colors font-medium">View your products &rarr;</a>
            </div>
        </div>
    </div>
@endsection
