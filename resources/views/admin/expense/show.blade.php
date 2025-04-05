@extends('layouts.static')
@section('title', 'Expense Details - Admin Dashboard')
@section('content')
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Expense Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.expense.edit', ['id' => $expense->id]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('admin.expense.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>
</header>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border-b pb-3 md:border-b-0 md:border-r md:pr-6">
                <h2 class="text-lg font-semibold mb-4">Expense Information</h2>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Expense Type</p>
                        <p class="font-medium">{{ $expense->expense_type }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Description</p>
                        <p class="font-medium">{{ $expense->description }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Amount</p>
                        <p class="font-medium">₱{{ number_format($expense->amount, 2) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="pt-3 md:pt-0 md:pl-6">
                <h2 class="text-lg font-semibold mb-4">Additional Details</h2>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Date</p>
                        <p class="font-medium">{{ date('F d, Y', strtotime($expense->date)) }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Category</p>
                        <p class="font-medium">{{ $expense->category }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Notes</p>
                        <p class="font-medium">{{ $expense->notes ?? 'No notes provided' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Created At</p>
                        <p class="font-medium">{{ $expense->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Last Updated</p>
                        <p class="font-medium">{{ $expense->updated_at->format('F d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-6 border-t">
            <form action="{{ route('admin.expense.destroy', ['id' => $expense->id]) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg" onclick="return confirm('Are you sure you want to delete this expense?')">
                    <i class="fas fa-trash mr-2"></i> Delete Expense
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

