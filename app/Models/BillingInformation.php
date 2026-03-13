<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'billing_information';

    protected $fillable = [
        'name',
        'email',
        'address',
        'city',
        'zip',
        'payment_method',
        'online_payment_method',
        'reference_number',
        'total_amount',
        'items',
        'status'
    ];

    protected $casts = [
        'items' => 'array',
    ];
}
