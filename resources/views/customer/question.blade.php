@extends('layouts.default')

@section('title', 'Frequently Asked Questions - JM Casabar Private Farm')

@push('styles')
<style>
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }
    .faq-answer.active {
        max-height: 500px;
        transition: max-height 0.3s ease-in;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-blue-600 via-purple-600 to-blue-800 text-white">
    <div class="container mx-auto px-4 py-16 text-center">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Frequently Asked Questions</h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">Find answers to common questions about JM Casabar Private Farm</p>
            
            <!-- Search Bar -->
            <div class="max-w-md mx-auto relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="faqSearch" 
                       class="w-full pl-10 pr-4 py-3 rounded-full text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50" 
                       placeholder="Search questions..." 
                       onkeyup="searchFAQ()">
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-white py-12 -mt-8 relative z-10">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="text-3xl font-bold text-blue-600 mb-2">24/7</div>
                <div class="text-gray-600 text-sm font-medium">Online Support</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="text-3xl font-bold text-green-600 mb-2">1000+</div>
                <div class="text-gray-600 text-sm font-medium">Happy Customers</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="text-3xl font-bold text-yellow-600 mb-2">5★</div>
                <div class="text-gray-600 text-sm font-medium">Customer Rating</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="text-3xl font-bold text-purple-600 mb-2">50+</div>
                <div class="text-gray-600 text-sm font-medium">Questions Answered</div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Content -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        
        <!-- General Information -->
        <div class="mb-12" data-category="general">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-2xl p-6 text-white">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">General Farm & Ordering Information</h2>
                        <p class="opacity-90">Everything you need to know about ordering and our farm</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-b-2xl shadow-lg border border-gray-200">
                <!-- FAQ Item 1 -->
                <div class="faq-item border-b border-gray-100 last:border-b-0" data-keywords="location address bacoor calabarzon philippines">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">Where is JM Casabar Private Farm located?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <p>JM Casabar Private Farm is located in <span class="font-semibold text-gray-800">Sitio Maroyroy, Macatoc, Victoria, Mimaropa, Philippines</span>. Our farm is easily accessible and we provide detailed directions with every order confirmation.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="faq-item border-b border-gray-100 last:border-b-0" data-keywords="operating hours online orders 24/7">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">What are your operating hours for online orders?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <p>Our online store is open <span class="font-semibold text-gray-800">24/7</span> for placing orders. Processing and delivery schedules will be specified during checkout and in your order confirmation email.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="faq-item border-b border-gray-100 last:border-b-0" data-keywords="payment methods gcash paymaya bank transfer cod">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">What payment methods do you accept?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                    <h4 class="font-semibold text-blue-800 mb-3 flex items-center">
                                        <i class="fas fa-credit-card mr-2"></i>
                                        Digital Payments
                                    </h4>
                                    <ul class="space-y-1 text-blue-700">
                                        <li>• GCash</li>
                                        <li>• PayMaya</li>
                                        <li>• Online Bank Transfers (BDO, BPI)</li>
                                        <li>• Credit/Debit Cards</li>
                                    </ul>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                    <h4 class="font-semibold text-green-800 mb-3 flex items-center">
                                        <i class="fas fa-money-bill mr-2"></i>
                                        Traditional Methods
                                    </h4>
                                    <ul class="space-y-1 text-green-700">
                                        <li>• Cash on Delivery (COD)</li>
                                        <li>• Bank Deposit</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="faq-item border-b border-gray-100 last:border-b-0" data-keywords="bulk orders discount wholesale">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">Do you offer discounts for bulk orders?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <p class="mb-4">Yes! We offer attractive discounts for bulk orders. Contact us directly with your requirements for a customized quote.</p>
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                <h4 class="font-semibold text-yellow-800 mb-2 flex items-center">
                                    <i class="fas fa-percentage mr-2"></i>
                                    Bulk Pricing Applies To:
                                </h4>
                                <ul class="space-y-1 text-yellow-700">
                                    <li>• Orders of 10+ items</li>
                                    <li>• Orders exceeding ₱5,000</li>
                                    <li>• Custom quotes available</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="faq-item" data-keywords="order confirmation email sms">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">How do I know my order has been confirmed?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <p class="mb-4">You will receive both <span class="font-semibold text-gray-800">email and SMS confirmation</span> once your order has been successfully placed and payment verified.</p>
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <h4 class="font-semibold text-green-800 mb-2 flex items-center">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Your confirmation includes:
                                </h4>
                                <ul class="space-y-1 text-green-700">
                                    <li>• Order number</li>
                                    <li>• Estimated delivery time</li>
                                    <li>• Tracking information</li>
                                    <li>• Contact details</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Macopa Wine -->
        <div class="mb-12" data-category="wine">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-t-2xl p-6 text-white">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-wine-bottle text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Macopa Wine</h2>
                        <p class="opacity-90">Learn about our artisanal macopa wine</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-b-2xl shadow-lg border border-gray-200">
                <!-- Wine FAQ Item 1 -->
                <div class="faq-item border-b border-gray-100 last:border-b-0" data-keywords="macopa wine artisanal fruit wine malay apple">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">What is JM Casabar Private Farm Macopa Wine?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <p class="mb-4">Our macopa wine is an <span class="font-semibold text-gray-800">artisanal fruit wine</span> crafted exclusively from ripe macopa fruit ("Malay apple" or <em>Syzygium samarangense</em>) harvested from our private farm in Bacoor, Calabarzon.</p>
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <h4 class="font-semibold text-purple-800 mb-2 flex items-center">
                                    <i class="fas fa-star mr-2"></i>
                                    What Makes It Special:
                                </h4>
                                <ul class="space-y-1 text-purple-700">
                                    <li>• Unique and refreshing local wine</li>
                                    <li>• Distinctive Filipino flavor profile</li>
                                    <li>• Farm-to-bottle freshness</li>
                                    <li>• Traditional crafting methods</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wine FAQ Item 2 -->
                <div class="faq-item border-b border-gray-100 last:border-b-0" data-keywords="wine storage temperature cool dark place">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">How should I store macopa wine?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <h4 class="font-semibold text-blue-800 mb-3 flex items-center">
                                    <i class="fas fa-thermometer-half mr-2"></i>
                                    Optimal Storage Conditions:
                                </h4>
                                <ul class="space-y-2 text-blue-700">
                                    <li>• <span class="font-medium">Temperature:</span> 10-15°C (50-59°F)</li>
                                    <li>• <span class="font-medium">Location:</span> Cool, dark place</li>
                                    <li>• <span class="font-medium">Position:</span> Store horizontally if cork-sealed</li>
                                    <li>• <span class="font-medium">Environment:</span> Away from direct sunlight and strong odors</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wine FAQ Item 3 -->
                <div class="faq-item" data-keywords="age verification minors alcohol law philippines">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">Do you sell to minors?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <div class="bg-red-50 p-4 rounded-lg border border-red-200 border-l-4 border-l-red-400">
                                <h4 class="font-semibold text-red-800 mb-2 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Age Restriction
                                </h4>
                                <p class="text-red-700"><span class="font-semibold">No.</span> As per Philippine law, we strictly do not sell alcoholic beverages to individuals under 18 years old. Age verification may be required upon delivery.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Duck Products -->
        <div class="mb-12" data-category="duck">
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-t-2xl p-6 text-white">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-egg text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Duck Products</h2>
                        <p class="opacity-90">Fresh duck meat and eggs from our ethically raised Pekin ducks</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-b-2xl shadow-lg border border-gray-200">
                <!-- Duck FAQ Item 1 -->
                <div class="faq-item border-b border-gray-100 last:border-b-0" data-keywords="duck products meat eggs balut penoy">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">What types of duck products do you offer?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                                    <h4 class="font-semibold text-orange-800 mb-3 flex items-center">
                                        <i class="fas fa-drumstick-bite mr-2"></i>
                                        Fresh Duck Meat
                                    </h4>
                                    <ul class="space-y-1 text-orange-700">
                                        <li>• Whole dressed duck</li>
                                        <li>• Duck breast</li>
                                        <li>• Duck legs</li>
                                        <li>• Duck wings</li>
                                    </ul>
                                </div>
                                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                    <h4 class="font-semibold text-yellow-800 mb-3 flex items-center">
                                        <i class="fas fa-egg mr-2"></i>
                                        Duck Eggs
                                    </h4>
                                    <ul class="space-y-1 text-yellow-700">
                                        <li>• Fresh duck eggs</li>
                                        <li>• Salted duck eggs</li>
                                        <li>• Balut (fertilized eggs)</li>
                                        <li>• Penoy (unfertilized balut)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Duck FAQ Item 2 -->
                <div class="faq-item" data-keywords="ethical raising spacious environment natural foraging">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">Are your ducks raised ethically?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <p class="mb-4">Yes! Our Pekin ducks are ethically raised in spacious environments on JM Casabar Private Farm.</p>
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <h4 class="font-semibold text-green-800 mb-3 flex items-center">
                                    <i class="fas fa-heart mr-2"></i>
                                    Our Ethical Practices:
                                </h4>
                                <ul class="space-y-1 text-green-700">
                                    <li>• Spacious, clean living environments</li>
                                    <li>• Access to natural foraging areas</li>
                                    <li>• Clean, fresh water supply</li>
                                    <li>• Regular veterinary care</li>
                                    <li>• Stress-free handling procedures</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hog Products -->
        <div class="mb-12" data-category="hog">
            <div class="bg-gradient-to-r from-pink-500 to-pink-600 rounded-t-2xl p-6 text-white">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-piggy-bank text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Hog Products</h2>
                        <p class="opacity-90">Premium pork products from our naturally raised hogs</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-b-2xl shadow-lg border border-gray-200">
                <!-- Hog FAQ Item 1 -->
                <div class="faq-item border-b border-gray-100 last:border-b-0" data-keywords="hog products pork belly chops ground pork sausages bacon">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">What hog products do you sell?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                                    <h4 class="font-semibold text-red-800 mb-3 flex items-center">
                                        <i class="fas fa-cut mr-2"></i>
                                        Fresh Cuts
                                    </h4>
                                    <ul class="space-y-1 text-red-700">
                                        <li>• Pork belly</li>
                                        <li>• Pork chops</li>
                                        <li>• Pork shoulder</li>
                                        <li>• Ground pork</li>
                                    </ul>
                                </div>
                                <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                                    <h4 class="font-semibold text-orange-800 mb-3 flex items-center">
                                        <i class="fas fa-sausage mr-2"></i>
                                        Processed Products
                                    </h4>
                                    <ul class="space-y-1 text-orange-700">
                                        <li>• Specialty sausages</li>
                                        <li>• Bacon</li>
                                        <li>• Ham</li>
                                        <li>• Chorizo</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hog FAQ Item 2 -->
                <div class="faq-item" data-keywords="hog raising clean spacious pens natural ventilation">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">How are your hogs raised?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <p class="mb-4">Our hogs are raised on JM Casabar Private Farm in <span class="font-semibold text-gray-800">clean, spacious pens with natural ventilation</span>, ensuring their health and well-being.</p>
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <h4 class="font-semibold text-green-800 mb-2 flex items-center">
                                    <i class="fas fa-home mr-2"></i>
                                    Living Conditions:
                                </h4>
                                <ul class="space-y-1 text-green-700">
                                    <li>• Stress-free environment</li>
                                    <li>• Proper nutrition</li>
                                    <li>• Regular health monitoring</li>
                                    <li>• Clean water access</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Incubation Services -->
        <div class="mb-12" data-category="incubation">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-t-2xl p-6 text-white">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-temperature-high text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Incubation Services</h2>
                        <p class="opacity-90">Professional egg incubation with modern equipment</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-b-2xl shadow-lg border border-gray-200">
                <!-- Incubation FAQ Item 1 -->
                <div class="faq-item border-b border-gray-100 last:border-b-0" data-keywords="incubation services duck eggs chicken eggs modern incubators">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">What incubation services do you offer?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <p class="mb-4">We provide professional incubation services for <span class="font-semibold text-gray-800">duck eggs and chicken eggs</span>, utilizing modern and reliable incubators to maximize hatching success.</p>
                            <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-200">
                                <h4 class="font-semibold text-indigo-800 mb-2 flex items-center">
                                    <i class="fas fa-cogs mr-2"></i>
                                    Our Equipment:
                                </h4>
                                <ul class="space-y-1 text-indigo-700">
                                    <li>• Modern, reliable incubators</li>
                                    <li>• Controlled environment</li>
                                    <li>• Optimal conditions throughout incubation</li>
                                    <li>• Professional monitoring</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Incubation FAQ Item 2 -->
                <div class="faq-item" data-keywords="incubation period duck eggs chicken eggs 28 days 21 days">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-800 text-lg">How long does the incubation process take?</span>
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                    <h4 class="font-semibold text-yellow-800 mb-2 flex items-center">
                                        <i class="fas fa-egg mr-2"></i>
                                        Duck Eggs
                                    </h4>
                                    <p class="text-yellow-700">Approximately <span class="font-bold">28 days</span></p>
                                </div>
                                <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                                    <h4 class="font-semibold text-orange-800 mb-2 flex items-center">
                                        <i class="fas fa-egg mr-2"></i>
                                        Chicken Eggs
                                    </h4>
                                    <p class="text-orange-700">Approximately <span class="font-bold">21 days</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Contact Section -->
<div class="bg-gradient-to-br from-blue-600 via-purple-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-headset text-3xl"></i>
            </div>
            <h3 class="text-3xl md:text-4xl font-bold mb-4">Still Have Questions?</h3>
            <p class="text-xl mb-8 opacity-90">Can't find the answer you're looking for? Our friendly customer support team is here to help you 24/7.</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-envelope mr-2"></i>
                    Contact Support
                </a>
                <a href="tel:+639123456789" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-phone mr-2"></i>
                    Call Us Now
                </a>
            </div>
            
            <div class="mt-8 text-sm opacity-75">
                <p>Average response time: <span class="font-semibold">2 hours</span> | Customer satisfaction: <span class="font-semibold">98%</span></p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleFAQ(button) {
    const answer = button.nextElementSibling;
    const icon = button.querySelector('i');
    const toggle = button.querySelector('div');
    
    // Close all other FAQ items in the same section
    const section = button.closest('[data-category]');
    section.querySelectorAll('.faq-answer').forEach(item => {
        if (item !== answer) {
            item.classList.remove('active');
        }
    });
    
    section.querySelectorAll('.faq-item button i').forEach(item => {
        if (item !== icon) {
            item.className = 'fas fa-plus text-gray-600 text-sm';
        }
    });
    
    section.querySelectorAll('.faq-item button div').forEach(item => {
        if (item !== toggle) {
            item.className = 'w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200';
        }
    });
    
    // Toggle current FAQ item
    answer.classList.toggle('active');
    
    if (answer.classList.contains('active')) {
        icon.className = 'fas fa-minus text-white text-sm';
        toggle.className = 'w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200 transform rotate-180';
    } else {
        icon.className = 'fas fa-plus text-gray-600 text-sm';
        toggle.className = 'w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200';
    }
}

function searchFAQ() {
    const searchTerm = document.getElementById('faqSearch').value.toLowerCase();
    const faqItems = document.querySelectorAll('.faq-item');
    const sections = document.querySelectorAll('[data-category]');
    
    if (searchTerm === '') {
        faqItems.forEach(item => item.style.display = 'block');
        sections.forEach(section => section.style.display = 'block');
        return;
    }
    
    sections.forEach(section => {
        let hasVisibleItems = false;
        const items = section.querySelectorAll('.faq-item');
        
        items.forEach(item => {
            const keywords = item.getAttribute('data-keywords') || '';
            const questionText = item.querySelector('span').textContent.toLowerCase();
            const answerText = item.querySelector('.faq-answer').textContent.toLowerCase();
            
            if (keywords.includes(searchTerm) || 
                questionText.includes(searchTerm) || 
                answerText.includes(searchTerm)) {
                item.style.display = 'block';
                hasVisibleItems = true;
            } else {
                item.style.display = 'none';
            }
        });
        
        section.style.display = hasVisibleItems ? 'block' : 'none';
    });
}
</script>
@endpush