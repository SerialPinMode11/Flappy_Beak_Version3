<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DuckProducts;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $productId = (int) $request->input('product_id');
        $qtyToAdd = (int) ($request->input('quantity', 1));
        $product = DuckProducts::findOrFail($productId);

        if ($product->product_stock <= 0) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'This product is out of stock.'], 422);
            }
            return back()->with('error', 'This product is out of stock.');
        }

        $cart = session()->get('cart', []);
        $key = 'duck_' . $productId;

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
                "type" => "duck",
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

    public function viewCart()
    {
        return view('customer.mycart', ['cart' => session('cart')]);
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