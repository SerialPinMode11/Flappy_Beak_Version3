@extends('layouts.default')

@section('title', $product->product_name)

@section('content')
    <main class="flex-grow container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 flex items-center text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="flex items-center space-x-2">
                    <i class="fas fa-chevron-right text-xs"></i>
                    <a href="#" class="hover:text-primary transition-colors">Products</a>
                </li>
                <li class="flex items-center space-x-2">
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-primary">{{ $product->product_name }}</span>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="md:grid md:grid-cols-2">
                <!-- Product Image Section -->
                <div class="relative group">
                    <div class="absolute top-4 left-4 z-10">
                        <span class="bg-primary text-white text-sm font-semibold px-4 py-1 rounded-full">
                            Premium Wine Product
                        </span>
                    </div>
                    <form method="POST" action="{{ route('cart.add.wine') }}" class="h-full">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="h-[500px] overflow-hidden">
                            <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}">
                        </div>
                    </form>
                    <!-- Image Navigation Dots -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        <button class="w-2 h-2 rounded-full bg-white opacity-75"></button>
                        <button class="w-2 h-2 rounded-full bg-primary"></button>
                        <button class="w-2 h-2 rounded-full bg-white opacity-75"></button>
                    </div>
                </div>

                <!-- Product Details Section -->
                <div class="p-8 lg:p-10">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                                <span class="ml-2 text-sm text-gray-500">(4.5)</span>
                            </div>
                            <span class="text-sm text-gray-500">|</span>
                            <a href="#reviews" class="text-sm text-primary hover:underline">24 Reviews</a>
                        </div>
                        <button class="text-gray-400 hover:text-primary transition-colors">
                            <i class="far fa-heart text-xl"></i>
                        </button>
                    </div>

                    <h1 class="text-3xl font-bold text-neutral mb-4">{{ $product->product_name }}</h1>

                    <div class="mb-6">
                        <div class="flex items-baseline space-x-3">
                            <span
                                class="text-4xl font-bold text-primary">₱{{ number_format($product->product_price, 2) }}</span>
                            @if(isset($product->original_price))
                                <span
                                    class="text-lg text-gray-400 line-through">₱{{ number_format($product->original_price, 2) }}</span>
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                    Save {{ number_format((1 - $product->product_price / $product->original_price) * 100, 0) }}%
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Price includes taxes</p>
                    </div>

                    <div class="border-t border-b border-gray-100 py-6 mb-6">
                        <p class="text-gray-600 leading-relaxed">{{ $product->product_description }}</p>
                    </div>

                    <form method="POST" action="{{ route('cart.add') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Quantity Selector -->
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <div class="flex items-center w-32">
                                <button type="button" onclick="decrementQuantity()"
                                    class="w-10 h-10 bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors rounded-l-lg">
                                    <i class="fas fa-minus text-gray-600"></i>
                                </button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1"
                                    class="w-12 h-10 border-y border-gray-200 text-center focus:outline-none">
                                <button type="button" onclick="incrementQuantity()"
                                    class="w-10 h-10 bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors rounded-r-lg">
                                    <i class="fas fa-plus text-gray-600"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit"
                                class="flex-1 bg-primary hover:bg-opacity-90 text-white px-6 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                            <button type="submit"
                                class="flex-1 bg-secondary hover:bg-opacity-90 text-white px-6 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center">
                                <i class="fas fa-bolt mr-2"></i>
                                Buy Now
                            </button>
                        </div>
                    </form>

                    <!-- Additional Info -->
                    <div class="mt-8 grid grid-cols-2 gap-4">
                        <div class="flex items-center space-x-3 text-sm text-gray-500">
                            <i class="fas fa-truck text-secondary"></i>
                            <span>Free shipping over ₱5000</span>
                        </div>
                        <div class="flex items-center space-x-3 text-sm text-gray-500">
                            <i class="fas fa-shield-alt text-secondary"></i>
                            <span>Secure payment</span>
                        </div>
                        <div class="flex items-center space-x-3 text-sm text-gray-500">
                            <i class="fas fa-exchange-alt text-secondary"></i>
                            <span>14-day returns</span>
                        </div>
                        <div class="flex items-center space-x-3 text-sm text-gray-500">
                            <i class="fas fa-check-circle text-secondary"></i>
                            <span>Quality guaranteed</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Tabs -->
            <div class="border-t border-gray-100">
                <div class="p-6 md:p-8">
                    <div class="flex border-b border-gray-200">
                        <button onclick="openTab(event, 'description')"
                            class="tab-button px-6 py-3 text-primary border-b-2 border-primary">
                            Description
                        </button>
                        <button onclick="openTab(event, 'specifications')"
                            class="tab-button px-6 py-3 text-gray-500 hover:text-primary">
                            Specifications
                        </button>
                        <button onclick="openTab(event, 'reviews')"
                            class="tab-button px-6 py-3 text-gray-500 hover:text-primary">
                            Reviews (24)
                        </button>
                    </div>

                    <div id="description" class="tab-content py-6">
                        <div class="prose max-w-none text-gray-600">
                            <p class="mb-4">{{ $product->product_description }}</p>
                            <h3 class="text-lg font-semibold text-neutral mb-3">Key Features:</h3>
                            <ul class="list-disc pl-5 space-y-2">
                                <li>Crafted from macopa fruit cultivated on JM Casabar Private Farm.</li>
                                <li>Handcrafted with care in limited quantities.</li>
                                <li> Emphasizing traditional methods for authentic flavor.</li>
                                <li>Showcasing the distinct taste of Philippine macopa fruit.</li>
                            </ul>
                        </div>
                    </div>

                    <div id="specifications" class="tab-content hidden py-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold text-neutral mb-4">Product Specifications</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Wine Variant</span>
                                        <span class="font-medium text-neutral">{{ $product->product_name }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Age</span>
                                        <span class="font-medium text-neutral">6 month</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Average Height</span>
                                        <span class="font-medium text-neutral">400g</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Average Volume</span>
                                        <span class="font-medium text-neutral">720ml</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-neutral mb-4">Care Requirements</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Storage Temperature</span>
                                        <span class="font-medium text-neutral">10−15°C</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Light Exposure</span>
                                        <span class="font-medium text-neutral">Store in a dark place, away from direct sunlight or strong artificial light.</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Humidity</span>
                                        <span class="font-medium text-neutral">70−80% relative humidity</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Bottle Position</span>
                                        <span class="font-medium text-neutral">Store horizontally  to keep the cork moist and prevent it from drying out and shrinking</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="reviews" class="tab-content hidden py-6">
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-neutral">Customer Reviews</h3>
                                    <div class="flex items-center mt-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star-half-alt text-yellow-400"></i>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-500">Based on 24 reviews</span>
                                    </div>
                                </div>
                                <button
                                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition-colors">
                                    Write a Review
                                </button>
                            </div>

                            <!-- Sample Reviews -->
                            <div class="space-y-6">
                                <div class="border-b pb-6">
                                    <div class="flex items-start mb-4">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-semibold">
                                                JD
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="font-semibold text-neutral">Juan Dela Cruz</h4>
                                            <div class="flex items-center mt-1">
                                                <div class="flex items-center text-yellow-400">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <span class="ml-2 text-sm text-gray-500">2 weeks ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600">
                                        Excellent quality duck! Very healthy and active. The delivery was prompt and the
                                        duck arrived in perfect condition.
                                        Would definitely recommend to others.
                                    </p>
                                </div>

                                <div class="border-b pb-6">
                                    <div class="flex items-start mb-4">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-10 h-10 rounded-full bg-secondary text-white flex items-center justify-center font-semibold">
                                                MR
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="font-semibold text-neutral">Maria Reyes</h4>
                                            <div class="flex items-center mt-1">
                                                <div class="flex items-center text-yellow-400">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <span class="ml-2 text-sm text-gray-500">1 month ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600">
                                        Good quality duck, growing well and healthy. Customer service was helpful with my
                                        questions about care requirements.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Products -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-neutral mb-6">You May Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Similar Product Cards -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden group">
                    <div class="relative">
                        <img src="{{ asset('images/Female_Pekin_Duck.jpg') }}" alt="Female Pekin Duck"
                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-2 left-2">
                            <span class="bg-primary text-white text-xs px-2 py-1 rounded-full">Premium</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-neutral">Female Pekin Duck</h3>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400 text-xs">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="ml-1 text-xs text-gray-500">(18)</span>
                        </div>
                        <div class="mt-2">
                            <span class="font-bold text-primary">₱2,300.00</span>
                        </div>
                        <button
                            class="mt-3 w-full bg-gray-100 text-primary font-medium py-2 rounded-lg hover:bg-gray-200 transition-colors">
                            View Details
                        </button>
                    </div>
                </div>

                <!-- Add more similar product cards here -->
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            function buyNow() {
                const form = document.querySelector('form');
                form.action = "{{ route('checkout') }}";
                form.submit();
            }

            function incrementQuantity() {
                const input = document.getElementById('quantity');
                input.value = parseInt(input.value) + 1;
            }

            function decrementQuantity() {
                const input = document.getElementById('quantity');
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            }

            function openTab(evt, tabName) {
                const tabContents = document.getElementsByClassName("tab-content");
                for (let i = 0; i < tabContents.length; i++) {
                    tabContents[i].style.display = "none";
                }

                const tabButtons = document.getElementsByClassName("tab-button");
                for (let i = 0; i < tabButtons.length; i++) {
                    tabButtons[i].className = tabButtons[i].className.replace(" text-primary border-b-2 border-primary", " text-gray-500");
                }

                document.getElementById(tabName).style.display = "block";
                evt.currentTarget.className += " text-primary border-b-2 border-primary";
            }

            // Set default tab
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementsByClassName("tab-button")[0].click();
            });
        </script>
    @endpush
@endsection