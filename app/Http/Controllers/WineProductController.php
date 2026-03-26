<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WineProduct;

class WineProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wine_products = WineProduct::all();
        return view('customer.wine.index',[
            'wine_products' => $wine_products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WineProduct $product)
    {
         return view('customer.wine.view',['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $productId = (int) $request->input('product_id');
        $qtyToAdd = (int) ($request->input('quantity', 1));
        $product = WineProduct::findOrFail($productId);

        if ($product->product_stock <= 0) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'This product is out of stock.'], 422);
            }
            return back()->with('error', 'This product is out of stock.');
        }

        $cart = session()->get('cart', []);
        $key = 'wine_' . $productId;

        $existingQty = isset($cart[$key]) ? (int) ($cart[$key]['quantity'] ?? 0) : 0;
        $newQty = $existingQty + $qtyToAdd;
        if ($newQty > (int) $product->product_stock) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Not enough stock available.'], 422);
            }
            return back()->with('error', 'Not enough stock available.');
        }

        if(isset($cart[$key])) {
            $cart[$key]['quantity'] = $newQty;
        } else {
            $cart[$key] = [
                "type" => "wine",
                "id" => $productId,
                "name" => $product->product_name,
                "quantity" => $qtyToAdd,
                "price" => $product->product_price,
                "image" => $product->product_image
            ];
        }

        session()->put('cart', $cart);
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Added to cart.'], 200);
        }
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function removeFromCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Product removed successfully');
        }
    }
}
