@extends('layouts.public-site')

@section('title', 'Order successful — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-md border border-stone-200/80 overflow-hidden">
        <div class="bg-emerald-50/90 px-8 pt-10 pb-6 text-center border-b border-emerald-100/80">
            <div class="w-20 h-20 mx-auto rounded-full bg-white ring-2 ring-emerald-200/80 flex items-center justify-center mb-4">
                <i class="fas fa-check text-emerald-700 text-4xl"></i>
            </div>
            <h1 class="font-serif text-2xl font-semibold text-forest mb-2">Order successful</h1>
            <p class="text-stone-600 text-sm">
                Thank you for your order. We've received your payment and will process your order shortly.
            </p>
        </div>
        <div class="p-8 flex flex-col sm:flex-row justify-center gap-3">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 bg-forest text-white px-6 py-3 rounded-xl hover:bg-forest-dark transition-colors font-medium shadow-sm">
                <i class="fas fa-home"></i> Return home
            </a>
            @if(!empty($lastBillingId))
                <a href="{{ route('checkout.track-item') }}" class="inline-flex items-center justify-center gap-2 bg-gold text-forest px-6 py-3 rounded-xl hover:bg-gold-deep/90 transition-colors font-medium">
                    <i class="fas fa-route"></i> Track order
                </a>
            @endif
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 border-2 border-stone-200 text-stone-700 px-6 py-3 rounded-xl hover:border-forest hover:text-forest transition-colors font-medium">
                <i class="fas fa-envelope"></i> Contact us
            </a>
        </div>
    </div>
</main>
@endsection
