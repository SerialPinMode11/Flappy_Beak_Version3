@extends('layouts.default')

@section('title', 'Contact Us')

@section('content')
    <div class="flex-grow container mx-auto px-4 py-16 bg-gray-50">
        <h2 class="text-5xl font-bold text-center mb-16 text-neutral">Contact Us</h2>
        
        <div class="grid md:grid-cols-2 gap-16">
            <div class="space-y-10 bg-white rounded-2xl shadow-lg p-8">
                <h3 class="text-3xl font-semibold mb-8 text-neutral border-b pb-4">Get in Touch</h3>
                <div class="flex items-start space-x-6">
                    <div class="w-14 h-14 bg-primary text-white rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                        <i class="fas fa-map-marker-alt text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-xl text-neutral mb-2">Our Location</h4>
                        <p class="text-gray-600">123 Duck Street, Pond City, DC 12345</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-6">
                    <div class="w-14 h-14 bg-secondary text-white rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                        <i class="fas fa-phone text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-xl text-neutral mb-2">Phone Number</h4>
                        <p class="text-gray-600">+1 (555) 123-4567</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-6">
                    <div class="w-14 h-14 bg-accent text-white rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                        <i class="fas fa-envelope text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-xl text-neutral mb-2">Email Address</h4>
                        <p class="text-gray-600">jmcasabar@gmail.com</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route ('contact.post') }}" class="bg-white rounded-2xl shadow-lg p-8 space-y-8">
                @csrf
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" id="firstName" name="firstname" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary transition-all" required>
                    </div>
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" id="lastName" name="lastname" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary transition-all" required>
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary transition-all" required>
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
                    <textarea id="message" name="message" rows="6" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary transition-all" required></textarea>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-4 rounded-lg hover:bg-primary-dark transition-colors text-lg font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    Send Message
                </button>
            </form>
        </div>
    </div>
@endsection