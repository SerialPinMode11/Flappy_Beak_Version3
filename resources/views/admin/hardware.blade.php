<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feeding Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .schedule-item:hover .delete-btn {
            display: flex;
        }
        .delete-btn {
            display: none;
        }
    </style>
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
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white w-64 min-h-screen hidden md:block">
            <div class="p-4 border-b border-gray-700">
                <h2 class="text-xl font-bold text-primary">Feeding Dashboard</h2>
            </div>
            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="flex items-center p-2 text-white bg-primary rounded-lg transition-colors duration-200">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Feeding Schedule
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.dashboard')}}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200">
                            <i class="fas fa-utensils mr-3"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.hardwareHistory')}}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200">
                            <i class="fas fa-history mr-3"></i>
                            Feeding History
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.hardwareAnalytics')}}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200">
                            <i class="fas fa-chart-line mr-3"></i>
                            Analytics
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.hardwareSetting')}}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200">
                            <i class="fas fa-cog mr-3"></i>
                            Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.hardwareInventory')}}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200">
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
                            <input type="search" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
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

            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <!-- Status Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-gray-500 text-sm font-medium">Last Feeding</h3>
                            <span class="text-primary bg-indigo-100 p-2 rounded-full"><i class="fas fa-utensils"></i></span>
                        </div>
                        <p class="text-2xl font-bold text-gray-800" id="last-feeding-time">Today, 10:30 AM</p>
                        <p class="text-gray-500 text-sm font-medium mt-2">
                            <i class="fas fa-clock mr-1"></i>
                            <span id="time-since-last">5 hours ago</span>
                        </p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-gray-500 text-sm font-medium">Feed Dispensed Today</h3>
                            <span class="text-primary bg-indigo-100 p-2 rounded-full"><i class="fas fa-weight"></i></span>
                        </div>
                        <p class="text-2xl font-bold text-gray-800">1.3 kg</p>
                        <p class="text-green-500 text-sm font-medium mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>
                            15% from yesterday
                        </p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-gray-500 text-sm font-medium">Feed Inventory</h3>
                            <span class="text-primary bg-indigo-100 p-2 rounded-full"><i class="fas fa-box"></i></span>
                        </div>
                        <p class="text-2xl font-bold text-gray-800">78%</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                            <div class="bg-primary h-2.5 rounded-full" style="width: 78%"></div>
                        </div>
                        <p class="text-gray-500 text-sm font-medium mt-2">
                            23.4 kg remaining
                        </p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-gray-500 text-sm font-medium">Next Scheduled</h3>
                            <span class="text-primary bg-indigo-100 p-2 rounded-full"><i class="fas fa-calendar"></i></span>
                        </div>
                        <p class="text-2xl font-bold text-gray-800" id="next-feeding-time">Today, 4:00 PM</p>
                        <p class="text-gray-500 text-sm font-medium mt-2">
                            <i class="fas fa-hourglass-half mr-1"></i>
                            <span id="time-until-next">3 hours 30 min</span>
                        </p>
                    </div>
                </div>

                <!-- Manual Feeding Control -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-8">
                    <h3 class="text-lg font-semibold mb-6 text-gray-800">Manual Feeding Control</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="col-span-1">
                            <label for="feed-amount" class="block text-sm font-medium text-gray-700 mb-2">Feed Amount (kg)</label>
                            <div class="flex items-center">
                                <button id="decrease-amount" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-l">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="feed-amount" class="w-full text-center py-2 border-t border-b border-gray-300" value="0.5" step="0.1" min="0.1" max="5">
                                <button id="increase-amount" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-r">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <label for="feed-type" class="block text-sm font-medium text-gray-700 mb-2">Feed Type</label>
                            <select id="feed-type" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="standard">Standard Feed</option>
                                <option value="premium">Premium Mix</option>
                                <option value="growth">Growth Formula</option>
                                
                            </select>
                        </div>
                        <div class="col-span-1 flex items-end">
                            <button id="feed-now-btn" class="w-full bg-primary hover:bg-secondary text-white font-bold py-2 px-4 rounded-md transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-utensils mr-2"></i>
                                Feed Now
                            </button>
                        </div>
                    </div>
                    <div class="mt-6 p-4 bg-gray-50 rounded-md" id="manual-feed-status">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-primary mr-2"></i>
                            <p class="text-gray-700">Ready to dispense feed. Click "Feed Now" to start manual feeding.</p>
                        </div>
                    </div>
                </div>

                <!-- Scheduled Feeding & Feeding History -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Scheduled Feeding -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Scheduled Feeding</h3>
                            <button id="add-schedule-btn" class="bg-primary hover:bg-secondary text-white text-sm font-medium py-1 px-3 rounded-md transition-colors duration-200">
                                <i class="fas fa-plus mr-1"></i> Add Schedule
                            </button>
                        </div>
                        <div class="space-y-4 max-h-[350px] overflow-y-auto" id="schedule-list">
                            <div class="p-3 border border-gray-200 rounded-md schedule-item">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="bg-primary text-white p-2 rounded-md mr-3">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Morning Feed</h4>
                                            <p class="text-sm text-gray-500">Daily at 8:00 AM - 0.8 kg</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <label class="inline-flex items-center cursor-pointer mr-3">
                                            <input type="checkbox" class="sr-only peer" checked>
                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                        <button class="text-gray-400 hover:text-gray-600 delete-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border border-gray-200 rounded-md schedule-item">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="bg-primary text-white p-2 rounded-md mr-3">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Afternoon Feed</h4>
                                            <p class="text-sm text-gray-500">Daily at 1:00 PM - 0.5 kg</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <label class="inline-flex items-center cursor-pointer mr-3">
                                            <input type="checkbox" class="sr-only peer" checked>
                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                        <button class="text-gray-400 hover:text-gray-600 delete-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border border-gray-200 rounded-md schedule-item">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="bg-primary text-white p-2 rounded-md mr-3">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Evening Feed</h4>
                                            <p class="text-sm text-gray-500">Daily at 6:00 PM - 1.0 kg</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <label class="inline-flex items-center cursor-pointer mr-3">
                                            <input type="checkbox" class="sr-only peer" checked>
                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                        <button class="text-gray-400 hover:text-gray-600 delete-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border border-gray-200 rounded-md schedule-item">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="bg-primary text-white p-2 rounded-md mr-3">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Weekend Bonus</h4>
                                            <p class="text-sm text-gray-500">Sat, Sun at 11:00 AM - 0.3 kg</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <label class="inline-flex items-center cursor-pointer mr-3">
                                            <input type="checkbox" class="sr-only peer" checked>
                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                        <button class="text-gray-400 hover:text-gray-600 delete-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feeding History Chart -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Feeding History</h3>
                            <select id="history-period" class="border border-gray-300 rounded-md py-1 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="7">Last 7 Days</option>
                                <option value="14">Last 14 Days</option>
                                <option value="30">Last 30 Days</option>
                            </select>
                        </div>
                        <div id="feedingHistoryChart" style="height: 300px;"></div>
                    </div>
                </div>

                <!-- Feed Distribution & Daily Pattern -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Feed Distribution -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-lg font-semibold mb-6 text-gray-800">Feed Type Distribution</h3>
                        <div id="feedDistributionChart" style="height: 300px;"></div>
                    </div>
                    
                    <!-- Daily Pattern -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-lg font-semibold mb-6 text-gray-800">Daily Feeding Pattern</h3>
                        <div id="dailyPatternChart" style="height: 300px;"></div>
                    </div>
                </div>

                <!-- Recent Feeding Activity -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Feeding Activity</h3>
                            <a href="#" class="text-primary hover:text-secondary text-sm font-medium">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left border-b border-gray-200">
                                        <th class="pb-4 font-semibold text-sm text-gray-600">Date & Time</th>
                                        <th class="pb-4 font-semibold text-sm text-gray-600">Feed Type</th>
                                        <th class="pb-4 font-semibold text-sm text-gray-600">Amount</th>
                                        <th class="pb-4 font-semibold text-sm text-gray-600">Method</th>
                                        <th class="pb-4 font-semibold text-sm text-gray-600">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-200">
                                        <td class="py-4 text-sm">Today, 10:30 AM</td>
                                        <td class="py-4 text-sm">Standard Feed</td>
                                        <td class="py-4 text-sm">0.8 kg</td>
                                        <td class="py-4 text-sm">Scheduled</td>
                                        <td class="py-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Completed</span></td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td class="py-4 text-sm">Today, 8:00 AM</td>
                                        <td class="py-4 text-sm">Premium Mix</td>
                                        <td class="py-4 text-sm">0.5 kg</td>
                                        <td class="py-4 text-sm">Manual</td>
                                        <td class="py-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Completed</span></td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td class="py-4 text-sm">Yesterday, 6:00 PM</td>
                                        <td class="py-4 text-sm">Standard Feed</td>
                                        <td class="py-4 text-sm">1.0 kg</td>
                                        <td class="py-4 text-sm">Scheduled</td>
                                        <td class="py-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td class="py-4 text-sm">Yesterday, 1:00 PM</td>
                                        <td class="py-4 text-sm">Growth Formula</td>
                                        <td class="py-4 text-sm">0.5 kg</td>
                                        <td class="py-4 text-sm">Scheduled</td>
                                        <td class="py-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Completed</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Schedule Modal -->
    <div id="schedule-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Add Feeding Schedule</h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="schedule-form">
                <div class="mb-4">
                    <label for="schedule-name" class="block text-sm font-medium text-gray-700 mb-1">Schedule Name</label>
                    <input type="text" id="schedule-name" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="e.g. Morning Feed">
                </div>
                <div class="mb-4">
                    <label for="schedule-time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                    <input type="time" id="schedule-time" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label for="schedule-days" class="block text-sm font-medium text-gray-700 mb-1">Days</label>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="mon">Mon</button>
                        <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="tue">Tue</button>
                        <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="wed">Wed</button>
                        <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="thu">Thu</button>
                        <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="fri">Fri</button>
                        <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="sat">Sat</button>
                        <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="sun">Sun</button>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="schedule-amount" class="block text-sm font-medium text-gray-700 mb-1">Feed Amount (kg)</label>
                    <input type="number" id="schedule-amount" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="0.5" step="0.1" min="0.1" max="5">
                </div>
                <div class="mb-4">
                    <label for="schedule-feed-type" class="block text-sm font-medium text-gray-700 mb-1">Feed Type</label>
                    <select id="schedule-feed-type" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="standard">Standard Feed</option>
                        <option value="premium">Premium Mix</option>
                        <option value="growth">Growth Formula</option>
                        <option value="maintenance">Maintenance Formula</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancel-schedule" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-secondary text-white rounded-md text-sm font-medium">Save Schedule</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initialize time displays
        function updateTimeDisplays() {
            const now = moment();
            
            // Last feeding time was 2 hours ago
            const lastFeeding = moment().subtract(2, 'hours');
            document.getElementById('last-feeding-time').textContent = lastFeeding.format('ddd, h:mm A');
            document.getElementById('time-since-last').textContent = lastFeeding.fromNow();
            
            // Next feeding in 3.5 hours
            const nextFeeding = moment().add(3.5, 'hours');
            document.getElementById('next-feeding-time').textContent = nextFeeding.format('ddd, h:mm A');
            document.getElementById('time-until-next').textContent = moment.duration(nextFeeding.diff(now)).humanize();
        }
        
        updateTimeDisplays();
        setInterval(updateTimeDisplays, 60000); // Update every minute
        
        // Manual feeding controls
        document.getElementById('decrease-amount').addEventListener('click', function() {
            const input = document.getElementById('feed-amount');
            let value = parseFloat(input.value);
            if (value > 0.1) {
                input.value = (value - 0.1).toFixed(1);
            }
        });
        
        document.getElementById('increase-amount').addEventListener('click', function() {
            const input = document.getElementById('feed-amount');
            let value = parseFloat(input.value);
            if (value < 5) {
                input.value = (value + 0.1).toFixed(1);
            }
        });
        
        document.getElementById('feed-now-btn').addEventListener('click', function() {
            const amount = document.getElementById('feed-amount').value;
            const feedType = document.getElementById('feed-type').value;
            const statusDiv = document.getElementById('manual-feed-status');
            
            // Show feeding in progress
            statusDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-spinner fa-spin text-primary mr-2"></i>
                    <p class="text-gray-700">Dispensing ${amount} kg of ${feedType.replace(/([A-Z])/g, ' $1').toLowerCase()}...</p>
                </div>
            `;
            
            // Simulate feeding completion after 3 seconds
            setTimeout(() => {
                statusDiv.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-success mr-2"></i>
                        <p class="text-gray-700">Successfully dispensed ${amount} kg of ${feedType.replace(/([A-Z])/g, ' $1').toLowerCase()}.</p>
                    </div>
                `;
                
                // Update last feeding time
                const now = moment();
                document.getElementById('last-feeding-time').textContent = now.format('ddd, h:mm A');
                document.getElementById('time-since-last').textContent = 'just now';
                
                // Add to recent activity (would be done server-side in a real app)
                const tbody = document.querySelector('table tbody');
                const newRow = document.createElement('tr');
                newRow.classList.add('border-b', 'border-gray-200');
                newRow.innerHTML = `
                    <td class="py-4 text-sm">${now.format('ddd, h:mm A')}</td>
                    <td class="py-4 text-sm">${feedType.replace(/([A-Z])/g, ' $1').toLowerCase()}</td>
                    <td class="py-4 text-sm">${amount} kg</td>
                    <td class="py-4 text-sm">Manual</td>
                    <td class="py-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Completed</span></td>
                `;
                tbody.insertBefore(newRow, tbody.firstChild);
                
                // Remove last row to keep table size consistent
                if (tbody.children.length > 4) {
                    tbody.removeChild(tbody.lastChild);
                }
            }, 3000);
        });
        
        // Schedule modal controls
        document.getElementById('add-schedule-btn').addEventListener('click', function() {
            document.getElementById('schedule-modal').classList.remove('hidden');
        });
        
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('schedule-modal').classList.add('hidden');
        });
        
        document.getElementById('cancel-schedule').addEventListener('click', function() {
            document.getElementById('schedule-modal').classList.add('hidden');
        });
        
        // Day selection buttons
        document.querySelectorAll('.day-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.classList.toggle('bg-primary');
                this.classList.toggle('text-white');
                this.classList.toggle('border-primary');
            });
        });
        
        // Schedule form submission
        document.getElementById('schedule-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('schedule-name').value;
            const time = document.getElementById('schedule-time').value;
            const amount = document.getElementById('schedule-amount').value;
            
            // Get selected days
            const selectedDays = [];
            document.querySelectorAll('.day-btn.bg-primary').forEach(btn => {
                selectedDays.push(btn.dataset.day);
            });
            
            // Format days for display
            let daysText = 'Daily';
            if (selectedDays.length < 7) {
                daysText = selectedDays.map(day => day.charAt(0).toUpperCase() + day.slice(1)).join(', ');
            }
            
            // Format time for display
            const timeFormatted = moment(time, 'HH:mm').format('h:mm A');
            
            // Add new schedule to the list
            const scheduleList = document.getElementById('schedule-list');
            const newSchedule = document.createElement('div');
            newSchedule.classList.add('p-3', 'border', 'border-gray-200', 'rounded-md', 'schedule-item');
            newSchedule.innerHTML = `
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="bg-primary text-white p-2 rounded-md mr-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4 class="font-medium">${name}</h4>
                            <p class="text-sm text-gray-500">${daysText} at ${timeFormatted} - ${amount} kg</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label class="inline-flex items-center cursor-pointer mr-3">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                        <button class="text-gray-400 hover:text-gray-600 delete-btn">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            `;
            
            scheduleList.insertBefore(newSchedule, scheduleList.firstChild);
            
            // Close modal and reset form
            document.getElementById('schedule-modal').classList.add('hidden');
            document.getElementById('schedule-form').reset();
            document.querySelectorAll('.day-btn').forEach(btn => {
                btn.classList.remove('bg-primary', 'text-white', 'border-primary');
            });
        });
        
        // Delete schedule buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-btn')) {
                const scheduleItem = e.target.closest('.schedule-item');
                scheduleItem.remove();
            }
        });
        
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('fixed');
            sidebar.classList.toggle('inset-0');
            sidebar.classList.toggle('z-50');
            sidebar.classList.toggle('md:block');
        });

        // Feeding History Chart
        var feedingHistoryOptions = {
            series: [{
                name: 'Feed Amount (kg)',
                type: 'column',
                data: [0.8, 1.5, 1.2, 2.3, 1.8, 2.0, 2.5]
            }, {
                name: 'Average',
                type: 'line',
                data: [1.7, 1.7, 1.7, 1.7, 1.7, 1.7, 1.7]
            }],
            chart: {
                height: 300,
                type: 'line',
                toolbar: {
                    show: false
                }
            },
            stroke: {
                width: [0, 3],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    borderRadius: 5,
                    columnWidth: '60%',
                }
            },
            colors: ['#4f46e5', '#f59e0b'],
            dataLabels: {
                enabled: false
            },
            labels: ['Mar 1', 'Mar 2', 'Mar 3', 'Mar 4', 'Mar 5', 'Mar 6', 'Mar 7'],
            xaxis: {
                type: 'category'
            },
            yaxis: [{
                title: {
                    text: 'Feed Amount (kg)',
                },
            }],
            legend: {
                position: 'top'
            }
        };

        var feedingHistoryChart = new ApexCharts(document.querySelector("#feedingHistoryChart"), feedingHistoryOptions);
        feedingHistoryChart.render();

        // Feed Distribution Chart
        var feedDistributionOptions = {
            series: [45, 25, 20, 10],
            chart: {
                type: 'donut',
                height: 300
            },
            labels: ['Standard Feed', 'Premium Mix', 'Growth Formula', 'Maintenance Formula'],
            colors: ['#4f46e5', '#10b981', '#f59e0b', '#3b82f6'],
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '55%'
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val + "%"
                }
            }
        };

        var feedDistributionChart = new ApexCharts(document.querySelector("#feedDistributionChart"), feedDistributionOptions);
        feedDistributionChart.render();

        // Daily Pattern Chart
        var dailyPatternOptions = {
            series: [{
                name: 'Feed Amount (kg)',
                data: [0.8, 0.0, 0.0, 0.0, 0.0, 0.5, 0.0, 0.0, 0.0, 0.0, 0.0, 1.0]
            }],
            chart: {
                height: 300,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            colors: ['#4f46e5'],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '40%',
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['8 AM', '10 AM', '12 PM', '2 PM', '4 PM', '6 PM', '8 PM', '10 PM', '12 AM', '2 AM', '4 AM', '6 AM'],
                labels: {
                    rotate: -45,
                    rotateAlways: true
                }
            },
            yaxis: {
                title: {
                    text: 'Feed Amount (kg)'
                }
            }
        };

        var dailyPatternChart = new ApexCharts(document.querySelector("#dailyPatternChart"), dailyPatternOptions);
        dailyPatternChart.render();

        // Update charts when period changes
        document.getElementById('history-period').addEventListener('change', function() {
            const period = parseInt(this.value);
            let newData, newLabels;
            
            if (period === 7) {
                newData = [0.8, 1.5, 1.2, 2.3, 1.8, 2.0, 2.5];
                newLabels = ['Mar 1', 'Mar 2', 'Mar 3', 'Mar 4', 'Mar 5', 'Mar 6', 'Mar 7'];
            } else if (period === 14) {
                newData = [1.0, 1.2, 0.8, 1.5, 1.2, 2.3, 1.8, 2.0, 2.5, 1.9, 2.1, 1.7, 1.5, 2.2];
                newLabels = ['Feb 22', 'Feb 23', 'Feb 24', 'Feb 25', 'Feb 26', 'Feb 27', 'Feb 28', 'Mar 1', 'Mar 2', 'Mar 3', 'Mar 4', 'Mar 5', 'Mar 6', 'Mar 7'];
            } else {
                newData = [1.0, 1.2, 0.8, 1.5, 1.2, 2.3, 1.8, 2.0, 2.5, 1.9, 2.1, 1.7, 1.5, 2.2, 1.8, 1.9, 2.0, 1.7, 1.6, 1.8, 2.1, 2.3, 1.9, 1.7, 1.5, 1.8, 2.0, 2.2, 1.9, 2.5];
                newLabels = Array.from({length: 30}, (_, i) => `Feb ${i + 7}`).map((date, i) => {
                    const d = new Date(2025, 1, 7 + i);
                    return `${d.toLocaleString('default', { month: 'short' })} ${d.getDate()}`;
                });
            }
            
            feedingHistoryChart.updateOptions({
                series: [{
                    name: 'Feed Amount (kg)',
                    type: 'column',
                    data: newData
                }, {
                    name: 'Average',
                    type: 'line',
                    data: Array(newData.length).fill(newData.reduce((a, b) => a + b, 0) / newData.length).map(val => val.toFixed(1))
                }],
                labels: newLabels
            });
        });
    </script>
</body>
</html>