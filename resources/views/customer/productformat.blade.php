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
                        Premium Product
                    </span>
                </div>
                <form method="POST" action="{{ route('cart.add') }}" class="h-full">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="h-[500px] overflow-hidden">
                        <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" 
                             src="{{ asset($product->product_image) }}"
                             alt="{{ $product->product_name }}">
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
                            @php
                                $headerAvg = $averageRating;
                                $headerFull = (int) floor($headerAvg);
                                $headerHalf = ($headerAvg - $headerFull) >= 0.5;
                                $headerEmpty = 5 - $headerFull - ($headerHalf ? 1 : 0);
                            @endphp
                            @for ($i = 0; $i < $headerFull; $i++) <i class="fas fa-star text-yellow-400"></i> @endfor
                            @if ($headerHalf) <i class="fas fa-star-half-alt text-yellow-400"></i> @endif
                            @for ($i = 0; $i < $headerEmpty; $i++) <i class="far fa-star text-yellow-400"></i> @endfor
                            <span class="ml-2 text-sm text-gray-500">({{ number_format($averageRating, 1) }})</span>
                        </div>
                        <span class="text-sm text-gray-500">|</span>
                        <a href="#reviews" onclick="document.getElementById('tab-reviews-btn').click(); return false;" class="text-sm text-primary hover:underline">{{ $reviewsCount }} Review{{ $reviewsCount !== 1 ? 's' : '' }}</a>
                    </div>
                    <button class="text-gray-400 hover:text-primary transition-colors">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                </div>

                <h1 class="text-3xl font-bold text-neutral mb-4">{{ $product->product_name }}</h1>
                
                <div class="mb-6">
                    <div class="flex items-baseline space-x-3">
                        <span class="text-4xl font-bold text-primary">₱{{ number_format($product->product_price, 2) }}</span>
                        @if(isset($product->original_price))
                            <span class="text-lg text-gray-400 line-through">₱{{ number_format($product->original_price, 2) }}</span>
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

                <form id="add-to-cart-form" method="POST" action="{{ route('cart.add') }}" class="space-y-6">
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
                        <button type="button" id="add-to-cart-button"
                            class="flex-1 bg-primary hover:bg-opacity-90 text-white px-6 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Add to Cart
                        </button>
                        <button type="button" id="buy-now-button"
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
                    <button onclick="openTab(event, 'description')" class="tab-button px-6 py-3 text-primary border-b-2 border-primary">
                        Description
                    </button>
                    <button onclick="openTab(event, 'specifications')" class="tab-button px-6 py-3 text-gray-500 hover:text-primary">
                        Specifications
                    </button>
                    <button id="tab-reviews-btn" onclick="openTab(event, 'reviews')" class="tab-button px-6 py-3 text-gray-500 hover:text-primary">
                        Reviews ({{ $reviewsCount }})
                    </button>
                </div>

                <div id="description" class="tab-content py-6">
                    <div class="prose max-w-none text-gray-600">
                        <p class="mb-4">{{ $product->product_description }}</p>
                        <h3 class="text-lg font-semibold text-neutral mb-3">Key Features:</h3>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>Farm-raised Pekin duck</li>
                            <li>Healthy and strong breed</li>
                            <li>No antibiotics or hormones used</li>
                            <li>Ethically raised in spacious environments</li>
                        </ul>
                    </div>
                </div>

                <div id="specifications" class="tab-content hidden py-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-neutral mb-4">Product Specifications</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Breed</span>
                                    <span class="font-medium text-neutral">Pekin Duck</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Age</span>
                                    <span class="font-medium text-neutral">1 month</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Gender</span>
                                    <span class="font-medium text-neutral">Drake (Male)</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Average Weight</span>
                                    <span class="font-medium text-neutral">1.2 - 1.5 kg</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-neutral mb-4">Care Requirements</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Space Needed</span>
                                    <span class="font-medium text-neutral">4-5 sq ft</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Water Access</span>
                                    <span class="font-medium text-neutral">Daily required</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Feed Type</span>
                                    <span class="font-medium text-neutral">Duck grower feed</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Temperature</span>
                                    <span class="font-medium text-neutral">20-25°C</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="reviews" class="tab-content hidden py-6">
                    <div class="mb-8">
                        <div class="flex items-center flex-wrap gap-4 mb-4">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-neutral">Customer Reviews</h3>
                                <div class="flex items-center mt-2">
                                    @php
                                        $avg = $averageRating;
                                        $full = (int) floor($avg);
                                        $half = ($avg - $full) >= 0.5;
                                        $empty = 5 - $full - ($half ? 1 : 0);
                                    @endphp
                                    <div class="flex items-center text-yellow-400">
                                        @for ($i = 0; $i < $full; $i++) <i class="fas fa-star"></i> @endfor
                                        @if ($half) <i class="fas fa-star-half-alt"></i> @endif
                                        @for ($i = 0; $i < $empty; $i++) <i class="far fa-star"></i> @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-500">Based on {{ $reviewsCount }} review{{ $reviewsCount !== 1 ? 's' : '' }}</span>
                                </div>
                            </div>
                            @if (!$userHasReviewed)
                                <button type="button" id="write-review-btn" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition-colors font-medium">
                                    Write a Review
                                </button>
                            @else
                                <span class="text-sm text-gray-500 italic">You have already reviewed this product.</span>
                            @endif
                        </div>

                        <!-- Review form modal -->
                        <div id="review-modal" class="fixed inset-0 z-[9998] hidden" aria-modal="true" role="dialog">
                            <div class="absolute inset-0 bg-black/50" id="review-modal-backdrop"></div>
                            <div class="fixed left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white rounded-2xl shadow-xl p-6 z-10 max-h-[90vh] overflow-y-auto">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-xl font-semibold text-neutral">Write a Review</h3>
                                    <button type="button" id="review-modal-close" class="text-gray-400 hover:text-gray-600 p-1">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>
                                <form method="POST" action="{{ route('customer.product.review.store', $product) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Your rating</label>
                                        <div class="flex gap-1" id="rating-stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <button type="button" class="rating-star p-1 text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none" data-rating="{{ $i }}" aria-label="{{ $i }} star{{ $i > 1 ? 's' : '' }}">
                                                    <i class="far fa-star"></i>
                                                </button>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" id="rating-input" value="5" required>
                                        @error('rating')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-6">
                                        <label for="review-comment" class="block text-sm font-medium text-gray-700 mb-2">Your review</label>
                                        <textarea id="review-comment" name="comment" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Share your experience with this product (min 10 characters)..." required minlength="10" maxlength="2000">{{ old('comment') }}</textarea>
                                        @error('comment')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        <p class="text-xs text-gray-500 mt-1">Minimum 10 characters.</p>
                                    </div>
                                    <div class="flex gap-3 justify-end">
                                        <button type="button" id="review-modal-cancel" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">Cancel</button>
                                        <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-opacity-90 font-medium">Submit Review</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Reviews list -->
                        <div class="space-y-6">
                            @forelse($reviews as $review)
                                <div class="border-b border-gray-100 pb-6 last:border-0">
                                    <div class="flex items-start mb-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-semibold text-sm">
                                                {{ $review->author_initials }}
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-1 min-w-0">
                                            <h4 class="font-semibold text-neutral">{{ $review->user->name }}</h4>
                                            <div class="flex items-center mt-1">
                                                <div class="flex items-center text-yellow-400">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                    @endfor
                                                </div>
                                                <span class="ml-2 text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $review->comment }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 py-8 text-center">No reviews yet. Be the first to review this product!</p>
                            @endforelse
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
                    <button class="mt-3 w-full bg-gray-100 text-primary font-medium py-2 rounded-lg hover:bg-gray-200 transition-colors">
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
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementsByClassName("tab-button")[0].click();

        // Review modal
        var reviewModal = document.getElementById('review-modal');
        var writeReviewBtn = document.getElementById('write-review-btn');
        if (reviewModal && writeReviewBtn) {
            function openReviewModal() {
                reviewModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setRatingStars(5);
                document.getElementById('rating-input').value = 5;
            }
            function closeReviewModal() {
                reviewModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
            writeReviewBtn.addEventListener('click', openReviewModal);
            document.getElementById('review-modal-close')?.addEventListener('click', closeReviewModal);
            document.getElementById('review-modal-cancel')?.addEventListener('click', closeReviewModal);
            document.getElementById('review-modal-backdrop')?.addEventListener('click', closeReviewModal);
        }

        // Star rating
        function setRatingStars(value) {
            var stars = document.querySelectorAll('#rating-stars .rating-star');
            var input = document.getElementById('rating-input');
            if (!input) return;
            input.value = value;
            stars.forEach(function(btn, i) {
                var star = btn.querySelector('i');
                if (star) {
                    star.className = (i + 1) <= value ? 'fas fa-star' : 'far fa-star';
                }
            });
        }
        document.querySelectorAll('#rating-stars .rating-star').forEach(function(btn) {
            btn.addEventListener('click', function() {
                setRatingStars(parseInt(this.getAttribute('data-rating'), 10));
            });
        });

        // Add to Cart & Buy Now with toast feedback
        const cartForm = document.getElementById('add-to-cart-form');
        const addToCartButton = document.getElementById('add-to-cart-button');
        const buyNowButton = document.getElementById('buy-now-button');

        async function submitCart(redirectToCheckout) {
            if (!cartForm) return;
            try {
                const formData = new FormData(cartForm);
                const response = await fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                if (!response.ok) {
                    let message = 'Failed to add product to cart.';
                    try {
                        const data = await response.json();
                        if (data.message) message = data.message;
                    } catch (e) {}
                    if (window.showToast) {
                        window.showToast(message, 'error');
                    } else {
                        alert(message);
                    }
                    return;
                }

                if (redirectToCheckout) {
                    window.location.href = "{{ route('checkout') }}";
                } else {
                    if (window.showToast) {
                        window.showToast('Product added to cart successfully!', 'success');
                    } else {
                        alert('Product added to cart successfully!');
                    }
                }
            } catch (error) {
                if (window.showToast) {
                    window.showToast('Something went wrong. Please try again.', 'error');
                } else {
                    alert('Something went wrong. Please try again.');
                }
            }
        }

        if (addToCartButton) {
            addToCartButton.addEventListener('click', function (e) {
                e.preventDefault();
                submitCart(false);
            });
        }

        if (buyNowButton) {
            buyNowButton.addEventListener('click', function (e) {
                e.preventDefault();
                submitCart(true);
            });
        }
    });
</script>
@endpush
@endsection