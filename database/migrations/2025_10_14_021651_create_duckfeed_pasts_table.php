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
        Schema::create('duckfeed_pasts', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fed_at'); // When the feeding occurred
            $table->string('fed_by')->nullable(); // Optional: who fed (user name/id)
            $table->text('notes')->nullable(); // Optional notes
            $table->boolean('is_manual')->default(false); // Track if manually added
            $table->timestamps();
            $table->softDeletes(); // This enables soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duckfeed_pasts');
    }
};
