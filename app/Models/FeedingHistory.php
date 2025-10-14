<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedingHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'feed_histories';

    protected $fillable = [
        'fed_at',
        'fed_by',
        'notes',
        'is_manual'
    ];

    protected $casts = [
        'fed_at' => 'datetime',
        'is_manual' => 'boolean',
    ];

    // Order by most recent first
    protected static function booted()
    {
        static::addGlobalScope('recent', function ($query) {
            $query->orderBy('fed_at', 'desc');
        });
    }
}