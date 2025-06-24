@extends('layouts.default')

@section('title', 'My Cart - Options')

@section('content')
    <div class="flex-grow container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-8 text-neutral">Your Shopping Cart</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Duck Products Navigation -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="{{ asset('images/the-cart.jpg') }}" alt="Duck Products" class="w-full h-32 object-cover rounded mb-4">
                <h3 class="text-xl font-semibold mb-4 text-primary">Your Cart</h3>
                <a href="{{ route('cart.view') }}" class="text-neutral hover:text-primary transition-colors">View Your Products Availed</a>
            </div>

            <!-- Wine Products Navigation -->
            {{-- <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="{{ asset('images/macopa_wine.jpg') }}" alt="Wine Products" class="w-full h-32 object-cover rounded mb-4">
                <h3 class="text-xl font-semibold mb-4 text-primary">Wine Products</h3>
                <a href="{{ route('cart.wine.view') }}" class="text-neutral hover:text-primary transition-colors">View Wine Products</a>
            </div>

            <!-- Hog Products Navigation -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="{{ asset('images/Uncured_Duck_Breast.jpg') }}" alt="Duck Products" class="w-full h-32 object-cover rounded mb-4">
                <h3 class="text-xl font-semibold mb-4 text-primary">Hog Products</h3>
                <a href="{{ route('cart.hog.view') }}" class="text-neutral hover:text-primary transition-colors">View Hog Products</a>
            </div> --}}
        </div>
    </div>
@endsection