@extends('layouts.static')

@section('title', 'Edit Product')

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
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                        <a href="{{ route('admin.products.show', $product->id) }}" class="text-gray-500 hover:text-primary">{{ $product->product_name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                        <span class="text-primary font-medium">Edit</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Title -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral">Edit Product</h1>
            <p class="text-gray-600 mt-2">Update product information</p>
        </div>

        <!-- Edit Product Form -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-8">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Product Image -->
                    <div class="mb-6">
                        <label for="product_image" class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                        <div class="flex items-center">
                            <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300 mr-4 overflow-hidden">
                                <img id="image_preview" src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover rounded-lg">
                            </div>
                            <div class="flex-1">
                                <input type="file" id="product_image" name="product_image" 
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-dark"
                                    onchange="previewImage(this)">
                                <p class="mt-1 text-xs text-gray-500">PNG, JPG or JPEG (max. 2MB). Leave empty to keep current image.</p>
                            </div>
                        </div>
                        @error('product_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Name -->
                    <div class="mb-6">
                        <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                        <input type="text" id="product_name" name="product_name" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Enter product name" value="{{ old('product_name', $product->product_name) }}" required>
                        @error('product_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product ID -->
                    <div class="mb-6">
                        <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">Product ID</label>
                        <input type="text" id="product_id" name="product_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Enter product ID" value="{{ old('product_id', $product->product_id) }}" required>
                        @error('product_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Price -->
                    <div class="mb-6">
                        <label for="product_price" class="block text-sm font-medium text-gray-700 mb-2">Product Price (₱)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">₱</span>
                            </div>
                            <input type="number" id="product_price" name="product_price" step="0.01" min="0" 
                                class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="0.00" value="{{ old('product_price', $product->product_price) }}" required>
                        </div>
                        @error('product_price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Stock -->
                    <div class="mb-6">
                        <label for="product_stock" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                        <input type="number" id="product_stock" name="product_stock" min="0" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Enter stock quantity" value="{{ old('product_stock', $product->product_stock) }}" required>
                        @error('product_stock')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Description -->
                    <div class="mb-8">
                        <label for="product_description" class="block text-sm font-medium text-gray-700 mb-2">Product Description</label>
                        <textarea id="product_description" name="product_description" rows="5" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Enter product description">{{ old('product_description', $product->product_description) }}</textarea>
                        @error('product_description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.products.show', $product->id) }}" 
                            class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="px-6 py-3 bg-secondary text-white rounded-lg hover:bg-opacity-90 transition-colors">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('image_preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection