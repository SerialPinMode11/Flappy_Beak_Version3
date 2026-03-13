<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReview extends Model
{
    protected $table = 'product_reviews';

    protected $fillable = [
        'duck_product_id',
        'user_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(DuckProducts::class, 'duck_product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get initials for display (e.g. "JD" for Juan Dela Cruz).
     */
    public function getAuthorInitialsAttribute(): string
    {
        $name = $this->user?->name ?? 'Guest';
        $parts = preg_split('/\s+/', trim($name), 2);
        if (count($parts) >= 2) {
            return strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1));
        }
        return strtoupper(mb_substr($name, 0, 2));
    }
}
