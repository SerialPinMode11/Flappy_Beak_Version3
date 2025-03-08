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
    </style>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-primary">JM Casabar Pekin Store</h1>
            <nav class="hidden md:flex space-x-8">
                <a href="{{route('home')}}" class="text-neutral hover:text-primary transition-colors">Home</a>
                <a href="{{route('contact')}}" class="text-neutral hover:text-primary transition-colors">Contact Us</a>
                <a href="{{route('about')}}" class="text-neutral hover:text-primary transition-colors">About Us</a>
                <a href="{{route('login')}}" class="text-neutral hover:text-primary transition-colors">Log Out</a>
            </nav>
            <div class="flex items-center space-x-6">
                <div class="relative">
                    <input type="text" placeholder="What are you looking for?" class="pl-4 pr-10 py-2 border-2 border-gray-200 rounded-full w-64 focus:outline-none focus:border-primary transition-colors">
                    <button class="absolute right-3 top-2.5 text-gray-400 hover:text-primary transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <button class="text-neutral hover:text-primary transition-colors">
                    <a href="{{route('checkout')}}">
                        <i class="fas fa-credit-card text-xl"></i>
                    </a> 
                </button>
                <button class="text-neutral hover:text-primary transition-colors">
                    <a href="{{ route('cart.view' )}}">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </a>
                </button>
            </div>
        </div>
    </header>

    <!-- Make the main content push the footer down -->
    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-neutral text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 Flappy Beak. All rights reserved.</p>
        </div>
    </footer>

    @stack('scripts')
</body>


</html>