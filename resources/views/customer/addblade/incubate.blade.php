@extends('layouts.public-site')

@section('title', 'Incubation — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-deep/90 mb-2">Heritage hatch</p>
            <h1 class="font-serif text-2xl sm:text-3xl font-semibold text-forest">Incubator services</h1>
        </div>

        <div class="flex-1">
            @if(session()->has('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50/90 text-emerald-900 text-sm px-4 py-3 mb-6 flex gap-3 items-start">
                    <i class="fas fa-check-circle mt-0.5 text-emerald-600"></i>
                    <span>{{ session()->get('success') }}</span>
                </div>
            @elseif(session()->has('error'))
                <div class="rounded-xl border border-red-200 bg-red-50/90 text-red-900 text-sm px-4 py-3 mb-6 flex gap-3 items-start">
                    <i class="fas fa-exclamation-circle mt-0.5 text-red-600"></i>
                    <span>{{ session()->get('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8 mb-12">
                <!-- JM Casabar Formula -->
                <div class="product-card bg-white rounded-2xl border border-stone-200/80 shadow-md p-4 relative group">
                    <span
                        class="absolute top-4 left-4 bg-forest-light text-white text-sm px-3 py-1 rounded-full font-semibold">Premium</span>
                    <button class="absolute top-4 right-4 text-stone-400 hover:text-forest transition-colors">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                    <div class="relative mb-4">
                        <img src="{{asset('images/Casabar-Formula.jpeg')}}" alt="JM Casabar Formula Incubation"
                            class="w-full h-64 object-cover rounded-xl ring-1 ring-stone-200/60">
                        <button
                            class="quick-view absolute bottom-4 right-4 bg-white p-3 rounded-full shadow-md hover:bg-forest hover:text-gold-pale transition-colors">
                            <a href="#">
                                <i class="fas fa-eye"></i>
                            </a>
                        </button>
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-serif font-semibold text-lg text-forest">JM Casabar Formula Incubation</h3>
                        <p class="text-sm text-stone-600">Our signature incubation method with proven 85% hatch rate.
                            Includes temperature control (37.5°C), optimal humidity (55-65%), and automated egg turning.</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-forest font-bold text-xl">₱1,500</span>
                                <span class="text-stone-500 text-sm">/batch of 30 eggs</span>
                            </div>
                            <div class="flex items-center">
                                <div class="star-rating flex">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-stone-500 ml-2">(124)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom Formula -->
                <div class="product-card bg-white rounded-2xl border border-stone-200/80 shadow-md p-4 relative group">
                    <span
                        class="absolute top-4 left-4 bg-forest text-gold-pale text-sm px-3 py-1 rounded-full font-semibold">Customized</span>
                    <button class="absolute top-4 right-4 text-gray-400 hover:text-forest transition-colors">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                    <div class="relative mb-4">
                        <img src="{{asset('images/custom.jpeg')}}" alt="Custom Formula Incubation"
                            class="w-full h-64 object-cover rounded-xl ring-1 ring-stone-200/60">
                        <button
                            class="quick-view absolute bottom-4 right-4 bg-white p-3 rounded-full shadow-md hover:bg-forest hover:text-gold-pale transition-colors">
                            <a href="#">
                                <i class="fas fa-eye"></i>
                            </a>
                        </button>
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-serif font-semibold text-lg text-forest">Custom Formula Incubation</h3>
                        <p class="text-sm text-stone-600">Tailored incubation approach based on your specifications. Modify
                            temperature, humidity, turning frequency, and ventilation to your requirements.</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-forest font-bold text-xl">₱2,200</span>
                                <span class="text-stone-500 text-sm">/batch of 30 eggs</span>
                            </div>
                            <div class="flex items-center">
                                <div class="star-rating flex">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-stone-500 ml-2">(86)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Experimental Formula -->
                <div class="product-card bg-white rounded-2xl border border-stone-200/80 shadow-md p-4 relative group">
                    <span
                        class="absolute top-4 left-4 bg-gold text-forest text-sm px-3 py-1 rounded-full font-semibold">Experimental</span>
                    <button class="absolute top-4 right-4 text-gray-400 hover:text-forest transition-colors">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                    <div class="relative mb-4">
                        <img src="{{asset('images/Experimental.png')}}" alt="Experimental Formula Incubation"
                            class="w-full h-64 object-cover rounded-xl ring-1 ring-stone-200/60">
                        <button
                            class="quick-view absolute bottom-4 right-4 bg-white p-3 rounded-full shadow-md hover:bg-forest hover:text-gold-pale transition-colors">
                            <a href="#">
                                <i class="fas fa-eye"></i>
                            </a>
                        </button>
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-serif font-semibold text-lg text-forest">Experimental Formula Incubation</h3>
                        <p class="text-sm text-stone-600">Advanced incubation with specialized treatments including precision
                            temperature cycling (37.2-37.8°C), controlled humidity shifts, and enhanced ventilation
                            protocols.</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-forest font-bold text-xl">₱2,800</span>
                                <span class="text-stone-500 text-sm">/batch of 30 eggs</span>
                            </div>
                            <div class="flex items-center">
                                <div class="star-rating flex">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="text-stone-500 ml-2">(42)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- World-Based Formula -->
                <div class="product-card bg-white rounded-2xl border border-stone-200/80 shadow-md p-4 relative group">
                    <span
                        class="absolute top-4 left-4 bg-stone-700 text-gold-pale text-sm px-3 py-1 rounded-full font-semibold">Research-Based</span>
                    <button class="absolute top-4 right-4 text-gray-400 hover:text-forest transition-colors">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                    <div class="relative mb-4">
                        <img src="{{asset('images/world-based.jpg')}}" alt="World-Based Formula Incubation"
                            class="w-full h-64 object-cover rounded-xl ring-1 ring-stone-200/60">
                        <button
                            class="quick-view absolute bottom-4 right-4 bg-white p-3 rounded-full shadow-md hover:bg-forest hover:text-gold-pale transition-colors">
                            <a href="#">
                                <i class="fas fa-eye"></i>
                            </a>
                        </button>
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-serif font-semibold text-lg text-forest">World-Based Formula Incubation</h3>
                        <p class="text-sm text-stone-600">Following Cornell University's poultry science protocols (2023).
                            Precise 37.5°C temperature, 60% humidity with 45% during lockdown, and 8x daily turning for
                            optimal development.</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-forest font-bold text-xl">₱2,500</span>
                                <span class="text-stone-500 text-sm">/batch of 30 eggs</span>
                            </div>
                            <div class="flex items-center">
                                <div class="star-rating flex">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-stone-500 ml-2">(98)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incubation Services Information -->
            <div class="bg-white rounded-2xl border border-stone-200/80 p-6 sm:p-8 mb-12 shadow-md">
                <h2 class="font-serif text-2xl font-semibold text-forest mb-4">Our incubation services</h2>
                <p class="mb-4">At JM Casabar Pekin Store, we offer professional incubation services with various approaches
                    to meet your specific needs. All our incubation services consider these critical factors:</p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                    <div class="bg-cream/80 border border-stone-200/60 p-4 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-temperature-high text-forest text-xl"></i>
                            <h3 class="font-semibold">Temperature Control</h3>
                        </div>
                        <p class="text-sm text-stone-600">Precise temperature maintenance between 37.2-37.8°C for optimal
                            embryo development.</p>
                    </div>

                    <div class="bg-cream/80 border border-stone-200/60 p-4 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-tint text-forest text-xl"></i>
                            <h3 class="font-semibold">Humidity Levels</h3>
                        </div>
                        <p class="text-sm text-stone-600">55-65% humidity during incubation, reduced to 45-50% during
                            lockdown phase.</p>
                    </div>

                    <div class="bg-cream/80 border border-stone-200/60 p-4 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-sync text-forest text-xl"></i>
                            <h3 class="font-semibold">Egg Positioning & Turning</h3>
                        </div>
                        <p class="text-sm text-stone-600">Automatic turning 6-8 times daily to prevent embryo sticking to
                            shell membranes.</p>
                    </div>

                    <div class="bg-cream/80 border border-stone-200/60 p-4 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-wind text-forest text-xl"></i>
                            <h3 class="font-semibold">Ventilation</h3>
                        </div>
                        <p class="text-sm text-stone-600">Controlled airflow to ensure oxygen supply and carbon dioxide
                            removal.</p>
                    </div>

                    <div class="bg-cream/80 border border-stone-200/60 p-4 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-calendar-alt text-forest text-xl"></i>
                            <h3 class="font-semibold">Incubation Period</h3>
                        </div>
                        <p class="text-sm text-stone-600">28 days for duck eggs with careful monitoring throughout the
                            process.</p>
                    </div>

                    <div class="bg-cream/80 border border-stone-200/60 p-4 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-lightbulb text-forest text-xl"></i>
                            <h3 class="font-semibold">Candling Eggs</h3>
                        </div>
                        <p class="text-sm text-stone-600">Regular candling at days 7, 14, and 21 to monitor development and
                            remove infertile eggs.</p>
                    </div>

                    <div class="bg-cream/80 border border-stone-200/60 p-4 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-lock text-forest text-xl"></i>
                            <h3 class="font-semibold">Lockdown Phase</h3>
                        </div>
                        <p class="text-sm text-stone-600">Final 3 days with no turning, reduced humidity, and preparation for
                            hatching.</p>
                    </div>

                    <div class="bg-cream/80 border border-stone-200/60 p-4 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-chart-line text-forest text-xl"></i>
                            <h3 class="font-semibold">Success Rate</h3>
                        </div>
                        <p class="text-sm text-stone-600">Our methods achieve 80-90% hatch rates for healthy, fertile eggs.
                        </p>
                    </div>
                </div>

                <div class="mt-6 bg-gold/10 border border-gold/25 p-4 rounded-xl">
                    <h3 class="font-semibold text-forest mb-2">Why choose our incubation services?</h3>
                    <ul class="list-disc list-inside text-sm text-stone-600 space-y-1">
                        <li>Professional equipment with backup power systems</li>
                        <li>Daily monitoring and detailed reporting</li>
                        <li>Experienced staff with specialized training</li>
                        <li>Flexible pickup or delivery options for hatched ducklings</li>
                        <li>Consultation services for post-hatch care</li>
                    </ul>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{route('booking.index')}}"
                        class="inline-flex items-center gap-2 bg-forest text-white px-6 py-3 rounded-xl font-medium hover:bg-forest-dark transition-colors shadow-sm">
                        <i class="fas fa-calendar-check"></i>
                        Book Incubation Service
                    </a>
                </div>
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

        if (slides.length && dots.length) {
            setInterval(() => {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }, 5000);
        }
    </script>
@endpush