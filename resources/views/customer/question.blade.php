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
<div class="bg-gradient-to-br from-blue-600 via-purple-600 to-blue-800 text-white">
    <div class="container mx-auto px-4 py-16 text-center">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $fq['hero_title'] ?? 'Frequently Asked Questions' }}</h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">{{ $fq['hero_subtitle'] ?? 'Find answers to common questions about JM Casabar Private Farm' }}</p>
            
            <!-- Search Bar -->
            <div class="max-w-md mx-auto relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="faqSearch" 
                       class="w-full pl-10 pr-4 py-3 rounded-full text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50" 
                       placeholder="{{ $fq['search_placeholder'] ?? 'Search questions...' }}" 
                       onkeyup="searchFAQ()">
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-white py-12 -mt-8 relative z-10">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center border border-gray-100">
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $fq['stat_1_number'] ?? '' }}</div>
                <div class="text-gray-600 text-sm font-medium">{{ $fq['stat_1_label'] ?? '' }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center border border-gray-100">
                <div class="text-3xl font-bold text-green-600 mb-2">{{ $fq['stat_2_number'] ?? '' }}</div>
                <div class="text-gray-600 text-sm font-medium">{{ $fq['stat_2_label'] ?? '' }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center border border-gray-100">
                <div class="text-3xl font-bold text-yellow-600 mb-2">{{ $fq['stat_3_number'] ?? '' }}</div>
                <div class="text-gray-600 text-sm font-medium">{{ $fq['stat_3_label'] ?? '' }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center border border-gray-100">
                <div class="text-3xl font-bold text-purple-600 mb-2">{{ $fq['stat_4_number'] ?? '' }}</div>
                <div class="text-gray-600 text-sm font-medium">{{ $fq['stat_4_label'] ?? '' }}</div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Content -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        @foreach($faqSections as $section)
            <div class="mb-12" data-category="{{ $section['key'] }}">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-2xl p-6 text-white">
                    <h2 class="text-2xl font-bold">{{ $section['title'] }}</h2>
                    <p class="opacity-90">{{ $section['subtitle'] }}</p>
                </div>
                <div class="bg-white rounded-b-2xl shadow-lg border border-gray-200">
                    @for($i = 1; $i <= $section['count']; $i++)
                        @php
                            $q = $fq[$section['key'].'_q'.$i] ?? '';
                            $a = $fq[$section['key'].'_a'.$i] ?? '';
                        @endphp
                        <div class="faq-item border-b border-gray-100 last:border-b-0">
                            <button class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200" onclick="toggleFAQ(this)">
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

<!-- Contact Section -->
<div class="bg-gradient-to-br from-blue-600 via-purple-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <h3 class="text-3xl md:text-4xl font-bold mb-4">{{ $fq['cta_title'] ?? '' }}</h3>
            <p class="text-xl mb-8 opacity-90">{{ $fq['cta_subtitle'] ?? '' }}</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition-colors duration-200 flex items-center justify-center">
                    {{ $fq['cta_button_contact'] ?? '' }}
                </a>
                <a href="tel:{{ config('contact.owner_phone_tel') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-colors duration-200 flex items-center justify-center">
                    {{ $fq['cta_button_call'] ?? '' }}
                </a>
            </div>
            <div class="mt-8 text-sm opacity-75">
                <p>{{ $fq['cta_bottom_note'] ?? '' }}</p>
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
