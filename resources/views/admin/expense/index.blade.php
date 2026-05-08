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
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex flex-wrap gap-4 justify-between items-center">
        <div class="flex items-center gap-3 min-w-0">
            <h1 class="text-2xl font-semibold text-gray-800">Expenses Information</h1>
            <button type="button"
               id="openExpenseCreateModal"
               class="no-print inline-flex items-center justify-center w-10 h-10 rounded-full bg-emerald-600 text-white shadow-md hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors shrink-0"
               title="Add new expense"
               aria-label="Add new expense"
               aria-haspopup="dialog"
               aria-controls="expenseCreateModal">
                <i class="fas fa-plus text-lg" aria-hidden="true"></i>
            </button>
        </div>

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

<!-- Add expense modal -->
<div id="expenseCreateModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true" aria-labelledby="expenseCreateModalTitle">
    <div class="fixed inset-0 bg-black/50 transition-opacity" data-close-expense-modal></div>
    <div class="relative min-h-full flex items-center justify-center p-4 sm:p-6">
        <div class="relative w-full max-w-2xl rounded-xl bg-white shadow-xl border border-gray-200 max-h-[min(90vh,calc(100vh-2rem))] flex flex-col" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between gap-3 px-5 py-4 border-b border-gray-200 shrink-0">
                <h2 id="expenseCreateModalTitle" class="text-lg font-semibold text-gray-900">Add New Expense</h2>
                <button type="button" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100" onclick="closeExpenseCreateModal()" aria-label="Close">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="overflow-y-auto px-5 py-4">
                @if($errors->any() && old('_expense_modal'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-800">
                        Please correct the errors below.
                    </div>
                @endif
                <form action="{{ route('admin.expense.store') }}" method="POST" id="expenseCreateForm">
                    @csrf
                    <input type="hidden" name="_expense_modal" value="1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="modal_expense_type" class="block text-sm font-medium text-gray-700 mb-1">Expense Type</label>
                            <input type="text" name="expense_type" id="modal_expense_type" value="{{ old('expense_type') }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" required>
                            @error('expense_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="modal_amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                            <input type="number" name="amount" id="modal_amount" value="{{ old('amount') }}" step="0.01" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" required>
                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="modal_date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" name="date" id="modal_date" value="{{ old('date', date('Y-m-d')) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" required>
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="modal_category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category" id="modal_category" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" required>
                                <option value="">Select Category</option>
                                <option value="Farm" {{ old('category') == 'Farm' ? 'selected' : '' }}>Farm</option>
                                <option value="Ecommerce" {{ old('category') == 'Ecommerce' ? 'selected' : '' }}>Ecommerce</option>
                                <option value="Office" {{ old('category') == 'Office' ? 'selected' : '' }}>Office</option>
                                <option value="Utilities" {{ old('category') == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="modal_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <input type="text" name="description" id="modal_description" value="{{ old('description') }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" required>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="modal_notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                            <textarea name="notes" id="modal_notes" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-gray-100 pt-4">
                        <button type="button" onclick="closeExpenseCreateModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-save"></i>
                            Save Expense
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
            <table class="w-full table-fixed divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="w-16 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="w-40 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expense Type</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th scope="col" class="w-32 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="w-32 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="w-40 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="w-48 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th scope="col" class="w-24 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider no-print">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($expenses as $expense)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $expense->id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 truncate" title="{{ $expense->expense_type }}">{{ $expense->expense_type }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            @php
                                $fullDescription = $expense->description;
                                $shortDescription = \Illuminate\Support\Str::limit($fullDescription, 60);
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="truncate" title="{{ $fullDescription }}">{{ $shortDescription }}</span>
                                @if(strlen($fullDescription) > 60)
                                    <button type="button"
                                            class="text-blue-500 text-xs hover:underline"
                                            onclick="openExpenseTextModal('expense-description-{{ $expense->id }}', 'Description')">
                                        See more
                                    </button>
                                @endif
                            </div>
                            @if(strlen($fullDescription) > 60)
                                <div id="expense-description-{{ $expense->id }}" class="hidden">
                                    {{ $fullDescription }}
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 expense-amount">₱{{ number_format($expense->amount, 2) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 truncate" title="{{ $expense->category }}">{{ $expense->category }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            @php
                                $fullNotes = $expense->notes;
                                $shortNotes = \Illuminate\Support\Str::limit($fullNotes, 40);
                            @endphp
                            @if($fullNotes)
                                <div class="flex items-center gap-2">
                                    <span class="truncate" title="{{ $fullNotes }}">{{ $shortNotes }}</span>
                                    @if(strlen($fullNotes) > 40)
                                        <button type="button"
                                                class="text-blue-500 text-xs hover:underline"
                                                onclick="openExpenseTextModal('expense-notes-{{ $expense->id }}', 'Notes')">
                                            See more
                                        </button>
                                    @endif
                                </div>
                                @if(strlen($fullNotes) > 40)
                                    <div id="expense-notes-{{ $expense->id }}" class="hidden">
                                        {{ $fullNotes }}
                                    </div>
                                @endif
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium no-print text-center">
                            <a href="{{ route('expense.show', $expense->id) }}"
                               class="inline-flex items-center justify-center text-indigo-600 hover:text-indigo-900 mx-1"
                               title="View details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('expense.edit', $expense->id) }}"
                               class="inline-flex items-center justify-center text-yellow-500 hover:text-yellow-600 mx-1"
                               title="Edit expense">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('expense.destroy', $expense->id) }}" method="POST" class="inline-block" data-confirm="Are you sure you want to delete this expense?">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center justify-center text-red-600 hover:text-red-700 mx-1"
                                        title="Delete expense">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
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
function openExpenseCreateModal() {
    var el = document.getElementById('expenseCreateModal');
    if (!el) return;
    el.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    var first = el.querySelector('input:not([type="hidden"])');
    if (first) setTimeout(function () { first.focus(); }, 50);
}

function closeExpenseCreateModal() {
    var el = document.getElementById('expenseCreateModal');
    if (!el) return;
    el.classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', function () {
    var openBtn = document.getElementById('openExpenseCreateModal');
    if (openBtn) openBtn.addEventListener('click', openExpenseCreateModal);

    document.querySelectorAll('[data-close-expense-modal]').forEach(function (backdrop) {
        backdrop.addEventListener('click', closeExpenseCreateModal);
    });

    @if($errors->any() && old('_expense_modal'))
    openExpenseCreateModal();
    @endif

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var m = document.getElementById('expenseCreateModal');
        if (m && !m.classList.contains('hidden')) {
            closeExpenseCreateModal();
        }
    });
});

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

function openExpenseTextModal(sourceId, title) {
    const source = document.getElementById(sourceId);
    if (!source) return;
    const message = source.textContent || source.innerText || '';

    const existing = document.getElementById('expense-text-modal');
    if (existing) existing.remove();

    const wrapper = document.createElement('div');
    wrapper.id = 'expense-text-modal';
    wrapper.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/50';
    wrapper.innerHTML = `
        <div class="bg-white rounded-xl shadow-xl max-w-lg w-full mx-4">
            <div class="px-6 py-4 border-b flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">${title}</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeExpenseTextModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-6 py-4">
                <p class="text-sm text-gray-700 whitespace-pre-line break-words">${message}</p>
            </div>
            <div class="px-6 py-3 border-t flex justify-end">
                <button type="button"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200"
                        onclick="closeExpenseTextModal()">
                    Close
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(wrapper);
}

function closeExpenseTextModal() {
    const modal = document.getElementById('expense-text-modal');
    if (modal) modal.remove();
}
</script>
@endsection
