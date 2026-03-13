<?php

namespace App\Http\Controllers;
use App\Models\DuckProducts;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = DuckProducts::paginate(10);
        // View path is resources/views/admin/products/index.blade.php
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        // Validation logic here
        $validatedData = $request->validate([
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_name' => 'required|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_description' => 'required',
            'product_stock' => 'required|integer|min:0',
            'category' => 'nullable|in:duck,egg,wine',
        ]);
        $validatedData['category'] = $validatedData['category'] ?? 'duck';

        $imagePath = $request->file('product_image')->store('products', 'public');
        // Store with 'storage/' prefix so asset() works: asset($product->product_image)
        $validatedData['product_image'] = 'storage/' . $imagePath;

        // Create product first, then back-fill product_id from the primary key
        $product = DuckProducts::create($validatedData);
        $product->update(['product_id' => $product->id]);

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = DuckProducts::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = DuckProducts::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // Validation logic here
        $validatedData = $request->validate([
            'product_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_name' => 'required|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_description' => 'required',
            'product_stock' => 'required|integer|min:0',
            'category' => 'nullable|in:duck,egg,wine',
        ]);
        $validatedData['category'] = $validatedData['category'] ?? 'duck';

        $product = DuckProducts::findOrFail($id);

        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('products', 'public');
            $validatedData['product_image'] = 'storage/' . $imagePath;
        }

        $product->update($validatedData);

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = DuckProducts::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');
    }
}