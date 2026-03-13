@extends('layouts.static')
@section('title', 'Product List - Admin Dashboard')
@section('content')
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Product List</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Product
        </a>
    </div>
</header>
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="w-full table-fixed divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="w-16 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="w-24 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="w-32 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th scope="col" class="w-24 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th scope="col" class="w-24 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $product->id }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <img src="{{ asset( $product->product_image) }}" alt="{{ $product->product_name }}" class="h-10 w-10 rounded-full">
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 truncate" title="{{ $product->product_name }}">{{ $product->product_name }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">₱{{ number_format($product->product_price, 2) }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->product_stock }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-center">
                            <a href="{{ route('admin.products.show', $product->id) }}"
                               class="inline-flex items-center justify-center text-indigo-600 hover:text-indigo-900 mx-1"
                               title="View product">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="inline-flex items-center justify-center text-yellow-500 hover:text-yellow-600 mx-1"
                               title="Edit product">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center justify-center text-red-600 hover:text-red-700 mx-1"
                                        onclick="return confirm('Are you sure you want to delete this product?')"
                                        title="Delete product">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No products found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection