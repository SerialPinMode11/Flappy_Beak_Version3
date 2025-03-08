@extends('layouts.static')
@section('title', 'Admin Dashboard')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Dashboard Overview</h1>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="search" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <button class="relative">
                <i class="fas fa-bell text-gray-600 text-xl"></i>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
            </button>
            <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900" onclick="window.location.href='personal.html'">
                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Avatar" class="w-8 h-8 rounded-full">
                <span class="font-medium">JM Casabar</span>
            </button>
        </div>
    </div>
</header>
<div class="bg-gray-800 rounded-lg shadow-xl p-6">
    <h2 class="text-xl font-semibold text-white mb-4">Welcome, {{ Auth::guard('admin')->user()->name }}</h2>
    <p class="text-gray-300">This is your administrator dashboard. From here you can manage the entire system.</p>

</div>
@endsection

@push('scripts')

@endpush