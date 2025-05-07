<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'incubation_bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'service_type',
        'egg_quantity',
        'egg_source',
        'special_instructions',
        'start_date',
        'expected_completion_date',
        'actual_completion_date',
        'status',
        'status_notes',
        'confirmed_at',
        'first_candling_fertile_count',
        'second_candling_fertile_count',
        'candling_notes',
        'hatched_count',
        'hatch_rate',
        'hatching_notes',
        'total_price',
        'deposit_amount',
        'deposit_paid',
        'deposit_paid_at',
        'balance_paid',
        'balance_paid_at',
        'payment_method',
        'payment_reference',
        'booking_reference',
        'last_notification_sent_at',
        'last_status_update_at',
        'delivery_method',
        'pickup_date',
        'delivery_address',
        'delivery_fee',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'expected_completion_date' => 'date',
        'actual_completion_date' => 'date',
        'confirmed_at' => 'datetime',
        'deposit_paid' => 'boolean',
        'deposit_paid_at' => 'datetime',
        'balance_paid' => 'boolean',
        'balance_paid_at' => 'datetime',
        'last_notification_sent_at' => 'datetime',
        'last_status_update_at' => 'datetime',
        'pickup_date' => 'date',
        'total_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'hatch_rate' => 'float',
        'metadata' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'confirmed_at',
        'deposit_paid_at',
        'balance_paid_at',
        'last_notification_sent_at',
        'last_status_update_at',
    ];

    /**
     * Get the formatted service type name.
     *
     * @return string
     */
    public function getServiceTypeNameAttribute()
    {
        $types = [
            'jm_casabar' => 'JM Casabar Formula Incubation',
            'custom' => 'Custom Formula Incubation',
            'experimental' => 'Experimental Formula Incubation',
            'world_based' => 'World-Based Formula Incubation',
        ];

        return $types[$this->service_type] ?? $this->service_type;
    }

    /**
     * Get the formatted status name.
     *
     * @return string
     */
    public function getStatusNameAttribute()
    {
        $statuses = [
            'pending' => 'Pending Confirmation',
            'confirmed' => 'Booking Confirmed',
            'in_progress' => 'Incubation In Progress',
            'candling' => 'Candling Phase',
            'lockdown' => 'Lockdown Phase',
            'hatching' => 'Hatching In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Get the formatted egg source name.
     *
     * @return string
     */
    public function getEggSourceNameAttribute()
    {
        $sources = [
            'own_farm' => 'Customer\'s Own Farm',
            'jm_casabar' => 'JM Casabar Pekin Store',
            'other_supplier' => 'Other Supplier',
        ];

        return $sources[$this->egg_source] ?? $this->egg_source;
    }

    /**
     * Get the progress percentage of the incubation.
     *
     * @return int
     */
    public function getProgressPercentAttribute()
    {
        if ($this->status === 'completed') {
            return 100;
        }

        if ($this->status === 'cancelled') {
            return 0;
        }

        if (!$this->start_date) {
            return 0;
        }

        $startDate = Carbon::parse($this->start_date);
        $today = Carbon::now();
        
        // Standard incubation period for duck eggs is 28 days
        $totalDays = 28;
        $daysElapsed = min($totalDays, max(0, $today->diffInDays($startDate)));
        
        return min(100, round(($daysElapsed / $totalDays) * 100));
    }

    /**
     * Get the current incubation phase based on days elapsed.
     *
     * @return string
     */
    public function getCurrentPhaseAttribute()
    {
        if ($this->status === 'completed') {
            return 'Completed';
        }

        if ($this->status === 'cancelled') {
            return 'Cancelled';
        }

        if (!$this->start_date) {
            return 'Not Started';
        }

        $startDate = Carbon::parse($this->start_date);
        $today = Carbon::now();
        $daysElapsed = max(0, $today->diffInDays($startDate));

        if ($daysElapsed < 7) {
            return 'Initial Incubation';
        } elseif ($daysElapsed < 14) {
            return 'First Candling';
        } elseif ($daysElapsed < 25) {
            return 'Second Candling';
        } elseif ($daysElapsed < 28) {
            return 'Lockdown';
        } else {
            return 'Hatching';
        }
    }

    /**
     * Get the expected completion date.
     *
     * @return \Carbon\Carbon|null
     */
    public function getExpectedCompletionDateAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value);
        }

        if ($this->start_date) {
            return Carbon::parse($this->start_date)->addDays(28);
        }

        return null;
    }

    /**
     * Calculate the total price based on service type and egg quantity.
     *
     * @return float
     */
    public function calculateTotalPrice()
    {
        $pricePerBatch = [
            'jm_casabar' => 1500,
            'custom' => 2200,
            'experimental' => 2800,
            'world_based' => 2500
        ];
        
        $batchSize = 30;
        $batches = ceil($this->egg_quantity / $batchSize);
        
        return $pricePerBatch[$this->service_type] * $batches;
    }

    /**
     * Calculate the deposit amount (50% of total price).
     *
     * @return float
     */
    public function calculateDepositAmount()
    {
        return $this->calculateTotalPrice() * 0.5;
    }

    /**
     * Scope a query to only include pending bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include active bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['confirmed', 'in_progress', 'candling', 'lockdown', 'hatching']);
    }

    /**
     * Scope a query to only include completed bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include cancelled bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope a query to only include bookings that need attention.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNeedsAttention($query)
    {
        return $query->where('status', 'pending')
            ->orWhere(function ($query) {
                $query->where('status', 'confirmed')
                    ->where('deposit_paid', false);
            });
    }

    /**
     * Scope a query to only include bookings for a specific service type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $serviceType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfServiceType($query, $serviceType)
    {
        return $query->where('service_type', $serviceType);
    }

    /**
     * Update the booking status and related timestamps.
     *
     * @param  string  $status
     * @param  string|null  $notes
     * @return bool
     */
    public function updateStatus($status, $notes = null)
    {
        $this->status = $status;
        $this->status_notes = $notes;
        $this->last_status_update_at = now();
        
        if ($status === 'confirmed' && !$this->confirmed_at) {
            $this->confirmed_at = now();
        }
        
        return $this->save();
    }

    /**
     * Mark the deposit as paid.
     *
     * @param  string|null  $paymentMethod
     * @param  string|null  $paymentReference
     * @return bool
     */
    public function markDepositPaid($paymentMethod = null, $paymentReference = null)
    {
        $this->deposit_paid = true;
        $this->deposit_paid_at = now();
        
        if ($paymentMethod) {
            $this->payment_method = $paymentMethod;
        }
        
        if ($paymentReference) {
            $this->payment_reference = $paymentReference;
        }
        
        return $this->save();
    }

    /**
     * Mark the balance as paid.
     *
     * @param  string|null  $paymentMethod
     * @param  string|null  $paymentReference
     * @return bool
     */
    public function markBalancePaid($paymentMethod = null, $paymentReference = null)
    {
        $this->balance_paid = true;
        $this->balance_paid_at = now();
        
        if ($paymentMethod) {
            $this->payment_method = $paymentMethod;
        }
        
        if ($paymentReference) {
            $this->payment_reference = $paymentReference;
        }
        
        return $this->save();
    }

    /**
     * Record candling results.
     *
     * @param  int  $fertileCount
     * @param  string|null  $notes
     * @param  bool  $isFirstCandling
     * @return bool
     */
    public function recordCandlingResults($fertileCount, $notes = null, $isFirstCandling = true)
    {
        if ($isFirstCandling) {
            $this->first_candling_fertile_count = $fertileCount;
        } else {
            $this->second_candling_fertile_count = $fertileCount;
        }
        
        if ($notes) {
            $this->candling_notes = $notes;
        }
        
        return $this->save();
    }

    /**
     * Record hatching results.
     *
     * @param  int  $hatchedCount
     * @param  string|null  $notes
     * @return bool
     */
    public function recordHatchingResults($hatchedCount, $notes = null)
    {
        $this->hatched_count = $hatchedCount;
        
        // Calculate hatch rate based on second candling or original quantity
        $baseCount = $this->second_candling_fertile_count ?: $this->egg_quantity;
        $this->hatch_rate = $baseCount > 0 ? ($hatchedCount / $baseCount) * 100 : 0;
        
        if ($notes) {
            $this->hatching_notes = $notes;
        }
        
        $this->actual_completion_date = now();
        $this->status = 'completed';
        
        return $this->save();
    }

    /**
     * Generate a unique booking reference.
     *
     * @return string
     */
    public static function generateBookingReference()
    {
        $prefix = 'INC-';
        $timestamp = time();
        $random = rand(1000, 9999);
        
        return $prefix . $timestamp . $random;
    }

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate booking reference before creating
        static::creating(function ($booking) {
            if (!$booking->booking_reference) {
                $booking->booking_reference = self::generateBookingReference();
            }
            
            // Set expected completion date if not provided
            if (!$booking->expected_completion_date && $booking->start_date) {
                $booking->expected_completion_date = Carbon::parse($booking->start_date)->addDays(28);
            }
            
            // Calculate and set prices if not provided
            if (!$booking->total_price) {
                $booking->total_price = $booking->calculateTotalPrice();
            }
            
            if (!$booking->deposit_amount) {
                $booking->deposit_amount = $booking->calculateDepositAmount();
            }
        });
    }
}