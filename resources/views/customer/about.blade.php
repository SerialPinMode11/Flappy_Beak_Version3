@extends('layouts.default')

@section('title', 'About Us ')

@section('content')
    @php
        $a = $publicOthers['about'] ?? [];
    @endphp
    <div class="flex-grow container mx-auto px-4 py-16 bg-gray-50">
        <h2 class="text-4xl font-bold text-center mb-12 text-neutral">About Us</h2>
        
        <div class="bg-white rounded-xl shadow-lg p-8 mb-12">
            <h3 class="text-2xl font-semibold mb-6 text-neutral">{{ $a['story_title'] ?? 'Our Story' }}</h3>
            <p class="text-gray-600 leading-relaxed mb-6">
                {{ $a['story_p1'] ?? '' }}
            </p>
            <p class="text-gray-600 leading-relaxed">
                {{ $a['story_p2'] ?? '' }}
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-2xl"></i>
                </div>
                <h4 class="text-xl font-semibold mb-4 text-neutral">{{ $a['card1_title'] ?? 'Quality First' }}</h4>
                <p class="text-gray-600">{{ $a['card1_text'] ?? '' }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-secondary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-leaf text-2xl"></i>
                </div>
                <h4 class="text-xl font-semibold mb-4 text-neutral">{{ $a['card2_title'] ?? 'Sustainability' }}</h4>
                <p class="text-gray-600">{{ $a['card2_text'] ?? '' }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-accent text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <h4 class="text-xl font-semibold mb-4 text-neutral">{{ $a['card3_title'] ?? 'Community' }}</h4>
                <p class="text-gray-600">{{ $a['card3_text'] ?? '' }}</p>
            </div>
        </div>
    </div>
@endsection