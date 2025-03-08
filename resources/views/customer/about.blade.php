@extends('layouts.default')

@section('title', 'About Us ')

@section('content')
    <div class="flex-grow container mx-auto px-4 py-16 bg-gray-50">
        <h2 class="text-4xl font-bold text-center mb-12 text-neutral">About Us</h2>
        
        <div class="bg-white rounded-xl shadow-lg p-8 mb-12">
            <h3 class="text-2xl font-semibold mb-6 text-neutral">Our Story</h3>
            <p class="text-gray-600 leading-relaxed mb-6">
                Founded in 2010, Mr. Casabar started his own business, one of it are the JM Casabar Mini Farm, which has been at the forefront of sustainable duck, chicken, hog, turkey, and rabbit farming and premium poultry products. What began as a small family farm has grown into a trusted supplier of high-quality goods such as meat, eggs, and related products.
            </p>
            <p class="text-gray-600 leading-relaxed">
                We take pride in our commitment to ethical farming practices and maintaining the highest standards of quality in all our products.
                Our dedication to sustainability and animal welfare has made us a leader in the industry, trusted by chefs and home cooks alike.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-2xl"></i>
                </div>
                <h4 class="text-xl font-semibold mb-4 text-neutral">Quality First</h4>
                <p class="text-gray-600">We never compromise on the quality of our products and services, ensuring that every item meets our rigorous standards.</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-secondary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-leaf text-2xl"></i>
                </div>
                <h4 class="text-xl font-semibold mb-4 text-neutral">Sustainability</h4>
                <p class="text-gray-600">Committed to environmental responsibility and sustainable farming practices, we strive to minimize our ecological footprint.</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-accent text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <h4 class="text-xl font-semibold mb-4 text-neutral">Community</h4>
                <p class="text-gray-600">Supporting local communities and maintaining strong relationships with our customers is at the heart of everything we do.</p>
            </div>
        </div>
    </div>
@endsection