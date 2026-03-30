@extends('layouts.public-site')

@section('title', 'Shop — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@push('styles')
<style>
    .home-welcome-bg {
        background: linear-gradient(135deg, rgb(250 248 243) 0%, rgb(244 241 234) 50%, rgb(250 248 243) 100%);
    }
    .home-newsletter-bg {
        background-color: #ebe9e4;
        background-image: repeating-linear-gradient(
            -12deg,
            transparent,
            transparent 12px,
            rgb(0 0 0 / 0.02) 12px,
            rgb(0 0 0 / 0.02) 13px
        );
    }
</style>
@endpush

@section('content')
@php
    $pc = $publicContent ?? [];
    $storeName = $pc['store_name'] ?? 'JM Casabar Mini Farm';
    $user = auth()->user();
    $firstName = $user ? \Illuminate\Support\Str::of($user->name)->explode(' ')->first() : 'Guest';

    $typeTag = function (string $type): string {
        return match ($type) {
            'egg' => 'HERITAGE GRADE',
            'wine' => 'THE CELLAR',
            default => 'PRIME CUT',
        };
    };

    $productImage = function ($product): string {
        $path = $product->product_image ?? '';
        if ($path === '') {
            return asset('images/fav-icon.png');
        }
        return str_starts_with($path, 'http') ? $path : asset($path);
    };

    $productDesc = function ($product): string {
        $d = $product->product_description ?? '';
        return \Illuminate\Support\Str::limit(strip_tags($d), 120);
    };
@endphp

<div class="home-welcome-bg border-b border-stone-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-deep/90 mb-3">Farm Customer</p>
        <h1 class="font-serif text-3xl sm:text-4xl lg:text-[2.75rem] font-semibold text-forest leading-tight text-balance">
            Welcome back, {{ $firstName }}!
        </h1>
        <p class="mt-4 max-w-2xl text-stone-600 text-base sm:text-lg leading-relaxed">
            Our farm products selections are waiting for you. These days harvest has been exceptional today.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
    @if(session()->has('success'))
        <div class="mb-8 rounded-xl border border-emerald-200 bg-emerald-50/90 text-emerald-900 text-sm px-4 py-3 flex gap-3 items-start">
            <i class="fas fa-check-circle mt-0.5 text-emerald-600"></i>
            <span>{{ session()->get('success') }}</span>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="mb-8 rounded-xl border border-red-200 bg-red-50/90 text-red-900 text-sm px-4 py-3 flex gap-3 items-start">
            <i class="fas fa-exclamation-circle mt-0.5 text-red-600"></i>
            <span>{{ session()->get('error') }}</span>
        </div>
    @endif

    <div id="products" class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-8 sm:mb-10">
        <div class="min-w-0">
            <h2 class="font-serif text-2xl sm:text-3xl font-semibold text-forest">Curated Heritage</h2>
            <p class="mt-2 text-sm sm:text-base text-stone-600 max-w-xl leading-relaxed">
                Hand-selected cuts, eggs, and cellar releases — raised with care and prepared for your table.
            </p>
        </div>
        <div class="flex flex-wrap gap-2 shrink-0 justify-start sm:justify-end" role="group" aria-label="Filter products">
            <a href="{{ route('home', ['category' => 'all']) }}"
               class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors {{ ($currentCategory ?? 'all') === 'all' ? 'bg-forest text-white shadow-sm' : 'bg-white text-stone-600 border border-stone-200 hover:border-gold/40 hover:bg-cream' }}">
                All
            </a>
            <a href="{{ route('home', ['category' => 'duck']) }}"
               class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors {{ ($currentCategory ?? '') === 'duck' ? 'bg-forest text-white shadow-sm' : 'bg-white text-stone-600 border border-stone-200 hover:border-gold/40 hover:bg-cream' }}">
                Duck
            </a>
            <a href="{{ route('home', ['category' => 'wine']) }}"
               class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors {{ ($currentCategory ?? '') === 'wine' ? 'bg-forest text-white shadow-sm' : 'bg-white text-stone-600 border border-stone-200 hover:border-gold/40 hover:bg-cream' }}">
                Wine
            </a>
            <a href="{{ route('home', ['category' => 'egg']) }}"
               class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors {{ ($currentCategory ?? '') === 'egg' ? 'bg-forest text-white shadow-sm' : 'bg-white text-stone-600 border border-stone-200 hover:border-gold/40 hover:bg-cream' }}">
                Egg
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 lg:gap-10">
        @forelse($products as $item)
            @php
                $product = $item->product;
                $tag = $typeTag($item->type);
            @endphp
            <article class="group flex flex-col bg-white rounded-2xl border border-stone-200/80 shadow-sm hover:shadow-md hover:border-stone-300/90 transition-all duration-300 overflow-hidden">
                <a href="{{ route($item->detailRoute, $item->detailParam) }}" class="relative block aspect-[4/3] overflow-hidden bg-stone-100">
                    <img src="{{ $productImage($product) }}" alt="{{ $product->product_name }}"
                         class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-500">
                </a>
                <div class="flex flex-col flex-1 p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <a href="{{ route($item->detailRoute, $item->detailParam) }}" class="font-serif text-lg sm:text-xl font-semibold text-forest leading-snug group-hover:text-forest-light transition-colors min-w-0">
                            {{ $product->product_name }}
                        </a>
                        <span class="text-forest font-semibold text-lg shrink-0 tabular-nums">₱{{ number_format($product->product_price, 0) }}</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mb-3">
                        <div class="flex text-gold" aria-hidden="true">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-sm"></i>
                            @endfor
                        </div>
                        <span class="text-[0.65rem] font-semibold uppercase tracking-wider text-gold-deep/90">{{ $tag }}</span>
                    </div>
                    <p class="text-sm text-stone-600 leading-relaxed flex-1 line-clamp-3">
                        {{ $productDesc($product) ?: 'Farm-raised with care — quality you can taste in every batch.' }}
                    </p>
                    <a href="{{ route($item->detailRoute, $item->detailParam) }}"
                       class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-forest hover:text-gold-deep transition-colors">
                        View details <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-stone-300 bg-cream/50 px-6 py-16 text-center">
                <p class="text-stone-600 font-medium">No products in this category yet.</p>
                <a href="{{ route('home', ['category' => 'all']) }}" class="mt-4 inline-block text-sm font-semibold text-forest underline decoration-gold/50 underline-offset-4">Browse all products</a>
            </div>
        @endforelse
    </div>
</div>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 sm:pb-16">
    <div class="rounded-2xl sm:rounded-3xl overflow-hidden bg-forest text-white shadow-xl border border-forest-light/30">
        <div class="grid lg:grid-cols-2 gap-0 lg:gap-0 lg:items-stretch">
            <div class="relative min-h-[220px] lg:min-h-[320px] bg-forest-dark">
                <img src="{{ asset('images/Experimental.png') }}" alt=""
                     class="absolute inset-0 w-full h-full object-cover opacity-90 mix-blend-normal">
                <div class="absolute inset-0 bg-gradient-to-tr from-forest-dark/80 via-forest/40 to-transparent"></div>
            </div>
            <div class="p-8 sm:p-10 lg:p-12 flex flex-col justify-center">
                <span class="inline-flex self-start items-center rounded-md bg-gold/25 text-gold-pale text-[0.65rem] font-bold uppercase tracking-[0.15em] px-3 py-1.5 mb-4">Member exclusive</span>
                <h2 class="font-serif text-2xl sm:text-3xl font-semibold text-white leading-tight">Private Incubation Service</h2>
                <p class="mt-4 text-white/80 text-sm sm:text-base leading-relaxed max-w-lg">
                    Reserve capacity for your clutch with monitored temperature, humidity, and candling support — the same care we use for our own heritage lines.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="{{ route('home.incubator') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-gold px-6 py-3 text-sm font-semibold text-forest-dark shadow-md hover:bg-gold-pale transition-colors">
                        Reserve Now
                    </a>
                    <a href="{{ route('home.incubator') }}" class="text-sm font-medium text-gold-pale/95 hover:text-white underline underline-offset-4 decoration-gold/50">
                        Learn more
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- <section class="home-newsletter-bg border-t border-stone-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16 text-center">
        <h2 class="font-serif text-2xl sm:text-3xl font-semibold text-forest">Join the Conservatory Circle</h2>
        <p class="mt-3 max-w-xl mx-auto text-stone-600 text-sm sm:text-base leading-relaxed">
            Receive seasonal recipes, heritage updates, and priority access to our limited batches.
        </p>
        <form id="home-newsletter-form" class="mt-8 max-w-lg mx-auto flex flex-col sm:flex-row gap-3 sm:gap-0 sm:rounded-xl sm:overflow-hidden sm:border sm:border-stone-300 sm:bg-white sm:shadow-sm">
            <label for="newsletter-email" class="sr-only">Email</label>
            <input type="email" id="newsletter-email" name="email" autocomplete="email"
                   class="w-full flex-1 min-w-0 px-5 py-3.5 text-stone-800 bg-white border border-stone-300 sm:border-0 rounded-xl sm:rounded-none text-sm placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-gold/40"
                   placeholder="Enter your email" required>
            <button type="submit"
                    class="inline-flex justify-center items-center rounded-xl sm:rounded-none bg-forest px-8 py-3.5 text-sm font-semibold text-white hover:bg-forest-light transition-colors sm:shrink-0">
                JOIN
            </button>
        </form>
        <p class="mt-4 text-xs text-stone-500">We respect your inbox. <a href="{{ route('privacy-policy.page') }}" class="text-forest font-medium underline underline-offset-2">Privacy Policy</a></p>
    </div>
</section> --}}
@endsection

@push('scripts')
<script>
    (function () {
        var form = document.getElementById('home-newsletter-form');
        var email = document.getElementById('newsletter-email');
        if (!form || !email) return;
        var mailto = @json(($publicContent['contact_email'] ?? null) ?: 'jmcasabar@gmail.com');
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var v = (email.value || '').trim();
            if (!v) return;
            window.location.href = 'mailto:' + encodeURIComponent(mailto) +
                '?subject=' + encodeURIComponent('Conservatory Circle — newsletter') +
                '&body=' + encodeURIComponent('Please add this email to the Conservatory Circle list:\r\n\r\n' + v);
        });
    })();
</script>
@endpush
