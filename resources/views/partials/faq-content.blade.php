@php
    $fq = $publicOthers['faq'] ?? [];
    $faqSections = [
        ['key' => 'general', 'title' => $fq['general_title'] ?? '', 'subtitle' => $fq['general_subtitle'] ?? '', 'count' => 5],
        ['key' => 'wine', 'title' => $fq['wine_title'] ?? '', 'subtitle' => $fq['wine_subtitle'] ?? '', 'count' => 3],
        ['key' => 'duck', 'title' => $fq['duck_title'] ?? '', 'subtitle' => $fq['duck_subtitle'] ?? '', 'count' => 2],
        ['key' => 'incubation', 'title' => $fq['incubation_title'] ?? '', 'subtitle' => $fq['incubation_subtitle'] ?? '', 'count' => 2],
    ];
@endphp
<!-- Hero Section -->
<div class="bg-gradient-to-br from-forest via-forest-dark to-forest-dark text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16 text-center">
        <div class="max-w-4xl mx-auto">
            <h1 class="font-serif text-4xl md:text-5xl font-semibold mb-4">{{ $fq['hero_title'] ?? 'Frequently Asked Questions' }}</h1>
            <p class="text-lg md:text-xl mb-8 text-white/85">{{ $fq['hero_subtitle'] ?? 'Find answers to common questions about JM Casabar Private Farm' }}</p>

            <div class="max-w-md mx-auto relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-stone-400"></i>
                </div>
                <input type="text" id="faqSearch"
                       class="w-full pl-10 pr-4 py-3 rounded-full text-stone-900 placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-gold/50"
                       placeholder="{{ $fq['search_placeholder'] ?? 'Search questions...' }}"
                       onkeyup="searchFAQ()">
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-cream py-12 -mt-8 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-md p-6 text-center border border-stone-200/80">
                <div class="text-2xl sm:text-3xl font-bold text-forest mb-2">{{ $fq['stat_1_number'] ?? '24/7' }}</div>
                <div class="text-stone-600 text-sm font-medium">{{ $fq['stat_1_label'] ?? 'Online Support' }}</div>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 text-center border border-stone-200/80">
                <div class="text-2xl sm:text-3xl font-bold text-gold-deep mb-2">{{ $fq['stat_2_number'] ?? '1000+' }}</div>
                <div class="text-stone-600 text-sm font-medium">{{ $fq['stat_2_label'] ?? 'Happy Customers' }}</div>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 text-center border border-stone-200/80">
                <div class="text-2xl sm:text-3xl font-bold text-gold mb-2">{{ $fq['stat_3_number'] ?? '5★' }}</div>
                <div class="text-stone-600 text-sm font-medium">{{ $fq['stat_3_label'] ?? 'Customer Rating' }}</div>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 text-center border border-stone-200/80">
                <div class="text-2xl sm:text-3xl font-bold text-forest-light mb-2">{{ $fq['stat_4_number'] ?? '50+' }}</div>
                <div class="text-stone-600 text-sm font-medium">{{ $fq['stat_4_label'] ?? 'Questions Answered' }}</div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Content -->
<div class="bg-cream py-16 border-t border-stone-200/60">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @foreach($faqSections as $section)
            <div class="mb-12" data-category="{{ $section['key'] }}">
                <div class="bg-gradient-to-r from-forest to-forest-light rounded-t-2xl p-6 text-white border border-forest-light/30">
                    <h2 class="font-serif text-2xl font-semibold">{{ $section['title'] }}</h2>
                    <p class="text-white/85 text-sm mt-1">{{ $section['subtitle'] }}</p>
                </div>
                <div class="bg-white rounded-b-2xl shadow-md border border-stone-200 border-t-0">
                    @for($i = 1; $i <= $section['count']; $i++)
                        @php
                            $q = $fq[$section['key'].'_q'.$i] ?? '';
                            $a = $fq[$section['key'].'_a'.$i] ?? '';
                        @endphp
                        <div class="faq-item border-b border-gray-100 last:border-b-0">
                            <button type="button" class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
                                <span class="font-semibold text-gray-800 text-lg">{{ $q }}</span>
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200">
                                    <i class="fas fa-plus text-gray-600 text-sm"></i>
                                </div>
                            </button>
                            <div class="faq-answer">
                                <div class="px-6 pb-5 text-gray-600 leading-relaxed whitespace-pre-line">{{ $a }}</div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Contact CTA -->
<div class="bg-gradient-to-br from-forest via-forest-dark to-forest-dark text-white py-16 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-3xl mx-auto">
            <h3 class="font-serif text-3xl md:text-4xl font-semibold mb-4">{{ $fq['cta_title'] ?? 'Still have questions?' }}</h3>
            <p class="text-lg md:text-xl mb-8 text-white/85">{{ $fq['cta_subtitle'] ?? 'Our team is happy to help.' }}</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="bg-gold-pale text-forest px-8 py-4 rounded-full font-semibold hover:bg-white transition-colors duration-200 flex items-center justify-center shadow-md">
                    {{ $fq['cta_button_contact'] ?? 'Contact Us' }}
                </a>
                <a href="tel:{{ config('contact.owner_phone_tel') }}" class="bg-transparent border-2 border-gold-pale/80 text-white px-8 py-4 rounded-full font-semibold hover:bg-gold-pale hover:text-forest transition-colors duration-200 flex items-center justify-center">
                    {{ $fq['cta_button_call'] ?? 'Call Us' }}
                </a>
            </div>
            <div class="mt-8 text-sm opacity-75">
                <p>{{ $fq['cta_bottom_note'] ?? '' }}</p>
            </div>
        </div>
    </div>
</div>
