@extends('layouts.public-site')

@section('title', 'Products — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
    <div class="text-center max-w-2xl mx-auto">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-deep/90 mb-3">Catalog</p>
        <h1 class="font-serif text-3xl sm:text-4xl font-semibold text-forest mb-4">Products</h1>
        <p class="text-stone-600 leading-relaxed mb-8">
            Browse curated heritage items from the shop home. This page is reserved for future catalog views.
        </p>
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 bg-forest text-white px-6 py-3 rounded-xl hover:bg-forest-dark transition-colors font-medium">
            <i class="fas fa-arrow-left"></i> Back to shop
        </a>
    </div>
</div>
@endsection
