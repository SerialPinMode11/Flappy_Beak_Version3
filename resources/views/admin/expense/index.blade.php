@extends('layouts.static')
@section('title', 'Expenses Information - Admin Dashboard')
@section('content')

<!-- Enhanced print-specific CSS styles with better formatting and header -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    .printable-area, .printable-area * {
        visibility: visible;
    }
    .printable-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        overflow: visible !important;
    }
    .no-print {
        display: none !important;
    }
    .overflow-x-auto {
        overflow: visible !important;
    }
    .print-header {
        display: block !important;
        text-align: center;
        margin-bottom: 30px;
        page-break-inside: avoid;
    }
    .print-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #000;
    }
    .print-info {
        font-size: 14px;
        color: #666;
        margin-bottom: 5px;
    }
    table {
        width: 100% !important;
        border-collapse: collapse;
        font-size: 11px;
        table-layout: fixed;
        margin: 0;
        page-break-inside: auto;
    }
    th, td {
        border: 1px solid #000;
        padding: 4px 3px;
        text-align: left;
        word-wrap: break-word;
        overflow: hidden;
        vertical-align: top;
    }
    th {
        background-color: #f5f5f5;
        font-weight: bold;
        font-size: 10px;
        text-align: center;
    }
    th:nth-child(1), td:nth-child(1) { width: 6%; } /* ID */
    th:nth-child(2), td:nth-child(2) { width: 14%; } /* Expense Type */
    th:nth-child(3), td:nth-child(3) { width: 28%; } /* Description */
    th:nth-child(4), td:nth-child(4) { width: 14%; text-align: right; } /* Amount */
    th:nth-child(5), td:nth-child(5) { width: 16%; } /* Date */
    th:nth-child(6), td:nth-child(6) { width: 12%; } /* Category */
    th:nth-child(7), td:nth-child(7) { width: 10%; } /* Notes */
    
    td {
        font-size: 10px;
        line-height: 1.2;
    }
    
    .print-total {
        display: block !important;
        margin-top: 20px;
        text-align: right;
        font-weight: bold;
        font-size: 14px;
        border-top: 2px solid #000;
        padding-top: 10px;
        page-break-inside: avoid;
    }
    
    * {
        -webkit-print-color-adjust: exact !important;
        color-adjust: exact !important;
    }
    
    ::-webkit-scrollbar {
        display: none !important;
    }
    
    @page {
        margin: 0.5in;
        size: landscape;
    }
}
</style>

<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Expenses Information</h1>
        
        <!-- Added person selector dropdown and enhanced print button -->
        <div class="flex space-x-3 items-center">
            <div class="no-print">
                <label class="block text-sm font-medium text-gray-700 mb-1">Printed by:</label>
                <select id="printedBy" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="JERRY M. CASABAR">JERRY M. CASABAR</option>
                    <option value="MYRNA TUDAYAN PASCUA">MYRNA TUDAYAN PASCUA</option>
                </select>
            </div>
            <button onclick="printTable()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center no-print">
                <i class="fas fa-print mr-2"></i>
                Print Table
            </button>
            <button onclick="openExportModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center no-print">
                <i class="fas fa-file-excel mr-2"></i>
                Export to Excel
            </button>
        </div>
    </div>
</header>

<!-- Added export modal -->
<div id="exportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Export Expenses Report</h3>
                <button onclick="closeExportModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Fixed route name to match web.php -->
            <form action="{{ route('expense.export') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                    <input type="date" name="date_from" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                    <input type="date" name="date_to" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($expenses->pluck('category')->unique() as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expense Type</label>
                    <select name="expense_type" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Types</option>
                        @foreach($expenses->pluck('expense_type')->unique() as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeExportModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                        <i class="fas fa-download mr-1"></i>
                        Download Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded no-print" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded no-print" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    <!-- Added print header and enhanced printable area -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden printable-area">
        <div class="print-header" style="display: none;">
            <div class="print-title">Flappy-Beak Expense Report</div>
            <div class="print-info">Date Printed: <span id="printDate"></span></div>
            <div class="print-info">Printed by: <span id="printPerson"></span></div>
            <div class="print-info">Total Records: <span id="printRecordCount"></span></div>
        </div>
        
        <div class="table-container">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expense Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider no-print">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($expenses as $expense)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $expense->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $expense->expense_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $expense->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 expense-amount">₱{{ number_format($expense->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $expense->category }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $expense->notes }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium no-print">
                            <a href="{{ route('expense.show', $expense->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            <a href="{{ route('expense.edit', $expense->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                            <form action="{{ route('expense.destroy', $expense->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this expense?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No expenses found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Added total calculation display for print -->
        <div class="print-total" style="display: none;">
            <div>Total Expenses: <span id="printTotal"></span></div>
        </div>
    </div>

    <div class="mt-4 no-print">
        {{ $expenses->links() }}
    </div>
</div>

<!-- Enhanced print function with header information and total calculation -->
<script>
function printTable() {
    // Get selected person
    const selectedPerson = document.getElementById('printedBy').value;
    
    // Set print header information
    document.getElementById('printDate').textContent = new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    document.getElementById('printPerson').textContent = selectedPerson;
    
    // Calculate total expenses and record count
    const expenseAmounts = document.querySelectorAll('.expense-amount');
    let total = 0;
    let recordCount = 0;
    
    expenseAmounts.forEach(amount => {
        const amountText = amount.textContent.replace('₱', '').replace(/,/g, '');
        const numericAmount = parseFloat(amountText);
        if (!isNaN(numericAmount)) {
            total += numericAmount;
            recordCount++;
        }
    });
    
    document.getElementById('printRecordCount').textContent = recordCount;
    document.getElementById('printTotal').textContent = '₱' + total.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    
    // Show print elements
    document.querySelector('.print-header').style.display = 'block';
    document.querySelector('.print-total').style.display = 'block';
    
    // Print the page
    window.print();
    
    // Hide print elements after printing
    setTimeout(() => {
        document.querySelector('.print-header').style.display = 'none';
        document.querySelector('.print-total').style.display = 'none';
    }, 1000);
}

function openExportModal() {
    document.getElementById('exportModal').classList.remove('hidden');
}

function closeExportModal() {
    document.getElementById('exportModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('exportModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeExportModal();
    }
});
</script>
@endsection
