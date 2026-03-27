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

        /* Theme (Light default, Dark when body.dark) */
        body {
            background-color: #f3f4f6;
            color: #111827;
        }

        /* Light mode sidebar should follow light theme */
        body:not(.dark) #sidebar {
            background-color: #ffffff !important;
            color: #111827 !important;
            border-right: 1px solid #e5e7eb;
        }

        body:not(.dark) #sidebar .text-gray-300,
        body:not(.dark) #sidebar .text-gray-400,
        body:not(.dark) #sidebar a {
            color: #374151 !important;
        }

        body:not(.dark) #sidebar a:hover,
        body:not(.dark) #sidebar button:hover {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
        }

        body:not(.dark) #sidebar .border-gray-700 {
            border-color: #e5e7eb !important;
        }

        /* Dark mode */
        body.dark {
            background-color: #0b1220;
            color: #e5e7eb;
        }

        body.dark #sidebar {
            background-color: #0f172a !important;
            color: #e5e7eb !important;
            border-right: 1px solid #1f2937;
        }

        body.dark .bg-white { background-color: #0f172a !important; }
        body.dark .bg-gray-50 { background-color: #0b1220 !important; }
        body.dark .bg-gray-100 { background-color: #0b1220 !important; }
        body.dark .text-gray-900,
        body.dark .text-gray-800,
        body.dark .text-gray-700,
        body.dark .text-gray-600,
        body.dark .text-gray-500 { color: #e5e7eb !important; }
        body.dark .border-gray-200,
        body.dark .border-gray-300 { border-color: #1f2937 !important; }

        body.dark .divide-gray-200 > :not([hidden]) ~ :not([hidden]) {
            border-color: #1f2937 !important;
        }

        /* Global admin content theming for consistent readability */
        body:not(.dark) main,
        body:not(.dark) header,
        body:not(.dark) .printable-area {
            background-color: #f3f4f6;
            color: #111827;
        }

        body.dark main,
        body.dark header,
        body.dark .printable-area {
            background-color: #0b1220 !important;
            color: #e5e7eb !important;
        }

        body.dark .shadow-sm,
        body.dark .shadow-md,
        body.dark .shadow-lg {
            box-shadow: none !important;
        }

        body.dark input,
        body.dark select,
        body.dark textarea {
            background-color: #0f172a !important;
            color: #e5e7eb !important;
            border-color: #334155 !important;
        }

        body.dark input::placeholder,
        body.dark textarea::placeholder {
            color: #94a3b8 !important;
        }

        body.dark a {
            color: inherit;
        }

        body.dark .text-indigo-600,
        body.dark .hover\:text-indigo-900:hover {
            color: #93c5fd !important;
        }

        body.dark .text-yellow-500,
        body.dark .hover\:text-yellow-600:hover {
            color: #fcd34d !important;
        }

        body.dark .text-red-600,
        body.dark .hover\:text-red-700:hover {
            color: #f87171 !important;
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

        /* Active nav should respect light mode */
        body:not(.dark) .nav-link-active {
            background-color: #eef2ff !important;
            color: #111827 !important;
            border-left: 4px solid #ff6b6b;
        }
        body:not(.dark) .nav-link-active i {
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
                <h2 class="text-xl font-bold text-[#ff6b6b]">Admin Pannel</h2>
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
                        <div class="space-y-1">
                            <a href="{{ route('admin.billing.index') }}" 
                               class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.billing.*') ? 'nav-link-active' : '' }}"
                               onclick="closeMobileSidebar()">
                                <i class="fas fa-dollar-sign mr-3"></i>Income Generated
                            </a>
                            @if(request()->routeIs('admin.billing.*'))
                                <a href="{{ route('admin.billing.trash') }}" 
                                   class="ml-7 flex items-center p-1.5 text-sm text-gray-400 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.billing.trash') ? 'nav-link-active' : '' }}"
                                   onclick="closeMobileSidebar()">
                                    <i class="fas fa-trash-alt mr-2"></i>Trash
                                </a>
                            @endif
                        </div>
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
                        <div class="space-y-1">
                            <a href="{{ route('admin.hardware_esp32') }}" 
                               class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.hardware_esp32') || request()->routeIs('admin.hardwareHistory') || request()->routeIs('admin.hardwareSetting') || request()->routeIs('admin.hardwareInventory') ? 'nav-link-active' : '' }}"
                               onclick="closeMobileSidebar()">
                                <i class="fas fa-desktop mr-3"></i>Hardware
                            </a>
                            @if(request()->routeIs('admin.hardware_esp32') || request()->routeIs('admin.hardwareHistory') || request()->routeIs('admin.hardwareSetting') || request()->routeIs('admin.hardwareInventory'))
                                <a href="{{ route('admin.hardwareHistory') }}"
                                   class="ml-7 flex items-center p-1.5 text-sm text-gray-400 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.hardwareHistory') ? 'nav-link-active' : '' }}"
                                   onclick="closeMobileSidebar()">
                                    <i class="fas fa-history mr-2"></i>Feeding History
                                </a>
                                <a href="{{ route('admin.hardwareInventory') }}"
                                   class="ml-7 flex items-center p-1.5 text-sm text-gray-400 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.hardwareInventory') ? 'nav-link-active' : '' }}"
                                   onclick="closeMobileSidebar()">
                                    <i class="fas fa-boxes mr-2"></i>Feed Inventory
                                </a>
                                <a href="{{ route('admin.hardwareSetting') }}"
                                   class="ml-7 flex items-center p-1.5 text-sm text-gray-400 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item {{ request()->routeIs('admin.hardwareSetting') ? 'nav-link-active' : '' }}"
                                   onclick="closeMobileSidebar()">
                                    <i class="fas fa-cog mr-2"></i>Settings
                                </a>
                            @endif
                        </div>
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
                        <form id="admin-logout-form" method="POST" action="{{ route('admin.logout') }}" class="w-full">
                            @csrf
                            <button type="button" id="admin-logout-trigger" class="flex items-center w-full p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item">
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
                        <!-- Left: Mobile Menu + Title (optional subtitle + toggle dot) -->
                        <div class="flex items-start space-x-3 flex-1 min-w-0 md:mr-4">
                            <!-- Mobile Menu Button -->
                            <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200 shrink-0" onclick="toggleMobileSidebar()">
                                <div class="hamburger w-6 h-6 flex flex-col justify-center items-center space-y-1">
                                    <span class="hamburger-line w-6 h-0.5 bg-gray-600 block"></span>
                                    <span class="hamburger-line w-6 h-0.5 bg-gray-600 block"></span>
                                    <span class="hamburger-line w-6 h-0.5 bg-gray-600 block"></span>
                                </div>
                            </button>
                            @hasSection('header-title')
                                <div class="min-w-0 flex-1 flex flex-col">
                                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                                        <h1 class="text-xl md:text-2xl font-semibold text-gray-800 leading-tight">@yield('header-title')</h1>
                                        @hasSection('header-subtitle')
                                            <button type="button" id="adminHeaderSubtitleToggle" class="shrink-0 w-2.5 h-2.5 rounded-full bg-gray-400 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gray-400 transition-colors" aria-label="Show or hide description" aria-expanded="false" title="Show description"></button>
                                        @endif
                                        @hasSection('header-extra')
                                            <span class="text-xs px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 font-semibold whitespace-nowrap md:ml-auto">@yield('header-extra')</span>
                                        @endif
                                    </div>
                                    @hasSection('header-subtitle')
                                        <p id="adminHeaderSubtitle" class="hidden text-sm text-gray-500 mt-1 max-w-2xl pr-2">@yield('header-subtitle')</p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Right: Search + Theme + Notifications + User -->
                        <div class="flex items-center space-x-4 header-user">
                            <!-- Search Bar -->
                            <div class="relative header-search">
                                <input type="search" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-full sm:w-auto">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>

                            <!-- Theme Toggle -->
                            <button id="darkModeToggle" type="button" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200" title="Toggle dark mode">
                                <i class="fas fa-moon text-gray-600 text-xl"></i>
                            </button>
                            
                            <!-- Notifications -->
                            <button id="adminNotificationsBtn" type="button" class="relative p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200" title="Notifications">
                                <i class="fas fa-bell text-gray-600 text-xl"></i>
                                <span id="adminNotificationsDot" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full w-4 h-4 items-center justify-center">1</span>
                            </button>
                            
                            <!-- User Profile -->
                            <a href="{{ route('admin.profile.edit') }}" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Avatar" class="w-8 h-8 rounded-full">
                                <span class="font-medium hidden sm:block">{{ session('admin_name', 'Admin') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            @hasSection('header-subtitle')
            <script>
                (function () {
                    var btn = document.getElementById('adminHeaderSubtitleToggle');
                    var sub = document.getElementById('adminHeaderSubtitle');
                    if (!btn || !sub) return;
                    btn.addEventListener('click', function () {
                        sub.classList.toggle('hidden');
                        btn.setAttribute('aria-expanded', sub.classList.contains('hidden') ? 'false' : 'true');
                    });
                })();
            </script>
            @endif

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-4">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- JavaScript for Mobile Navigation -->
    <script>
        // Theme toggle (shared localStorage key with other admin layouts)
        (function () {
            const body = document.body;
            const btn = document.getElementById('darkModeToggle');

            function apply(isDark) {
                body.classList.toggle('dark', isDark);
                const icon = btn?.querySelector('i');
                if (icon) {
                    icon.className = isDark ? 'fas fa-sun text-yellow-400 text-xl' : 'fas fa-moon text-gray-600 text-xl';
                }
            }

            const saved = localStorage.getItem('darkMode') === 'true';
            apply(saved);

            btn?.addEventListener('click', function () {
                const next = !body.classList.contains('dark');
                localStorage.setItem('darkMode', next);
                apply(next);
            });
        })();

        // Notifications (poll latest completed purchase)
        (function () {
            const btn = document.getElementById('adminNotificationsBtn');
            const dot = document.getElementById('adminNotificationsDot');
            if (!btn || !dot) return;

            const url = "{{ route('admin.notifications.latest') }}";
            const storageKey = 'adminLastNotifiedCompletedBillingId';
            let latestMessage = null;

            function setDot(show) {
                dot.classList.toggle('hidden', !show);
                dot.classList.toggle('flex', show);
            }

            async function poll() {
                try {
                    const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) return;
                    const data = await res.json();
                    if (!data?.latest?.id) return;

                    const last = parseInt(localStorage.getItem(storageKey) || '0', 10);
                    const current = parseInt(String(data.latest.id), 10);
                    if (Number.isFinite(current) && current > last) {
                        latestMessage = data.latest;
                        setDot(true);
                        // Show toast immediately
                        const msg = `New completed purchase: #${data.latest.id} • ${data.latest.name} • ₱${Number(data.latest.total_amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                        window.showToast?.(msg, 'success');
                        localStorage.setItem(storageKey, String(current));
                    }
                } catch (e) {
                    // ignore
                }
            }

            btn.addEventListener('click', function () {
                if (!latestMessage) {
                    window.showToast?.('No new notifications.', 'info');
                    return;
                }

                const details = `Customer: ${latestMessage.name}\nEmail: ${latestMessage.email}\nAmount: ₱${Number(latestMessage.total_amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}\nDate: ${latestMessage.created_at}`;
                window.showToast?.(details, 'info');
                latestMessage = null;
                setDot(false);
            });

            // initial + interval polling
            poll();
            setInterval(poll, 15000);
        })();

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
    
    {{-- Global toast notifications for admin pages --}}
    @include('partials.toast-container')

    {{-- Tailwind modal for important admin errors --}}
    @if(session('error'))
        <div id="admin-error-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
                <div class="px-6 py-4 border-b flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                        <h2 class="text-lg font-semibold text-gray-800">Operation Failed</h2>
                    </div>
                    <button type="button" id="admin-error-modal-close" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="px-6 py-4">
                    <p class="text-sm text-gray-700 whitespace-pre-line break-words">
                        {{ session('error') }}
                    </p>
                </div>
                <div class="px-6 py-3 border-t flex justify-end">
                    <button type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200"
                            onclick="window.adminCloseErrorModal && window.adminCloseErrorModal()">
                        Close
                    </button>
                </div>
            </div>
        </div>
        <script>
            (function () {
                const modal = document.getElementById('admin-error-modal');
                if (!modal) return;

                window.adminCloseErrorModal = function () {
                    modal.remove();
                };

                document.getElementById('admin-error-modal-close')?.addEventListener('click', window.adminCloseErrorModal);
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        window.adminCloseErrorModal();
                    }
                });
            })();
        </script>
    @endif

    @include('partials.admin-logout-modal')
    @include('partials.confirm-modal')
    @stack('scripts')
</body>
</html>