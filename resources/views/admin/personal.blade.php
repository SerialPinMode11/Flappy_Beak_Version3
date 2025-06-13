@extends('layouts.self')
@section('title', 'Admin Personal')

@push('styles')
<style>
    /* Dark theme custom styles */
    body {
        background-color: #121826;
        color: #e2e8f0;
    }
    
    .dark-card {
        background-color: #1e293b;
        border: 1px solid #334155;
    }
    
    .dark-header {
        background-color: #1e293b;
        border-bottom: 1px solid #334155;
    }
    
    .dark-table-header {
        background-color: #0f172a;
    }
    
    .dark-table-row {
        border-color: #334155;
    }
    
    .dark-table-row:hover {
        background-color: #1e293b;
    }
    
    .dark-panel {
        background-color: #1e293b;
        border: 1px solid #334155;
    }
    
    .pagination-dark .page-link {
        background-color: #1e293b;
        border-color: #334155;
        color: #e2e8f0;
    }
    
    .pagination-dark .page-item.active .page-link {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<header class="dark-header shadow-md">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-100">Admin Credentials Information</h1>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.personal.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-plus mr-2"></i> Add New Admin User
            </a>
            <div class="relative">
                <input type="search" placeholder="Search..." class="pl-10 pr-4 py-2 bg-gray-800 border border-gray-700 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <button class="relative">
                <i class="fas fa-bell text-gray-300 text-xl"></i>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
            </button>
            <button class="flex items-center space-x-2 text-gray-300 hover:text-white">
                <span class="font-medium">Personal Data</span>
            </button>
        </div>
    </div>
</header>

<!-- Main Content Area -->
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-900 border-l-4 border-green-500 text-green-100 p-4 mb-4 rounded" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Admin Users Table -->
    <div class="dark-card rounded-lg overflow-hidden shadow-lg">
        <div class="p-4 border-b border-gray-700">
            <h2 class="text-xl font-semibold text-gray-100">Admin Users</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="dark-table-header">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($users as $user)
                        <tr class="dark-table-row hover:bg-gray-800 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-200">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-300">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-300">{{ $user->role ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('admin.personal.destroy', ['id' => $user->id]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition-colors duration-150" 
                                        onclick="return confirm('Are you sure you want to delete this admin user?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-400">No admin users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-700">
            <div class="pagination-dark">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Admin Privileges Section -->
    <div class="dark-card shadow-lg rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-100">Admin Privileges</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Expenses Report -->
                <div class="dark-panel rounded-lg p-5 shadow-md">
                    <h3 class="text-lg font-medium mb-3 text-gray-100">Expenses Report</h3>
                    <p class="text-gray-400 mb-4">
                        Generate a comprehensive expenses report in MS Excel format for detailed analysis and
                        record-keeping.
                    </p>
                    <button id="generateExpensesReport"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-colors duration-200">
                        Generate Expenses Report
                    </button>
                </div>
                
                <!-- Sales Report -->
                <div class="dark-panel rounded-lg p-5 shadow-md">
                    <h3 class="text-lg font-medium mb-3 text-gray-100">Sales Report</h3>
                    <p class="text-gray-400 mb-4">
                        Generate a comprehensive sales report in MS Excel format for detailed analysis and
                        record-keeping.
                    </p>
                    <button id="generateSalesReport"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-colors duration-200">
                        Generate Sales Report
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Income Report -->
                <div class="dark-panel rounded-lg p-5 shadow-md">
                    <h3 class="text-lg font-medium mb-3 text-gray-100">Income Report</h3>
                    <p class="text-gray-400 mb-4">
                        Generate a comprehensive income report in MS Excel format for detailed analysis and
                        record-keeping.
                    </p>
                    <button id="generateIncomeReport"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-colors duration-200">
                        Generate Income Report
                    </button>
                </div>
                
                <!-- Product Stock Report -->
                <div class="dark-panel rounded-lg p-5 shadow-md">
                    <h3 class="text-lg font-medium mb-3 text-gray-100">Product Stock Report</h3>
                    <p class="text-gray-400 mb-4">
                        Generate a comprehensive stock report in MS Excel format for detailed analysis and
                        record-keeping.
                    </p>
                    <button id="generateStockReport"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-colors duration-200">
                        Generate Stock Report
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any JavaScript functionality here
    document.addEventListener('DOMContentLoaded', function() {
        // Example: Add click handlers for report generation buttons
        const reportButtons = document.querySelectorAll('[id^="generate"]');
        reportButtons.forEach(button => {
            button.addEventListener('click', function() {
                alert('Report generation initiated. Your download will begin shortly.');
                // Actual implementation would call an endpoint to generate the report
            });
        });
    });
</script>
@endpush