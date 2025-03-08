@extends("layouts.admin")
@section("title", "Admin Login")
@section("content")
<div class="w-full max-w-md mx-auto">
    <div class="bg-gray-900 rounded-lg shadow-xl overflow-hidden">
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
            <div class="bg-gray-800 text-white py-4 px-6 rounded-t-lg text-center text-xl font-semibold mb-6">
                Flappy-Beak Admin Portal
            </div>
            <h2 class="text-3xl font-bold mb-6 text-center text-gray-100">Admin Login</h2>
            <form method="POST" action="{{ route('login.submit' )}}" class="space-y-6">
                @csrf
                <div>
                    <label for="login-email" class="block text-sm font-medium mb-2 text-gray-300">Email Address</label>
                    <input type="email" id="login-email" name="email" class="w-full p-3 border border-gray-700 bg-gray-800 text-white rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" required>
                </div>
                <div>
                    <label for="login-password" class="block text-sm font-medium mb-2 text-gray-300">Password</label>
                    <input type="password" id="login-password" name="password" class="w-full p-3 border border-gray-700 bg-gray-800 text-white rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" required>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="mr-2 rounded bg-gray-800 border-gray-700 text-blue-600 focus:ring-blue-600">
                        <label for="remember" class="text-sm text-gray-300">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-blue-400 hover:underline">Forgot password?</a>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition duration-200 transform hover:scale-105">
                    Login
                </button>
            </form>

           
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-400">Need customer access?</p>
                <a href="{{ route('login') }}" class="mt-2 inline-block text-blue-400 hover:text-blue-300 transition-colors font-semibold">
                    Switch to Customer Login
                </a>
            </div>

            <div class="mt-8">
                <p class="text-sm text-gray-300">Don't have an account yet?</p>
                <a href="{{ route('admin.register') }}" class="mt-2 inline-block text-primary hover:text-accent transition-colors font-semibold">
                    Create an account
                </a>

            </div>

            <div class="mt-8">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-gray-900 text-gray-400">Admin Access Only</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection