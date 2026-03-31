@extends('layouts.public-site')

@section('title', 'Incubation — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@section('content')
    @php
        $inc = $publicContent['others']['incubation_page'] ?? (\App\Models\PublicPageSetting::othersDefaults()['incubation_page'] ?? []);
        $services = $inc['services'] ?? [];
        $factors = $inc['factors'] ?? [];
        $whyItems = $inc['why_items'] ?? [];

        $imgUrl = function ($path) {
            $path = (string) $path;
            if ($path === '') return asset('images/fav-icon.png');
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;
            if (str_starts_with($path, 'public-page/')) return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
            return asset($path);
        };
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-deep/90 mb-2">{{ $inc['eyebrow'] ?? 'Heritage hatch' }}</p>
            <h1 class="font-serif text-2xl sm:text-3xl font-semibold text-forest">{{ $inc['title'] ?? 'Incubator services' }}</h1>
        </div>

        <div class="flex-1">
            @if(session()->has('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50/90 text-emerald-900 text-sm px-4 py-3 mb-6 flex gap-3 items-start">
                    <i class="fas fa-check-circle mt-0.5 text-emerald-600"></i>
                    <span>{{ session()->get('success') }}</span>
                </div>
            @elseif(session()->has('error'))
                <div class="rounded-xl border border-red-200 bg-red-50/90 text-red-900 text-sm px-4 py-3 mb-6 flex gap-3 items-start">
                    <i class="fas fa-exclamation-circle mt-0.5 text-red-600"></i>
                    <span>{{ session()->get('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8 mb-12">
                @foreach($services as $service)
                    @php
                        $rating = (float) ($service['rating'] ?? 5);
                        $full = (int) floor($rating);
                        $half = ($rating - $full) >= 0.5;
                    @endphp
                    <div class="product-card bg-white rounded-2xl border border-stone-200/80 shadow-md p-4 relative group">
                        <span class="absolute top-4 left-4 bg-forest-light text-white text-sm px-3 py-1 rounded-full font-semibold">
                            {{ $service['badge'] ?? 'Premium' }}
                        </span>
                        <button class="absolute top-4 right-4 text-stone-400 hover:text-forest transition-colors" type="button">
                            <i class="far fa-heart text-xl"></i>
                        </button>
                        <div class="relative mb-4">
                            <img src="{{ $imgUrl($service['image'] ?? '') }}" alt="{{ $service['title'] ?? 'Incubation service' }}"
                                class="w-full h-64 object-cover rounded-xl ring-1 ring-stone-200/60">
                            <button class="quick-view absolute bottom-4 right-4 bg-white p-3 rounded-full shadow-md hover:bg-forest hover:text-gold-pale transition-colors" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-serif font-semibold text-lg text-forest">{{ $service['title'] ?? '' }}</h3>
                            <p class="text-sm text-stone-600">{{ $service['description'] ?? '' }}</p>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-forest font-bold text-xl">{{ $service['price'] ?? '' }}</span>
                                    <span class="text-stone-500 text-sm">{{ $service['price_note'] ?? '' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="star-rating flex">
                                        @for($i=0; $i<5; $i++)
                                            @if($i < $full)
                                                <i class="fas fa-star"></i>
                                            @elseif($half && $i === $full)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-stone-500 ml-2">({{ $service['reviews'] ?? '0' }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Incubation Services Information -->
            <div class="bg-white rounded-2xl border border-stone-200/80 p-6 sm:p-8 mb-12 shadow-md">
                <h2 class="font-serif text-2xl font-semibold text-forest mb-4">{{ $inc['details_title'] ?? 'Our incubation services' }}</h2>
                <p class="mb-4">{{ $inc['details_text'] ?? '' }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                    @foreach($factors as $factor)
                        <div class="bg-cream/80 border border-stone-200/60 p-4 rounded-xl">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="{{ $factor['icon'] ?? 'fas fa-circle' }} text-forest text-xl"></i>
                                <h3 class="font-semibold">{{ $factor['title'] ?? '' }}</h3>
                            </div>
                            <p class="text-sm text-stone-600">{{ $factor['description'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 bg-gold/10 border border-gold/25 p-4 rounded-xl">
                    <h3 class="font-semibold text-forest mb-2">{{ $inc['why_title'] ?? 'Why choose our incubation services?' }}</h3>
                    <ul class="list-disc list-inside text-sm text-stone-600 space-y-1">
                        @foreach($whyItems as $why)
                            @if(trim((string) $why) !== '')
                                <li>{{ $why }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{route('booking.index')}}"
                        class="inline-flex items-center gap-2 bg-forest text-white px-6 py-3 rounded-xl font-medium hover:bg-forest-dark transition-colors shadow-sm">
                        <i class="fas fa-calendar-check"></i>
                        {{ $inc['book_button'] ?? 'Book Incubation Service' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
