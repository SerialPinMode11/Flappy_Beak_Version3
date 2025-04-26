@extends('layouts.hardware')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">Feeding Analytics</h1>
        
        <!-- Date Range Selector -->
        <div class="mt-4 bg-white rounded-lg shadow p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="date_range" class="block text-sm font-medium text-gray-700">Date Range</label>
                    <select id="date_range" name="date_range" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="7">Last 7 Days</option>
                        <option value="30" selected>Last 30 Days</option>
                        <option value="90">Last 90 Days</option>
                        <option value="365">Last Year</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                <div>
                    <label for="animal_group" class="block text-sm font-medium text-gray-700">Duck Category</label>
                    <select id="animal_group" name="animal_group" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="">All Ducks</option>
                        <option value="adult">Adult Pekin Duck (Cage A-G)</option>
                        <option value="duckling">Pekin Duckling (Cage H-M)</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Update Analytics
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Summary Cards -->
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Card 1 -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-md p-3">
                            <i class="fas fa-chart-line text-primary h-6 w-6"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Feed Used
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">
                                        2,450 kg
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="#" class="font-medium text-primary hover:text-secondary">
                            View all<span class="sr-only"> stats</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-md p-3">
                            <i class="fas fa-clock text-primary h-6 w-6"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Avg. Daily Consumption
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">
                                        81.7 kg
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="#" class="font-medium text-primary hover:text-secondary">
                            View details<span class="sr-only"> stats</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-md p-3">
                            <i class="fas fa-peso-sign text-primary h-6 w-6"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Feed Cost
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">
                                        ₱3,245.00
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="#" class="font-medium text-primary hover:text-secondary">
                            View breakdown<span class="sr-only"> stats</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-md p-3">
                            <i class="fas fa-check-circle text-primary h-6 w-6"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Feeding Compliance
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">
                                        94.2%
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="#" class="font-medium text-primary hover:text-secondary">
                            View schedule<span class="sr-only"> stats</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts -->
        <div class="mt-6 grid grid-cols-1 gap-5 lg:grid-cols-2">
            <!-- Chart 1: Daily Feed Consumption -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Daily Feed Consumption</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div id="dailyConsumptionChart" style="height: 300px;"></div>
                </div>
            </div>
            
            <!-- Chart 2: Feed Type Distribution -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Feed Type Distribution</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div id="feedTypeChart" style="height: 300px;"></div>
                </div>
            </div>
            
            <!-- Chart 3: Feed Cost Trends -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Feed Cost Trends</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div id="feedCostChart" style="height: 300px;"></div>
                </div>
            </div>
            
            <!-- Chart 4: Feeding Schedule Compliance -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Feeding Schedule Compliance</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div id="complianceChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        
        <!-- Download Reports -->
        <div class="mt-6 bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Download Reports
                </h3>
                <div class="mt-2 max-w-xl text-sm text-gray-500">
                    <p>
                        Export feeding analytics data for your records or further analysis.
                    </p>
                </div>
                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <a href="#" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary w-full">
                            PDF Report
                        </a>
                    </div>
                    <div>
                        <a href="#" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary w-full">
                            Excel Export
                        </a>
                    </div>
                    <div>
                        <a href="#" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary w-full">
                            CSV Export
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Daily Feed Consumption Chart
    var dailyConsumptionOptions = {
        series: [{
            name: 'Feed Amount (kg)',
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94, 86, 115, 106, 95, 88, 90, 110, 102, 95, 97, 92, 100, 94, 98, 92, 87, 99, 93, 85, 88, 95]
        }],
        chart: {
            type: 'area',
            height: 300,
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        colors: ['#4f46e5'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.3,
                stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: Array.from({length: 30}, (_, i) => {
                const d = new Date();
                d.setDate(d.getDate() - 29 + i);
                return d.toLocaleDateString('en-US', {month: 'short', day: 'numeric'});
            }),
            labels: {
                rotate: -45,
                rotateAlways: false
            }
        },
        yaxis: {
            title: {
                text: 'Feed Amount (kg)'
            }
        },
        markers: {
            size: 4
        }
    };

    var dailyConsumptionChart = new ApexCharts(document.querySelector("#dailyConsumptionChart"), dailyConsumptionOptions);
    dailyConsumptionChart.render();

    // Feed Type Distribution Chart
    var feedTypeOptions = {
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

    var feedTypeChart = new ApexCharts(document.querySelector("#feedTypeChart"), feedTypeOptions);
    feedTypeChart.render();

    // Feed Cost Trends Chart
    var feedCostOptions = {
        series: [{
            name: 'Feed Cost (₱)',
            data: [2100, 2350, 2500, 2800, 3100, 3245]
        }],
        chart: {
            height: 300,
            type: 'line',
            toolbar: {
                show: false
            }
        },
        colors: ['#4f46e5'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight',
            width: 3
        },
        grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'],
                opacity: 0.5
            },
        },
        xaxis: {
            categories: ['Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'],
        },
        yaxis: {
            title: {
                text: 'Cost (₱)'
            }
        },
        markers: {
            size: 5
        }
    };

    var feedCostChart = new ApexCharts(document.querySelector("#feedCostChart"), feedCostOptions);
    feedCostChart.render();

    // Compliance Chart
    var complianceOptions = {
        series: [{
            name: 'Compliance Rate',
            data: [92, 93, 95, 91, 96, 94, 98]
        }],
        chart: {
            height: 300,
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                columnWidth: '50%',
            }
        },
        colors: ['#4f46e5'],
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            labels: {
                rotate: -45,
                rotateAlways: false
            }
        },
        yaxis: {
            title: {
                text: 'Compliance Rate (%)'
            },
            min: 80,
            max: 100
        }
    };

    var complianceChart = new ApexCharts(document.querySelector("#complianceChart"), complianceOptions);
    complianceChart.render();

    // Update charts when date range changes
    document.getElementById('date_range').addEventListener('change', function() {
        // In a real application, this would fetch new data from the server
        // For this example, we'll just simulate a data update
        
        const range = parseInt(this.value);
        
        // Update daily consumption chart with new date range
        const newDates = Array.from({length: range}, (_, i) => {
            const d = new Date();
            d.setDate(d.getDate() - (range - 1) + i);
            return d.toLocaleDateString('en-US', {month: 'short', day: 'numeric'});
        });
        
        // Generate random data for the new range
        const newData = Array.from({length: range}, () => Math.floor(Math.random() * 40) + 80);
        
        dailyConsumptionChart.updateOptions({
            xaxis: {
                categories: newDates
            },
            series: [{
                name: 'Feed Amount (kg)',
                data: newData
            }]
        });
    });
</script>
@endsection