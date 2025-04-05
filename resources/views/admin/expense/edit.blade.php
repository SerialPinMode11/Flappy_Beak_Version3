@extends('layouts.static')
@section('title', 'Edit Expense - Admin Dashboard')
@section('content')
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Expense</h1>
        <a href="{{ route('admin.expense.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i> Back to Expenses
        </a>
    </div>
</header>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden p-6">
        <form action="{{ route('admin.expense.update', $expense->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="expense_type" class="block text-sm font-medium text-gray-700 mb-1">Expense Type</label>
                    <input type="text" name="expense_type" id="expense_type" value="{{ old('expense_type', $expense->expense_type) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @error('expense_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount', $expense->amount) }}" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $expense->date) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @error('date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" id="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        <option value="">Select Category</option>
                        <option value="Farm" {{ old('category', $expense->category) == 'Farm' ? 'selected' : '' }}>Farm</option>
                        <option value="Ecommerce" {{ old('category', $expense->category) == 'Ecommerce' ? 'selected' : '' }}>Ecommerce</option>
                        <option value="Office" {{ old('category', $expense->category) == 'Office' ? 'selected' : '' }}>Office</option>
                        <option value="Utilities" {{ old('category', $expense->category) == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                        <option value="Other" {{ old('category', $expense->category) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <input type="text" name="description" id="description" value="{{ old('description', $expense->description) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                    <textarea name="notes" id="notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes', $expense->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i> Update Expense
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

