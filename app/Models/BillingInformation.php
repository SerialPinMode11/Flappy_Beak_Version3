<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingInformation extends Model
{
    use HasFactory;

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
        'status'
    ];
}