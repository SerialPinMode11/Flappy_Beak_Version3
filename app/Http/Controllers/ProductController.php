<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DuckProducts;
use Illuminate\Support\Str; // Add this import for the Str class

class ProductController extends Controller
{
    public function index()
    {
        $duckproducts = DuckProducts::all();
        return view('customer.home',[
            'duckproducts' => $duckproducts
        ]);
        
    }

    public function incubator()
    {
        $duckproducts = DuckProducts::all();
        return view('customer.addblade.incubate');
        
    }

    public function destroy($id)
    {
        $product = DuckProducts::findOrFail($id);

        // Delete product image
        if ($product->product_image && file_exists(public_path($product->product_image))) {
            unlink(public_path($product->product_image));
        }

        // Delete the product
        $product->delete();

        return redirect()->route('admin.product.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function show(DuckProducts $product)
    {
            // $product = Product::where('id', $product->id)->first();
            return view('customer.productformat',['product' => $product]);
    }

    public function edit($id)
    {
        $product = DuckProducts::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'product_id' => 'required|string|max:255|unique:duckproducts,product_id',
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_description' => 'required|string',
            'product_stock' => 'required|integer|min:0',
            'product_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Handle file upload
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            // Convert product name to a URL-friendly slug
            $slug = Str::slug($request->product_name);
            // Create filename using the slug and original extension
            $imageName = $slug . '.' . $image->getClientOriginalExtension();
            // Move the file to the public/images directory
            $image->move(public_path('images'), $imageName);
            $validated['product_image'] = 'images/' . $imageName;
        }
    
        // Create the product
        $product = DuckProducts::create($validated);
    
        return redirect()->route('admin.product.index')
            ->with('success', 'Product created successfully!');
    }


    //

    public function update(Request $request, $id)
    {
        $product = DuckProducts::findOrFail($id);
    
        // Validate the request
        $validated = $request->validate([
            'product_id' => 'required|string|max:255|unique:duckproducts,product_id,' . $id,
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_description' => 'required|string',
            'product_stock' => 'required|integer|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Handle file upload
        if ($request->hasFile('product_image')) {
            // Delete old image if it exists
            if ($product->product_image && file_exists(public_path($product->product_image))) {
                unlink(public_path($product->product_image));
            }
    
            $image = $request->file('product_image');
            // Convert product name to a URL-friendly slug
            $slug = Str::slug($request->product_name);
            // Create filename using the slug and original extension
            $imageName = $slug . '.' . $image->getClientOriginalExtension();
            // Move the file to the public/images directory
            $image->move(public_path('images'), $imageName);
            $validated['product_image'] = 'images/' . $imageName;
        }
    
        // Update the product
        $product->update($validated);
    
        return redirect()->route('admin.products.show', $product->id)
            ->with('success', 'Product updated successfully!');
    }
}
