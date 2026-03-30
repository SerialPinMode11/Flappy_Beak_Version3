@extends('layouts.public-site')

@section('title', 'Wine — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-deep/90 mb-2">The Cellar</p>
            <h1 class="font-serif text-2xl sm:text-3xl font-semibold text-forest">Wine products</h1>
        </div>

        <div class="flex flex-wrap justify-center gap-2 md:gap-3 mb-10">
            <a href="{{ route('home') }}" class="px-5 py-2.5 bg-gold text-forest rounded-full text-sm font-medium hover:bg-gold-deep/90 transition-colors flex items-center gap-2 shadow-sm">
                <i class="fas fa-egg"></i>
                Duck products
            </a>
            <a href="{{ route('wine.home') }}" class="px-5 py-2.5 bg-forest text-white rounded-full text-sm font-medium hover:bg-forest-dark transition-colors flex items-center gap-2 shadow-sm ring-2 ring-gold/30">
                <i class="fas fa-wine-bottle"></i>
                Wine products
            </a>
            <a href="{{ route('home.incubator') }}" class="px-5 py-2.5 bg-forest-light text-white rounded-full text-sm font-medium hover:opacity-95 transition-colors flex items-center gap-2">
                <i class="fas fa-temperature-high"></i>
                Incubator
            </a>
            <a href="{{ route('hog.home') }}" class="px-5 py-2.5 bg-stone-700 text-white rounded-full text-sm font-medium hover:bg-stone-800 transition-colors flex items-center gap-2">
                <i class="fas fa-piggy-bank"></i>
                Hog products
            </a>
        </div>

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
            @foreach($wine_products as $product)
                <div class="product-card bg-white rounded-2xl p-4 relative group border border-stone-200/80 shadow-md hover:border-gold/35 transition-colors">
                    <span class="absolute top-4 left-4 bg-forest text-gold-pale text-xs px-3 py-1 rounded-full font-semibold z-10">Featured</span>
                    <button type="button" class="absolute top-4 right-4 text-stone-400 hover:text-forest transition-colors z-10" aria-label="Favorite">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                    <div class="relative mb-4">
                        <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}"
                            class="w-full h-64 object-cover rounded-xl ring-1 ring-stone-200/60">
                        <a href="{{ route('customer.wine.view', $product->id) }}"
                            class="quick-view absolute bottom-4 right-4 bg-white p-3 rounded-full shadow-md hover:bg-forest hover:text-gold-pale transition-colors text-forest"
                            aria-label="View product">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-serif font-semibold text-lg text-forest">{{ $product->product_name }}</h3>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-gold-deep font-bold text-xl">₱{{ $product->product_price }}</span>
                            </div>
                            <div class="flex items-center text-amber-500">
                                <div class="star-rating flex text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-stone-500 ml-2 text-sm">(88)</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            if (slides[index]) slides[index].classList.add('active');
            if (dots[index]) dots[index].classList.add('active');
        }

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

        if (slides.length && dots.length) {
            setInterval(() => {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }, 5000);
        }
    </script>
@endpush
