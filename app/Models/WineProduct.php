<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WineProduct extends Model
{
    // Change this line to match your actual table name
    protected $table = 'wine_products'; // Changed from 'wineproducts' to 'wine_products'
    
    protected $fillable = [
        'product_id', 
        'product_image', 
        'product_name', 
        'product_price', 
        'product_description', 
        'product_stock',
    ];
}