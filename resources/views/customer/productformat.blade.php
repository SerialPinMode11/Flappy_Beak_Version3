@extends('layouts.default')

@section('title', 'Product-Format Page')

@section('content')
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="md:flex">
                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="md:flex-shrink-0">
                        <img class="h-96 w-full object-cover md:w-96" src="{{ asset($product->product_image) }}"
                            alt="Product Image">
                    </div>
                    <div class="p-8">
                        <div class="uppercase tracking-wide text-sm text-primary font-semibold">Premium Product</div>
                        <h2 class="mt-2 text-3xl font-bold text-neutral">{{ $product->product_name }}</h2>
                        <p class="mt-2 text-gray-500">{{ $product->product_description }}</p>
                        <div class="mt-4">
                            <span class="text-3xl font-bold text-primary">₱{{ $product->product_price }}</span>
                        </div>
                        <div class="mt-4 flex items-center">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                            </div>
                            <span class="ml-2 text-sm text-gray-500">(4.5 stars, 24 reviews)</span>
                        </div>

                        <div class="mt-8 flex space-x-4">
                            <button type="submit"
                                class="flex-1 bg-primary text-white px-6 py-3 rounded-full hover:bg-primary-dark transition-colors">
                                Add to Cart
                            </button>
                            <button type="button" onclick="buyNow()"
                                class="flex-1 bg-secondary text-white px-6 py-3 rounded-full hover:bg-secondary-dark transition-colors">
                                Buy Now
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection