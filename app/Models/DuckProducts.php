<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuckProducts extends Model
{
    protected $table = 'duckproducts';
    protected $fillable = [
        'product_id', 
        'product_image', 
        'product_name', 
        'product_price', 
        'product_description', 
        'product_stock',
    ];
}
