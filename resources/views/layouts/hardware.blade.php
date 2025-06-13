<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feeding Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5',
                        secondary: '#6366f1',
                        success: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444',
                        info: '#3b82f6'
                    }
                }
            }
        }
    </script>
    @yield('styles')
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white w-64 fixed h-screen hidden md:block overflow-y-auto">
            <div class="p-4 border-b border-gray-700">
                <h2 class="text-xl font-bold text-primary">Feeding Dashboard</h2>
            </div>
            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.hardware_esp32') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('feeding.schedule') ? 'bg-primary text-white' : '' }}">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Feeding Schedule
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : '' }}">
                            <i class="fas fa-utensils mr-3"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.hardwareHistory') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('feeding.history') ? 'bg-primary text-white' : '' }}">
                            <i class="fas fa-history mr-3"></i>
                            Feeding History
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.hardwareAnalytics') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('feeding.analytics') ? 'bg-primary text-white' : '' }}">
                            <i class="fas fa-chart-line mr-3"></i>
                            Analytics
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.hardwareSetting') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('feeding.settings') ? 'bg-primary text-white' : '' }}">
                            <i class="fas fa-cog mr-3"></i>
                            Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.hardwareInventory') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('feed.inventory') ? 'bg-primary text-white' : '' }}">
                            <i class="fas fa-box mr-3"></i>
                            Feed Inventory
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <button class="md:hidden text-gray-500 focus:outline-none" id="mobile-menu-button">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-2xl font-semibold text-gray-800">Feeding Control System</h1>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="search" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:  class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-primary focus:border-primary">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-search h-5 w-5 text-gray-400"></i>
                            </div>
                        </div>
                        <button class="relative">
                            <i class="fas fa-bell text-gray-600 text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                        </button>
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                            <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Avatar" class="w-8 h-8 rounded-full">
                            <span class="font-medium">Mr.JM</span>
                        </button>
                    </div>
                </div>
            </header>

            @yield('content')
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('fixed');
            sidebar.classList.toggle('inset-0');
            sidebar.classList.toggle('z-50');
            sidebar.classList.toggle('md:block');
        });
    </script>
    @yield('scripts')
</body>
</html>