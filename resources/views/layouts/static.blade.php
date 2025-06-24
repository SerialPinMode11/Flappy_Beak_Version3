<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar - Fixed position -->
        <aside class="bg-gray-800 text-white w-64 fixed h-screen hidden md:block overflow-y-auto z-10">
            <div class="p-4 border-b border-gray-700">
                <h2 class="text-xl font-bold text-[#ff6b6b]">Admin Dashboard</h2>
            </div>
            <nav class="p-4">
                <ul class="space-y-2">
                    <li><a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-tachometer-alt mr-3"></i>Dashboard</a></li>
                    <li><a href="{{ route('admin.product.index') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-box mr-3"></i>Product Stocks</a></li>
                    <li><a href="{{ route('admin.billing.index') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-dollar-sign mr-3"></i>Income Generated</a></li>
                    <li><a href="{{ route('admin.expense.index')}}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-table mr-3"></i>Expenses Table</a></li>
                    <li><a href="{{ route('contactforlist' ) }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-industry mr-3"></i>Customer Feedback Management</a></li>
                    <li><a href="{{ route('admin.incubation.index' ) }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-industry mr-3"></i>Incubation Book List</a></li>
                    <li><a href="{{route('admin.hardware_esp32')}}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-desktop mr-3"></i>Hardware</a></li>
                    <li><a href="{{route('admin.personal')}}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-user-circle mr-3"></i>Personal</a></li>

                    <!-- 🛑 Fix Logout Button (Using Form) -->
                    <li>
                        <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="flex items-center w-full p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                <i class="fas fa-sign-out-alt mr-3"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content - Scrollable -->
        <div class="flex-1 md:ml-64 flex flex-col h-screen overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('header-title', 'Dashboard Overview')</h1>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="search" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button class="relative">
                            <i class="fas fa-bell text-gray-600 text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                        </button>
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                            <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Avatar" class="w-8 h-8 rounded-full">
                            <span class="font-medium">JM Casabar</span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content - Scrollable Area -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-4">
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>