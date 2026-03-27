@extends('layouts.static')

@section('title', 'Feeding History')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
            <h1 class="text-2xl font-semibold text-gray-900">Feeding History</h1>
            <button type="button" onclick="openModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-plus mr-2"></i>Add Manual Entry
            </button>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Chart at top --}}
        <div class="mb-6 bg-white shadow rounded-lg border border-gray-100">
            <div class="px-4 py-4 sm:px-6 border-b border-gray-100">
                <h2 class="text-lg font-medium text-gray-900">Monthly feeding history</h2>
                <p class="mt-1 text-sm text-gray-500">Feed consumption over the past 6 months (from stored records).</p>
            </div>
            <div class="px-4 py-4 sm:px-6">
                <p class="text-xs text-gray-400 mb-3">Based on <span class="font-medium text-gray-600">{{ $monthStats['feeding_count'] }}</span> records this month (amounts parsed from notes where available).</p>
                <div id="monthlyFeedingChart" class="w-full min-h-[300px]" style="min-height: 300px;"></div>
                <p id="monthlyChartEmpty" class="hidden text-sm text-gray-500 text-center py-8">No chart data yet. Add feedings from Hardware or manual entries with amounts in notes.</p>
            </div>
        </div>

        {{-- Summary KPIs --}}
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100">
                <div class="px-4 py-4 sm:px-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-600 text-white rounded-md p-3">
                            <i class="fas fa-weight h-6 w-6"></i>
                        </div>
                        <div class="ml-4 min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-500 truncate">Total feed (this month)</p>
                            <p class="text-lg font-semibold text-gray-900">{{ number_format($monthStats['month_kg'], 1) }} kg</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100">
                <div class="px-4 py-4 sm:px-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-600 text-white rounded-md p-3">
                            <i class="fas fa-calendar-check h-6 w-6"></i>
                        </div>
                        <div class="ml-4 min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-500 truncate">Compliance rate</p>
                            <p class="text-lg font-semibold text-gray-900">{{ number_format($monthStats['compliance'], 1) }}%</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100">
                <div class="px-4 py-4 sm:px-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-600 text-white rounded-md p-3">
                            <i class="fas fa-peso-sign h-6 w-6"></i>
                        </div>
                        <div class="ml-4 min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-500 truncate">Feed cost (this month)</p>
                            <p class="text-lg font-semibold text-gray-900">₱{{ number_format($monthStats['cost_php'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table (left) + Filters (right) --}}
        <div class="flex flex-col lg:flex-row gap-6 lg:items-start">
            <div class="min-w-0 flex-1">
                <div class="bg-white shadow overflow-hidden rounded-lg border border-gray-100">
                    <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fed By</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($histories as $history)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $history->fed_at->format('M d, Y h:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $history->fed_by ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($history->is_manual)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Manual
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Auto
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $history->notes ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('history.destroy', $history->id) }}" method="POST" class="inline" data-confirm="Are you sure you want to delete this record?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No feeding history found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
                    </div>
             {{-- Pagination  --}}
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </a>
                    <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Next
                    </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $histories->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $histories->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $histories->total() }}</span> results
                        </p>
                    </div>
                    <div>
                        {{ $histories->links() }}
                    </div>
                </div>
            </div>
                </div>
            </div>

            <aside class="w-full lg:w-72 xl:w-80 shrink-0 lg:sticky lg:top-4 self-start">
                <div class="bg-white rounded-lg shadow border border-gray-100 p-4 sm:p-5">
                    <h3 class="text-sm font-semibold text-gray-900">Filters</h3>
                    <p class="text-xs text-gray-500 mt-1 mb-4">Date range and feed type.</p>
                    <div class="space-y-4">
                        <div>
                            <label for="feed_type" class="block text-xs font-medium text-gray-600 mb-1">Feed type</label>
                            <select id="feed_type" name="feed_type" class="block w-full rounded-md border border-gray-300 shadow-sm text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                <option value="">All types</option>
                                <option value="standard">Standard Feed</option>
                                <option value="premium">Premium Mix</option>
                                <option value="growth">Growth Formula</option>
                            </select>
                        </div>
                        <div>
                            <label for="date_from" class="block text-xs font-medium text-gray-600 mb-1">From</label>
                            <input type="date" name="date_from" id="date_from" class="block w-full rounded-md border border-gray-300 shadow-sm text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="date_to" class="block text-xs font-medium text-gray-600 mb-1">To</label>
                            <input type="date" name="date_to" id="date_to" class="block w-full rounded-md border border-gray-300 shadow-sm text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Apply filters
                        </button>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

 {{-- Manual Entry Modal  --}}
<div id="manualEntryModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Add Manual Feeding Entry</h3>
            <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form action="{{ route('history.store') }}" method="POST">
            @csrf
            
             Date Input 
            <div class="mb-4">
                <label for="fed_date" class="block text-gray-700 text-sm font-bold mb-2">
                    Date <span class="text-red-500">*</span>
                </label>
                <input 
                    type="date" 
                    id="fed_date" 
                    name="fed_date" 
                    required 
                    value="{{ date('Y-m-d') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            
             Time Input 
            <div class="mb-4">
                <label for="fed_time" class="block text-gray-700 text-sm font-bold mb-2">
                    Time <span class="text-red-500">*</span>
                </label>
                <input 
                    type="time" 
                    id="fed_time" 
                    name="fed_time" 
                    required 
                    value="{{ date('H:i') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            
             Notes Input 
            <div class="mb-4">
                <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">
                    Notes (Optional)
                </label>
                <textarea 
                    id="notes" 
                    name="notes" 
                    rows="3" 
                    placeholder="Add any additional details about this feeding..."
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none"></textarea>
            </div>
            
             Form Actions 
            <div class="flex justify-end gap-3 mt-6">
                <button 
                    type="button" 
                    onclick="closeModal()" 
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors">
                    Cancel
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    <i class="fas fa-save mr-2"></i>Save Entry
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.__monthlyFeedingChartData = @json($monthlyChart ?? ['labels' => [], 'series' => []]);

    function openModal() {
        const modal = document.getElementById('manualEntryModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.getElementById('fed_date').value = new Date().toISOString().split('T')[0];
            document.getElementById('fed_time').value = new Date().toTimeString().slice(0, 5);
        }
    }

    function closeModal() {
        const modal = document.getElementById('manualEntryModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.querySelector('form').reset();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('manualEntryModal');
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === this) closeModal();
            });
        }
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });

        var el = document.querySelector('#monthlyFeedingChart');
        var emptyMsg = document.getElementById('monthlyChartEmpty');
        if (!el || typeof ApexCharts === 'undefined') {
            if (emptyMsg) {
                emptyMsg.textContent = 'Chart library failed to load. Refresh the page.';
                emptyMsg.classList.remove('hidden');
            }
            return;
        }

        var payload = window.__monthlyFeedingChartData || { labels: [], series: [] };
        var labels = payload.labels || [];
        var series = payload.series || [];

        var totalKg = 0;
        series.forEach(function (s) {
            (s.data || []).forEach(function (v) { totalKg += parseFloat(v) || 0; });
        });

        if (totalKg <= 0 && labels.length) {
            // still draw chart (flat zeros) — helps see timeline
        }

        var palette = ['#4f46e5', '#10b981', '#f59e0b', '#06b6d4', '#ef4444', '#a855f7', '#84cc16', '#f97316', '#64748b'];
        var dynamicColors = (series.length ? series : [{ name: 'Total (kg)', data: labels.map(function () { return 0; }) }]).map(function (_, i) {
            return palette[i % palette.length];
        });

        var monthlyFeedingOptions = {
            series: series.length ? series : [{ name: 'Total (kg)', data: labels.map(function () { return 0; }) }],
            chart: {
                type: 'bar',
                height: 340,
                stacked: true,
                toolbar: { show: true },
                fontFamily: 'Inter, system-ui, sans-serif',
                animations: { enabled: true }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '58%',
                    borderRadius: 4
                }
            },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 1, colors: ['#fff'] },
            xaxis: {
                categories: labels.length ? labels : ['—'],
                title: { text: 'Month', style: { fontSize: '12px' } }
            },
            yaxis: {
                title: { text: 'Feed (kg) — from stored records' },
                min: 0,
                labels: { formatter: function (v) { return (Math.round(v * 100) / 100).toFixed(2); } }
            },
            colors: dynamicColors,
            legend: { position: 'top', horizontalAlign: 'left' },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (val) {
                        return (val != null ? parseFloat(val).toFixed(2) : '0') + ' kg';
                    }
                }
            },
            fill: { opacity: 0.92 }
        };

        try {
            var chart = new ApexCharts(el, monthlyFeedingOptions);
            chart.render();
        } catch (e) {
            console.error(e);
            if (emptyMsg) {
                emptyMsg.textContent = 'Could not render chart.';
                emptyMsg.classList.remove('hidden');
            }
        }
    });
</script>
@endpush