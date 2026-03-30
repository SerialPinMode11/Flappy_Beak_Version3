<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $pcHead = $publicContent ?? [];
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ !empty($pcHead['store_name'] ?? null) ? $pcHead['store_name'] . ' — Farm-Raised Duck' : 'JM Casabar Mini Farm — Farm-Raised Duck' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        forest: { DEFAULT: '#1a3d2e', light: '#234d3a', dark: '#0f2419' },
                        gold: { DEFAULT: '#c9a227', pale: '#e8d48b', deep: '#8b6914' },
                        cream: '#faf8f3',
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: Inter, system-ui, sans-serif; }
        .font-serif { font-family: "Playfair Display", Georgia, serif; }
        .hero-bg {
            background-size: cover;
            background-position: center;
        }
        .heritage-img-wrap::before {
            content: '';
            position: absolute;
            inset: 12% -8% -8% 12%;
            background: #f5f0e6;
            border-radius: 0.75rem;
            z-index: 0;
        }
        .featured-track {
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .featured-track::-webkit-scrollbar { display: none; }
        .featured-card { scroll-snap-align: start; }
        #mobile-menu:not(.hidden) { animation: fadeIn 0.2s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        /* Toast sits over hero (upper-right), not under browser chrome */
        body.welcome-page #toast-container {
            top: max(6.5rem, 22vh);
            right: clamp(0.75rem, 3vw, 2rem);
            left: auto;
            width: min(22rem, calc(100vw - 1.5rem));
            max-width: min(22rem, calc(100vw - 1.5rem));
            align-items: flex-end;
        }
        body.welcome-page #toast-container .toast-item {
            animation: toast-hero-in 0.35s ease-out;
        }
        @keyframes toast-hero-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (min-width: 1024px) {
            body.welcome-page #toast-container {
                top: max(7.5rem, 24vh);
                right: 2.5rem;
            }
        }
        /* Mobile FAB nav: draggable; collapsed = only active tab */
        #welcome-mobile-float-root {
            touch-action: none;
            cursor: grab;
        }
        #welcome-mobile-float-root.is-dragging {
            cursor: grabbing;
        }
        #welcome-mobile-float-root.is-dragging * {
            pointer-events: none;
        }
        #welcome-mobile-bottom-pill[data-expanded="false"] .welcome-mobile-nav-link:not([aria-current="page"]) {
            display: none;
        }
        #welcome-mobile-bottom-pill[data-expanded="false"] {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }
        #welcome-mobile-bottom-pill {
            transition: box-shadow 0.2s ease;
        }
        #welcome-mobile-bottom-pill[data-expanded="true"] {
            transition: none;
        }
        #welcome-mobile-bottom-pill[data-expanded="true"][data-layout="row-left"] {
            flex-direction: row-reverse;
            flex-wrap: nowrap;
        }
        #welcome-mobile-bottom-pill[data-expanded="true"][data-layout="row-right"] {
            flex-direction: row;
            flex-wrap: nowrap;
        }
        #welcome-mobile-bottom-pill[data-expanded="true"][data-layout="col-up"] {
            flex-direction: column-reverse;
            flex-wrap: nowrap;
            align-items: flex-end;
        }
        #welcome-mobile-bottom-pill[data-expanded="true"][data-layout="col-down"] {
            flex-direction: column;
            flex-wrap: nowrap;
            align-items: flex-end;
        }
        .welcome-mobile-nav-link.welcome-mobile-nav-link--active {
            background-color: rgb(201 162 39 / 0.2);
            color: #e8d48b;
        }
        .welcome-mobile-nav-link:not(.welcome-mobile-nav-link--active) {
            color: rgb(255 255 255 / 0.7);
        }
        .welcome-mobile-nav-link:not(.welcome-mobile-nav-link--active):hover {
            background-color: rgb(255 255 255 / 0.1);
        }
    </style>
</head>
<body class="welcome-page min-h-screen bg-cream text-stone-800 antialiased pb-10 lg:pb-0">
    @php
        $pc = $pcHead;
        $toAsset = function ($path, $fallback) {
            $value = $path ?: $fallback;
            return str_starts_with($value, 'public-page/') ? asset('storage/' . $value) : asset($value);
        };
        $items = $products ?? collect();
        $storeName = $pc['store_name'] ?? 'JM Casabar Mini Farm';
        $heroTitle = $pc['hero_title'] ?? 'The Gold Standard of Farm-Raised Duck.';
        $heroSub = $pc['hero_subtitle'] ?? 'Honored by tradition. Raised with care. Discover the difference of ethical husbandry and lineage you can taste in every cut.';
    @endphp

    <!-- Header: mobile row (no overlap) + desktop 3-column row -->
    <header class="sticky top-0 z-[60] bg-white border-b border-stone-200/80 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Mobile / tablet: [menu] [brand center] [icons] -->
            <div class="flex lg:hidden items-center justify-between gap-3 h-16 min-h-[4rem]">
                <button type="button" id="mobile-menu-btn" class="p-2 -ml-2 rounded-lg text-forest hover:bg-cream shrink-0" aria-label="Open menu">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ url('/') }}" class="font-serif text-base sm:text-lg font-semibold text-forest text-center truncate min-w-0 flex-1 px-2">
                    {{ $storeName }}
                </a>
                <div class="flex items-center gap-1 sm:gap-2 shrink-0">
                    <a href="{{ route('login') }}" class="inline-flex p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors" aria-label="Account">
                        <i class="fas fa-user text-lg"></i>
                    </a>
                    <a href="{{ route('cart.view') }}" class="p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors" aria-label="Shopping bag">
                        <i class="fas fa-shopping-bag text-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Desktop: [brand left] [nav center] [icons right] — no absolute positioning -->
            <div class="hidden lg:grid lg:grid-cols-[minmax(0,1fr)_auto_minmax(0,1fr)] lg:items-center lg:gap-6 lg:h-[4.25rem]">
                <div class="flex items-center justify-start min-w-0">
                    <a href="{{ url('/') }}" class="font-serif text-xl font-semibold text-forest tracking-tight truncate">
                        {{ $storeName }}
                    </a>
                </div>
                <nav class="flex items-center justify-center gap-5 xl:gap-7 text-sm font-medium text-stone-600 whitespace-nowrap">
                    <a href="#heritage" class="hover:text-forest transition-colors">Heritage</a>
                    <a href="#products" class="hover:text-forest transition-colors">Products</a>
                    
                    <a href="{{ route('question.page') }}" class="hover:text-forest transition-colors">FAQ</a>
                    <a href="{{ route('contact') }}" class="hover:text-forest transition-colors">Contact</a>
                </nav>
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('login') }}" class="inline-flex p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors" aria-label="Account">
                        <i class="fas fa-user text-lg"></i>
                    </a>
                    <a href="{{ route('cart.view') }}" class="inline-flex p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors" aria-label="Shopping bag">
                        <i class="fas fa-shopping-bag text-lg"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile slide-down menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-stone-100 bg-white">
            <nav class="max-w-7xl mx-auto px-4 py-4 flex flex-col gap-1 text-stone-700 font-medium">
                <a href="#heritage" class="py-3 border-b border-stone-100">Heritage</a>
                <a href="#products" class="py-3 border-b border-stone-100">The Aviary</a>
                <a href="#products" class="py-3 border-b border-stone-100">Curation</a>
                <a href="{{ route('question.page') }}" class="py-3 border-b border-stone-100">FAQ</a>
                <a href="{{ route('contact') }}" class="py-3 border-b border-stone-100">Contact</a>
                <a href="{{ route('login') }}" class="py-3 text-forest">Sign in</a>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative min-h-[78vh] md:min-h-[85vh] flex items-center">
        <div class="absolute inset-0 hero-bg z-0"
             style="background-image: url('{{ $toAsset($pc['hero_image'] ?? null, 'images/pekin-young-alive.jpg') }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/45 to-black/25 z-[1]"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 w-full">
            <div class="max-w-2xl text-center md:text-left mx-auto md:mx-0">
                <p class="inline-block px-4 py-1.5 rounded-full bg-gold/90 text-forest-dark text-xs font-semibold tracking-widest uppercase mb-6">
                    Established 2020
                </p>
                <h1 class="font-serif text-4xl sm:text-5xl md:text-6xl font-semibold text-white leading-tight mb-6">
                    {{ $heroTitle }}
                </h1>
                <p class="text-lg text-white/90 font-light leading-relaxed mb-10 max-w-xl mx-auto md:mx-0">
                    {{ $heroSub }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="#products"
                       class="inline-flex items-center justify-center px-8 py-3.5 bg-forest text-white font-semibold rounded-lg hover:bg-forest-light transition-colors shadow-lg">
                        Explore Our Products
                    </a>
                    <a href="#heritage"
                       class="inline-flex items-center justify-center px-8 py-3.5 border-2 border-white text-white font-semibold rounded-lg hover:bg-white/10 transition-colors">
                        Our Story
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Selection -->
    <section id="products" class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-10 md:mb-12">
                <div>
                    <h2 class="font-serif text-3xl md:text-4xl text-forest font-semibold">Featured Selection</h2>
                    <p class="mt-2 text-stone-600 max-w-xl text-sm md:text-base">
                        A curated offering from our reserve — whole duck, eggs, and cellar selections, prepared with the same care we bring to the farm.
                    </p>
                    <span class="mt-4 inline-block h-1 w-16 bg-gold rounded-full md:hidden" aria-hidden="true"></span>
                </div>
                <div class="hidden md:flex items-center gap-2 shrink-0">
                    <button type="button" id="feat-prev" class="w-10 h-10 rounded-full border border-stone-200 text-stone-600 hover:bg-cream hover:border-gold/50 transition-colors" aria-label="Previous products">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" id="feat-next" class="w-10 h-10 rounded-full border border-stone-200 text-stone-600 hover:bg-cream hover:border-gold/50 transition-colors" aria-label="Next products">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            @if($items->isEmpty())
                <p class="text-center text-stone-500 py-16">No products available yet.</p>
            @else
                <div id="featured-scroller" class="featured-track flex gap-6 overflow-x-auto pb-2 md:cursor-grab active:cursor-grabbing">
                    @foreach($items as $item)
                        @php
                            $p = $item->product;
                            $badge = $item->type === 'wine' ? 'Wine' : ($item->type === 'egg' ? 'Egg' : 'Duck');
                            $isLimited = $loop->index === 0;
                            $isBest = $loop->index === 1;
                            $img = $p->product_image ? asset($p->product_image) : asset('images/pekin-young-alive.jpg');
                            $desc = \Illuminate\Support\Str::limit($p->product_description ?? 'Clean, succulent, farm-to-table freshness from our ponds.', 120);
                        @endphp
                        <article class="js-product-card featured-card flex-shrink-0 w-[min(100%,340px)] sm:w-[300px] lg:w-[320px] rounded-2xl overflow-hidden border border-stone-200/80 shadow-md bg-white flex flex-col @if($loop->index >= 8) hidden @endif">
                            <div class="relative aspect-[4/3] bg-stone-900">
                                @if($isLimited)
                                    <span class="absolute top-3 right-3 z-10 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-white/95 text-stone-800">Limited Reserve</span>
                                @elseif($isBest)
                                    <span class="absolute top-3 right-3 z-10 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-gold text-forest-dark">Best Seller</span>
                                @else
                                    <span class="absolute top-3 right-3 z-10 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-emerald-700/90 text-white">{{ $badge }}</span>
                                @endif
                                <img src="{{ $img }}" alt="{{ $p->product_name }}" class="w-full h-full object-cover opacity-95 md:opacity-100">
                            </div>
                            <div class="p-5 flex flex-col flex-1 bg-white md:bg-white text-stone-800">
                                <div class="flex items-start justify-between gap-3 mb-2">
                                    <h3 class="font-serif font-semibold text-lg leading-snug">{{ $p->product_name }}</h3>
                                    <span class="font-serif font-semibold text-forest whitespace-nowrap">₱{{ number_format($p->product_price ?? 0, 0) }}</span>
                                </div>
                                <p class="text-sm text-stone-500 mb-5 flex-1 leading-relaxed">{{ $desc }}</p>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('login') }}"
                                       class="flex-1 min-w-[140px] inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-stone-300 text-sm font-medium text-stone-800 hover:bg-cream hover:border-gold/40 transition-colors">
                                        View Selection
                                        <i class="fas fa-chevron-down text-xs opacity-60"></i>
                                    </a>
                                    <button type="button"
                                            class="js-add-to-cart inline-flex items-center justify-center w-12 h-12 rounded-xl bg-forest text-white hover:bg-forest-light transition-colors shrink-0"
                                            data-type="{{ $item->type === 'wine' ? 'wine' : 'duck' }}"
                                            data-id="{{ $p->id }}"
                                            aria-label="Add to cart">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($items->count() > 8)
                    <div class="mt-10 flex justify-center">
                        <div class="relative inline-block text-left">
                            {{-- <button type="button" id="see-more-button"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-forest text-white font-medium rounded-lg shadow hover:bg-forest-light transition-colors"
                                    aria-haspopup="true" aria-expanded="false">
                                See more
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button> --}}
                            <div id="see-more-menu"
                                 class="hidden absolute left-1/2 -translate-x-1/2 mt-3 w-56 rounded-xl bg-white shadow-lg ring-1 ring-black/5 overflow-hidden z-20">
                                <button type="button" id="show-all-products" class="w-full px-4 py-3 text-left text-sm text-stone-700 hover:bg-cream">Show all products</button>
                                <button type="button" id="show-less-products" class="w-full px-4 py-3 text-left text-sm text-stone-700 hover:bg-cream">Show fewer</button>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </section>

    <!-- CTA strip -->
    <section class="py-12 md:py-16 bg-forest">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
            <div class="flex items-center gap-4 md:gap-6">
                <div class="hidden sm:flex w-14 h-14 rounded-full bg-gold/20 items-center justify-center text-gold text-xl shrink-0" aria-hidden="true">
                    <i class="fas fa-quote-left"></i>
                </div>
                <p class="font-serif text-2xl md:text-3xl text-white italic leading-snug">
                    Ethically Raised, Exquisitely Delivered.
                </p>
            </div>
            <a href="{{ route('login') }}"
               class="inline-flex items-center justify-center px-8 py-3.5 bg-gold text-forest-dark font-bold text-sm tracking-widest rounded-full hover:bg-gold-pale transition-colors shadow-lg whitespace-nowrap">
                Reserve Now
            </a>
        </div>
    </section>

    <!-- Heritage -->
    <section id="heritage" class="py-16 md:py-24 bg-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="relative heritage-img-wrap">
                    <div class="relative z-[1] rounded-xl overflow-hidden shadow-xl">
                        <img src="{{ $toAsset($pc['about_image'] ?? null, 'images/Male_Pekin_Duck.jpg') }}"
                             alt="Our farm" class="w-full h-[420px] lg:h-[520px] object-cover">
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold tracking-[0.2em] text-stone-500 uppercase mb-3">Our Legacy</p>
                    <h2 class="font-serif text-3xl md:text-4xl text-forest font-semibold mb-6">
                        {{ $pc['about_title'] ?? 'Heritage & Heart: The Digital Conservatory' }}
                    </h2>
                    <div class="space-y-4 text-stone-600 leading-relaxed text-sm md:text-base">
                        <p>{{ $pc['about_paragraph_1'] ?? 'For over fifteen years, JM Casabar Mini Farm has blended time-honored husbandry with modern care — nurturing Pekin ducks in open ponds and ethical conditions you can trace from egg to table.' }}</p>
                        <p>{{ $pc['about_paragraph_2'] ?? 'We believe exceptional flavor begins with respect: for the land, the flock, and the families who share our table.' }}</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-6 mt-10 py-6 border-y border-stone-200/80">
                        <div>
                            <p class="font-serif text-xl md:text-2xl font-semibold text-forest">{{ $pc['stat_1_number'] ?? '100%' }}</p>
                            <p class="text-xs font-semibold tracking-wider text-stone-500 uppercase">{{ $pc['stat_1_label'] ?? 'Natural Feed' }}</p>
                        </div>
                        <span class="hidden sm:block w-px h-12 bg-stone-200" aria-hidden="true"></span>
                        <div>
                            <p class="font-serif text-xl md:text-2xl font-semibold text-forest">{{ $pc['stat_2_number'] ?? '15+' }}</p>
                            <p class="text-xs font-semibold tracking-wider text-stone-500 uppercase">{{ $pc['stat_2_label'] ?? 'Years Experience' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('question.page') }}" class="inline-flex items-center gap-2 mt-6 text-forest font-medium border-b border-gold/60 hover:border-gold pb-0.5 transition-colors">
                        Explore our provenance history
                        <span aria-hidden="true">—</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Journal / Newsletter -->
    <section id="journal" class="py-16 md:py-24 bg-white border-t border-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <h2 class="font-serif text-3xl md:text-4xl text-forest font-semibold mb-3">The Weekly Journal</h2>
                    <p class="text-stone-600 mb-8 max-w-md">
                        Recipes, harvest notes, and farm updates — subscribe and we’ll send seasonal inspiration to your inbox.
                    </p>
                    <form class="flex flex-col sm:flex-row gap-0 sm:gap-0 max-w-lg" action="#" method="post" onsubmit="event.preventDefault(); window.showToast?.('Thanks — newsletter coming soon.', 'success');">
                        @csrf
                        <label class="sr-only" for="newsletter-email">Email</label>
                        <input type="email" id="newsletter-email" required placeholder="Your email address"
                               class="flex-1 min-w-0 px-4 py-3.5 rounded-l-lg sm:rounded-r-none border border-stone-200 bg-stone-50 text-stone-800 placeholder:text-stone-400 focus:ring-2 focus:ring-gold/50 focus:border-gold outline-none">
                        <button type="submit" class="mt-2 sm:mt-0 px-8 py-3.5 bg-forest text-white font-semibold rounded-lg sm:rounded-l-none sm:rounded-r-lg hover:bg-forest-light transition-colors">
                            Join
                        </button>
                    </form>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    
                    <img src="{{ $toAsset($pc['hero_image'] ?? null, 'images/pekin-young-alive.jpg') }}" alt="" class="rounded-xl h-48 object-cover w-full shadow-md mt-8">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-forest-dark text-white pt-14 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-10 mb-10">
                <div class="max-w-xs">
                    <p class="font-serif text-xl text-gold-pale font-semibold mb-2">{{ $storeName }}</p>
                    <p class="text-sm text-white/70 leading-relaxed">
                        {{ $pc['footer_brand_text'] ?? 'Premium farm-raised duck and artisan products from JM Casabar Mini Farm.' }}
                    </p>
                </div>
                <nav class="flex flex-wrap gap-x-8 gap-y-3 text-sm text-white/80 justify-center md:justify-end">
                    <a href="#heritage" class="hover:text-gold-pale transition-colors">Provenance</a>
                    <a href="{{ route('question.page') }}" class="hover:text-gold-pale transition-colors">FAQ</a>
                    <a href="{{ route('contact') }}" class="hover:text-gold-pale transition-colors">Contact Us</a>
                    <a href="{{ route('privacy-policy.page') }}" class="hover:text-gold-pale transition-colors">Privacy Policy</a>
                </nav>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 border-t border-white/10">
                <p class="text-xs text-white/50">© {{ date('Y') }} {{ $storeName }}. All rights reserved.</p>
                <div class="flex gap-4 text-white/60">
                    <a href="https://web.facebook.com/IMORTALxiiJERRY" target="_blank" rel="noopener" class="hover:text-gold-pale" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/jerry_casabar" target="_blank" rel="noopener" class="hover:text-gold-pale" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="mailto:jmcasabar@gmail.com" class="hover:text-gold-pale" aria-label="Email"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile FAB nav: default right side, draggable; tap active tab to expand (direction from position) -->
    <nav id="welcome-mobile-bottom-nav" class="lg:hidden fixed inset-0 z-[70] pointer-events-none" aria-label="Mobile navigation" aria-expanded="false">
        <div id="welcome-mobile-float-root" class="pointer-events-auto fixed rounded-full bg-forest-dark/95 backdrop-blur shadow-xl border border-white/10" role="presentation">
            <div id="welcome-mobile-bottom-pill" class="flex items-center gap-1 px-2 py-2 rounded-full" data-expanded="false" data-layout="row-left" role="group" aria-label="Quick navigation">
            <a href="{{ url('/') }}" data-nav="home" class="welcome-mobile-nav-link welcome-mobile-nav-link--active flex flex-col items-center justify-center w-14 h-14 shrink-0 rounded-full" aria-current="page">
                <i class="fas fa-home text-lg" aria-hidden="true"></i>
                <span class="text-[9px] mt-0.5 font-medium">Home</span>
            </a>
            <a href="#products" data-nav="shop" class="welcome-mobile-nav-link flex flex-col items-center justify-center w-14 h-14 shrink-0 rounded-full">
                <i class="fas fa-store text-lg" aria-hidden="true"></i>
                <span class="text-[9px] mt-0.5 font-medium">Shop</span>
            </a>
            <a href="{{ route('question.page') }}" data-nav="faq" class="welcome-mobile-nav-link flex flex-col items-center justify-center w-14 h-14 shrink-0 rounded-full">
                <i class="fas fa-circle-question text-lg" aria-hidden="true"></i>
                <span class="text-[9px] mt-0.5 font-medium">FAQ</span>
            </a>
            <a href="{{ route('login') }}" data-nav="profile" class="welcome-mobile-nav-link flex flex-col items-center justify-center w-14 h-14 shrink-0 rounded-full">
                <i class="fas fa-user text-lg" aria-hidden="true"></i>
                <span class="text-[9px] mt-0.5 font-medium">Profile</span>
            </a>
            </div>
        </div>
    </nav>

    @include('partials.toast-container')

    <script>
        (function () {
            var btn = document.getElementById('mobile-menu-btn');
            var menu = document.getElementById('mobile-menu');
            if (!btn || !menu) return;
            btn.addEventListener('click', function () {
                menu.classList.toggle('hidden');
                var open = !menu.classList.contains('hidden');
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                btn.innerHTML = open ? '<i class="fas fa-times text-xl"></i>' : '<i class="fas fa-bars text-xl"></i>';
            });
            menu.querySelectorAll('a').forEach(function (a) {
                a.addEventListener('click', function () {
                    menu.classList.add('hidden');
                    btn.setAttribute('aria-expanded', 'false');
                    btn.innerHTML = '<i class="fas fa-bars text-xl"></i>';
                });
            });
        })();

        (function () {
            var floatRoot = document.getElementById('welcome-mobile-float-root');
            var pill = document.getElementById('welcome-mobile-bottom-pill');
            var navEl = document.getElementById('welcome-mobile-bottom-nav');
            if (!floatRoot || !pill || !navEl) return;

            var LS_KEY = 'welcomeMobileFab';
            var DRAG_THRESHOLD = 12;
            var dragMoved = false;
            var isDragging = false;
            var dragPointerId = null;
            var startClientX = 0;
            var startClientY = 0;
            var originRightDist = 0;
            var originTop = 0;
            var suppressNextClick = false;

            function approxExpandedWidth() {
                var cell = 56;
                var gap = 4;
                var pad = 16;
                return 4 * cell + 3 * gap + pad;
            }

            function marginX() { return 10; }
            function marginTop() { return 64; }
            function marginBottom() { return Math.max(24, 88); }

            function clampRightTop(rightDist, top) {
                var w = floatRoot.offsetWidth || 64;
                var h = floatRoot.offsetHeight || 64;
                var vw = window.innerWidth;
                var vh = window.innerHeight;
                var maxR = vw - w - marginX();
                var r = Math.min(maxR, Math.max(marginX(), rightDist));
                var t = Math.min(vh - h - marginBottom(), Math.max(marginTop(), top));
                return { right: r, top: t };
            }

            function applyPosition(rightDist, top) {
                var c = clampRightTop(rightDist, top);
                floatRoot.style.left = 'auto';
                floatRoot.style.right = c.right + 'px';
                floatRoot.style.top = c.top + 'px';
                return c;
            }

            function defaultPosition() {
                var h = floatRoot.offsetHeight || 64;
                var vh = window.innerHeight;
                return clampRightTop(marginX(), vh - h - marginBottom());
            }

            function savePosition() {
                try {
                    var r = floatRoot.getBoundingClientRect();
                    var rightDist = window.innerWidth - r.right;
                    var top = r.top;
                    localStorage.setItem(LS_KEY, JSON.stringify({ right: rightDist, top: top }));
                } catch (e) {}
            }

            function loadPosition() {
                try {
                    var raw = localStorage.getItem(LS_KEY);
                    if (!raw) return null;
                    var p = JSON.parse(raw);
                    if (typeof p.right === 'number' && typeof p.top === 'number') {
                        return clampRightTop(p.right, p.top);
                    }
                    if (typeof p.left === 'number' && typeof p.top === 'number') {
                        var w = floatRoot.offsetWidth || 64;
                        return clampRightTop(window.innerWidth - p.left - w, p.top);
                    }
                    return null;
                } catch (e) {
                    return null;
                }
            }

            function chooseExpandLayout() {
                var rect = floatRoot.getBoundingClientRect();
                var vw = window.innerWidth;
                var vh = window.innerHeight;
                var cx = rect.left + rect.width / 2;
                var cy = rect.top + rect.height / 2;
                var ew = approxExpandedWidth();
                var spaceLeft = rect.left - marginX();
                var spaceRight = vw - rect.right - marginX();
                var spaceUp = rect.top - marginTop();
                var spaceDown = vh - rect.bottom - marginBottom();

                if (cx >= vw * 0.5) {
                    if (spaceLeft >= ew - rect.width + 8) {
                        pill.setAttribute('data-layout', 'row-left');
                    } else if (spaceUp >= ew * 0.65) {
                        pill.setAttribute('data-layout', 'col-up');
                    } else if (spaceDown >= ew * 0.65) {
                        pill.setAttribute('data-layout', 'col-down');
                    } else {
                        pill.setAttribute('data-layout', spaceUp > spaceDown ? 'col-up' : 'col-down');
                    }
                } else {
                    if (spaceRight >= ew - rect.width + 8) {
                        pill.setAttribute('data-layout', 'row-right');
                    } else if (spaceUp >= ew * 0.65) {
                        pill.setAttribute('data-layout', 'col-up');
                    } else if (spaceDown >= ew * 0.65) {
                        pill.setAttribute('data-layout', 'col-down');
                    } else {
                        pill.setAttribute('data-layout', spaceUp > spaceDown ? 'col-up' : 'col-down');
                    }
                }
            }

            function setActiveStyles(link) {
                pill.querySelectorAll('.welcome-mobile-nav-link').forEach(function (a) {
                    a.removeAttribute('aria-current');
                    a.classList.remove('welcome-mobile-nav-link--active');
                });
                if (link) {
                    link.setAttribute('aria-current', 'page');
                    link.classList.add('welcome-mobile-nav-link--active');
                }
            }

            function syncActiveFromHash() {
                var hash = (location.hash || '').toLowerCase();
                var target = hash === '#products' ? pill.querySelector('[data-nav="shop"]') : pill.querySelector('[data-nav="home"]');
                if (target) setActiveStyles(target);
            }

            function setExpanded(expanded) {
                var rightD = window.innerWidth - floatRoot.getBoundingClientRect().right;
                var bottom = floatRoot.getBoundingClientRect().bottom;
                pill.setAttribute('data-expanded', expanded ? 'true' : 'false');
                navEl.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                if (expanded) {
                    chooseExpandLayout();
                    requestAnimationFrame(function () {
                        if (pill.getAttribute('data-layout') !== 'col-up') return;
                        var nh = floatRoot.offsetHeight;
                        applyPosition(rightD, bottom - nh);
                    });
                } else {
                    requestAnimationFrame(function () {
                        var lay = pill.getAttribute('data-layout');
                        if (lay !== 'col-up') return;
                        var nh = floatRoot.offsetHeight;
                        applyPosition(rightD, bottom - nh);
                    });
                }
            }

            function isExpanded() {
                return pill.getAttribute('data-expanded') === 'true';
            }

            function initFabPosition() {
                var saved = loadPosition();
                if (saved) {
                    applyPosition(saved.right, saved.top);
                } else {
                    var d = defaultPosition();
                    applyPosition(d.right, d.top);
                }
            }

            pill.addEventListener('click', function (e) {
                if (suppressNextClick) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    suppressNextClick = false;
                    return;
                }
                var a = e.target.closest('.welcome-mobile-nav-link');
                if (!a) return;
                var isCurrent = a.getAttribute('aria-current') === 'page';
                if (!isExpanded() && isCurrent) {
                    e.preventDefault();
                    setExpanded(true);
                    return;
                }
                if (isExpanded() && isCurrent) {
                    e.preventDefault();
                    setExpanded(false);
                    if (a.getAttribute('data-nav') === 'home') {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                    return;
                }
                if (isExpanded() && !isCurrent) {
                    setExpanded(false);
                }
            }, true);

            floatRoot.addEventListener('pointerdown', function (e) {
                if (e.button !== undefined && e.button !== 0) return;
                dragMoved = false;
                isDragging = false;
                dragPointerId = e.pointerId;
                startClientX = e.clientX;
                startClientY = e.clientY;
                var r = floatRoot.getBoundingClientRect();
                originRightDist = window.innerWidth - r.right;
                originTop = r.top;
                try {
                    floatRoot.setPointerCapture(e.pointerId);
                } catch (err) {}
            });

            floatRoot.addEventListener('pointermove', function (e) {
                if (dragPointerId !== e.pointerId) return;
                var dx = e.clientX - startClientX;
                var dy = e.clientY - startClientY;
                if (!isDragging && dx * dx + dy * dy > DRAG_THRESHOLD * DRAG_THRESHOLD) {
                    isDragging = true;
                    dragMoved = true;
                    floatRoot.classList.add('is-dragging');
                    if (isExpanded()) {
                        setExpanded(false);
                    }
                }
                if (isDragging) {
                    e.preventDefault();
                    applyPosition(originRightDist - dx, originTop + dy);
                }
            });

            floatRoot.addEventListener('pointerup', function (e) {
                if (dragPointerId !== e.pointerId) return;
                try {
                    floatRoot.releasePointerCapture(e.pointerId);
                } catch (err) {}
                dragPointerId = null;
                floatRoot.classList.remove('is-dragging');
                if (dragMoved) {
                    suppressNextClick = true;
                    savePosition();
                }
                isDragging = false;
            });

            floatRoot.addEventListener('pointercancel', function (e) {
                dragPointerId = null;
                floatRoot.classList.remove('is-dragging');
                isDragging = false;
            });

            document.addEventListener('click', function (e) {
                if (!isExpanded()) return;
                if (floatRoot.contains(e.target)) return;
                setExpanded(false);
            });

            window.addEventListener('resize', function () {
                var r = floatRoot.getBoundingClientRect();
                applyPosition(window.innerWidth - r.right, r.top);
            });

            window.addEventListener('hashchange', syncActiveFromHash);
            requestAnimationFrame(function () {
                initFabPosition();
                syncActiveFromHash();
            });

            document.querySelectorAll('a[href="#products"]').forEach(function (el) {
                if (pill.contains(el)) return;
                el.addEventListener('click', function () {
                    requestAnimationFrame(function () { syncActiveFromHash(); });
                });
            });
        })();

        (function () {
            var scroller = document.getElementById('featured-scroller');
            var prev = document.getElementById('feat-prev');
            var next = document.getElementById('feat-next');
            if (!scroller || !prev || !next) return;
            var step = function () { return Math.min(scroller.clientWidth * 0.85, 340); };
            prev.addEventListener('click', function () { scroller.scrollBy({ left: -step(), behavior: 'smooth' }); });
            next.addEventListener('click', function () { scroller.scrollBy({ left: step(), behavior: 'smooth' }); });
        })();

        (function () {
            var btn = document.getElementById('see-more-button');
            var menu = document.getElementById('see-more-menu');
            var showAll = document.getElementById('show-all-products');
            var showLess = document.getElementById('show-less-products');
            var cards = Array.from(document.querySelectorAll('.featured-card'));
            if (!btn || !cards.length) return;

            function openMenu() { menu?.classList.remove('hidden'); btn.setAttribute('aria-expanded', 'true'); }
            function closeMenu() { menu?.classList.add('hidden'); btn.setAttribute('aria-expanded', 'false'); }
            function showAllProducts() { cards.forEach(function (c) { c.classList.remove('hidden'); }); }
            function showLessProducts() {
                cards.forEach(function (c, idx) { c.classList.toggle('hidden', idx >= 8); });
                document.getElementById('products')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            btn.addEventListener('click', function (e) {
                e.preventDefault();
                if (!menu) return;
                if (menu.classList.contains('hidden')) openMenu(); else closeMenu();
            });
            showAll?.addEventListener('click', function () { showAllProducts(); closeMenu(); });
            showLess?.addEventListener('click', function () { showLessProducts(); closeMenu(); });
            document.addEventListener('click', function (e) {
                if (menu && !menu.contains(e.target) && !btn.contains(e.target)) closeMenu();
            });
        })();

        (function () {
            var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            var buttons = Array.from(document.querySelectorAll('.js-add-to-cart'));
            if (!buttons.length) return;

            async function addToCart(type, id) {
                var url = type === 'wine' ? "{{ route('cart.add.wine') }}" : "{{ route('cart.add') }}";
                var body = new URLSearchParams();
                body.set('product_id', String(id));
                body.set('quantity', '1');
                var res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: body.toString(),
                });
                if (res.ok) {
                    window.showToast?.('Added to cart. Sign in to checkout.', 'success');
                    return;
                }
                var msg = 'Failed to add to cart.';
                try { var data = await res.json(); if (data?.message) msg = data.message; } catch (e) {}
                window.showToast?.(msg, 'error');
            }

            buttons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    addToCart(btn.getAttribute('data-type'), btn.getAttribute('data-id'));
                });
            });
        })();
    </script>
</body>
</html>
