@extends('layouts.hardware')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Feed Inventory</h1>
            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Add New Feed
            </button>
        </div>
        
        <!-- Inventory Summary Cards -->
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Card 1 -->
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
                                        12,450 kg
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
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
                                        3 items
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-md p-3">
                            <i class="fas fa-peso-sign h-6 w-6 text-primary"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Monthly Feed Cost
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">
                                        ₱4,320.75
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Inventory Table -->
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
                        <input type="text" name="search" id="search" class="focus:ring-primary focus:border-primary block w-full pr-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search inventory...">
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
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Feed Name</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Quantity</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Unit</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Location</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Expiry Date</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Grass Hay</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Hay</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">2,450</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">kg</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Barn B</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">In Stock</span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">2023-11-10</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="#" class="text-primary hover:text-secondary">Edit</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Corn Silage</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Silage</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">5,500</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">kg</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Silo 2</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">In Stock</span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">2023-10-30</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="#" class="text-primary hover:text-secondary">Edit</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Crushed Grain Waste (Ipa)</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Grain</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">850</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">kg</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Storage Room B</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">Low Stock</span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">2023-09-15</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="#" class="text-primary hover:text-secondary">Edit</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Protein Supplement</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Supplement</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">300</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">kg</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Storage Room A</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">Low Stock</span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">2023-11-20</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="#" class="text-primary hover:text-secondary">Edit</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Mineral Mix</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Supplement</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">150</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">kg</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Storage Room A</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">Low Stock</span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">2023-12-05</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="#" class="text-primary hover:text-secondary">Edit</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Feed Usage Trends -->
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
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
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