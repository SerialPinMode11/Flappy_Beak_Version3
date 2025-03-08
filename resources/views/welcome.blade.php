<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products - Flappy-Beak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-card:hover .quick-view {
            opacity: 1;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100">
    <header class="bg-gradient-to-r from-red-500 to-red-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold tracking-wide">JM Casabar Pekin Duck Products</h1>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="What are you looking for?" class="pl-4 pr-10 py-2 border-2 border-red-300 rounded-lg w-64 shadow-sm focus:ring-2 focus:ring-yellow-300">
                    <button class="absolute right-3 top-2.5">
                        <i class="fas fa-search text-gray-500"></i>
                    </button>
                </div>
                <button class="hover:text-yellow-300 transition-colors">
                    <i class="far fa-heart"></i>
                </button>
                <button class="hover:text-yellow-300 transition-colors">
                    <i class="fas fa-shopping-cart"></i>
                </button>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">Our Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            
            <!-- Product Cards 1 -->
            <div class="product-card bg-white rounded-lg shadow-md p-4 relative group transform hover:scale-105 transition-transform">
                <span class="absolute top-2 left-2 bg-gradient-to-r from-red-500 to-yellow-500 text-white text-sm px-2 py-1 rounded">-40%</span>

                <div class="relative">
                    <img src="{{asset('images/pekin-raw-meat.jpg')}}" alt="Whole Butchered Duck Meat" class="w-full rounded-lg">
                    <button class="quick-view absolute bottom-2 right-2 bg-white p-2 rounded-full shadow-lg hover:bg-red-500 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="mt-4 space-y-2">
                    <h3 class="font-semibold text-gray-700">Whole Butchered Duck Meat</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-red-500 font-bold">$120</span>
                        <span class="text-gray-400 line-through">$160</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-gray-500">(88)</span>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button onclick="redirectToLogin()" class="flex-1 bg-gradient-to-r from-red-500 to-yellow-500 text-white py-2 rounded hover:bg-red-600 transition-colors duration-300">
                            Add to Cart
                        </button>
                        <button onclick="redirectToLogin()" class="flex-1 border border-red-500 text-red-500 py-2 rounded hover:bg-red-50 transition-colors duration-300">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
            <!-- Repeat product card structure -->
              <!-- Product Cards 2 -->
            <div class="product-card bg-white rounded-lg shadow-md p-4 relative group transform hover:scale-105 transition-transform">
                <span class="absolute top-2 left-2 bg-gradient-to-r from-red-500 to-yellow-500 text-white text-sm px-2 py-1 rounded">-40%</span>

                <div class="relative">
                    <img src="{{asset('images/pekin-white-egg.jpg')}}" alt="Whole Butchered Duck Meat" class="w-full rounded-lg">
                    <button class="quick-view absolute bottom-2 right-2 bg-white p-2 rounded-full shadow-lg hover:bg-red-500 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="mt-4 space-y-2">
                    <h3 class="font-semibold text-gray-700">Deluxe Pekin Egg Set</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-red-500 font-bold">$120</span>
                        <span class="text-gray-400 line-through">$160</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-gray-500">(88)</span>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button onclick="redirectToLogin()" class="flex-1 bg-gradient-to-r from-red-500 to-yellow-500 text-white py-2 rounded hover:bg-red-600 transition-colors duration-300">
                            Add to Cart
                        </button>
                        <button onclick="redirectToLogin()" class="flex-1 border border-red-500 text-red-500 py-2 rounded hover:bg-red-50 transition-colors duration-300">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
            <!-- Repeat product card structure -->
              <!-- Product Cards 3 -->
              <div class="product-card bg-white rounded-lg shadow-md p-4 relative group transform hover:scale-105 transition-transform">
                <span class="absolute top-2 left-2 bg-gradient-to-r from-red-500 to-yellow-500 text-white text-sm px-2 py-1 rounded">-20%</span>

                <div class="relative">
                    <img src="{{asset('images/Male_Pekin_Duck.jpg')}}" alt="Whole Butchered Duck Meat" class="w-full rounded-lg">
                    <button class="quick-view absolute bottom-2 right-2 bg-white p-2 rounded-full shadow-lg hover:bg-red-500 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="mt-4 space-y-2">
                    <h3 class="font-semibold text-gray-700">Drake Pekin Duck</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-red-500 font-bold">$120</span>
                        <span class="text-gray-400 line-through">$160</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-gray-500">(88)</span>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button onclick="redirectToLogin()" class="flex-1 bg-gradient-to-r from-red-500 to-yellow-500 text-white py-2 rounded hover:bg-red-600 transition-colors duration-300">
                            Add to Cart
                        </button>
                        <button onclick="redirectToLogin()" class="flex-1 border border-red-500 text-red-500 py-2 rounded hover:bg-red-50 transition-colors duration-300">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
            <!-- Repeat product card structure -->
              <!-- Product Cards 4 -->
              <div class="product-card bg-white rounded-lg shadow-md p-4 relative group transform hover:scale-105 transition-transform">
                <span class="absolute top-2 left-2 bg-gradient-to-r from-red-500 to-yellow-500 text-white text-sm px-2 py-1 rounded">-40%</span>

                <div class="relative">
                    <img src="{{asset('images/Female_Pekin_Duck.jpg')}}" alt="Whole Butchered Duck Meat" class="w-full rounded-lg">
                    <button class="quick-view absolute bottom-2 right-2 bg-white p-2 rounded-full shadow-lg hover:bg-red-500 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="mt-4 space-y-2">
                    <h3 class="font-semibold text-gray-700">Hen Pekin Duck</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-red-500 font-bold">$120</span>
                        <span class="text-gray-400 line-through">$160</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-gray-500">(88)</span>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button onclick="redirectToLogin()" class="flex-1 bg-gradient-to-r from-red-500 to-yellow-500 text-white py-2 rounded hover:bg-red-600 transition-colors duration-300">
                            Add to Cart
                        </button>
                        <button onclick="redirectToLogin()" class="flex-1 border border-red-500 text-red-500 py-2 rounded hover:bg-red-50 transition-colors duration-300">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
            <!-- Repeat product card structure -->
              <!-- Product Cards 5 -->
              <div class="product-card bg-white rounded-lg shadow-md p-4 relative group transform hover:scale-105 transition-transform">
                <span class="absolute top-2 left-2 bg-gradient-to-r from-red-500 to-yellow-500 text-white text-sm px-2 py-1 rounded">-40%</span>

                <div class="relative">
                    <img src="{{asset('images/pekin-young-alive.jpg')}}" alt="Whole Butchered Duck Meat" class="w-full rounded-lg">
                    <button class="quick-view absolute bottom-2 right-2 bg-white p-2 rounded-full shadow-lg hover:bg-red-500 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="mt-4 space-y-2">
                    <h3 class="font-semibold text-gray-700">One Week Old Pekin Ducling</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-red-500 font-bold">$120</span>
                        <span class="text-gray-400 line-through">$160</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-gray-500">(88)</span>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button onclick="redirectToLogin()" class="flex-1 bg-gradient-to-r from-red-500 to-yellow-500 text-white py-2 rounded hover:bg-red-600 transition-colors duration-300">
                            Add to Cart
                        </button>
                        <button onclick="redirectToLogin()" class="flex-1 border border-red-500 text-red-500 py-2 rounded hover:bg-red-50 transition-colors duration-300">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
            <!-- Repeat product card structure -->
            
        </div>
    </main>

    <script>
        function redirectToLogin() {
            window.location.href = '{{route('login')}}';
        }
    </script>
</body>
</html>
