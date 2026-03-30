@php
    $c = $publicOthers['contact'] ?? [];
@endphp
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 bg-cream">
    <h2 class="font-serif text-4xl md:text-5xl font-semibold text-center mb-12 md:mb-16 text-forest">Contact Us</h2>

    <div class="grid md:grid-cols-2 gap-10 lg:gap-16">
        <div class="space-y-10 bg-white rounded-2xl shadow-md border border-stone-200/80 p-8">
            <h3 class="font-serif text-2xl sm:text-3xl font-semibold mb-8 text-forest border-b border-stone-200 pb-4">Get in Touch</h3>
            <div class="flex items-start space-x-6">
                <div class="w-14 h-14 bg-forest text-gold-pale rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                    <i class="fas fa-map-marker-alt text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-xl text-stone-800 mb-2">{{ $c['location_label'] ?? 'Our Location' }}</h4>
                    <p class="text-stone-600 leading-relaxed">{{ $c['location_text'] ?? '' }}</p>
                </div>
            </div>

            <div class="flex items-start space-x-6">
                <div class="w-14 h-14 bg-forest-light text-gold-pale rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                    <i class="fas fa-phone text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-xl text-stone-800 mb-2">{{ $c['phone_label'] ?? 'Phone Number' }}</h4>
                    <p class="text-stone-600">{{ !empty(trim($c['phone_text'] ?? '')) ? $c['phone_text'] : config('contact.owner_phone_display') }}</p>
                </div>
            </div>

            <div class="flex flex-col space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="w-14 h-14 bg-gold-deep text-white rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                        <i class="fas fa-envelope text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-xl text-stone-800 mb-2">{{ $c['email_label'] ?? 'Email Address' }}</h4>
                        <p class="text-stone-600">{{ $c['email_text'] ?? 'jmcasabar@gmail.com' }}</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-14 h-14 bg-forest text-gold-pale rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                        <i class="fab fa-facebook-f text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-xl text-stone-800 mb-2">{{ $c['facebook_label'] ?? 'Facebook Account' }}</h4>
                        <p class="text-stone-600">
                            <a href="{{ $c['facebook_url'] ?? 'https://www.facebook.com/share/18gxfPvdFU/' }}" class="text-forest font-medium hover:text-gold-deep hover:underline transition-colors" target="_blank" rel="noopener">
                                {{ $c['facebook_text'] ?? 'facebook.com/share/18gxfPvdFU' }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('contact.post') }}" class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-8 space-y-8">
            @csrf
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm flex items-center gap-2" role="alert">
                    <i class="fas fa-check-circle flex-shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-900 text-sm flex items-center gap-2" role="alert">
                    <i class="fas fa-exclamation-circle flex-shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <label for="firstName" class="block text-sm font-medium text-stone-600 mb-2">First Name</label>
                    <input type="text" id="firstName" name="firstname" class="w-full p-3 border border-stone-200 rounded-xl bg-cream/50 focus:outline-none focus:border-forest focus:ring-2 focus:ring-gold/30 transition-all" required>
                </div>
                <div>
                    <label for="lastName" class="block text-sm font-medium text-stone-600 mb-2">Last Name</label>
                    <input type="text" id="lastName" name="lastname" class="w-full p-3 border border-stone-200 rounded-xl bg-cream/50 focus:outline-none focus:border-forest focus:ring-2 focus:ring-gold/30 transition-all" required>
                </div>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-stone-600 mb-2">Email Address</label>
                <input type="email" id="email" name="email" class="w-full p-3 border border-stone-200 rounded-xl bg-cream/50 focus:outline-none focus:border-forest focus:ring-2 focus:ring-gold/30 transition-all" required>
            </div>
            <div>
                <label for="message" class="block text-sm font-medium text-stone-600 mb-2">Your Message</label>
                <textarea id="message" name="message" rows="6" class="w-full p-3 border border-stone-200 rounded-xl bg-cream/50 focus:outline-none focus:border-forest focus:ring-2 focus:ring-gold/30 transition-all" required></textarea>
            </div>
            <button type="submit" class="w-full bg-forest text-white py-4 rounded-xl hover:bg-forest-light transition-colors text-lg font-semibold shadow-md">
                Send Message
            </button>
        </form>
    </div>
</div>
