@extends('layouts.hardware')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
         {{-- Header with Add Manual Entry Button  --}}
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold text-gray-900">Feeding History</h1>
            <button onclick="openModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-plus mr-2"></i>Add Manual Entry
            </button>
        </div>

         {{-- Success Message  --}}
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
         {{-- Filters  --}}
        <div class="mt-4 bg-white rounded-lg shadow p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="animal" class="block text-sm font-medium text-gray-700">Cage</label>
                    <select id="animal" name="animal" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">All Cages</option>
                        <optgroup label="Adult Pekin Duck (Drake & Hen)">
                            <option value="A">Cage A</option>
                            <option value="B">Cage B</option>
                            <option value="C">Cage C</option>
                            <option value="D">Cage D</option>
                            <option value="E">Cage E</option>
                            <option value="F">Cage F</option>
                            <option value="G">Cage G</option>
                        </optgroup>
                        <optgroup label="Pekin Duckling">
                            <option value="H">Cage H</option>
                            <option value="I">Cage I</option>
                            <option value="J">Cage J</option>
                            <option value="K">Cage K</option>
                            <option value="L">Cage L</option>
                            <option value="M">Cage M</option>
                        </optgroup>
                    </select>
                </div>
                <div>
                    <label for="feed_type" class="block text-sm font-medium text-gray-700">Feed Type</label>
                    <select id="feed_type" name="feed_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">All Types</option>
                        <option value="standard">Standard Feed</option>
                        <option value="premium">Premium Mix</option>
                        <option value="growth">Growth Formula</option>
                    </select>
                </div>
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700">Date From</label>
                    <input type="date" name="date_from" id="date_from" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700">Date To</label>
                    <input type="date" name="date_to" id="date_to" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Apply Filters
                </button>
            </div>
        </div>
        
         {{-- History Table  --}}
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-md">
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
                            <form action="{{ route('history.destroy', $history->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
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
        
         {{-- Feeding Summary  --}}
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-primary text-white rounded-md p-3">
                            <i class="fas fa-weight h-6 w-6"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Feed Used (This Month)
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">
                                        45.8 kg
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-primary text-white rounded-md p-3">
                            <i class="fas fa-calendar-check h-6 w-6"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Feeding Compliance Rate
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
            </div>
            
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-primary text-white rounded-md p-3">
                            <i class="fas fa-peso-sign h-6 w-6"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Feed Cost (This Month)
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">
                                        ₱1,245.60
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
         {{-- Monthly Feeding Chart  --}}
        <div class="mt-8 bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Monthly Feeding History</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Feed consumption over the past 6 months.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div id="monthlyFeedingChart" style="height: 300px;"></div>
            </div>
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Modal Functions
    function openModal() {
        const modal = document.getElementById('manualEntryModal');
        if (modal) {
            modal.classList.remove('hidden');
            // Set current date and time as default
            document.getElementById('fed_date').value = new Date().toISOString().split('T')[0];
            document.getElementById('fed_time').value = new Date().toTimeString().slice(0, 5);
        }
    }

    

    function closeModal() {
        const modal = document.getElementById('manualEntryModal');
        if (modal) {
            modal.classList.add('hidden');
            // Reset form
            modal.querySelector('form').reset();
        }
    }

    // Close modal when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('manualEntryModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        }// Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    });

    // Close modal when clicking outside
    // document.getElementById('manualEntryModal')?.addEventListener('click', function(e) {
    //     if (e.target === this) {
    //         closeModal();
    //     }
    // });

    // Monthly Feeding Chart
    var monthlyFeedingOptions = {
        series: [{
            name: 'Standard Feed',
            data: [25, 28, 32, 30, 35, 38]
        }, {
            name: 'Premium Mix',
            data: [15, 18, 20, 22, 25, 28]
        }, {
            name: 'Growth Formula',
            data: [10, 12, 15, 18, 20, 22]
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
                columnWidth: '55%',
                borderRadius: 5,
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
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
        colors: ['#4f46e5', '#10b981', '#f59e0b'],
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

    var monthlyFeedingChart = new ApexCharts(document.querySelector("#monthlyFeedingChart"), monthlyFeedingOptions);
    monthlyFeedingChart.render();
</script>
@endsection