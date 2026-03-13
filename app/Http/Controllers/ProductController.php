<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DuckProducts;
use App\Models\ProductReview;
use App\Models\WineProduct;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');

        $duckProducts = DuckProducts::orderBy('created_at', 'desc')->get();
        $wineProducts = WineProduct::orderBy('created_at', 'desc')->get();

        $products = collect();

        // Duck products: categorize by product name (Egg / Wine / Duck)
        foreach ($duckProducts as $p) {
            $name = $p->product_name ?? '';
            $type = 'duck';
            if (stripos($name, 'egg') !== false) {
                $type = 'egg';
            } elseif (stripos($name, 'wine') !== false) {
                $type = 'wine';
            }
            $products->push((object) [
                'type' => $type,
                'product' => $p,
                'detailRoute' => 'customer.productformat',
                'detailParam' => $p->id,
            ]);
        }

        // Wine products table: all are wine, link to wine detail page
        foreach ($wineProducts as $p) {
            $products->push((object) [
                'type' => 'wine',
                'product' => $p,
                'detailRoute' => 'customer.wine.view',
                'detailParam' => $p->id,
            ]);
        }

        // Sort so all products are in one list (e.g. by created_at), then filter by category
        $products = $products->sortByDesc(fn ($item) => $item->product->created_at ?? 0)->values();

        if ($category !== 'all') {
            $products = $products->filter(fn ($item) => $item->type === $category)->values();
        }

        return view('customer.home', [
            'products' => $products,
            'currentCategory' => $category,
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
        $product->load(['reviews.user']);
        $reviews = $product->reviews;
        $reviewsCount = $reviews->count();
        $averageRating = $reviewsCount > 0 ? round($reviews->avg('rating'), 1) : 0;
        $userHasReviewed = Auth::check() && $reviews->where('user_id', Auth::id())->isNotEmpty();

        return view('customer.productformat', [
            'product' => $product,
            'reviews' => $reviews,
            'reviewsCount' => $reviewsCount,
            'averageRating' => $averageRating,
            'userHasReviewed' => $userHasReviewed,
        ]);
    }

    public function storeReview(Request $request, DuckProducts $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:2000',
        ]);

        $existing = ProductReview::where('duck_product_id', $product->id)->where('user_id', Auth::id())->first();
        if ($existing) {
            return redirect()->back()->with('error', 'You have already reviewed this product. You can edit your review later.');
        }

        ProductReview::create([
            'duck_product_id' => $product->id,
            'user_id' => Auth::id(),
            'rating' => (int) $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Thank you! Your review has been posted.');
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
