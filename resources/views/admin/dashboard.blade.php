@extends('layouts.static')
@section('title', 'Admin Dashboard')

@push('styles')
<style>
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    .chart-error {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        text-align: center;
        padding: 1rem;
    }
</style>
@endpush

@section('content')
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Dashboard Overview</h1>
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
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-medium">Total Revenue</h3>
                <span class="text-red-500 bg-red-100 p-2 rounded-full"><i class="fas fa-dollar-sign"></i></span>
            </div>
            <p class="text-2xl font-bold text-gray-800">₱{{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-medium">Total Customers</h3>
                <span class="text-blue-500 bg-blue-100 p-2 rounded-full"><i class="fas fa-users"></i></span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $totalCustomers }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-medium">Completed Orders</h3>
                <span class="text-green-500 bg-green-100 p-2 rounded-full"><i class="fas fa-check-circle"></i></span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $completedCustomers }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-medium">Pending Orders</h3>
                <span class="text-yellow-500 bg-yellow-100 p-2 rounded-full"><i class="fas fa-clock"></i></span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $totalCustomers - $completedCustomers }}</p>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Monthly Sales Chart -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold mb-4">Monthly Sales</h3>
            <div id="monthlySalesChart" class="chart-container"></div>
        </div>
        
        <!-- Orders by Status Chart -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold mb-4">Orders by Status</h3>
            <div id="orderStatusChart" class="chart-container"></div>
        </div>
    </div>
    
    <!-- Customer Purchase Charts -->
    <div class="grid grid-cols-1 gap-6 mb-8">
        <!-- Successful Purchases by Customer -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold mb-4">Successful Purchases by Customer</h3>
            <div id="successfulPurchasesChart" class="chart-container"></div>
        </div>
        
        <!-- All Purchases by Customer -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold mb-4">All Customer Purchases</h3>
            <div id="allPurchasesChart" class="chart-container"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded');
        
        // Check if ApexCharts is loaded
        if (typeof ApexCharts === 'undefined') {
            console.error('ApexCharts is not loaded!');
            document.querySelectorAll('.chart-container').forEach(container => {
                container.innerHTML = '<div class="chart-error">ApexCharts library not loaded. Please check your network connection.</div>';
            });
            return;
        }
        
        console.log('ApexCharts is loaded');
        
        // Debug data
        console.log('Monthly Sales Data:', @json($monthlySales));
        console.log('Status Data:', @json($purchasesByStatus));
        console.log('Successful Purchases:', @json($successfulPurchases));
        console.log('All Purchases:', @json($allPurchases));
        console.log('Customer Names:', @json($customerNames));
        
        try {
            // Monthly Sales Chart
            renderMonthlySalesChart();
            
            // Orders by Status Chart
            renderOrderStatusChart();
            
            // Successful Purchases Chart
            renderSuccessfulPurchasesChart();
            
            // All Purchases Chart
            renderAllPurchasesChart();
            
            console.log('All charts initialized successfully!');
        } catch (error) {
            console.error('Error initializing charts:', error);
            document.querySelectorAll('.chart-container').forEach(container => {
                container.innerHTML = `<div class="chart-error">Error: ${error.message}</div>`;
            });
        }
        
        function renderMonthlySalesChart() {
            const monthlySalesData = @json($monthlySales);
            const monthlySalesContainer = document.getElementById('monthlySalesChart');
            
            if (!monthlySalesContainer) {
                console.error('Monthly sales chart container not found');
                return;
            }
            
            if (!monthlySalesData || monthlySalesData.length === 0) {
                monthlySalesContainer.innerHTML = '<div class="chart-error">No monthly sales data available</div>';
                return;
            }
            
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            const monthLabels = monthlySalesData.map(item => monthNames[parseInt(item.month) - 1] || `Month ${item.month}`);
            const salesData = monthlySalesData.map(item => parseFloat(item.total) || 0);
            
            const monthlySalesOptions = {
                series: [{
                    name: 'Monthly Sales',
                    data: salesData
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#4ade80'],
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: '50%',
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: monthLabels
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                }
            };
            
            console.log('Rendering monthly sales chart with data:', salesData);
            const monthlySalesChart = new ApexCharts(monthlySalesContainer, monthlySalesOptions);
            monthlySalesChart.render();
        }
        
        function renderOrderStatusChart() {
            const statusData = @json($purchasesByStatus);
            const orderStatusContainer = document.getElementById('orderStatusChart');
            
            if (!orderStatusContainer) {
                console.error('Order status chart container not found');
                return;
            }
            
            if (!statusData || statusData.length === 0) {
                orderStatusContainer.innerHTML = '<div class="chart-error">No status data available</div>';
                return;
            }
            
            const statusLabels = statusData.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1));
            const statusCounts = statusData.map(item => parseInt(item.count) || 0);
            
            const statusColors = statusData.map(item => {
                switch(item.status) {
                    case 'completed': return '#22c55e'; // green
                    case 'pending': return '#eab308';  // yellow
                    case 'processing': return '#3b82f6'; // blue
                    case 'cancelled': return '#ef4444'; // red
                    default: return '#6b7280'; // gray
                }
            });
            
            const orderStatusOptions = {
                series: statusCounts,
                chart: {
                    type: 'donut',
                    height: 300
                },
                labels: statusLabels,
                colors: statusColors,
                legend: {
                    position: 'right'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
            
            console.log('Rendering order status chart with data:', statusCounts);
            const orderStatusChart = new ApexCharts(orderStatusContainer, orderStatusOptions);
            orderStatusChart.render();
        }
        
        function renderSuccessfulPurchasesChart() {
            const successfulPurchasesData = @json($successfulPurchases);
            const successfulPurchasesContainer = document.getElementById('successfulPurchasesChart');
            
            if (!successfulPurchasesContainer) {
                console.error('Successful purchases chart container not found');
                return;
            }
            
            if (!successfulPurchasesData || successfulPurchasesData.length === 0) {
                successfulPurchasesContainer.innerHTML = '<div class="chart-error">No successful purchases data available</div>';
                return;
            }
            
            const customerLabels = successfulPurchasesData.map(item => item.name);
            const purchaseAmounts = successfulPurchasesData.map(item => parseFloat(item.total_amount) || 0);
            
            const successfulPurchasesOptions = {
                series: [{
                    name: 'Purchase Amount',
                    data: purchaseAmounts
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#22c55e'],
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: customerLabels
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                }
            };
            
            console.log('Rendering successful purchases chart with data:', purchaseAmounts);
            const successfulPurchasesChart = new ApexCharts(successfulPurchasesContainer, successfulPurchasesOptions);
            successfulPurchasesChart.render();
        }
        
        function renderAllPurchasesChart() {
            const allPurchasesData = @json($allPurchases);
            const uniqueCustomerNames = @json($customerNames);
            const allPurchasesContainer = document.getElementById('allPurchasesChart');
            
            if (!allPurchasesContainer) {
                console.error('All purchases chart container not found');
                return;
            }
            
            if (!allPurchasesData || allPurchasesData.length === 0 || !uniqueCustomerNames || uniqueCustomerNames.length === 0) {
                allPurchasesContainer.innerHTML = '<div class="chart-error">No purchase data available</div>';
                return;
            }
            
            // Group data by customer and status
            const statuses = ['completed', 'pending', 'processing', 'cancelled'];
            const statusColors = {
                'completed': '#22c55e',
                'pending': '#eab308',
                'processing': '#3b82f6',
                'cancelled': '#ef4444'
            };
            
            // Prepare series data for each status
            const series = statuses.map(status => {
                const data = uniqueCustomerNames.map(name => {
                    const customerPurchases = allPurchasesData.filter(item => 
                        item.name === name && item.status === status);
                    
                    if (customerPurchases.length > 0) {
                        return parseFloat(customerPurchases[0].total_amount) || 0;
                    }
                    return 0;
                });
                
                return {
                    name: status.charAt(0).toUpperCase() + status.slice(1),
                    data: data
                };
            }).filter(series => series.data.some(value => value > 0)); // Only include series with data
            
            const allPurchasesOptions = {
                series: series,
                chart: {
                    type: 'bar',
                    height: 300,
                    stacked: false,
                    toolbar: {
                        show: false
                    }
                },
                colors: statuses.map(status => statusColors[status]),
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 4,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: uniqueCustomerNames
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                },
                legend: {
                    position: 'top'
                }
            };
            
            console.log('Rendering all purchases chart with series:', series);
            const allPurchasesChart = new ApexCharts(allPurchasesContainer, allPurchasesOptions);
            allPurchasesChart.render();
        }
    });
</script>
@endpush

