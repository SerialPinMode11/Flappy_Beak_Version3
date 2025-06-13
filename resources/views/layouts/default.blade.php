<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Flappy-Beak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FF6B6B',
                        secondary: '#4ECDC4',
                        accent: '#45B7D1',
                        neutral: '#2C3E50',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .slide {
            display: none;
            transition: all 0.5s ease;
        }

        .slide.active {
            display: block;
        }

        .dot {
            transition: all 0.3s ease;
        }

        .dot.active {
            background-color: #FF6B6B;
        }

        .quick-view {
            opacity: 0;
            transition: all 0.3s ease;
        }

        .product-card:hover .quick-view {
            opacity: 1;
        }

        .star-rating {
            color: #FFD700;
        }

        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Add smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Improve header shadow */
        .header-shadow {
            box-shadow: 0 2px 4px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.04);
        }

        /* Add loading animation */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white header-shadow sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo and Brand -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <i class="fas fa-feather text-primary text-2xl"></i>
                    <h1 class="text-2xl font-bold text-neutral">
                        <span class="text-primary">JM Casabar</span> Pekin Store
                    </h1>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{route('home')}}" class="text-neutral hover:text-primary transition-colors font-medium">Home</a>
                    <a href="{{route('contact')}}" class="text-neutral hover:text-primary transition-colors font-medium">Contact Us</a>
                    <a href="{{route('about')}}" class="text-neutral hover:text-primary transition-colors font-medium">About Us</a>
                    <a href="{{route('login')}}" class="text-neutral hover:text-primary transition-colors font-medium">Log Out</a>
                </nav>

                <!-- Search and Actions -->
                <div class="flex items-center space-x-6">
                    <!-- Search Bar -->
                    <div class="relative hidden md:block">
                        <input type="text" 
                               placeholder="Search products..." 
                               class="w-64 pl-10 pr-4 py-2 border-2 border-gray-100 rounded-full focus:outline-none focus:border-primary transition-colors">
                        <button class="absolute left-3 top-2.5 text-gray-400 hover:text-primary transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{route('checkout')}}" class="relative text-neutral hover:text-primary transition-colors">
                            <i class="fas fa-credit-card text-xl"></i>
                        </a>
                        <a href="{{ route('cart.view') }}" class="relative text-neutral hover:text-primary transition-colors">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span class="absolute -top-2 -right-2 bg-primary text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">0</span>
                        </a>
                        <!-- Mobile Menu Button -->
                        <button class="md:hidden text-neutral hover:text-primary transition-colors">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Search (Hidden by Default) -->
            <div class="mt-4 md:hidden">
                <div class="relative">
                    <input type="text" 
                           placeholder="Search products..." 
                           class="w-full pl-10 pr-4 py-2 border-2 border-gray-100 rounded-full focus:outline-none focus:border-primary transition-colors">
                    <button class="absolute left-3 top-2.5 text-gray-400 hover:text-primary transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Menu (Hidden by Default) -->
    <div class="hidden md:hidden bg-white border-t border-gray-100">
        <nav class="container mx-auto px-4 py-2">
            <a href="{{route('home')}}" class="block py-2 text-neutral hover:text-primary transition-colors">Home</a>
            <a href="{{route('contact')}}" class="block py-2 text-neutral hover:text-primary transition-colors">Contact Us</a>
            <a href="{{route('about')}}" class="block py-2 text-neutral hover:text-primary transition-colors">About Us</a>
            <a href="{{route('login')}}" class="block py-2 text-neutral hover:text-primary transition-colors">Log Out</a>
        </nav>
    </div>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-neutral text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Brand Info -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-feather text-primary text-2xl"></i>
                        <h3 class="text-xl font-bold">Flappy Beak</h3>
                    </div>
                    <p class="text-gray-300 text-sm">
                        Premium farm-raised Pekin duck products delivered straight to your door.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-primary transition-colors">FAQs</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-primary transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-2">
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt mt-1 text-primary"></i>
                            <span class="text-gray-300">Barangay Maroyroy, Macatoc, Oriental Mindoro, Luzon Philippines</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-phone mt-1 text-primary"></i>
                            <span class="text-gray-300">+63 977 6193 200</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-envelope mt-1 text-primary"></i>
                            <span class="text-gray-300">jmcasabar@gmail.com</span>
                        </li>
                    </ul>
                </div>

                
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-gray-700 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">&copy; 2025 Flappy Beak. All rights reserved.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>