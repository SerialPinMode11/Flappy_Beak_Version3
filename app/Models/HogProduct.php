<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HogProduct extends Model
{
    protected $table = 'hog_products'; // Changed from 'wineproducts' to 'wine_products'
    
    protected $fillable = [
        'product_id', 
        'product_image', 
        'product_name', 
        'product_price', 
        'product_description', 
        'product_stock',
    ];
}
