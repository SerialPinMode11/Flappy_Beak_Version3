@extends('layouts.default')

@section('title', 'Home Page')

@section('content')
    <div class="container mx-auto px-4 py-8 flex flex-col md:flex-row gap-8">

        <!-- Main Content -->
        <div class="flex-1">
            <!-- FIX: Hero Slider is now fully responsive -->
            <div class="relative mb-12 rounded-xl overflow-hidden shadow-lg">
                <!-- The slide container itself -->
                <div class="slide active">
                    <!-- The content wrapper with responsive padding and flex direction -->
                    <div class="relative bg-gradient-to-r from-neutral to-accent text-white p-8 md:p-12 flex flex-col md:flex-row md:items-center min-h-[350px]">
                        
                        <!-- Text Content (stacks on top on mobile) -->
                        <div class="space-y-6 z-10">
                            <div class="flex items-center gap-4">
                                <img src="{{asset('images/world-based.jpg')}}" alt="Duck icon"
                                    class="w-16 h-16 rounded-full border-4 border-white">
                                <span class="text-xl font-semibold">Egg Incubation Service</span>
                            </div>
                            <!-- FIX: Responsive font size -->
                            <h2 class="text-4xl md:text-5xl font-bold leading-tight">We also offer<br>Private Incubation</h2>
                            <a href="{{ route('home.incubator') }}"
                                class="inline-flex items-center gap-2 bg-[#FF6B6B] hover:bg-[#e65a5a] text-white font-semibold px-6 py-3 rounded-full shadow transition duration-300 ease-in-out">
                                Reserve Now
                                <i class="fas fa-arrow-right w-4 h-4"></i>
                            </a>
                        </div>

                        <!-- FIX: Image is absolutely positioned to prevent layout issues -->
                        <div class="absolute bottom-0 right-0 z-0">
                             <img src="{{asset('images/Experimental.png')}}" alt="Eggs in incubator" 
                                  class="w-48 md:w-56 lg:w-64 opacity-40 md:opacity-100"
                                  style="transform: translateX(20px);">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success or Error Messages -->
            @if(session()->has('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    {{ session()->get('success') }}
                </div>
            @elseif(session()->has('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    {{ session()->get('error') }}
                </div>
            @endif

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
                @foreach($duckproducts as $product)
                    <!-- Product Card Template -->
                    <div class="product-card bg-white rounded-xl p-4 relative group">
                        <span
                            class="absolute top-4 left-4 bg-primary text-white text-sm px-3 py-1 rounded-full font-semibold">-40%</span>
                        <button class="absolute top-4 right-4 text-gray-400 hover:text-primary transition-colors">
                            <i class="far fa-heart text-xl"></i>
                        </button>
                        <div class="relative mb-4">
                            <img src="{{asset($product->product_image)}}" alt="{{ $product->product_name }}"
                                class="w-full h-64 object-cover rounded-lg">
                            <a href="{{route('customer.productformat', $product->id)}}"
                                class="quick-view absolute bottom-4 right-4 bg-white p-3 rounded-full shadow-md hover:bg-primary hover:text-white transition-colors">
                                <i class="fas fa-eye"> </i>
                            </a>
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-semibold text-lg">{{ $product->product_name }}</h3>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-primary font-bold text-xl">₱{{ $product->product_price  }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="star-rating flex text-yellow-400">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="text-gray-500 ml-2">(88)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Your existing slider functionality is fine and doesn't need changes.
        // It will work with the new responsive layout.
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        
        // Check if there are slides before trying to run the slider
        if (slides.length > 0) {
            // If you have dots, their logic would go here.
            // const dots = document.querySelectorAll('.dot'); 
            
            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove('active'));
                // dots.forEach(dot => dot.classList.remove('active'));

                slides[index].classList.add('active');
                // dots[index].classList.add('active');
            }

            // Auto-slide every 5 seconds
            setInterval(() => {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }, 5000);
        }
    </script>
@endpush