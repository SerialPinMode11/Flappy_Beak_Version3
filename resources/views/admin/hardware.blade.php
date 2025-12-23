<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feeding Control System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#4f46e5', // indigo-600
                            light: '#c7d2fe',   // indigo-200
                        },
                        sidebar: '#1f2937', // gray-800
                        success: '#10b981',
                        danger: '#ef4444',
                        warning: '#f59e0b',
                    }
                }
            }
        }
    </script>
    <style>
        /* CSS-Only Sidebar Toggle */
        #menu-toggle {
            display: none;
        }

        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0);
            }
        }

        #menu-toggle:checked~.sidebar-container .sidebar {
            transform: translateX(0);
        }

        .sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.6);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        #menu-toggle:checked~.sidebar-overlay {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        @media (max-width: 767px) {
            body:has(#menu-toggle:checked) {
                overflow: hidden;
            }
        }

        /* Pure CSS Toggle Switch */
        .toggle-label {
            width: 44px;
            height: 24px;
            background-color: #e5e7eb;
        }

        .toggle-checkbox {
            width: 20px;
            height: 20px;
            top: 2px;
            left: 2px;
            transition: transform 0.2s ease-in-out;
        }

        .toggle-checkbox:checked {
            transform: translateX(20px);
        }

        .toggle-checkbox:checked+.toggle-label {
            background-color: #4f46e5;
        }

        .schedule-item:hover .delete-btn {
            display: flex;
        }

        .delete-btn {
            display: none;
        }
    </style>
</head>

<body class="bg-slate-50">

    <input type="checkbox" id="menu-toggle" class="hidden">

    <!-- FIX: Hamburger Menu Button is now outside the main content flow -->
    <label for="menu-toggle" class="fixed top-4 left-4 z-50 md:hidden bg-white p-2 rounded-md shadow-lg cursor-pointer"
        aria-label="Open Menu">
        <i class="fas fa-bars text-xl text-gray-600 w-6 h-6"></i>
    </label>

    <!-- Sidebar & Overlay -->
    <div class="sidebar-container fixed inset-y-0 left-0 z-40">
        <aside class="sidebar bg-sidebar text-gray-300 w-64 h-full flex flex-col">
            <div class="p-4">
                <h1 class="text-xl font-bold text-primary-light">Feeding Dashboard</h1>
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <!-- ROUTES RESTORED HERE -->
                <a href="#" class="flex items-center px-4 py-2.5 rounded-lg bg-primary text-white font-semibold">
                    <i class="fas fa-sliders-h w-6 text-center mr-3"></i><span>Feeding Schedule</span>
                </a>
                <a href="{{route('admin.dashboard')}}"
                    class="flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-chart-pie w-6 text-center mr-3"></i><span>Dashboard</span>
                </a>
                <a href="{{route('admin.hardwareHistory')}}"
                    class="flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-history w-6 text-center mr-3"></i><span>Feeding History</span>
                </a>
                <a href="{{route('admin.hardwareAnalytics')}}"
                    class="flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-chart-line w-6 text-center mr-3"></i><span>Analytics</span>
                </a>
                <a href="{{route('admin.hardwareSetting')}}"
                    class="flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-cog w-6 text-center mr-3"></i><span>Settings</span>
                </a>
                <a href="{{route('admin.hardwareInventory')}}"
                    class="flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-boxes w-6 text-center mr-3"></i><span>Feed Inventory</span>
                </a>
            </nav>
        </aside>
    </div>
    <label for="menu-toggle" class="sidebar-overlay fixed inset-0 z-30 md:hidden"></label>

    <!-- Main Content Wrapper -->
    <div class="md:ml-64 flex flex-col min-h-screen">
        <!-- Header -->
        <header class="bg-white sticky top-0 z-20 border-b">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- FIX: Header content now has its own container for alignment -->
                    <div class="flex-1 flex items-center">
                        <!-- On mobile, this empty div pushes the title to the center. On desktop, it has no width. -->
                        <div class="w-10 md:w-0"></div>
                        <h2
                            class="text-lg sm:text-xl font-bold text-gray-800 text-center md:text-left flex-1 md:flex-none">
                            Flappy-Beak System Administrator</h2>
                    </div>
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="relative hidden sm:block">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" placeholder="Search..."
                                class="w-full sm:w-48 lg:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <div class="relative">
                            <button class="p-2 rounded-full text-gray-500 hover:bg-gray-100"
                                aria-label="Notifications"><i class="fas fa-bell text-xl"></i></button>
                            <span class="absolute top-0 right-0 flex h-4 w-4"><span
                                    class="relative inline-flex rounded-full h-4 w-4 bg-primary text-white text-xs items-center justify-center">3</span></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <img src="https://i.pravatar.cc/150?u=jm" alt="User Avatar" class="w-9 h-9 rounded-full">
                            <span class="font-semibold text-gray-700 hidden sm:block">JM Casabar</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6">
            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-5 rounded-xl shadow-sm flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Last Feeding</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="last-feeding-time"></p>
                        <p class="text-xs text-gray-400 mt-1"><i class="far fa-clock"></i> <span
                                id="time-since-last"></span></p>
                    </div>
                    <div class="bg-primary-light text-primary p-2 rounded-lg"><i class="fas fa-utensils"></i></div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Feed Dispensed Today</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">1.3 kg</p>
                        <p class="text-xs text-green-500 font-semibold mt-1"><i class="fas fa-arrow-up"></i> 15% from
                            yesterday</p>
                    </div>
                    <div class="bg-primary-light text-primary p-2 rounded-lg"><i class="fas fa-box"></i></div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm flex justify-between items-start">
                    {{-- Please Change This --}}
                    <div> 
                        <p class="text-sm font-medium text-gray-500">Feed Inventory</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">78%</p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-primary h-2 rounded-full" style="width: 78%"></div>
                        </div>
                    </div>
                    <div class="bg-primary-light text-primary p-2 rounded-lg"><i class="fas fa-warehouse"></i></div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Next Scheduled</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="next-feeding-time"></p>
                        <p class="text-xs text-gray-400 mt-1"><i class="far fa-hourglass-half"></i> <span
                                id="time-until-next"></span></p>
                    </div>
                    <div class="bg-primary-light text-primary p-2 rounded-lg"><i class="far fa-calendar-check"></i>
                    </div>
                </div>
            </div>

            <!-- Manual Feeding -->
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Manual Feeding Control</h3>
                <div class="flex flex-col sm:flex-row items-end gap-4">
                    <div class="w-full sm:w-auto"><label for="feed-amount"
                            class="block text-sm font-medium text-gray-700 mb-1">Amount (kg)</label>
                        <div class="flex items-center"><button id="decrease-amount"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold p-2.5 rounded-l-lg"><i
                                    class="fas fa-minus"></i></button><input type="number" id="feed-amount"
                                class="w-20 text-center py-2 border-t border-b border-gray-300" value="0.5"
                                step="0.1"><button id="increase-amount"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold p-2.5 rounded-r-lg"><i
                                    class="fas fa-plus"></i></button></div>
                    </div>
                    <div class="w-full sm:w-auto flex-grow"><label for="feed-type"
                            class="text-sm font-medium text-gray-700 mb-1">Feed Type</label><select id="feed-type"
                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="Standard Feed">Standard Feed</option>
                            <option value="Premium Mix">Premium Mix</option>
                        </select></div>





                    <div class="w-full sm:w-auto"><button id="feed-now-btn"
                            class="w-full bg-primary hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md flex items-center justify-center"><i
                                class="fas fa-utensils mr-2"></i>Feed Now</button></div>

                    <!-- Success message -->
                    <div id="feed-success"
                        class="hidden mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">Feeding recorded successfully!</span>
                    </div>



                </div>
                <div class="mt-4 p-3 bg-slate-50 rounded-md" id="manual-feed-status">
                    <div class="flex items-center"><i class="fas fa-info-circle text-primary mr-2"></i>
                        <p class="text-gray-700 text-sm">Ready to dispense feed.</p>
                    </div>
                </div>
            </div>

            <!-- Scheduled Feeding & History -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Scheduled Feeding</h3><button
                            id="add-schedule-btn"
                            class="bg-primary hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm"><i
                                class="fas fa-plus mr-1"></i> Add Schedule</button>
                    </div>
                    <ul id="schedule-list" class="space-y-2">
                        <li class="flex justify-between items-center py-3 border-b schedule-item">
                            <div>
                                <h4 class="font-medium">Morning Feed</h4>
                                <p class="text-sm text-gray-500">Daily at 8:00 AM - 0.8 kg</p>
                            </div>
                            <div class="flex items-center">
                                <div class="relative mr-2"><input type="checkbox" id="toggle1"
                                        class="toggle-checkbox absolute rounded-full bg-white shadow-sm appearance-none cursor-pointer"
                                        checked /><label for="toggle1"
                                        class="toggle-label block overflow-hidden rounded-full cursor-pointer"></label>
                                </div><button class="text-gray-400 hover:text-danger delete-btn"><i
                                        class="fas fa-trash-alt"></i></button>
                            </div>
                        </li>
                        <li class="flex justify-between items-center py-3 border-b schedule-item">
                            <div>
                                <h4 class="font-medium">Afternoon Feed</h4>
                                <p class="text-sm text-gray-500">Daily at 1:00 PM - 0.5 kg</p>
                            </div>
                            <div class="flex items-center">
                                <div class="relative mr-2"><input type="checkbox" id="toggle2"
                                        class="toggle-checkbox absolute rounded-full bg-white shadow-sm appearance-none cursor-pointer"
                                        checked /><label for="toggle2"
                                        class="toggle-label block overflow-hidden rounded-full cursor-pointer"></label>
                                </div><button class="text-gray-400 hover:text-danger delete-btn"><i
                                        class="fas fa-trash-alt"></i></button>
                            </div>
                        </li>
                        <li class="flex justify-between items-center py-3 schedule-item">
                            <div>
                                <h4 class="font-medium">Evening Feed</h4>
                                <p class="text-sm text-gray-500">Daily at 6:00 PM - 1.0 kg</p>
                            </div>
                            <div class="flex items-center">
                                <div class="relative mr-2"><input type="checkbox" id="toggle3"
                                        class="toggle-checkbox absolute rounded-full bg-white shadow-sm appearance-none cursor-pointer" /><label
                                        for="toggle3"
                                        class="toggle-label block overflow-hidden rounded-full cursor-pointer"></label>
                                </div><button class="text-gray-400 hover:text-danger delete-btn"><i
                                        class="fas fa-trash-alt"></i></button>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Feeding History</h3><select id="history-period"
                            class="border border-gray-300 rounded-md py-1 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="7">Last 7 Days</option>
                            <option value="14">Last 14 Days</option>
                            <option value="30">Last 30 Days</option>
                        </select>
                    </div>
                    <div id="feedingHistoryChart" style="height: 300px;"></div>
                </div>
            </div>

            <!-- Feed Distribution & Daily Pattern -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="text-lg font-semibold mb-6 text-gray-800">Feed Type Distribution</h3>
                    <div id="feedDistributionChart" style="height: 300px;"></div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="text-lg font-semibold mb-6 text-gray-800">Daily Feeding Pattern</h3>
                    <div id="dailyPatternChart" style="height: 300px;"></div>
                </div>
            </div>


        </main>
    </div>

    <!-- Add Schedule Modal -->
    <div id="schedule-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Add Feeding Schedule</h3><button id="close-modal"
                    class="text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></button>
            </div>
            <form id="schedule-form">
                <div class="mb-4"><label for="schedule-name"
                        class="block text-sm font-medium text-gray-700 mb-1">Schedule Name</label><input type="text"
                        id="schedule-name"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary"
                        placeholder="e.g. Morning Feed" required></div>
                <div class="mb-4"><label for="schedule-time"
                        class="block text-sm font-medium text-gray-700 mb-1">Time</label><input type="time"
                        id="schedule-time"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary"
                        required></div>
                <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Days</label>
                    <div class="flex flex-wrap gap-2"><button type="button"
                            class="day-btn px-3 py-1 border rounded-md text-sm" data-day="Mon">Mon</button><button
                            type="button" class="day-btn px-3 py-1 border rounded-md text-sm"
                            data-day="Tue">Tue</button><button type="button"
                            class="day-btn px-3 py-1 border rounded-md text-sm" data-day="Wed">Wed</button><button
                            type="button" class="day-btn px-3 py-1 border rounded-md text-sm"
                            data-day="Thu">Thu</button><button type="button"
                            class="day-btn px-3 py-1 border rounded-md text-sm" data-day="Fri">Fri</button><button
                            type="button" class="day-btn px-3 py-1 border rounded-md text-sm"
                            data-day="Sat">Sat</button><button type="button"
                            class="day-btn px-3 py-1 border rounded-md text-sm" data-day="Sun">Sun</button></div>
                </div>
                <div class="mb-4"><label for="schedule-amount"
                        class="block text-sm font-medium text-gray-700 mb-1">Amount (kg)</label><input type="number"
                        id="schedule-amount"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary"
                        value="0.5" step="0.1" min="0.1" required></div>
                <div class="flex justify-end space-x-3"><button type="button" id="cancel-schedule"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</button><button
                        type="submit"
                        class="px-4 py-2 bg-primary hover:bg-indigo-700 text-white rounded-md text-sm font-medium">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            function updateTimeDisplays() {
                const now = moment();
                const lastFeeding = moment().subtract(5, 'hours').subtract(30, 'minutes');
                document.getElementById('last-feeding-time').textContent = lastFeeding.format('ddd, h:mm A');
                document.getElementById('time-since-last').textContent = lastFeeding.fromNow();

                const nextFeeding = moment().add(3, 'hours').add(30, 'minutes');
                document.getElementById('next-feeding-time').textContent = nextFeeding.format('ddd, h:mm A');
                document.getElementById('time-until-next').textContent = "in " + moment.duration(nextFeeding.diff(now)).humanize();
            }
            updateTimeDisplays();
            setInterval(updateTimeDisplays, 60000);

            document.getElementById('decrease-amount').addEventListener('click', () => {
                const input = document.getElementById('feed-amount');
                let value = parseFloat(input.value);
                if (value > 0.1) input.value = (value - 0.1).toFixed(1);
            });
            document.getElementById('increase-amount').addEventListener('click', () => {
                const input = document.getElementById('feed-amount');
                let value = parseFloat(input.value);
                input.value = (value + 0.1).toFixed(1);
            });
            document.getElementById('feed-now-btn').addEventListener('click', () => {
                const amount = document.getElementById('feed-amount').value;
                const feedType = document.getElementById('feed-type').value;
                const statusDiv = document.getElementById('manual-feed-status');
                const btn = this; // Now 'this' correctly refers to the button

                // Disable button and show loading state
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Recording...';

                // Show dispensing status
                statusDiv.innerHTML = `<div class="flex items-center"><i class="fas fa-spinner fa-spin text-primary mr-2"></i><p class="text-gray-700 text-sm">Dispensing ${amount} kg of ${feedType}...</p></div>`;

                // Send to database
                fetch('{{ route("feed.now") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: amount,
                        feed_type: feedType
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success status
                            statusDiv.innerHTML = `<div class="flex items-center"><i class="fas fa-check-circle text-success mr-2"></i><p class="text-gray-700 text-sm">Successfully dispensed ${amount} kg.</p></div>`;

                            // Update last feeding time
                            const now = moment();
                            document.getElementById('last-feeding-time').textContent = now.format('ddd, h:mm A');
                            document.getElementById('time-since-last').textContent = 'just now';

                            // Show success message
                            const successDiv = document.getElementById('feed-success');
                            if (successDiv) {
                                successDiv.classList.remove('hidden');
                                setTimeout(() => {
                                    successDiv.classList.add('hidden');
                                }, 3000);
                            }
                        }

                        // Re-enable button
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-utensils mr-2"></i>Feed Now';
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // Show error status
                        statusDiv.innerHTML = `<div class="flex items-center"><i class="fas fa-exclamation-circle text-red-500 mr-2"></i><p class="text-gray-700 text-sm">Failed to record feeding. Please try again.</p></div>`;

                        // Re-enable button
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-utensils mr-2"></i>Feed Now';
                    });
            });

            const modal = document.getElementById('schedule-modal');
            document.getElementById('add-schedule-btn').addEventListener('click', () => modal.classList.remove('hidden'));
            document.getElementById('close-modal').addEventListener('click', () => modal.classList.add('hidden'));
            document.getElementById('cancel-schedule').addEventListener('click', () => modal.classList.add('hidden'));
            document.querySelectorAll('.day-btn').forEach(btn => btn.addEventListener('click', () => { btn.classList.toggle('bg-primary'); btn.classList.toggle('text-white'); }));

            document.getElementById('schedule-form').addEventListener('submit', (e) => {
                e.preventDefault();
                const name = document.getElementById('schedule-name').value;
                const time = moment(document.getElementById('schedule-time').value, 'HH:mm').format('h:mm A');
                const amount = document.getElementById('schedule-amount').value;
                const newScheduleItem = document.createElement('li');
                newScheduleItem.className = 'flex justify-between items-center py-3 border-b schedule-item';
                newScheduleItem.innerHTML = `<div><h4 class="font-medium">${name}</h4><p class="text-sm text-gray-500">Daily at ${time} - ${amount} kg</p></div><div class="flex items-center"><div class="relative mr-2"><input type="checkbox" class="toggle-checkbox absolute rounded-full bg-white shadow-sm appearance-none cursor-pointer" checked/><label class="toggle-label block overflow-hidden rounded-full cursor-pointer"></label></div><button class="text-gray-400 hover:text-danger delete-btn"><i class="fas fa-trash-alt"></i></button></div>`;
                document.getElementById('schedule-list').appendChild(newScheduleItem);
                modal.classList.add('hidden');
                e.target.reset();
                document.querySelectorAll('.day-btn').forEach(btn => btn.classList.remove('bg-primary', 'text-white'));
            });

            document.getElementById('schedule-list').addEventListener('click', (e) => {
                if (e.target.closest('.delete-btn')) e.target.closest('.schedule-item').remove();
            });

            var feedingHistoryOptions = { series: [{ name: 'Feed Amount (kg)', type: 'column', data: [0.8, 1.5, 1.2, 2.3, 1.8, 2.0, 2.5] }, { name: 'Average', type: 'line', data: [1.7, 1.7, 1.7, 1.7, 1.7, 1.7, 1.7] }], chart: { height: 300, type: 'line', toolbar: { show: false } }, stroke: { width: [0, 3], curve: 'smooth' }, plotOptions: { bar: { borderRadius: 5, columnWidth: '60%' } }, colors: ['#4f46e5', '#f59e0b'], dataLabels: { enabled: false }, labels: ['Mar 1', 'Mar 2', 'Mar 3', 'Mar 4', 'Mar 5', 'Mar 6', 'Mar 7'], xaxis: { type: 'category' }, yaxis: [{ title: { text: 'Feed Amount (kg)' } }], legend: { position: 'top' } };
            var feedingHistoryChart = new ApexCharts(document.querySelector("#feedingHistoryChart"), feedingHistoryOptions);
            feedingHistoryChart.render();

            var feedDistributionOptions = { series: [45, 25, 20, 10], chart: { type: 'donut', height: 300 }, labels: ['Standard Feed', 'Premium Mix', 'Growth Formula', 'Maintenance'], colors: ['#4f46e5', '#10b981', '#f59e0b', '#6366f1'], legend: { position: 'bottom' }, plotOptions: { pie: { donut: { size: '55%' } } }, dataLabels: { enabled: true, formatter: val => val.toFixed(1) + "%" } };
            var feedDistributionChart = new ApexCharts(document.querySelector("#feedDistributionChart"), feedDistributionOptions);
            feedDistributionChart.render();

            var dailyPatternOptions = { series: [{ name: 'Feed (kg)', data: [0.8, 0, 0, 0, 0.5, 0, 0, 0, 0, 1.0, 0, 0] }], chart: { height: 300, type: 'bar', toolbar: { show: false } }, colors: ['#4f46e5'], plotOptions: { bar: { borderRadius: 4, columnWidth: '40%' } }, dataLabels: { enabled: false }, xaxis: { categories: ['8 AM', '10 AM', '12 PM', '2 PM', '4 PM', '6 PM', '8 PM', '10 PM', '12 AM', '2 AM', '4 AM', '6 AM'] }, yaxis: { title: { text: 'Feed Amount (kg)' } } };
            var dailyPatternChart = new ApexCharts(document.querySelector("#dailyPatternChart"), dailyPatternOptions);
            dailyPatternChart.render();
        });
    </script>
</body>

</html>