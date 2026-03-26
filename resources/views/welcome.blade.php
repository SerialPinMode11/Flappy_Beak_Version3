<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Flappy-Beak - Farm-Fresh Duck Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-card:hover .quick-view {
            opacity: 1;
        }
        .hero-pattern {
            background-color: #f8fafc;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23e2e8f0' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Enhanced Responsive Styles */
        
        /* Mobile First Approach - Extra Small devices (portrait phones, less than 576px) */
        @media (max-width: 575.98px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            /* Header adjustments */
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            .mobile-header-top {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .mobile-nav {
                width: 100%;
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 1rem;
            }
            
            .mobile-nav a {
                font-size: 0.875rem;
                padding: 0.5rem;
            }
            
            .mobile-search {
                width: 100%;
                margin-top: 0.5rem;
            }
            
            .mobile-search input {
                width: 100% !important;
                font-size: 0.875rem;
            }
            
            /* Hero section */
            .hero-title {
                font-size: 2rem !important;
                line-height: 1.2;
                margin-bottom: 1rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
                line-height: 1.5;
                margin-bottom: 1.5rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .hero-buttons a {
                text-align: center;
                padding: 0.75rem 1.5rem;
                font-size: 0.875rem;
            }
            
            .hero-image {
                margin-top: 2rem;
                max-height: 250px !important;
            }
            
            /* Product cards */
            .product-grid {
                grid-template-columns: 1fr !important;
                gap: 1.5rem;
            }
            
            .product-card {
                max-width: 100%;
            }
            
            .product-card img {
                height: 200px;
            }
            
            .product-price {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
            
            .product-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .product-buttons button:last-child {
                width: 100%;
            }
            
            /* About section */
            .about-content {
                flex-direction: column;
                text-align: center;
            }
            
            .about-image {
                order: -1;
                margin-bottom: 2rem;
            }
            
            .about-stats {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 1rem;
            }
            
            .about-stats > div {
                padding: 1rem;
            }
            
            .about-stats .stat-number {
                font-size: 1.5rem;
            }
            
            /* Features section */
            .features-grid {
                grid-template-columns: 1fr !important;
                gap: 1.5rem;
            }
            
            /* Footer */
            .footer-grid {
                grid-template-columns: 1fr !important;
                gap: 2rem;
                text-align: center;
            }
            
            .footer-bottom {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .footer-links {
                justify-content: center;
            }
        }
        
        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            
            .features-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            
            .footer-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .about-stats {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
        
        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            
            .features-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            
            .footer-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            
            .mobile-nav {
                display: none !important;
            }
        }
        
        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr) !important;
            }
            
            .features-grid {
                grid-template-columns: repeat(4, 1fr) !important;
            }
        }
        
        /* Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {
            .product-grid {
                grid-template-columns: repeat(4, 1fr) !important;
            }
        }
        
        /* Utility classes for better responsiveness */
        .responsive-text-sm {
            font-size: clamp(0.875rem, 2.5vw, 1rem);
        }
        
        .responsive-text-base {
            font-size: clamp(1rem, 3vw, 1.125rem);
        }
        
        .responsive-text-lg {
            font-size: clamp(1.125rem, 3.5vw, 1.25rem);
        }
        
        .responsive-text-xl {
            font-size: clamp(1.25rem, 4vw, 1.5rem);
        }
        
        .responsive-text-2xl {
            font-size: clamp(1.5rem, 5vw, 2rem);
        }
        
        .responsive-text-3xl {
            font-size: clamp(2rem, 6vw, 3rem);
        }
        
        .responsive-padding {
            padding: clamp(1rem, 5vw, 2rem);
        }
        
        .responsive-margin {
            margin: clamp(1rem, 5vw, 2rem);
        }
        
        /* Image responsiveness */
        .responsive-img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        
        /* Button responsiveness */
        .responsive-btn {
            padding: clamp(0.5rem, 2vw, 1rem) clamp(1rem, 4vw, 2rem);
            font-size: clamp(0.875rem, 2.5vw, 1rem);
        }
        
        /* Card responsiveness */
        .responsive-card {
            padding: clamp(1rem, 3vw, 1.5rem);
        }
        
        /* Navigation fixes for mobile */
        @media (max-width: 767.98px) {
            .desktop-nav {
                display: none !important;
            }
            
            .mobile-menu-toggle {
                display: block !important;
            }
            
            .mobile-nav.active {
                display: flex !important;
            }
            
            .header-actions {
                gap: 0.5rem;
            }
            
            .header-actions button,
            .header-actions a {
                padding: 0.5rem;
                font-size: 0.875rem;
            }
            
            .cart-icon,
            .wishlist-icon {
                font-size: 1.25rem;
            }
        }
        
        /* Improved touch targets for mobile */
        @media (max-width: 767.98px) {
            button, 
            a, 
            input[type="submit"], 
            input[type="button"] {
                min-height: 44px;
                min-width: 44px;
            }
            
            .product-card .quick-view {
                opacity: 1; /* Always visible on mobile */
                position: relative !important;
                bottom: auto !important;
                right: auto !important;
                margin-top: 0.5rem;
                width: 100%;
                border-radius: 0.5rem;
            }
        }
        
        /* Loading performance improvements */
        .product-card img,
        .hero-image,
        .about-image {
            transition: transform 0.3s ease;
        }
        
        /* Accessibility improvements */
        @media (prefers-reduced-motion: reduce) {
            .product-card img,
            .hero-image,
            button,
            a {
                transition: none;
            }
            
            .product-card:hover img {
                transform: none;
            }
        }
        
        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .product-card {
                border: 2px solid currentColor;
            }
            
            .bg-emerald-50,
            .bg-white {
                background-color: transparent;
            }
        }
        
        /* Dark mode considerations (if needed in future) */
        @media (prefers-color-scheme: dark) {
            .hero-pattern {
                background-color: #ffffff;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 font-sans">
    <!-- Header -->
    <header class="bg-gradient-to-r from-emerald-600 to-teal-700 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                 <img src="{{ asset('images/fav-icon.png') }}" alt="Flappy IoT Logo" class="w-8 h-8">
                <h1 class="text-2xl font-bold tracking-wide">JM Casabar Mini Farm</h1>
            </div>
            
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ url('/') }}" class="hover:text-yellow-300 transition-colors font-medium">Home</a>
                <a href="#products" class="hover:text-yellow-300 transition-colors font-medium">Products</a>
                <a href="#about" class="hover:text-yellow-300 transition-colors font-medium">About Us</a>
                <a href="{{ route('contact') }}" class="hover:text-yellow-300 transition-colors font-medium">Contact</a>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="relative hidden md:block">
                    <input type="text" placeholder="Search our products..." class="pl-4 pr-10 py-2 border-2 border-teal-300 rounded-lg w-64 shadow-sm focus:ring-2 focus:ring-yellow-300 focus:outline-none">
                    <button class="absolute right-3 top-2.5" onclick="redirectToLogin()">
                        <i class="fas fa-search text-gray-500"></i>
                    </button>
                </div>
                <button class="hover:text-yellow-300 transition-colors relative">
                    <i class="fas fa-shopping-cart text-xl" onclick="redirectToLogin(event)"></i>
                    <span class="absolute -top-2 -right-2 bg-yellow-400 text-xs text-teal-800 font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </button>
                <a href="{{route('login')}}" class="bg-yellow-400 hover:bg-yellow-500 text-teal-900 font-semibold px-4 py-2 rounded-lg transition-colors shadow-md hidden md:block">
                    Sign In
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-pattern py-16 md:py-24">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold text-teal-900 leading-tight mb-4">
                        Farm-Fresh <span class="text-emerald-600">Pekin Duck</span> Products
                    </h1>
                    <p class="text-lg text-slate-700 mb-6">
                        Experience the exceptional quality of our farm-raised Pekin ducks. 
                        From premium meat cuts to fresh eggs, we offer the finest duck products 
                        straight from our family farm to your table.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#products" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors shadow-md text-center">
                            Shop Now
                        </a>
                        <a href="#about" class="border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-50 font-semibold px-6 py-3 rounded-lg transition-colors text-center">
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <img src="{{asset('images/pekin-young-alive.jpg')}}" alt="Pekin Ducks" class="rounded-lg shadow-xl max-w-full h-auto object-cover" style="max-height: 400px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="products" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-teal-900 mb-4">Our Premium Duck Products</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">
                    Discover our selection of high-quality, farm-raised Pekin duck products. 
                    Each item is carefully produced with a focus on quality, freshness, and ethical farming practices.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @php
                    $items = $products ?? collect();
                @endphp

                @forelse($items as $item)
                    @php
                        $p = $item->product;
                        $badge = $item->type === 'wine' ? 'Wine' : ($item->type === 'egg' ? 'Egg' : 'Duck');
                        $badgeClass = $item->type === 'wine' ? 'bg-purple-600' : ($item->type === 'egg' ? 'bg-yellow-400 text-teal-900' : 'bg-emerald-600');
                        $img = $p->product_image ? asset($p->product_image) : asset('images/pekin-young-alive.jpg');
                    @endphp

                    <div class="product-card bg-white rounded-xl shadow-md overflow-hidden group js-product-card {{ $loop->index >= 8 ? 'hidden' : '' }}">
                        <div class="relative">
                            <span class="absolute top-3 left-3 {{ $badgeClass }} text-white text-sm px-3 py-1 rounded-full font-medium z-10">
                                {{ $badge }}
                            </span>
                            <div class="overflow-hidden">
                                <img src="{{ $img }}" alt="{{ $p->product_name }}" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <a href="{{ route('login') }}" class="quick-view absolute bottom-3 right-3 bg-white p-2 rounded-full shadow-lg hover:bg-emerald-600 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100 z-10" aria-label="Quick view">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        <div class="p-5 border-t">
                            <h3 class="font-bold text-lg text-teal-900 mb-1 truncate" title="{{ $p->product_name }}">{{ $p->product_name }}</h3>
                            <p class="text-slate-600 text-sm mb-3">
                                {{ \Illuminate\Support\Str::limit($p->product_description ?? '', 90) }}
                            </p>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-emerald-600 font-bold text-xl">₱{{ number_format($p->product_price ?? 0, 2) }}</span>
                                <div class="flex gap-2">
                                    <button type="button"
                                            class="w-10 h-10 flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors duration-300 js-add-to-cart"
                                            data-type="{{ $item->type === 'wine' ? 'wine' : 'duck' }}"
                                            data-id="{{ $p->id }}"
                                            aria-label="Add to cart">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-slate-600">
                        No products available yet.
                    </div>
                @endforelse
            </div>

            @if(($items ?? collect())->count() > 8)
                <div class="mt-10 flex justify-center">
                    <div class="relative inline-block text-left">
                        <button type="button" id="see-more-button"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg shadow hover:bg-emerald-700 transition-colors"
                                aria-haspopup="true" aria-expanded="false">
                            See More
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>

                        <div id="see-more-menu"
                             class="hidden absolute left-1/2 -translate-x-1/2 mt-3 w-56 rounded-xl bg-white shadow-lg ring-1 ring-black/5 overflow-hidden z-20">
                            <button type="button" id="show-all-products"
                                    class="w-full px-4 py-3 text-left text-sm text-gray-700 hover:bg-gray-50">
                                Show all products
                            </button>
                            <button type="button" id="show-less-products"
                                    class="w-full px-4 py-3 text-left text-sm text-gray-700 hover:bg-gray-50">
                                Show fewer (8)
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            
           
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="py-16 bg-emerald-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2">
                    <img src="{{asset('images/Male_Pekin_Duck.jpg')}}" alt="Our Duck Farm" class="rounded-xl shadow-xl w-full h-auto">
                </div>
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold text-teal-900 mb-6">Our Mission & Story</h2>
                    <div class="space-y-4 text-slate-700">
                        <p>
                            At JM Casabar Mini Farm, we're dedicated to raising the healthiest, happiest Pekin ducks using sustainable and ethical farming practices. Our family-owned farm has been in operation for over 15 years, focusing on quality over quantity.
                        </p>
                        <p>
                            We believe that happy ducks produce the best meat and eggs. That's why our ducks enjoy spacious, clean living conditions with access to fresh water and natural feed. We never use antibiotics or growth hormones, ensuring you get the purest duck products possible.
                        </p>
                        <p>
                            From our farm to your table, we take pride in offering premium duck products that are not only delicious but also responsibly raised. Whether you're a chef looking for the finest ingredients or a home cook wanting to try something special, our duck products will exceed your expectations.
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <div class="text-emerald-600 text-3xl font-bold mb-2">100%</div>
                            <div class="text-slate-700 font-medium">Natural Feed</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <div class="text-emerald-600 text-3xl font-bold mb-2">15+</div>
                            <div class="text-slate-700 font-medium">Years Experience</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <div class="text-emerald-600 text-3xl font-bold mb-2">0</div>
                            <div class="text-slate-700 font-medium">Antibiotics Used</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <div class="text-emerald-600 text-3xl font-bold mb-2">1000+</div>
                            <div class="text-slate-700 font-medium">Happy Customers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-teal-900 mb-4">Why Choose Our Duck Products?</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">
                    We take pride in offering the highest quality Pekin duck products, raised with care and processed with attention to detail.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-emerald-50 p-6 rounded-xl text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-leaf text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-teal-900 mb-2">100% Natural</h3>
                    <p class="text-slate-600">Our ducks are raised naturally without antibiotics or growth hormones.</p>
                </div>
                
                <div class="bg-emerald-50 p-6 rounded-xl text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-award text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-teal-900 mb-2">Premium Quality</h3>
                    <p class="text-slate-600">Each product meets our strict quality standards before reaching your table.</p>
                </div>
                
                <div class="bg-emerald-50 p-6 rounded-xl text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-teal-900 mb-2">Fast Delivery</h3>
                    <p class="text-slate-600">We ensure quick and safe delivery to maintain freshness and quality.</p>
                </div>
                
                <div class="bg-emerald-50 p-6 rounded-xl text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-leaf text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-teal-900 mb-2">Ethically Raised</h3>
                    <p class="text-slate-600">Our ducks enjoy spacious, clean living conditions with proper care.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="bg-teal-900 text-white pt-12 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                       <img src="{{ asset('images/Flappy_IoT.png') }}" alt="Flappy IoT Logo" class="w-8 h-8">
                        <h3 class="text-xl font-bold">Flappy-Beak</h3>
                    </div>
                    <p class="text-teal-200 mb-4">
                        Premium farm-raised Pekin duck products delivered straight to your door.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://web.facebook.com/IMORTALxiiJERRY" class="text-teal-200 hover:text-yellow-300" target="_blank" rel="noopener" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/jerry_casabar?igsh=Y2x6enlmdHB3cmhq" class="text-teal-200 hover:text-yellow-300" target="_blank" rel="noopener" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="tel:+639294833413" class="text-teal-200 hover:text-yellow-300" aria-label="Call">
                            <i class="fas fa-phone"></i>
                        </a>
                        <a href="mailto:jmcasabar@gmail.com" class="text-teal-200 hover:text-yellow-300" aria-label="Email">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-teal-200 hover:text-yellow-300">Home</a></li>
                        <li><a href="{{ url('/') }}#products" class="text-teal-200 hover:text-yellow-300">Products</a></li>
                        <li><a href="{{ url('/') }}#about" class="text-teal-200 hover:text-yellow-300">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-teal-200 hover:text-yellow-300">Contact</a></li>
                        <li><a href="{{ route('question.page') }}" class="text-teal-200 hover:text-yellow-300">FAQ</a></li>
                        <li><a href="{{ route('privacy-policy.page') }}" class="text-teal-200 hover:text-yellow-300">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start space-x-2">
                            <i class="fas fa-map-marker-alt mt-1 text-yellow-300"></i>
                            <span class="text-teal-200">Brgy. Maroyroy, Macatoc, Oriental Mindoro, Luzon Philippines</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <i class="fas fa-phone mt-1 text-yellow-300"></i>
                            <span class="text-teal-200">+63 9294 833 413</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <i class="fas fa-envelope mt-1 text-yellow-300"></i>
                            <span class="text-teal-200">jmcasabar@gmail.com</span>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Business Hours</h3>
                    <ul class="space-y-2">
                        <li class="text-teal-200">Monday - Friday: 8am - 5pm</li>
                        <li class="text-teal-200">Saturday: 9am - 4pm</li>
                        <li class="text-teal-200">Sunday: Closed</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-teal-800 pt-6 mt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-teal-300 text-sm">© 2025 Flappy-Beak Duck Farm. All rights reserved.</p>
                    <div class="flex space-x-4 mt-4 md:mt-0">
                        <a href="#" class="text-teal-300 text-sm hover:text-yellow-300">Privacy Policy</a>
                        <a href="#" class="text-teal-300 text-sm hover:text-yellow-300">Terms of Service</a>
                        <a href="#" class="text-teal-300 text-sm hover:text-yellow-300">Shipping Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @include('partials.toast-container')

    <script>
        // "See More" dropdown for products
        (function () {
            const btn = document.getElementById('see-more-button');
            const menu = document.getElementById('see-more-menu');
            const showAll = document.getElementById('show-all-products');
            const showLess = document.getElementById('show-less-products');
            const cards = Array.from(document.querySelectorAll('.js-product-card'));

            if (!btn || !menu || !cards.length) return;

            function openMenu() {
                menu.classList.remove('hidden');
                btn.setAttribute('aria-expanded', 'true');
            }
            function closeMenu() {
                menu.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
            }
            function showAllProducts() {
                cards.forEach(c => c.classList.remove('hidden'));
            }
            function showLessProducts() {
                cards.forEach((c, idx) => {
                    if (idx < 8) c.classList.remove('hidden');
                    else c.classList.add('hidden');
                });
                const productsSection = document.getElementById('products');
                if (productsSection) productsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            btn.addEventListener('click', function (e) {
                e.preventDefault();
                if (menu.classList.contains('hidden')) openMenu();
                else closeMenu();
            });
            showAll?.addEventListener('click', function () {
                showAllProducts();
                closeMenu();
            });
            showLess?.addEventListener('click', function () {
                showLessProducts();
                closeMenu();
            });

            document.addEventListener('click', function (e) {
                if (!menu.contains(e.target) && !btn.contains(e.target)) closeMenu();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeMenu();
            });
        })();

        // Guest add-to-cart (keeps cart in session; checkout still requires login)
        (function () {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const buttons = Array.from(document.querySelectorAll('.js-add-to-cart'));
            if (!buttons.length) return;

            async function addToCart(type, id) {
                const url = type === 'wine' ? "{{ route('cart.add.wine') }}" : "{{ route('cart.add') }}";
                const body = new URLSearchParams();
                body.set('product_id', String(id));
                body.set('quantity', '1');

                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: body.toString(),
                });

                if (res.ok) {
                    window.showToast?.('Added to cart. You can checkout after logging in.', 'success');
                    return;
                }

                let msg = 'Failed to add to cart.';
                try {
                    const data = await res.json();
                    if (data?.message) msg = data.message;
                } catch (e) {}
                window.showToast?.(msg, 'error');
            }

            buttons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const type = this.getAttribute('data-type');
                    const id = this.getAttribute('data-id');
                    addToCart(type, id);
                });
            });
        })();
    </script>
</body>
</html>