@extends('layouts.default')

@section('title', 'Order Successful - Flappy Beak')

@section('content')
<main class="flex-grow container mx-auto px-4 py-16">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-emerald-50 px-8 pt-10 pb-6 text-center">
            <div class="w-20 h-20 mx-auto rounded-full bg-emerald-100 flex items-center justify-center mb-4">
                <i class="fas fa-check text-emerald-600 text-4xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-neutral mb-2">Order Successful!</h1>
            <p class="text-gray-600 text-sm">
                Thank you for your order. We've received your payment and will process your order shortly.
            </p>
        </div>
        <div class="p-8 flex flex-col sm:flex-row justify-center gap-3">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 bg-primary text-white px-6 py-3 rounded-xl hover:bg-red-600 transition-colors font-medium shadow-sm">
                <i class="fas fa-home"></i> Return Home
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 border-2 border-gray-200 text-gray-700 px-6 py-3 rounded-xl hover:border-primary hover:text-primary transition-colors font-medium">
                <i class="fas fa-envelope"></i> Contact Us
            </a>
        </div>
    </div>
</main>
@endsection