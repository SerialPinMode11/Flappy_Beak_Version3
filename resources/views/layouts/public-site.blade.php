<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $pcLayout = $publicContent ?? [];
        $storeNameLayout = $pcLayout['store_name'] ?? 'JM Casabar Mini Farm';
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $storeNameLayout)</title>
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
    @stack('styles')
</head>
<body class="min-h-screen bg-cream text-stone-800 antialiased @hasSection('auth_full_page') pb-0 @else pb-20 lg:pb-0 @endif">
    @php
        $pc = $pcLayout;
        $storeName = $storeNameLayout;
    @endphp

    @sectionMissing('auth_full_page')
    <header class="sticky top-0 z-[60] bg-white border-b border-stone-200/80 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex lg:hidden items-center justify-between gap-3 h-16 min-h-[4rem]">
                <button type="button" id="public-menu-btn" class="p-2 -ml-2 rounded-lg text-forest hover:bg-cream shrink-0" aria-label="Open menu">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ url('/') }}" class="font-serif text-base sm:text-lg font-semibold text-forest text-center truncate min-w-0 flex-1 px-2">
                    {{ $storeName }}
                </a>
                <div class="flex items-center gap-1 sm:gap-2 shrink-0">
                    @auth
                        <a href="{{ route('checkout.track-item') }}" class="inline-flex p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors {{ request()->routeIs('checkout.track-item') ? 'text-forest bg-cream' : '' }}" aria-label="Track your orders" title="Track orders">
                            <i class="fas fa-truck text-lg"></i>
                        </a>
                        <a href="{{ route('booking.status') }}" class="inline-flex p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors {{ request()->routeIs('booking.status') ? 'text-forest bg-cream' : '' }}" aria-label="Track egg incubation booking" title="Track egg booking">
                            <i class="fas fa-egg text-lg"></i>
                        </a>
                        <button type="button" class="inline-flex p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors" aria-label="Notifications" title="Notifications">
                            <i class="fas fa-bell text-lg"></i>
                        </button>
                        <a href="{{ route('cart.view') }}" class="p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors" aria-label="Shopping bag">
                            <i class="fas fa-shopping-bag text-lg"></i>
                        </a>
                        @php $headerUser = auth()->user(); $headerAvatar = $headerUser->profileAvatarUrl(); @endphp
                        <a href="{{ route('profile.edit') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-forest text-gold-pale text-sm font-semibold hover:bg-forest-light transition-colors overflow-hidden ring-2 ring-white shrink-0" title="{{ $headerUser->name }}" aria-label="Your profile">
                            @if($headerAvatar)
                                <img src="{{ $headerAvatar }}" alt="" class="h-full w-full object-cover">
                            @else
                                {{ strtoupper(\Illuminate\Support\Str::substr($headerUser->name, 0, 1)) }}
                            @endif
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors" aria-label="Account">
                            <i class="fas fa-user text-lg"></i>
                        </a>
                        <a href="{{ route('cart.view') }}" class="p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors" aria-label="Shopping bag">
                            <i class="fas fa-shopping-bag text-lg"></i>
                        </a>
                    @endauth
                </div>
            </div>

            <div class="hidden lg:grid lg:grid-cols-[minmax(0,1fr)_auto_minmax(0,1fr)] lg:items-center lg:gap-6 lg:h-[4.25rem]">
                <div class="flex items-center justify-start min-w-0">
                    <a href="{{ auth()->check() ? route('home') : url('/') }}" class="font-serif text-xl font-semibold text-forest tracking-tight truncate">
                        {{ $storeName }}
                    </a>
                </div>
                @auth
                    <nav class="flex items-center justify-center gap-6 xl:gap-8 text-sm font-medium text-stone-600 whitespace-nowrap" aria-label="Primary">
                        <a href="{{ route('home') }}" class="pb-1 border-b-2 transition-colors {{ request()->routeIs('home') ? 'text-forest border-gold' : 'border-transparent hover:text-forest' }}">Products</a>
                        <a href="{{ route('home.incubator') }}" class="pb-1 border-b-2 transition-colors {{ request()->routeIs('home.incubator') ? 'text-forest border-gold' : 'border-transparent hover:text-forest' }}">Incubation</a>
                        
                    </nav>
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('checkout.track-item') }}" class="inline-flex p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors {{ request()->routeIs('checkout.track-item') ? 'text-forest bg-cream' : '' }}" aria-label="Track your orders" title="Track orders">
                            <i class="fas fa-truck text-lg"></i>
                        </a>
                        <a href="{{ route('booking.status') }}" class="inline-flex p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors {{ request()->routeIs('booking.status') ? 'text-forest bg-cream' : '' }}" aria-label="Track egg incubation booking" title="Track egg booking">
                            <i class="fas fa-egg text-lg"></i>
                        </a>
                        <a href="{{ route('cart.view') }}" class="inline-flex p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors" aria-label="Shopping bag">
                            <i class="fas fa-shopping-bag text-lg"></i>
                        </a>
                        <button type="button" class="inline-flex p-2 rounded-full text-stone-500 hover:text-forest hover:bg-cream transition-colors" aria-label="Notifications" title="Notifications">
                            <i class="fas fa-bell text-lg"></i>
                        </button>
                        @php $headerUserLg = auth()->user(); $headerAvatarLg = $headerUserLg->profileAvatarUrl(); @endphp
                        <a href="{{ route('profile.edit') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-forest text-gold-pale text-sm font-semibold hover:bg-forest-light transition-colors ring-2 ring-white shadow-sm overflow-hidden" title="{{ $headerUserLg->name }}" aria-label="Your profile">
                            @if($headerAvatarLg)
                                <img src="{{ $headerAvatarLg }}" alt="" class="h-full w-full object-cover">
                            @else
                                {{ strtoupper(\Illuminate\Support\Str::substr($headerUserLg->name, 0, 1)) }}
                            @endif
                        </a>
                    </div>
                @else
                    <nav class="flex items-center justify-center gap-5 xl:gap-7 text-sm font-medium text-stone-600 whitespace-nowrap">
                        <a href="{{ url('/') }}#heritage" class="hover:text-forest transition-colors">Heritage</a>
                        <a href="{{ url('/') }}#products" class="hover:text-forest transition-colors">Products</a>
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
                @endauth
            </div>
        </div>

        <div id="public-mobile-menu" class="hidden lg:hidden border-t border-stone-100 bg-white">
            <nav class="max-w-7xl mx-auto px-4 py-4 flex flex-col gap-1 text-stone-700 font-medium">
                @auth
                    <a href="{{ route('home') }}" class="py-3 border-b border-stone-100">Heritage</a>
                    <a href="{{ route('profile.edit') }}" class="py-3 border-b border-stone-100">Profile</a>
                    <a href="{{ route('checkout.track-item') }}" class="py-3 border-b border-stone-100">Track orders</a>
                    <a href="{{ route('booking.status') }}" class="py-3 border-b border-stone-100">Track egg booking</a>
                    <a href="{{ route('home.incubator') }}" class="py-3 border-b border-stone-100">Incubation</a>
                    <a href="{{ route('wine.home') }}" class="py-3 border-b border-stone-100">The Cellar</a>
                    <a href="{{ route('question.page') }}" class="py-3 border-b border-stone-100">FAQ</a>
                    <a href="{{ route('contact') }}" class="py-3 border-b border-stone-100">Contact</a>
                    <a href="{{ route('privacy-policy.page') }}" class="py-3 border-b border-stone-100">Privacy Policy</a>
                    <form method="POST" action="{{ route('logout') }}" class="py-3 border-b border-stone-100">
                        @csrf
                        <button type="submit" class="text-left w-full text-forest font-semibold">Log out</button>
                    </form>
                @else
                    <a href="{{ url('/') }}#heritage" class="py-3 border-b border-stone-100">Heritage</a>
                    <a href="{{ url('/') }}#products" class="py-3 border-b border-stone-100">Products</a>
                    <a href="{{ route('question.page') }}" class="py-3 border-b border-stone-100">FAQ</a>
                    <a href="{{ route('contact') }}" class="py-3 border-b border-stone-100">Contact</a>
                    <a href="{{ route('privacy-policy.page') }}" class="py-3 border-b border-stone-100">Privacy Policy</a>
                    <a href="{{ route('login') }}" class="py-3 text-forest">Sign in</a>
                @endauth
            </nav>
        </div>
    </header>
    @endif

    <main>
        @yield('content')
    </main>

    @sectionMissing('auth_full_page')
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
                    <a href="{{ url('/') }}#heritage" class="hover:text-gold-pale transition-colors">Provenance</a>
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

    <nav class="lg:hidden fixed bottom-0 inset-x-0 z-[70] flex justify-center pb-3 pointer-events-none" style="padding-bottom: max(0.75rem, env(safe-area-inset-bottom))" aria-label="Mobile navigation">
        <div class="pointer-events-auto flex items-center gap-1 px-2 py-2 rounded-full bg-forest-dark/95 backdrop-blur shadow-xl border border-white/10">
            <a href="{{ auth()->check() ? route('home') : url('/') }}" class="flex flex-col items-center justify-center w-14 h-14 rounded-full {{ request()->routeIs('home') ? 'bg-gold/20 text-gold-pale' : 'text-white/70 hover:bg-white/10' }}">
                <i class="fas fa-home text-lg"></i>
                <span class="text-[9px] mt-0.5 font-medium">Home</span>
            </a>
            <a href="{{ auth()->check() ? route('home') . '#products' : url('/') . '#products' }}" class="flex flex-col items-center justify-center w-14 h-14 rounded-full text-white/70 hover:bg-white/10">
                <i class="fas fa-store text-lg"></i>
                <span class="text-[9px] mt-0.5 font-medium">Shop</span>
            </a>
            <a href="{{ route('question.page') }}" class="flex flex-col items-center justify-center w-14 h-14 rounded-full text-white/70 hover:bg-white/10">
                <i class="fas fa-circle-question text-lg"></i>
                <span class="text-[9px] mt-0.5 font-medium">FAQ</span>
            </a>
            @auth
                @php $navUser = auth()->user(); $navAvatar = $navUser->profileAvatarUrl(); @endphp
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-14 h-14 rounded-full {{ request()->routeIs('profile.edit') ? 'bg-gold/20 text-gold-pale' : 'text-white/70 hover:bg-white/10' }}" aria-label="Profile">
                    @if($navAvatar)
                        <span class="flex h-7 w-7 rounded-full overflow-hidden ring-2 ring-white/20"><img src="{{ $navAvatar }}" alt="" class="h-full w-full object-cover"></span>
                    @else
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-gold/30 text-gold-pale text-xs font-bold">{{ strtoupper(\Illuminate\Support\Str::substr($navUser->name, 0, 1)) }}</span>
                    @endif
                    <span class="text-[9px] mt-0.5 font-medium">You</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="flex flex-col items-center justify-center w-14 h-14 rounded-full text-white/70 hover:bg-white/10">
                    <i class="fas fa-user text-lg"></i>
                    <span class="text-[9px] mt-0.5 font-medium">Profile</span>
                </a>
            @endauth
        </div>
    </nav>
    @endif

    @include('partials.toast-container')

    <script>
        (function () {
            var btn = document.getElementById('public-menu-btn');
            var menu = document.getElementById('public-mobile-menu');
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
    </script>
    @stack('scripts')
</body>
</html>
