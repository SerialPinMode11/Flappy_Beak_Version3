<?php

namespace App\Http\Controllers;
use App\Models\WineProduct;

use Illuminate\Http\Request;

class CartWineController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $product = WineProduct::findOrFail($productId);  // Changed this line

        $wcart = session()->get('winecart', []);

        if(isset($cart[$productId])) {
            $wcart[$productId]['quantity']++;
        } else {
            $wcart[$productId] = [
                "name" => $product->product_name,
                "quantity" => 1,
                "price" => $product->product_price,
                "image" => $product->product_image
            ];
        }

        session()->put('winecart', $wcart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    // public function viewCart()
    // {
    //     return view('customer.mycart', ['cart' => session('cart')]);
    // }

    public function removeFromCart(Request $request)
    {
        if($request->id) {
            $wcart = session()->get('winecart');
            if(isset($wcart[$request->id])) {
                unset($wcart[$request->id]);
                session()->put('winecart', $wcart);
            }
            return redirect()->back()->with('success', 'Product removed successfully');
        }
    }
}
