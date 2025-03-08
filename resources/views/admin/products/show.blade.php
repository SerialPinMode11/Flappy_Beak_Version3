@extends('layouts.static')

@section('title', $product->product_name)

@section('content')
<main class="flex-grow container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.product.index') }}" class="text-gray-500 hover:text-primary">
                        <i class="fas fa-home mr-2"></i>Admin Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                        <a href="{{ route('admin.product.index') }}" class="text-gray-500 hover:text-primary">Products</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                        <span class="text-primary font-medium">{{ $product->product_name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral">Product Details</h1>
            <div class="flex space-x-3">
                <a href="{{ route('admin.products.edit', $product->id) }}" 
                   class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-opacity-90 transition-colors flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <button type="button" onclick="confirmDelete()" 
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-opacity-90 transition-colors flex items-center">
                    <i class="fas fa-trash-alt mr-2"></i> Delete
                </button>
            </div>
        </div>

        <!-- Product Details Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="md:flex">
                <!-- Product Image -->
                <div class="md:w-2/5">
                    <div class="h-80 md:h-full overflow-hidden">
                        <img class="w-full h-full object-cover" 
                             src="{{ asset($product->product_image) }}" 
                             alt="{{ $product->product_name }}">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="md:w-3/5 p-8">
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 bg-primary bg-opacity-10 text-primary text-xs font-semibold rounded-full">
                            ID: {{ $product->product_id }}
                        </span>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-neutral mb-4">{{ $product->product_name }}</h2>
                    
                    <div class="mb-6">
                        <span class="text-3xl font-bold text-primary">₱{{ number_format($product->product_price, 2) }}</span>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-neutral mb-2">Description</h3>
                        <p class="text-gray-600">{{ $product->product_description }}</p>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-neutral mb-2">Stock Information</h3>
                        <div class="flex items-center">
                            <span class="text-gray-600 mr-2">Available Stock:</span>
                            <span class="font-semibold {{ $product->product_stock > 10 ? 'text-green-600' : ($product->product_stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $product->product_stock }} units
                            </span>
                        </div>
                        <div class="mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-primary h-2.5 rounded-full" style="width: {{ min(100, ($product->product_stock / 100) * 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-6">
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div>Created: {{ $product->created_at->format('M d, Y') }}</div>
                            <div>Last Updated: {{ $product->updated_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Delete Confirmation Modal (Hidden by default) -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-neutral mb-4">Confirm Delete</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to delete <span class="font-semibold">{{ $product->product_name }}</span>? This action cannot be undone.</p>
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="closeModal()" 
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Cancel
            </button>
            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-opacity-90 transition-colors">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endpush
@endsection