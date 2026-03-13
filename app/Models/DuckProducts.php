<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DuckProducts extends Model
{
    protected $table = 'duckproducts';
    protected $fillable = [
        'category',
        'product_image',
        'product_name',
        'product_price',
        'product_description',
        'product_stock',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class, 'duck_product_id')->latest();
    }
}
