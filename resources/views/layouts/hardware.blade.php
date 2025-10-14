<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feeding Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
    <style>
        /* CSS-only mobile navigation using checkbox hack */
        #mobile-menu-toggle {
            display: none;
        }

        /* Mobile sidebar hidden by default */
        .mobile-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        /* Show sidebar when checkbox is checked */
        #mobile-menu-toggle:checked ~ .sidebar-container .mobile-sidebar {
            transform: translateX(0);
        }

        /* Show overlay when checkbox is checked */
        #mobile-menu-toggle:checked ~ .sidebar-overlay {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        /* Prevent body scroll when sidebar is open */
        #mobile-menu-toggle:checked ~ * {
            overflow: hidden;
        }

        /* Overlay styling */
        .sidebar-overlay {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: all 0.3s ease-in-out;
        }

        /* Hamburger animation */
        .hamburger-line {
            transition: all 0.3s ease-in-out;
            transform-origin: center;
        }

        #mobile-menu-toggle:checked + .hamburger-container .hamburger .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        #mobile-menu-toggle:checked + .hamburger-container .hamburger .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        #mobile-menu-toggle:checked + .hamburger-container .hamburger .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        /* Active navigation styles */
        .nav-link-active {
            background-color: #4f46e5 !important;
            color: white !important;
        }

        /* Mobile navigation item styling */
        .mobile-nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #d1d5db;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            min-height: 44px;
        }

        .mobile-nav-item:hover {
            background-color: #374151;
            color: white;
        }

        .mobile-nav-item i {
            width: 20px;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Hidden checkbox for mobile menu toggle -->
    <input type="checkbox" id="mobile-menu-toggle" class="hidden">
    
    <!-- Hamburger button (label for checkbox) -->
    <label for="mobile-menu-toggle" class="hamburger-container fixed top-4 left-4 z-50 md:hidden cursor-pointer">
        <div class="hamburger bg-white p-3 rounded-lg shadow-lg hover:bg-gray-50 transition-colors duration-200">
            <div class="w-6 h-6 flex flex-col justify-center items-center space-y-1">
                <span class="hamburger-line w-6 h-0.5 bg-gray-600 block"></span>
                <span class="hamburger-line w-6 h-0.5 bg-gray-600 block"></span>
                <span class="hamburger-line w-6 h-0.5 bg-gray-600 block"></span>
            </div>
        </div>
    </label>

    <!-- Sidebar overlay -->
    <div class="sidebar-overlay fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden">
        <label for="mobile-menu-toggle" class="absolute inset-0 cursor-pointer"></label>
    </div>

    <!-- Sidebar container -->
    <div class="sidebar-container">
        <aside class="mobile-sidebar md:translate-x-0 bg-gray-800 text-white w-64 fixed h-screen overflow-y-auto z-50 md:z-10">
            <div class="p-4 border-b border-gray-700 flex justify-between items-center">
                <h2 class="text-xl font-bold text-primary">Feeding Dashboard</h2>
                <!-- Close button for mobile -->
                <label for="mobile-menu-toggle" class="md:hidden text-gray-300 hover:text-white p-2 rounded-lg cursor-pointer">
                    <i class="fas fa-times text-lg"></i>
                </label>
            </div>
            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.hardware_esp32') }}" 
                           class="mobile-nav-item {{ request()->routeIs('admin.hardware_esp32') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            Feeding Schedule
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="mobile-nav-item {{ request()->routeIs('admin.dashboard') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-utensils"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.hardwareHistory') }}" 
                           class="mobile-nav-item {{ request()->routeIs('admin.hardwareHistory') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-history"></i>
                            Feeding History
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.hardwareAnalytics') }}" 
                           class="mobile-nav-item {{ request()->routeIs('admin.hardwareAnalytics') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-chart-line"></i>
                            Analytics
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.hardwareSetting') }}" 
                           class="mobile-nav-item {{ request()->routeIs('admin.hardwareSetting') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-cog"></i>
                            Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.hardwareInventory') }}" 
                           class="mobile-nav-item {{ request()->routeIs('admin.hardwareInventory') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-box"></i>
                            Feed Inventory
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
    </div>

    <div class="min-h-screen flex">
        <!-- Main Content -->
        <div class="flex-1 md:ml-64 flex flex-col h-screen overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center">
                        <!-- Left: Title (with extra margin on mobile for hamburger) -->
                        <div class="flex items-center ml-16 md:ml-0">
                            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Feeding Control System</h1>
                        </div>

                        <!-- Right: Search (hidden on mobile) + Notifications + User -->
                        <div class="flex items-center space-x-4">
                            {{-- <!-- Search Bar - HIDDEN ON MOBILE -->
                            <div class="relative hidden md:block">
                                <input type="search" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-full sm:w-auto focus:outline-none focus:ring-primary focus:border-primary">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div> --}}
                            
                            <!-- Notifications -->
                            <button class="relative p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200" type="button">
                                <i class="fas fa-bell text-gray-600 text-xl"></i>
                                <span class="absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                            </button>
                            
                            <!-- User Profile -->
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200" type="button">
                                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Avatar" class="w-8 h-8 rounded-full">
                                <span class="font-medium hidden sm:block">Mr.JM</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-4">
                @yield('content')
                
                <!-- Default content if no content is yielded -->
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Feeding Control Dashboard</h2>
                        <p class="text-gray-600 mb-4">Welcome to your feeding control system. Use the navigation menu to access different features.</p>
                        
                        <!-- Quick Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                            <div class="bg-primary text-white p-6 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-primary-100">Next Feeding</p>
                                        <p class="text-2xl font-bold">2:30 PM</p>
                                    </div>
                                    <i class="fas fa-clock text-3xl opacity-75"></i>
                                </div>
                            </div>
                            
                            <div class="bg-success text-white p-6 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-green-100">Feed Level</p>
                                        <p class="text-2xl font-bold">78%</p>
                                    </div>
                                    <i class="fas fa-fill-drip text-3xl opacity-75"></i>
                                </div>
                            </div>
                            
                            <div class="bg-info text-white p-6 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-blue-100">Today's Feedings</p>
                                        <p class="text-2xl font-bold">4</p>
                                    </div>
                                    <i class="fas fa-utensils text-3xl opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Minimal JavaScript for closing sidebar on navigation -->
    <script>
        // Auto-close sidebar when navigating on mobile
        document.querySelectorAll('.mobile-nav-item').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    document.getElementById('mobile-menu-toggle').checked = false;
                }
            });
        });

        // Close sidebar on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.getElementById('mobile-menu-toggle').checked = false;
            }
        });
    </script>
</body>
</html>