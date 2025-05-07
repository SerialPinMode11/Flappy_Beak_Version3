@extends('layouts.default')

@section('title', 'Home Page')

@section('content')
    <div class="container mx-auto px-4 py-8 flex flex-col md:flex-row gap-8">


        <!-- Main Content -->
        <div class="flex-1">
            <!-- Hero Slider -->
            <div class="relative mb-12 rounded-xl overflow-hidden shadow-lg" style="height: 350px;">
                <div class="slide active">
                    <div class="bg-gradient-to-r from-neutral to-accent text-white p-12 flex items-center justify-between">
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <img src="{{asset('images/Uncured_Duck_Breast.jpg')}}" alt="Duck icon"
                                    class="w-16 h-16 rounded-full border-4 border-white">
                                <span class="text-xl font-semibold">Duck Raw Meat</span>
                            </div>
                            <h2 class="text-5xl font-bold leading-tight">Up to 10% off<br>Butchered</h2>
                            <button
                                class="flex items-center gap-3 text-white bg-primary hover:bg-primary-dark px-6 py-3 rounded-full transition-colors">
                                Shop Now
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                        <img src="{{asset('images/Uncured_Duck_Breast.jpg')}}" alt="Raw meat"
                            class="w-1/2 rounded-lg shadow-xl" style="width: 200px;">
                    </div>
                    <!--new push -->
                    

                </div>
                
                
            </div>

            <div>
                <!-- Product Navigation Tabs -->
                <div class="mt-6 mb-8">
                    <div class="flex flex-wrap justify-center gap-2 md:gap-4">
                        <a href="#" class="px-6 py-3 bg-yellow-500 text-white rounded-full font-medium hover:bg-opacity-90 transition-colors flex items-center gap-2">
                            <i class="fas fa-wine-bottle"></i>
                            Duck Products
                        </a>
                        <a href="#" class="px-6 py-3 bg-primary text-white rounded-full font-medium hover:bg-opacity-90 transition-colors flex items-center gap-2">
                            <i class="fas fa-wine-bottle"></i>
                            Wine Products
                        </a>
                        <a href="{{route('home.incubator')}}" class="px-6 py-3 bg-accent text-white rounded-full font-medium hover:bg-opacity-90 transition-colors flex items-center gap-2">
                            <i class="fas fa-temperature-high"></i>
                            Incubator Rents
                        </a>
                        <a href="#" class="px-6 py-3 bg-neutral text-white rounded-full font-medium hover:bg-opacity-90 transition-colors flex items-center gap-2">
                            <i class="fas fa-piggy-bank"></i>
                            Hog Products
                        </a>
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
                            <button
                                class="quick-view absolute bottom-4 right-4 bg-white p-3 rounded-full shadow-md hover:bg-primary hover:text-white transition-colors">

                                <a href="{{route('customer.productformat', $product->id)}}">
                                    <i class="fas fa-eye"> </i>
                                </a>

                            </button>
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-semibold text-lg">{{ $product->product_name }}</h3>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-primary font-bold text-xl">₱{{ $product->product_price  }}</span>

                                </div>
                                <div class="flex items-center">
                                    <div class="star-rating flex">
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
                <!-- Repeat product cards for other items -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Slider functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

        // Auto-slide every 5 seconds
        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }, 5000);
    </script>
@endpush