<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }

        .dark {
            background-color: #1a202c;
            color: #e2e8f0;
        }

        .dark .bg-white {
            background-color: #2d3748;
        }

        .dark .text-gray-700,
        .dark .text-gray-800 {
            color: #ffffff !important;
        }

        .dark .text-gray-600 {
            color: #cbd5e0 !important;
        }

        .dark input,
        .dark textarea,
        .dark select {
            background-color: #4a5568 !important;
            color: #e2e8f0 !important;
            border-color: #718096 !important;
        }

        .transition-bg {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Ensure text is always visible */
        .content-text {
            color: #374151 !important;
        }

        .content-text-secondary {
            color: #6b7280 !important;
        }

        .dark .content-text {
            color: #f9fafb !important;
        }

        .dark .content-text-secondary {
            color: #d1d5db !important;
        }

        /* Admin table styles */
        .admin-table {
            background-color: white;
            color: #374151;
        }

        .dark .admin-table {
            background-color: #2d3748;
            color: #f9fafb;
        }

        .admin-table th {
            background-color: #f9fafb;
            color: #374151;
            font-weight: 600;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #e5e7eb;
        }

        .dark .admin-table th {
            background-color: #374151;
            color: #f9fafb;
            border-bottom: 2px solid #4b5563;
        }

        .admin-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
        }

        .dark .admin-table td {
            border-bottom: 1px solid #4b5563;
            color: #f9fafb;
        }

        /* Report card styles */
        .report-card {
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .dark .report-card {
            background-color: #2d3748;
            border-color: #4b5563;
        }

        .report-card h3 {
            color: #374151;
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .dark .report-card h3 {
            color: #f9fafb;
        }

        .report-card p {
            color: #6b7280;
            margin-bottom: 16px;
        }

        .dark .report-card p {
            color: #d1d5db;
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

        /* Active navigation styles */
        .nav-link-active {
            background-color: #374151 !important;
            color: #ff6b6b !important;
            border-left: 4px solid #ff6b6b;
        }
        .nav-link-active i {
            color: #ff6b6b !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .mobile-nav-item {
                padding: 0.75rem 1rem;
                font-size: 0.95rem;
            }
            
            .mobile-nav-item i {
                width: 20px;
                margin-right: 0.75rem;
            }

            .content-padding {
                padding: 1rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        @media (min-width: 769px) {
            .content-padding {
                padding: 2rem;
            }

            .form-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
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
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                        </a>
                    </li>
                    <!-- Product Stocks -->
                    <li>
                        <a href="{{ route('admin.product.index') }}"  
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-box mr-3"></i>Product Stocks
                        </a>
                    </li>
                    <!-- Income Generated -->
                    <li>
                        <a href="{{ route('admin.billing.index') }}"  
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-dollar-sign mr-3"></i>Income Generated
                        </a>
                    </li>
                    <!-- Expenses Table -->
                    <li>
                        <a href="{{ route('admin.expense.index')}}"  
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-table mr-3"></i>Expenses Table
                        </a>
                    </li>
                    <!-- Customer Feedback Management -->
                    <li>
                        <a href="{{ route('contactforlist' ) }}"  
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-comments mr-3"></i>Customer Feedback Management
                        </a>
                    </li>
                    <!-- Incubation Book List -->
                    <li>
                        <a href="#"href="{{ route('admin.incubation.index' ) }}"  
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-industry mr-3"></i>Incubation Book List
                        </a>
                    </li>
                    <!-- Hardware -->
                    <li>
                        <a href="{{route('admin.hardware_esp32')}}"  
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item"
                           onclick="closeMobileSidebar()">
                            <i class="fas fa-desktop mr-3"></i>Hardware
                        </a>
                    </li>
                    <!-- Personal -->
                    <li>
                        <a href="#" 
                           class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200 mobile-nav-item nav-link-active"
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
        <main class="flex-1 md:ml-64 flex flex-col min-h-screen">
            <!-- Mobile Header with Hamburger Menu -->
            <header class="bg-white shadow-sm md:hidden">
                <div class="flex justify-between items-center p-4">
                    <!-- Mobile Menu Button -->
                    <button id="mobileMenuBtn" class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200" onclick="toggleMobileSidebar()">
                        <div class="hamburger w-6 h-6 flex flex-col justify-center items-center space-y-1">
                            <span class="hamburger-line w-6 h-0.5 bg-gray-600 block"></span>
                            <span class="hamburger-line w-6 h-0.5 bg-gray-600 block"></span>
                            <span class="hamburger-line w-6 h-0.5 bg-gray-600 block"></span>
                        </div>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-800">Personal Settings</h1>
                    <button id="darkModeToggle" class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-moon text-gray-600"></i>
                    </button>
                </div>
            </header>

            <!-- Content Area with Light Background -->
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 content-padding">
                <div class="max-w-6xl mx-auto">
                    <!-- Page Header -->
                    <div class="mb-8">
                        <h1 class="text-2xl md:text-3xl font-bold content-text mb-2">Personal Settings</h1>
                        <p class="content-text-secondary">Manage your admin profile and account settings</p>
                    </div>

                    <!-- Dark Mode Toggle for Desktop -->
                    <div class="hidden md:flex justify-end mb-4">
                        <button id="darkModeToggleDesktop" class="p-2 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                            <i class="fas fa-moon text-gray-600"></i>
                            <span class="ml-2 content-text">Dark Mode</span>
                        </button>
                    </div>

                    <!-- Admin Management Table -->
                    <div class="report-card">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold content-text">Admin User Management</h3>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <i class="fas fa-plus mr-2"></i>Add New Admin
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full admin-table rounded-lg overflow-hidden">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>JM Casabar</td>
                                        <td>jmcasabar.success@gmail.com</td>
                                        <td>
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Admin</span>
                                        </td>
                                        <td>
                                            <button class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Toshiro</td>
                                        <td>validadmin@gmail.com</td>
                                        <td>
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">Admin</span>
                                        </td>
                                        <td>
                                            <button class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="stats-grid mb-8">
                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium content-text-secondary">Total Sessions</p>
                                    <p class="text-2xl font-bold content-text">1,247</p>
                                </div>
                                <div class="p-3 bg-blue-100 rounded-full">
                                    <i class="fas fa-chart-line text-blue-600"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium content-text-secondary">Last Login</p>
                                    <p class="text-2xl font-bold content-text">2 hrs ago</p>
                                </div>
                                <div class="p-3 bg-green-100 rounded-full">
                                    <i class="fas fa-clock text-green-600"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium content-text-secondary">Account Status</p>
                                    <p class="text-2xl font-bold text-green-600">Active</p>
                                </div>
                                <div class="p-3 bg-purple-100 rounded-full">
                                    <i class="fas fa-user-check text-purple-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Generation Cards -->
                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div class="report-card">
                            <h3>Expenses Report</h3>
                            <p>Generate a comprehensive expenses report in MS Excel format for detailed analysis and record-keeping.</p>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                                <i class="fas fa-download mr-2"></i>Generate Expenses Report
                            </button>
                        </div>

                        <div class="report-card">
                            <h3>Sales Report</h3>
                            <p>Generate a comprehensive sales report in MS Excel format for detailed analysis and record-keeping.</p>
                            <button id="generateSalesReport" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                                <i class="fas fa-download mr-2"></i>Generate Sales Report
                            </button>
                        </div>

                        <div class="report-card">
                            <h3>Income Report</h3>
                            <p>Generate a comprehensive income report in MS Excel format for detailed analysis and record-keeping.</p>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                                <i class="fas fa-download mr-2"></i>Generate Income Report
                            </button>
                        </div>

                        <div class="report-card">
                            <h3>Stock Report</h3>
                            <p>Generate a comprehensive stock report in MS Excel format for detailed analysis and record-keeping.</p>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                                <i class="fas fa-download mr-2"></i>Generate Stock Report
                            </button>
                        </div>
                    </div>

                    <!-- Admin Profile Form -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                        <h2 class="text-xl font-semibold content-text mb-6">Admin Profile</h2>
                        <form id="adminForm" class="form-grid">
                            <div>
                                <label for="fullName" class="block text-sm font-medium content-text mb-2">Full Name</label>
                                <input type="text" id="fullName" name="fullName" value="JM Casabar" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium content-text mb-2">Email Address</label>
                                <input type="email" id="email" name="email" value="admin@example.com" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium content-text mb-2">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="+1 (555) 123-4567" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="role" class="block text-sm font-medium content-text mb-2">Role</label>
                                <select id="role" name="role" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="super-admin" selected>Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="moderator">Moderator</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="bio" class="block text-sm font-medium content-text mb-2">Bio</label>
                                <textarea id="bio" name="bio" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Tell us about yourself...">Experienced administrator with expertise in system management and user support.</textarea>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium content-text mb-2">New Password</label>
                                <input type="password" id="password" name="password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Leave blank to keep current password">
                            </div>

                            <div>
                                <label for="confirm-password" class="block text-sm font-medium content-text mb-2">Confirm Password</label>
                                <input type="password" id="confirm-password" name="confirm-password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Confirm new password">
                            </div>

                            <div class="md:col-span-2 flex flex-col sm:flex-row gap-4 pt-4">
                                <button type="submit" 
                                        class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                                    <i class="fas fa-save mr-2"></i>Update Profile
                                </button>
                                <button type="button" id="generateReport"
                                        class="flex-1 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200 font-medium">
                                    <i class="fas fa-download mr-2"></i>Generate Profile Report
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript for Mobile Navigation and Dark Mode -->
    <script>
        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeToggleDesktop = document.getElementById('darkModeToggleDesktop');
        const body = document.body;
        
        function toggleDarkMode() {
            body.classList.toggle('dark');
            const isDark = body.classList.contains('dark');
            localStorage.setItem('darkMode', isDark);
            
            // Update toggle icons
            const moonIcons = document.querySelectorAll('#darkModeToggle i, #darkModeToggleDesktop i');
            moonIcons.forEach(icon => {
                icon.className = isDark ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-600';
            });
        }
        
        // Load saved dark mode preference
        const savedDarkMode = localStorage.getItem('darkMode') === 'true';
        if (savedDarkMode) {
            body.classList.add('dark');
            const moonIcons = document.querySelectorAll('#darkModeToggle i, #darkModeToggleDesktop i');
            moonIcons.forEach(icon => {
                icon.className = 'fas fa-sun text-yellow-400';
            });
        }
        
        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', toggleDarkMode);
        }
        
        if (darkModeToggleDesktop) {
            darkModeToggleDesktop.addEventListener('click', toggleDarkMode);
        }

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

        // Admin form submission
        const adminForm = document.getElementById('adminForm');
        if (adminForm) {
            adminForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(adminForm);
                const adminData = Object.fromEntries(formData.entries());
                console.log('Admin data submitted:', adminData);
                
                // Validate password match
                if (adminData.password !== adminData['confirm-password']) {
                    alert('Passwords do not match. Please try again.');
                    return;
                }
                
                // Here you would typically send the data to your backend
                // For now, we'll just show an alert
                alert('Admin details updated successfully!');
            });
        }

        // Generate sales report
        const generateReportBtn = document.getElementById('generateReport');
        const generateSalesReportBtn = document.getElementById('generateSalesReport');
        
        function generateSalesReport() {
            // Sample sales data
            const salesData = [
                { date: '2023-01-01', product: 'Widget A', quantity: 10, revenue: 1000 },
                { date: '2023-01-02', product: 'Widget B', quantity: 5, revenue: 750 },
                { date: '2023-01-03', product: 'Widget C', quantity: 8, revenue: 1200 },
                { date: '2023-01-04', product: 'Widget A', quantity: 15, revenue: 1500 },
                { date: '2023-01-05', product: 'Widget B', quantity: 7, revenue: 1050 },
            ];

            // Create workbook and worksheet
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.json_to_sheet(salesData);

            // Add worksheet to workbook
            XLSX.utils.book_append_sheet(wb, ws, 'Sales Report');

            // Generate Excel file
            XLSX.writeFile(wb, 'sales_report.xlsx');

            alert('Sales report generated successfully!');
        }
        
        if (generateReportBtn) {
            generateReportBtn.addEventListener('click', generateSalesReport);
        }
        
        if (generateSalesReportBtn) {
            generateSalesReportBtn.addEventListener('click', generateSalesReport);
        }
    </script>
</body>
</html>