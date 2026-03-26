@extends('layouts.static')
@section('title', 'Admin Dashboard')

@push('styles')
<style>
    .kpi-card { transition: transform .2s ease, box-shadow .2s ease; }
    .kpi-card:hover { transform: translateY(-2px); }
    .chart-box { height: 320px; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 space-y-6">
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
            <p class="text-sm text-gray-500">Operational summary of sales, products, inventory, bookings, expenses, and customer inquiries.</p>
        </div>
        <span class="text-xs px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 font-semibold">Updated {{ now()->format('M d, Y h:i A') }}</span>
    </div>

    <!-- Executive KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="kpi-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-xs uppercase tracking-wide text-gray-500">Total Revenue</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">₱{{ number_format($totalSales, 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">Net: ₱{{ number_format($netRevenue, 2) }} after expenses</p>
        </div>
        <div class="kpi-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-xs uppercase tracking-wide text-gray-500">Today Revenue</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">₱{{ number_format($todayRevenue, 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">Orders today contribute to cashflow</p>
        </div>
        <div class="kpi-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-xs uppercase tracking-wide text-gray-500">Total Orders</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalOrders }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $completedCustomers }} completed / {{ $pendingOrders + $processingOrders }} in progress</p>
        </div>
        <div class="kpi-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-xs uppercase tracking-wide text-gray-500">Total Expenses</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">₱{{ number_format($totalExpenses, 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">Monitor spending against revenue</p>
        </div>
    </div>

    <!-- Module Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <a href="{{ route('admin.product.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <p class="text-sm font-semibold text-gray-800">Products</p>
            <p class="text-2xl font-bold mt-1">{{ $totalProducts }}</p>
            <p class="text-xs text-gray-500 mt-1">Duck: {{ $duckProductCount }} | Wine: {{ $wineProductCount }} | Low stock: {{ $lowStockProducts }}</p>
        </a>
        <a href="{{ route('admin.billing.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <p class="text-sm font-semibold text-gray-800">Orders</p>
            <p class="text-2xl font-bold mt-1">{{ $totalOrders }}</p>
            <p class="text-xs text-gray-500 mt-1">Pending {{ $pendingOrders }}, Processing {{ $processingOrders }}, Cancelled {{ $cancelledOrders }}</p>
        </a>
        <a href="{{ route('admin.incubation.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <p class="text-sm font-semibold text-gray-800">Incubation</p>
            <p class="text-2xl font-bold mt-1">{{ $incubationTotal }}</p>
            <p class="text-xs text-gray-500 mt-1">Active bookings: {{ $incubationActive }}</p>
        </a>
        <a href="{{ route('contactforlist') }}" class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <p class="text-sm font-semibold text-gray-800">Customer Messages</p>
            <p class="text-2xl font-bold mt-1">{{ $contactMessages }}</p>
            <p class="text-xs text-gray-500 mt-1">Last 7 days: {{ $recentContactMessages }}</p>
        </a>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Revenue Trend</h3>
            <div id="monthlySalesChart" class="chart-box"></div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Status Distribution</h3>
            <div id="orderStatusChart" class="chart-box"></div>
        </div>
    </div>

    <!-- Recent activity -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
                <a href="{{ route('admin.billing.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-xs uppercase text-gray-500">
                        <tr>
                            <th class="text-left py-2">Customer</th>
                            <th class="text-left py-2">Status</th>
                            <th class="text-right py-2">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="py-2 text-gray-700">{{ $order->name }}</td>
                                <td class="py-2">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : ($order->status === 'processing' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-2 text-right font-semibold text-gray-800">₱{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-4 text-center text-gray-500">No recent orders</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Expenses</h3>
                <a href="{{ route('admin.expense.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-xs uppercase text-gray-500">
                        <tr>
                            <th class="text-left py-2">Category</th>
                            <th class="text-left py-2">Date</th>
                            <th class="text-right py-2">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentExpenses as $expense)
                            <tr>
                                <td class="py-2 text-gray-700">{{ $expense->category ?? $expense->expense_type ?? 'Expense' }}</td>
                                <td class="py-2 text-gray-600">{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</td>
                                <td class="py-2 text-right font-semibold text-gray-800">₱{{ number_format($expense->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-4 text-center text-gray-500">No recent expenses</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Operational alerts -->
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Operational Alerts</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-3">
                <p class="font-semibold text-yellow-800">Low stock products</p>
                <p class="text-yellow-700 mt-1">{{ $lowStockProducts }} products need restocking soon.</p>
            </div>
            <div class="rounded-lg border border-red-200 bg-red-50 p-3">
                <p class="font-semibold text-red-800">Feed inventory alert</p>
                <p class="text-red-700 mt-1">{{ $feedLowStock }} feed records are low/out of stock (out of {{ $feedInventoryCount }}).</p>
            </div>
            <div class="rounded-lg border border-blue-200 bg-blue-50 p-3">
                <p class="font-semibold text-blue-800">Open order workload</p>
                <p class="text-blue-700 mt-1">{{ $pendingOrders + $processingOrders }} orders still require action.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof ApexCharts === 'undefined') return;

    const monthlySalesData = @json($monthlySales);
    const statusData = @json($purchasesByStatus);
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    if (monthlySalesData && monthlySalesData.length) {
        new ApexCharts(document.querySelector('#monthlySalesChart'), {
            series: [{ name: 'Revenue', data: monthlySalesData.map(item => parseFloat(item.total) || 0) }],
            chart: { type: 'bar', height: 320, toolbar: { show: false } },
            colors: ['#22c55e'],
            plotOptions: { bar: { borderRadius: 6, columnWidth: '45%' } },
            dataLabels: { enabled: false },
            xaxis: { categories: monthlySalesData.map(item => monthNames[(parseInt(item.month) || 1) - 1]) },
            yaxis: { labels: { formatter: (v) => '₱' + Number(v).toLocaleString() } },
            tooltip: { y: { formatter: (v) => '₱' + Number(v).toLocaleString() } }
        }).render();
    }

    if (statusData && statusData.length) {
        const labels = statusData.map(s => (s.status || '').charAt(0).toUpperCase() + (s.status || '').slice(1));
        const counts = statusData.map(s => parseInt(s.count) || 0);
        const colors = statusData.map(s => {
            if (s.status === 'completed') return '#22c55e';
            if (s.status === 'pending') return '#eab308';
            if (s.status === 'processing') return '#3b82f6';
            if (s.status === 'cancelled') return '#ef4444';
            return '#64748b';
        });

        new ApexCharts(document.querySelector('#orderStatusChart'), {
            series: counts,
            chart: { type: 'donut', height: 320 },
            labels: labels,
            colors: colors,
            legend: { position: 'bottom' }
        }).render();
    }
});
</script>
@endpush
