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
        $productId = $request->input('product_id');
        $product = WineProduct::findOrFail($productId);  // Changed this line

        $cart = session()->get('cart', []);

        if(isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "name" => $product->product_name,
                "quantity" => 1,
                "price" => $product->product_price,
                "image" => $product->product_image
            ];
        }

        session()->put('cart', $cart);
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
