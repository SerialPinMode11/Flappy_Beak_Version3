<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incubation_bookings', function (Blueprint $table) {
            $table->id();
            
            // Customer Information
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            
            // Service Details
            $table->string('service_type'); // jm_casabar, custom, experimental, world_based
            $table->integer('egg_quantity');
            $table->string('egg_source'); // own_farm, jm_casabar, other_supplier
            $table->text('special_instructions')->nullable();
            
            // Scheduling
            $table->date('start_date');
            $table->date('expected_completion_date')->nullable();
            $table->date('actual_completion_date')->nullable();
            
            // Status Tracking
            $table->string('status')->default('pending'); // pending, confirmed, in_progress, candling, lockdown, hatching, completed, cancelled
            $table->text('status_notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            
            // Candling Results
            $table->integer('first_candling_fertile_count')->nullable();
            $table->integer('second_candling_fertile_count')->nullable();
            $table->text('candling_notes')->nullable();
            
            // Hatching Results
            $table->integer('hatched_count')->nullable();
            $table->float('hatch_rate')->nullable();
            $table->text('hatching_notes')->nullable();
            
            // Payment Information
            $table->decimal('total_price', 10, 2)->nullable();
            $table->decimal('deposit_amount', 10, 2)->nullable();
            $table->boolean('deposit_paid')->default(false);
            $table->timestamp('deposit_paid_at')->nullable();
            $table->boolean('balance_paid')->default(false);
            $table->timestamp('balance_paid_at')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_reference')->nullable();
            
            // Tracking and Reference
            $table->string('booking_reference')->unique();
            $table->timestamp('last_notification_sent_at')->nullable();
            $table->timestamp('last_status_update_at')->nullable();
            
            // Pickup/Delivery
            $table->string('delivery_method')->nullable(); // pickup, delivery
            $table->date('pickup_date')->nullable();
            $table->text('delivery_address')->nullable();
            $table->decimal('delivery_fee', 8, 2)->nullable();
            
            // Metadata
            $table->json('metadata')->nullable(); // For any additional data
            
            // Standard Timestamps
            $table->timestamps();
            $table->softDeletes(); // Allow for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incubation_bookings');
    }
};