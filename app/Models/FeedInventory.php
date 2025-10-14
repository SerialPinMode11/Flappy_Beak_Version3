<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedInventory extends Model
{
    use HasFactory;

    protected $table = 'feed_inventories';

    protected $fillable = [
        'feed_name',
        'type',
        'quantity',
        'unit',
        'location',
        'status',
        'expiry_date',
        'cost_per_unit',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'cost_per_unit' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    // Automatically update status based on quantity
    protected static function booted()
    {
        static::saving(function ($feed) {
            if ($feed->quantity == 0) {
                $feed->status = 'Out of Stock';
            } elseif ($feed->quantity < 500) { // You can adjust this threshold
                $feed->status = 'Low Stock';
            } else {
                $feed->status = 'In Stock';
            }
        });
    }

    // Accessor for formatted cost
    public function getFormattedCostAttribute()
    {
        return '₱' . number_format($this->cost_per_unit, 2);
    }
}