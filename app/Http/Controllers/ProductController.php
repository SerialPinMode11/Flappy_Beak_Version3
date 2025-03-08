<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DuckProducts;

class ProductController extends Controller
{
    public function index()
    {
        $duckproducts = DuckProducts::all();
        return view('customer.home',[
            'duckproducts' => $duckproducts
        ]);
        
    }

    public function show(DuckProducts $product)
        {
            // $product = Product::where('id', $product->id)->first();
            return view('customer.productformat',['product' => $product]);
        }
}
