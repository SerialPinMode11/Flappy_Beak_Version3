<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body class="min-h-screen bg-slate-50 font-sans">
    <!-- Header -->
    <header class="bg-gradient-to-r from-emerald-600 to-teal-700 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                 <img src="{{ asset('images/Flappy_IoT.png') }}" alt="Flappy IoT Logo" class="w-8 h-8">
                <h1 class="text-2xl font-bold tracking-wide">JM Casabar Mini Farm</h1>
            </div>
            
            <div class="hidden md:flex items-center space-x-6">
                <a href="#" onclick="redirectToLogin(event)" class="hover:text-yellow-300 transition-colors font-medium">Home</a>
                <a href="#products" onclick="redirectToLogin(event)" class="hover:text-yellow-300 transition-colors font-medium">Products</a>
                <a href="#about" onclick="redirectToLogin(event)" class="hover:text-yellow-300 transition-colors font-medium">About Us</a>
                <a href="#" onclick="redirectToLogin(event)" class="hover:text-yellow-300 transition-colors font-medium">Contact</a>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="relative hidden md:block">
                    <input type="text" placeholder="Search our products..." class="pl-4 pr-10 py-2 border-2 border-teal-300 rounded-lg w-64 shadow-sm focus:ring-2 focus:ring-yellow-300 focus:outline-none">
                    <button class="absolute right-3 top-2.5" onclick="redirectToLogin()">
                        <i class="fas fa-search text-gray-500"></i>
                    </button>
                </div>
                <button class="hover:text-yellow-300 transition-colors relative">
                    <i class="far fa-heart text-xl" onclick="redirectToLogin(event)"></i>
                    <span class="absolute -top-2 -right-2 bg-yellow-400 text-xs text-teal-800 font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </button>
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
                        <a href="#products" onclick="redirectToLogin(event)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors shadow-md text-center">
                            Shop Now
                        </a>
                        <a href="#about" onclick="redirectToLogin(event)" class="border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-50 font-semibold px-6 py-3 rounded-lg transition-colors text-center">
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
                
                <!-- Product Card 1 -->
                <div class="product-card bg-white rounded-xl shadow-md overflow-hidden group">
                    <div class="relative">
                        <span class="absolute top-3 left-3 bg-emerald-600 text-white text-sm px-3 py-1 rounded-full font-medium z-10">
                            Best Seller
                        </span>
                        <div class="overflow-hidden">
                            <img src="{{asset('images/pekin-raw-meat.jpg')}}" alt="Whole Butchered Duck Meat" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <button class="quick-view absolute bottom-3 right-3 bg-white p-2 rounded-full shadow-lg hover:bg-emerald-600 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100 z-10">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="p-5 border-t">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-slate-500 text-sm">(42 reviews)</span>
                        </div>
                        <h3 class="font-bold text-lg text-teal-900 mb-1">Butchered Raw Pekin Duck Meat</h3>
                        <p class="text-slate-600 text-sm mb-3">Farm-raised, hand-processed whole duck, perfect for roasting.</p>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-emerald-600 font-bold text-xl">₱1650.00</span>
                            <span class="text-slate-400 line-through">₱2000.00</span>
                            <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-full">Save 24%</span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="redirectToLogin()" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg transition-colors duration-300 flex items-center justify-center">
                                <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                            </button>
                            <button onclick="redirectToLogin()" class="w-12 border border-emerald-600 text-emerald-600 py-2 rounded-lg hover:bg-emerald-50 transition-colors duration-300">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product Card 2 -->
                <div class="product-card bg-white rounded-xl shadow-md overflow-hidden group">
                    <div class="relative">
                        <span class="absolute top-3 left-3 bg-yellow-400 text-teal-900 text-sm px-3 py-1 rounded-full font-medium z-10">
                            Fresh
                        </span>
                        <div class="overflow-hidden">
                            <img src="{{asset('images/pekin-white-egg.jpg')}}" alt="Pekin Duck Eggs" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <button class="quick-view absolute bottom-3 right-3 bg-white p-2 rounded-full shadow-lg hover:bg-emerald-600 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100 z-10" onclick="redirectToLogin()">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="p-5 border-t">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-slate-500 text-sm">(38 reviews)</span>
                        </div>
                        <h3 class="font-bold text-lg text-teal-900 mb-1">Deluxe Pekin Egg Set</h3>
                        <p class="text-slate-600 text-sm mb-3">Farm-fresh duck eggs, rich in flavor and perfect for baking.</p>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-emerald-600 font-bold text-xl">₱300.00</span>
                            <span class="text-slate-400 line-through">₱350.00</span>
                            <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-full">Save 24%</span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="redirectToLogin()" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg transition-colors duration-300 flex items-center justify-center">
                                <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                            </button>
                            <button onclick="redirectToLogin()" class="w-12 border border-emerald-600 text-emerald-600 py-2 rounded-lg hover:bg-emerald-50 transition-colors duration-300">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product Card 3 -->
                <div class="product-card bg-white rounded-xl shadow-md overflow-hidden group">
                    <div class="relative">
                        <span class="absolute top-3 left-3 bg-emerald-600 text-white text-sm px-3 py-1 rounded-full font-medium z-10">
                            Limited
                        </span>
                        <div class="overflow-hidden">
                            <img src="{{asset('images/Male_Pekin_Duck.jpg')}}" alt="Drake Pekin Duck" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <button class="quick-view absolute bottom-3 right-3 bg-white p-2 rounded-full shadow-lg hover:bg-emerald-600 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100 z-10">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="p-5 border-t">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="text-slate-500 text-sm">(29 reviews)</span>
                        </div>
                        <h3 class="font-bold text-lg text-teal-900 mb-1">Adult Drake Pekin Duck</h3>
                        <p class="text-slate-600 text-sm mb-3">Healthy adult male Pekin duck for breeding or farm raising.</p>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-emerald-600 font-bold text-xl">₱2500.00</span>
                            <span class="text-slate-400 line-through">₱3000.00</span>
                            <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-full">Save 16%</span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="redirectToLogin()" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg transition-colors duration-300 flex items-center justify-center">
                                <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                            </button>
                            <button onclick="redirectToLogin()" class="w-12 border border-emerald-600 text-emerald-600 py-2 rounded-lg hover:bg-emerald-50 transition-colors duration-300">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product Card 4 -->
                <div class="product-card bg-white rounded-xl shadow-md overflow-hidden group">
                    <div class="relative">
                        <span class="absolute top-3 left-3 bg-emerald-600 text-white text-sm px-3 py-1 rounded-full font-medium z-10">
                            Popular
                        </span>
                        <div class="overflow-hidden">
                            <img src="{{asset('images/Female_Pekin_Duck.jpg')}}" alt="Hen Pekin Duck" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <button class="quick-view absolute bottom-3 right-3 bg-white p-2 rounded-full shadow-lg hover:bg-emerald-600 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100 z-10">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="p-5 border-t">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-slate-500 text-sm">(35 reviews)</span>
                        </div>
                        <h3 class="font-bold text-lg text-teal-900 mb-1">Adult Hen Pekin Duck</h3>
                        <p class="text-slate-600 text-sm mb-3">Healthy adult female Pekin duck, excellent egg layer.</p>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-emerald-600 font-bold text-xl">₱3300.00</span>
                            <span class="text-slate-400 line-through">₱4000.00</span>
                            <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-full">Save 18%</span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="redirectToLogin()" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg transition-colors duration-300 flex items-center justify-center">
                                <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                            </button>
                            <button onclick="redirectToLogin()" class="w-12 border border-emerald-600 text-emerald-600 py-2 rounded-lg hover:bg-emerald-50 transition-colors duration-300">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product Card 5 -->
                <div class="product-card bg-white rounded-xl shadow-md overflow-hidden group">
                    <div class="relative">
                        <span class="absolute top-3 left-3 bg-yellow-400 text-teal-900 text-sm px-3 py-1 rounded-full font-medium z-10">
                            Cute!
                        </span>
                        <div class="overflow-hidden">
                            <img src="{{asset('images/pekin-young-alive.jpg')}}" alt="Pekin Duckling" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <button class="quick-view absolute bottom-3 right-3 bg-white p-2 rounded-full shadow-lg hover:bg-emerald-600 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100 z-10">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="p-5 border-t">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-slate-500 text-sm">(52 reviews)</span>
                        </div>
                        <h3 class="font-bold text-lg text-teal-900 mb-1">One-Week-Old Duckling</h3>
                        <p class="text-slate-600 text-sm mb-3">Adorable one-week-old Pekin duckling, healthy and active.</p>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-emerald-600 font-bold text-xl">₱3000.00</span>
                            <span class="text-slate-400 line-through">₱3500.00</span>
                            <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-full">Save 20%</span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="redirectToLogin()" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg transition-colors duration-300 flex items-center justify-center">
                                <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                            </button>
                            <button onclick="redirectToLogin()" class="w-12 border border-emerald-600 text-emerald-600 py-2 rounded-lg hover:bg-emerald-50 transition-colors duration-300">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>
            
           
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
                        <i class="fas fa-heart text-emerald-600 text-2xl"></i>
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
                        <a href="https://web.facebook.com/IMORTALxiiJERRY" class="text-teal-200 hover:text-yellow-300"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/jerry_casabar?igsh=Y2x6enlmdHB3cmhq" class="text-teal-200 hover:text-yellow-300"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-teal-200 hover:text-yellow-300"><i class="fab fa-telegram-plane"></i></a>
                        <a href="#" class="text-teal-200 hover:text-yellow-300"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href='{{route('login')}}' class="text-teal-200 hover:text-yellow-300">Home</a></li>
                        <li><a href='{{route('login')}}' class="text-teal-200 hover:text-yellow-300">Products</a></li>
                        <li><a href='{{route('login')}}' class="text-teal-200 hover:text-yellow-300">About Us</a></li>
                        <li><a href='{{route('login')}}' class="text-teal-200 hover:text-yellow-300">Contact</a></li>
                        <li><a href='{{route('login')}}' class="text-teal-200 hover:text-yellow-300">FAQ</a></li>
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

    <script>
        function redirectToLogin() {
            event.preventDefault(); // Prevent default anchor behavior
            window.location.href = '{{route('login')}}';
        }
    </script>
</body>
</html>