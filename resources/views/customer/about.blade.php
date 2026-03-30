@extends('layouts.public-site')

@section('title', 'About — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@section('content')
    @php
        $a = $publicOthers['about'] ?? [];
        $storeName = $publicContent['store_name'] ?? 'JM Casabar Mini Farm';
    @endphp

    <div class="border-b border-stone-200/60 bg-gradient-to-br from-cream via-[#f5f2ea] to-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-deep/90 mb-3">Our farm</p>
            <h1 class="font-serif text-3xl sm:text-4xl font-semibold text-forest leading-tight">About {{ $storeName }}</h1>
            <p class="mt-4 max-w-2xl text-stone-600 text-base sm:text-lg leading-relaxed">
                Heritage practices, careful stewardship, and produce we are proud to share with our customers.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
        <div class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-8 sm:p-10 mb-12 sm:mb-14">
            <h2 class="font-serif text-2xl sm:text-3xl font-semibold text-forest mb-6">{{ $a['story_title'] ?? 'Our Story' }}</h2>
            <p class="text-stone-600 leading-relaxed mb-6">
                {{ $a['story_p1'] ?? '' }}
            </p>
            <p class="text-stone-600 leading-relaxed">
                {{ $a['story_p2'] ?? '' }}
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
            <div class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8 text-center">
                <div class="w-16 h-16 bg-forest text-gold-pale rounded-full flex items-center justify-center mx-auto mb-5 ring-2 ring-gold/25">
                    <i class="fas fa-heart text-2xl"></i>
                </div>
                <h3 class="font-serif text-xl font-semibold text-forest mb-3">{{ $a['card1_title'] ?? 'Quality First' }}</h3>
                <p class="text-stone-600 text-sm leading-relaxed">{{ $a['card1_text'] ?? '' }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8 text-center">
                <div class="w-16 h-16 bg-forest-light text-gold-pale rounded-full flex items-center justify-center mx-auto mb-5 ring-2 ring-gold/25">
                    <i class="fas fa-leaf text-2xl"></i>
                </div>
                <h3 class="font-serif text-xl font-semibold text-forest mb-3">{{ $a['card2_title'] ?? 'Sustainability' }}</h3>
                <p class="text-stone-600 text-sm leading-relaxed">{{ $a['card2_text'] ?? '' }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8 text-center">
                <div class="w-16 h-16 bg-forest-dark text-gold-pale rounded-full flex items-center justify-center mx-auto mb-5 ring-2 ring-gold/25">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <h3 class="font-serif text-xl font-semibold text-forest mb-3">{{ $a['card3_title'] ?? 'Community' }}</h3>
                <p class="text-stone-600 text-sm leading-relaxed">{{ $a['card3_text'] ?? '' }}</p>
            </div>
        </div>
    </div>
@endsection
