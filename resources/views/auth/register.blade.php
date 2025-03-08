@extends("layouts.maintain")
@section("title", "Register Page")
@section("content")
<div class="w-full max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        @if(session()->has("success")) 
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session()->get("success") }}
            </div>
        @endif
        @if(session()->has("error")) 
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                {{ session()->get("error") }}
            </div>
        @endif
        <div class="p-8">
            <div class="gradient-bg text-white py-4 px-6 rounded-t-lg text-center text-xl font-semibold mb-6">
                Welcome to Flappy-Beak
            </div>
            <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Register</h2>
            <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium mb-2 text-gray-700">Full Name</label>
                    <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium mb-2 text-gray-700">Email Address</label>
                    <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium mb-2 text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors" required>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg hover:bg-opacity-90 transition duration-200 transform hover:scale-105">
                    Create Account
                </button>
            </form>
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Already have an account now?</p>
                <a href="{{ route('login') }}" class="mt-2 inline-block text-primary hover:text-accent transition-colors font-semibold">
                    Login Now
                </a>
            </div>

            <div class="mt-8">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-3 gap-3">
                    <button class="flex justify-center items-center py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200 transform hover:scale-105">
                        <i class="fab fa-google text-red-500 text-xl"></i>
                    </button>
                    <button class="flex justify-center items-center py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200 transform hover:scale-105">
                        <i class="fab fa-facebook text-blue-600 text-xl"></i>
                    </button>
                    <button class="flex justify-center items-center py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200 transform hover:scale-105">
                        <i class="fab fa-apple text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection