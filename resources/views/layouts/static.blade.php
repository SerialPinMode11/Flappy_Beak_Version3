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
        /* Added active navigation styles */
        .nav-link-active {
            background-color: #374151 !important;
            color: #ff6b6b !important;
            border-left: 4px solid #ff6b6b;
        }
        .nav-link-active i {
            color: #ff6b6b !important;
        }

        /* Mobile sidebar overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Mobile sidebar animation */
        .mobile-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-sidebar.active {
            transform: translateX(0);
        }

        /* Hamburger menu animation */
        .hamburger-line {
            transition: all 0.3s ease-in-out;
            transform-origin: center;
        }

        .hamburger.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .hamburger.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        /* Responsive header adjustments */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            .header-search {
                order: 2;
                width: 100%;
            }
            
            .header-user {
                order: 1;
                justify-self: flex-end;
            }
        }

        /* Improved mobile navigation spacing */
        @media (max-width: 640px) {
            .mobile-nav-item {
                padding: 0.75rem 1rem;
                font-size: 0.95rem;
            }
            
            .mobile-nav-item i {
                width: 20px;
                margin-right: 0.75rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="sidebar-overlay md:hidden" onclick="toggleMobileSidebar()"></div>

        <!-- Sidebar - Desktop (Fixed) & Mobile (Sliding) -->
        <aside id="sidebar" class="bg-gray-800 text-white w-64 fixed h-screen overflow-y-auto z-50 mobile-sidebar md:translate-x-0 md:z-10">
            <div class="p-4 border-b border-gray-700 flex justify-between items-center">
                <h2 class="text-xl font-bold text-[#ff6b6b]">Admin Dashboard</h2>
                <!-- Close button for mobile -->
                <button id="closeSidebar" class="md:hidden text-gray-300 hover:text-white" onclick="toggleMobileSidebar()">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <nav class="p-4">
                <ul class="space-y-2">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.dashboard') ? 'nav-link-active' : '' }}"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                        </a>
                    </li>
                    <!-- Product Stocks -->
                    <li>
                        <a href="{{ route('admin.product.index') }}" 
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.product.*') ? 'nav-link-active' : '' }}"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-box mr-3"></i>Product Stocks
                        </a>
                    </li>
                    <!-- Income Generated -->
                    <li>
                        <a href="{{ route('admin.billing.index') }}" 
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.billing.*') ? 'nav-link-active' : '' }}"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-dollar-sign mr-3"></i>Income Generated
                        </a>
                    </li>
                    <!-- Expenses Table -->
                    <li>
                        <a href="{{ route('admin.expense.index')}}" 
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.expense.*') ? 'nav-link-active' : '' }}"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-table mr-3"></i>Expenses Table
                        </a>
                    </li>
                    <!-- Customer Feedback Management -->
                    <li>
                        <a href="{{ route('contactforlist' ) }}" 
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('contactforlist') ? 'nav-link-active' : '' }}"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-comments mr-3"></i>Customer Feedback Management
                        </a>
                    </li>
                    <!-- Incubation Book List -->
                    <li>
                        <a href="{{ route('admin.incubation.index' ) }}" 
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.incubation.*') ? 'nav-link-active' : '' }}"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-industry mr-3"></i>Incubation Book List
                        </a>
                    </li>
                    <!-- Hardware -->
                    <li>
                        <a href="{{route('admin.hardware_esp32')}}" 
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.hardware_esp32') ? 'nav-link-active' : '' }}"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-desktop mr-3"></i>Hardware
                        </a>
                    </li>
                    <!-- Personal -->
                    <li>
                        <a href="{{route('admin.personal')}}" 
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.personal') ? 'nav-link-active' : '' }}"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-user-circle mr-3"></i>Personal
                        </a>
                    </li>

                    <!-- Logout Button -->
                    <li>
                        <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="flex items-center w-full p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item">
                                <i class="fas fa-sign-out-alt mr-3"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64 flex flex-col h-screen overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-start md:items-center header-content">
                        <!-- Left: Mobile Menu + Title -->
                        <div class="flex items-center space-x-3">
                            <!-- Mobile Menu Button -->
                            <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200" onclick="toggleMobileSidebar()">
                                <div class="hamburger w-6 h-6 flex flex-col justify-center items-center space-y-1">
                                    <span class="hamburger-line w-6 h-0.5 bg-gray-600 block"></span>
                                    <span class="hamburger-line w-6 h-0.5 bg-gray-600 block"></span>
                                    <span class="hamburger-line w-6 h-0.5 bg-gray-600 block"></span>
                                </div>
                            </button>
                            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">@yield('header-title', 'Dashboard Overview')</h1>
                        </div>

                        <!-- Right: Search + Notifications + User -->
                        <div class="flex items-center space-x-4 header-user">
                            <!-- Search Bar -->
                            <div class="relative header-search">
                                <input type="search" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-full sm:w-auto">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                <i class="fas fa-bell text-gray-600 text-xl"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                            </button>
                            
                            <!-- User Profile -->
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Avatar" class="w-8 h-8 rounded-full">
                                <span class="font-medium hidden sm:block">JM Casabar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-4">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- JavaScript for Mobile Navigation -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const hamburger = document.querySelector('.hamburger');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            hamburger.classList.toggle('active');
            
            // Prevent body scroll when sidebar is open
            if (sidebar.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }

        function closeMobileSidebar() {
            // Only close on mobile devices
            if (window.innerWidth < 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                const hamburger = document.querySelector('.hamburger');
                
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                hamburger.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        // Close sidebar when window is resized to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                const hamburger = document.querySelector('.hamburger');
                
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                hamburger.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });

        // Prevent sidebar from staying open on page load if window is mobile
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth < 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                const hamburger = document.querySelector('.hamburger');
                
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                hamburger.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>