@extends('layouts.hardware')

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header with Add Button --}}
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Feed Inventory</h1>
                <button onclick="openAddModal()" type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <i class="fas fa-plus mr-2"></i>Add New Feed
                </button>
            </div>

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Inventory Summary Cards --}}
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                {{-- Card 1 --}}
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-md p-3">
                                <i class="fas fa-box h-6 w-6 text-primary"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Feed in Stock
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            {{ number_format($totalStock, 0) }} kg
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                <i class="fas fa-exclamation-triangle h-6 w-6 text-yellow-600"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Low Stock Items
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            {{ $lowStockCount }} items
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Inventory Table --}}
            <div class="mt-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h2 class="text-xl font-semibold text-gray-900">Current Inventory</h2>
                        <p class="mt-2 text-sm text-gray-700">
                            A list of all feed items currently in stock including their quantity, location, and status.
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <div class="relative rounded-md shadow-sm">
                            <input type="text" name="search" id="search"
                                class="focus:ring-primary focus:border-primary block w-full pr-10 sm:text-sm border-gray-300 rounded-md"
                                placeholder="Search inventory...">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-search h-5 w-5 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                Feed Name</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Quantity
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Unit</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Location
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Expiry
                                                Date</th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @forelse($feeds as $feed)
                                            <tr>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ $feed->feed_name }}</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $feed->type }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ number_format($feed->quantity, 0) }}</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $feed->unit }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ $feed->location ?? 'N/A' }}</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    @if($feed->status == 'In Stock')
                                                        <span
                                                            class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">{{ $feed->status }}</span>
                                                    @elseif($feed->status == 'Low Stock')
                                                        <span
                                                            class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">{{ $feed->status }}</span>
                                                    @else
                                                        <span
                                                            class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">{{ $feed->status }}</span>
                                                    @endif
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ $feed->expiry_date ? $feed->expiry_date->format('Y-m-d') : 'N/A' }}</td>
                                                <td
                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 space-x-2">
                                                    <button
                                                        onclick="openEditModal({{ $feed->id }}, '{{ $feed->feed_name }}', '{{ $feed->type }}', {{ $feed->quantity }}, '{{ $feed->unit }}', '{{ $feed->location }}', '{{ $feed->expiry_date }}', {{ $feed->cost_per_unit ?? 0 }}, '{{ $feed->notes }}')"
                                                        class="text-primary hover:text-secondary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    @if($feed->quantity == 0)
                                                        <form action="{{ route('inventory.destroy', $feed->id) }}" method="POST"
                                                            class="inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this feed item?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                                    No feed items found. Click "Add New Feed" to get started.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Feed Usage Trends --}}
            <div class="mt-8 bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Feed Usage Trends
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Monthly consumption of different feed types.
                    </p>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div id="feedUsageChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Feed Modal --}}
    <div id="addFeedModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Add New Feed</h3>
                <button type="button" onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Feed Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="feed_name" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Type <span
                                class="text-red-500">*</span></label>
                        <select name="type" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="">Select Type</option>
                            <option value="Hay">Hay</option>
                            <option value="Silage">Silage</option>
                            <option value="Grain">Grain</option>
                            <option value="Supplement">Supplement</option>
                            <option value="Pellets">Pellets</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Quantity <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="quantity" step="0.01" min="0" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Unit <span
                                class="text-red-500">*</span></label>
                        <select name="unit" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="kg">kg</option>
                            <option value="lbs">lbs</option>
                            <option value="bags">bags</option>
                            <option value="tons">tons</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Location</label>
                        <input type="text" name="location"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Expiry Date</label>
                        <input type="date" name="expiry_date"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Cost per Unit (₱)</label>
                        <input type="number" name="cost_per_unit" step="0.01" min="0"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                        <textarea name="notes" rows="3"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary resize-none"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeAddModal()"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-secondary text-white font-semibold rounded">
                        <i class="fas fa-save mr-2"></i>Add Feed
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Feed Modal --}}
    <div id="editFeedModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Edit Feed</h3>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="editFeedForm" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Feed Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="edit_feed_name" name="feed_name" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Type <span
                                class="text-red-500">*</span></label>
                        <select id="edit_type" name="type" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="">Select Type</option>
                            <option value="Hay">Hay</option>
                            <option value="Silage">Silage</option>
                            <option value="Grain">Grain</option>
                            <option value="Supplement">Supplement</option>
                            <option value="Pellets">Pellets</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Quantity <span
                                class="text-red-500">*</span></label>
                        <input type="number" id="edit_quantity" name="quantity" step="0.01" min="0" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Unit <span
                                class="text-red-500">*</span></label>
                        <select id="edit_unit" name="unit" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="kg">kg</option>
                            <option value="lbs">lbs</option>
                            <option value="bags">bags</option>
                            <option value="tons">tons</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Location</label>
                        <input type="text" id="edit_location" name="location"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Expiry Date</label>
                        <input type="date" id="edit_expiry_date" name="expiry_date"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Cost per Unit (₱)</label>
                        <input type="number" id="edit_cost_per_unit" name="cost_per_unit" step="0.01" min="0"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                        <textarea id="edit_notes" name="notes" rows="3"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary resize-none"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-secondary text-white font-semibold rounded">
                        <i class="fas fa-save mr-2"></i>Update Feed
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Add Modal Functions
        function openAddModal() {
            document.getElementById('addFeedModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addFeedModal').classList.add('hidden');
            document.querySelector('#addFeedModal form').reset();
        }

        // Edit Modal Functions
        function openEditModal(id, name, type, quantity, unit, location, expiryDate, cost, notes) {
            const modal = document.getElementById('editFeedModal');
            const form = document.getElementById('editFeedForm');

            // Set form action
            form.action = `/inventory/${id}`;

            // Populate form fields
            document.getElementById('edit_feed_name').value = name;
            document.getElementById('edit_type').value = type;
            document.getElementById('edit_quantity').value = quantity;
            document.getElementById('edit_unit').value = unit;
            document.getElementById('edit_location').value = location || '';
            document.getElementById('edit_expiry_date').value = expiryDate || '';
            document.getElementById('edit_cost_per_unit').value = cost || '';
            document.getElementById('edit_notes').value = notes || '';

            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editFeedModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.addEventListener('DOMContentLoaded', function () {
            const addModal = document.getElementById('addFeedModal');
            const editModal = document.getElementById('editFeedModal');

            if (addModal) {
                addModal.addEventListener('click', function (e) {
                    if (e.target === this) closeAddModal();
                });
            }

            if (editModal) {
                editModal.addEventListener('click', function (e) {
                    if (e.target === this) closeEditModal();
                });
            }

            // Close with Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeAddModal();
                    closeEditModal();
                }
            });
        });

        // Feed Usage Trends Chart
        var feedUsageOptions = {
            series: [{
                name: 'Standard Feed',
                data: [44, 55, 41, 67, 22, 43]
            }, {
                name: 'Premium Mix',
                data: [13, 23, 20, 8, 13, 27]
            }, {
                name: 'Growth Formula',
                data: [11, 17, 15, 15, 21, 14]
            }, {
                name: 'Maintenance Formula',
                data: [21, 7, 25, 13, 22, 8]
            }],
            chart: {
                type: 'bar',
                height: 300,
                stacked: true,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    borderRadius: 5,
                    columnWidth: '55%',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'],
            },
            yaxis: {
                title: {
                    text: 'Feed Amount (kg)'
                }
            },
            fill: {
                opacity: 1
            },
            colors: ['#4f46e5', '#10b981', '#f59e0b', '#3b82f6'],
            legend: {
                position: 'top'
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " kg"
                    }
                }
            }
        };

        var feedUsageChart = new ApexCharts(document.querySelector("#feedUsageChart"), feedUsageOptions);
        feedUsageChart.render();
    </script>
@endsection