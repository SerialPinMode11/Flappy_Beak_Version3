@extends('layouts.default')

@section('title', 'Order Successful - Flappy Beak')

@section('content')
<main class="flex-grow container mx-auto px-4 py-16 text-center">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md p-8">
        <div class="text-green-500 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        
        <h2 class="text-2xl font-bold mb-4">Order Successful!</h2>
        
        <p class="text-gray-600 mb-6">
            Thank you for your order. We've received your payment and will process your order shortly.
        </p>
        
        <div class="flex justify-center gap-4">
            <a href="{{ route('home') }}" class="bg-primary text-white px-6 py-2 rounded-full hover:bg-primary-dark transition-colors">
                Return Home
            </a>
        </div>
    </div>
</main>
@endsection