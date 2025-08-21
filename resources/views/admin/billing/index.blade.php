@extends('layouts.static')
@section('title', 'Billing Information - Admin Dashboard')
@section('content')

<!-- Enhanced print-specific CSS styles with improved table formatting and column widths -->
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
        font-size: 12px;
    }
    .no-print {
        display: none !important;
    }
    /* Hide status and action columns in print */
    .status-column,
    .action-column {
        display: none !important;
    }
    .print-header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #000;
        padding-bottom: 20px;
    }
    .print-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #000;
    }
    .print-info {
        font-size: 14px;
        margin-bottom: 5px;
        color: #000;
    }
    .print-total {
        margin-top: 20px;
        text-align: right;
        font-size: 16px;
        font-weight: bold;
        border-top: 2px solid #000;
        padding-top: 10px;
    }
    /* Improved table formatting with better column widths and spacing */
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-size: 11px;
    }
    th, td {
        border: 1px solid #000;
        padding: 6px 4px;
        text-align: left;
        vertical-align: top;
        word-wrap: break-word;
    }
    th {
        background-color: #f5f5f5;
        font-weight: bold;
        font-size: 10px;
        text-transform: uppercase;
    }
    /* Specific column width optimization for better date visibility */
    th:nth-child(1), td:nth-child(1) { /* ID */
        width: 8%;
        text-align: center;
    }
    th:nth-child(2), td:nth-child(2) { /* Customer */
        width: 25%;
    }
    th:nth-child(3), td:nth-child(3) { /* Address */
        width: 30%;
        font-size: 10px;
    }
    th:nth-child(4), td:nth-child(4) { /* Payment Method */
        width: 15%;
        font-size: 10px;
    }
    th:nth-child(5), td:nth-child(5) { /* Amount */
        width: 12%;
        text-align: right;
        font-weight: bold;
    }
    th:nth-child(6), td:nth-child(6) { /* Date */
        width: 15%;
        white-space: nowrap;
        font-size: 10px;
    }
    /* Better text formatting for customer info */
    .customer-name {
        font-weight: bold;
        font-size: 11px;
    }
    .customer-email {
        font-size: 9px;
        color: #666;
        margin-top: 2px;
    }
    /* Payment method formatting */
    .payment-main {
        font-weight: bold;
    }
    .payment-details {
        font-size: 9px;
        color: #666;
        margin-top: 1px;
    }
}
</style>

<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Billing Information</h1>
        <!-- Added person selector and enhanced print button -->
        <div class="flex space-x-3 items-center">
            <div class="no-print">
                <label class="block text-sm font-medium text-gray-700 mb-1">Printed by:</label>
                <select id="printedBy" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="JERRY M. CASABAR">JERRY M. CASABAR</option>
                    <option value="MYRNA TUDAYAN PASCUA">MYRNA TUDAYAN PASCUA</option>
                </select>
            </div>
            <button onclick="printTable()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 no-print">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Table
            </button>
            <button onclick="openExportModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 no-print">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Income Report
            </button>
        </div>
    </div>
</header>

<!-- Added export modal for filtering income reports -->
<div id="exportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.billing.export') }}" method="GET">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Export Income Sales Report</h3>
                            <p class="text-sm text-gray-600 mb-4">This will export all completed billing records and calculate total income.</p>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                                    <input type="date" name="date_from" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                                    <input type="date" name="date_to" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name (Optional)</label>
                                    <input type="text" name="customer_name" placeholder="Enter customer name" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method (Optional)</label>
                                    <select name="payment_method" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">All Payment Methods</option>
                                        <option value="cash">Cash</option>
                                        <option value="online">Online</option>
                                        <option value="card">Card</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Export Excel
                    </button>
                    <button type="button" onclick="closeExportModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Added success message display -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 no-print">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-sm rounded-lg overflow-hidden printable-area">
        <!-- Added comprehensive print header -->
        <div class="print-header" style="display: none;">
            <div class="print-title">Flappy-Beak Income Generated Report</div>
            <div class="print-info">Date Printed: <span id="printDate"></span></div>
            <div class="print-info">Printed by: <span id="printPerson"></span></div>
            <div class="print-info">Report Type: Complete Income Records Only</div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <!-- Added status-column class to hide in print -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider status-column">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <!-- Added action-column class to hide in print -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider action-column">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($billingInfo as $info)
                    <tr class="billing-row" data-status="{{ $info->status }}" data-amount="{{ $info->total_amount }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $info->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <!-- Added CSS classes for better print formatting -->
                            <div class="customer-name">{{ $info->name }}</div>
                            <div class="customer-email">{{ $info->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $info->address }}, {{ $info->city }}, {{ $info->zip }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <!-- Added CSS classes for better print formatting -->
                            <div class="payment-main">{{ ucfirst($info->payment_method) }}</div>
                            @if($info->online_payment_method)
                                <div class="payment-details">
                                    {{ ucfirst($info->online_payment_method) }}
                                    @if($info->reference_number)
                                        <span class="block">Ref: {{ $info->reference_number }}</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱{{ number_format($info->total_amount, 2) }}</td>
                        <!-- Added status-column class to hide in print -->
                        <td class="px-6 py-4 whitespace-nowrap status-column">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($info->status == 'completed') bg-green-100 text-green-800 
                                @elseif($info->status == 'pending') bg-yellow-100 text-yellow-800 
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($info->status) }}
                            </span>
                        </td>
                        <!-- Improved date formatting for better print visibility -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $info->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium action-column">
                            <a href="{{ route('admin.billing.show', $info->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            <a href="{{ route('admin.billing.edit', $info->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <!-- Updated colspan to match visible columns in print -->
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No billing information found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Added total calculation section for print -->
        <div class="print-total" style="display: none;">
            <div>Total Completed Income: ₱<span id="totalAmount">0.00</span></div>
            <div style="font-size: 14px; margin-top: 5px;">Total Records: <span id="totalRecords">0</span></div>
        </div>
    </div>
    <div class="mt-4 no-print">
        {{ $billingInfo->links() }}
    </div>
</div>

<!-- Enhanced JavaScript with total calculation and print header functionality -->
<script>
function printTable() {
    // Get selected person
    const selectedPerson = document.getElementById('printedBy').value;
    
    // Set current date
    const currentDate = new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    // Calculate total for completed records
    let totalAmount = 0;
    let totalRecords = 0;
    const rows = document.querySelectorAll('.billing-row');
    
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        const amount = parseFloat(row.getAttribute('data-amount'));
        
        if (status === 'completed') {
            totalAmount += amount;
            totalRecords++;
        }
    });
    
    // Update print header and total
    document.getElementById('printDate').textContent = currentDate;
    document.getElementById('printPerson').textContent = selectedPerson;
    document.getElementById('totalAmount').textContent = totalAmount.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    document.getElementById('totalRecords').textContent = totalRecords;
    
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
