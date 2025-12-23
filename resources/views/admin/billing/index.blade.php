@extends('layouts.static')
@section('title', 'Billing Information - Admin Dashboard')
@section('content')

<!-- Updated print styles to receipt format with custom fonts and spacing -->
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
        max-width: 800px;
        margin: 0 auto;
        font-family: 'Courier New', monospace;
        font-size: 12px;
        line-height: 1.6;
    }
    .no-print {
        display: none !important;
    }
    
    /* Receipt header styles */
    .receipt-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px dashed #000;
    }
    .receipt-business-name {
        font-size: 24px;
        font-weight: bold;
        font-family: Arial, sans-serif;
        margin-bottom: 5px;
        letter-spacing: 1px;
    }
    .receipt-title {
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0;
        text-transform: uppercase;
    }
    .receipt-meta {
        font-size: 11px;
        margin: 3px 0;
        color: #333;
    }
    
    /* Receipt item styles */
    .receipt-items {
        margin: 20px 0;
    }
    .receipt-item {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #ccc;
        page-break-inside: avoid;
    }
    .receipt-item:last-child {
        border-bottom: 2px dashed #000;
    }
    .receipt-row {
        display: flex;
        justify-content: space-between;
        margin: 4px 0;
        font-size: 11px;
    }
    .receipt-label {
        font-weight: bold;
        width: 140px;
        flex-shrink: 0;
    }
    .receipt-value {
        flex: 1;
        text-align: left;
    }
    .receipt-amount {
        font-weight: bold;
        font-size: 13px;
        text-align: right;
        margin-top: 5px;
    }
    
    /* Receipt footer/total styles */
    .receipt-total-section {
        margin-top: 20px;
        padding-top: 15px;
        border-top: 2px solid #000;
    }
    .receipt-total-row {
        display: flex;
        justify-content: space-between;
        margin: 8px 0;
        font-size: 13px;
    }
    .receipt-total-row.grand-total {
        font-size: 16px;
        font-weight: bold;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #000;
    }
    
    /* Receipt footer */
    .receipt-footer {
        text-align: center;
        margin-top: 30px;
        padding-top: 15px;
        border-top: 2px dashed #000;
        font-size: 10px;
    }
    
    /* Hide table in print view */
    .billing-table {
        display: none !important;
    }
}

/* Screen-only: Hide receipt view */
@media screen {
    .receipt-view {
        display: none;
    }
}
</style>

<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Billing Information</h1>
        <!-- Added month/year filter for print function -->
        <div class="flex space-x-3 items-center">
            <div class="no-print">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Month:</label>
                <input type="month" id="filterMonth" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
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
                Print Receipt
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

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Added success message display -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 no-print">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-sm rounded-lg overflow-hidden printable-area">
        <!-- Added receipt format view for printing -->
        <div class="receipt-view">
            <div class="receipt-header">
                <div class="receipt-business-name">FLAPPY-BEAK</div>
                <div class="receipt-title">Monthly Revenue Income Report</div>
                <div class="receipt-meta">Date Printed: <span id="printDate"></span></div>
                <div class="receipt-meta">Printed by: <span id="printPerson"></span></div>
                <div class="receipt-meta">Report Period: <span id="reportPeriod">All Time</span></div>
                <div class="receipt-meta">Status: Completed Orders Only</div>
            </div>
            
            <div class="receipt-items" id="receiptItems">
                <!-- Items will be populated by JavaScript -->
            </div>
            
            <div class="receipt-total-section">
                <div class="receipt-total-row">
                    <span>Total Records:</span>
                    <span id="receiptTotalRecords">0</span>
                </div>
                <div class="receipt-total-row grand-total">
                    <span>GRAND TOTAL:</span>
                    <span>₱<span id="receiptGrandTotal">0.00</span></span>
                </div>
            </div>
            
            <div class="receipt-footer">
                <div>Thank you for your business!</div>
                <div>This is a computer-generated report</div>
            </div>
        </div>
        
        <!-- Added billing-table class to hide table during print -->
        <div class="overflow-x-auto billing-table">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider status-column">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider action-column">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($billingInfo as $info)
                    <tr class="billing-row" 
                        data-status="{{ $info->status }}" 
                        data-amount="{{ $info->total_amount }}"
                        data-date="{{ $info->created_at->format('Y-m-d') }}"
                        data-customer="{{ $info->name }}"
                        data-email="{{ $info->email }}"
                        data-address="{{ $info->address }}, {{ $info->city }}, {{ $info->zip }}"
                        data-payment="{{ ucfirst($info->payment_method) }}"
                        data-online-payment="{{ $info->online_payment_method ?? '' }}"
                        data-reference="{{ $info->reference_number ?? '' }}"
                        data-id="{{ $info->id }}">
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
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">No billing information found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4 no-print">
        {{ $billingInfo->links() }}
    </div>
</div>

<!-- Completely rewritten printTable() function with monthly filtering and receipt generation -->
<script>
function printTable() {
    const selectedPerson = document.getElementById('printedBy').value;
    const filterMonth = document.getElementById('filterMonth').value;
    
    // Set current date and time
    const currentDate = new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
    
    // Determine report period
    let reportPeriod = 'All Time';
    let filterYear = null;
    let filterMonthNum = null;
    
    if (filterMonth) {
        const [year, month] = filterMonth.split('-');
        filterYear = parseInt(year);
        filterMonthNum = parseInt(month);
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 
                          'July', 'August', 'September', 'October', 'November', 'December'];
        reportPeriod = `${monthNames[filterMonthNum - 1]} ${filterYear}`;
    }
    
    // Calculate total and build receipt items
    let totalAmount = 0;
    let totalRecords = 0;
    const rows = document.querySelectorAll('.billing-row');
    const receiptItemsContainer = document.getElementById('receiptItems');
    receiptItemsContainer.innerHTML = '';
    
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        const dateStr = row.getAttribute('data-date');
        const amount = parseFloat(row.getAttribute('data-amount'));
        
        // Only process completed orders
        if (status !== 'completed') return;
        
        // Apply monthly filter if set
        if (filterMonth) {
            const rowDate = new Date(dateStr);
            const rowYear = rowDate.getFullYear();
            const rowMonth = rowDate.getMonth() + 1;
            
            if (rowYear !== filterYear || rowMonth !== filterMonthNum) {
                return; // Skip this row
            }
        }
        
        // Add to totals
        totalAmount += amount;
        totalRecords++;
        
        // Build receipt item
        const customer = row.getAttribute('data-customer');
        const email = row.getAttribute('data-email');
        const address = row.getAttribute('data-address');
        const payment = row.getAttribute('data-payment');
        const onlinePayment = row.getAttribute('data-online-payment');
        const reference = row.getAttribute('data-reference');
        const id = row.getAttribute('data-id');
        
        // Format date
        const formattedDate = new Date(dateStr).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
        
        // Create receipt item HTML
        let paymentDetails = payment;
        if (onlinePayment) {
            paymentDetails += ` - ${onlinePayment}`;
            if (reference) {
                paymentDetails += ` (Ref: ${reference})`;
            }
        }
        
        const itemHTML = `
            <div class="receipt-item">
                <div class="receipt-row">
                    <span class="receipt-label">Order ID:</span>
                    <span class="receipt-value">#${id}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Date:</span>
                    <span class="receipt-value">${formattedDate}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Customer:</span>
                    <span class="receipt-value">${customer}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Email:</span>
                    <span class="receipt-value">${email}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Address:</span>
                    <span class="receipt-value">${address}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Payment Method:</span>
                    <span class="receipt-value">${paymentDetails}</span>
                </div>
                <div class="receipt-amount">Amount: ₱${amount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}</div>
            </div>
        `;
        
        receiptItemsContainer.innerHTML += itemHTML;
    });
    
    // Check if any records found
    if (totalRecords === 0) {
        receiptItemsContainer.innerHTML = '<div style="text-align: center; padding: 20px; font-size: 14px;">No completed orders found for the selected period.</div>';
    }
    
    // Update receipt header and footer
    document.getElementById('printDate').textContent = currentDate;
    document.getElementById('printPerson').textContent = selectedPerson;
    document.getElementById('reportPeriod').textContent = reportPeriod;
    document.getElementById('receiptTotalRecords').textContent = totalRecords;
    document.getElementById('receiptGrandTotal').textContent = totalAmount.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    
    // Trigger print
    window.print();
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
